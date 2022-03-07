import axios from "axios";
import React from "react";
import ReactDom from "react-dom";
import Chart from 'chart.js/auto';


class ObjectiveEvolution extends React.Component{

    constructor(props){
        super(props);

        this.state = {
            loading: true,
            update: false,
        }
        this.objectives=this.props.objectives;
        this.dataSets = [];
        this.years = [];
        this.chart = {};
        this.selectedObjective = this.objectives[0].token;

    }

    render(){
        if (this.state.loading) {
            return(
                <div className="ibox">

                    <div className="ibox-title bg-primary">
                        <h5>Evolución de los objetivos</h5>
                    </div>

                    <div className="ibox-content bg-light animated fadeIn">
                        <div className="spiner-example">
                            <div className="sk-spinner sk-spinner-double-bounce">
                                <div className="sk-double-bounce1"></div>
                                <div className="sk-double-bounce2"></div>
                            </div>
                        </div>
                        <p className="mt-3 text-center"> Cargando... </p>
                            
                    </div>


                </div>
            )
        }
        return(
            <div className="ibox">

                <div className="ibox-title bg-primary">
                    <h5>Evolución de los objetivos</h5>
                </div>

                <div className="ibox-content bg-light">
                    <select id="objective_selector" className="form-control" defaultValue={this.selectedObjective}>
                        {
                            this.objectives.map( (objective) => {
                                return(
                                    <option
                                        key={"option_"+objective.token}
                                        value={objective.token}
                                    >
                                        {objective.title}
                                    </option>
                                );
                            } )
                        }
                    </select>

                    <canvas id="objective_evolution" className="animated fadeIn" height={200}></canvas>
                    
                </div>


            </div>
        );
    }

    componentDidMount(){

        let value = this.objectives[0].token;

        axios.post('/ods/dashboard/objective/evolution', {token: value}).then( (response) => {

            
            let evaluations =  response.data.evaluations;
            let years = response.data.years;
            let objective = response.data.objective;

            var data = [];

            years.map( (year) => {

                let suma = 0;
                evaluations[year].map( (evaluation) => {
                    suma += Number(evaluation.value);
                    
                } )
                
                data.push(suma);

            } )

            this.dataSets = data;
            this.years = years;

            
            this.setState({loading: false, update: false});
            
        }).then( () => {
            let ctx = document.getElementById('objective_evolution').getContext('2d');

            const config = {
                type: 'line',
                
                data:{
                    labels: this.years,
                    datasets: [{
                        label: "Evolución",
                        data: this.dataSets,
                        fill: false,
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }],
                },

                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: '',
                        }
                    }
                }
            }

            this.chart = new Chart(ctx, config);

            //INIT SELECT2
            $('#objective_selector').select2(
                {
                    placeholder: "Selecciona un objetivo",
                    theme: "bootstrap4"
                }
            );
            const handleChangeObjective = (value) => {
                this.changeObjective(value);
            }

            //ON CHANGE
            
            $('#objective_selector').on('change', function(e){
                
                let value = e.target.value;
               
                handleChangeObjective(
                    value
                );

                
            });
        } );

        

        
    }

    componentDidUpdate(){

        if (this.state.update != false) {

            let value = this.selectedObjective;

            
            axios.post('/ods/dashboard/objective/evolution', {token: value}).then( (response) => {

                let evaluations =  response.data.evaluations;
                let years = response.data.years;

                var data = [];

                years.map( (year) => {

                    let suma = 0;
                    evaluations[year].map( (evaluation) => {
                        suma += Number(evaluation.value);
                        
                    } )
                    
                    data.push(suma);

                } )

                this.dataSets = data;
                this.years = years;

                this.setState({loading: false, update: false});

            }).then( () => {
                
                let ctx = document.getElementById('objective_evolution').getContext('2d');

                const config = {
                    type: 'line',
                    
                    data:{
                        labels: this.years,
                        datasets: [{
                            label: "Evolución",
                            data: this.dataSets,
                            fill: false,
                            borderColor: 'rgb(75, 192, 192)',
                            backgroundColor: 'rgb(75, 192, 192)',
                            tension: 0.1
                        }],
                    },

                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: '',
                            }
                        }
                    }
                }

                this.chart = new Chart(ctx, config);
                
                //INIT SELECT2

                $('#objective_selector').select2(
                    {
                        placeholder: "Selecciona un objetivo",
                        theme: "bootstrap4"
                    }
                );
                const handleChangeObjective = (value) => {
                    this.changeObjective(value);
                }

                //ON CHANGE
                $('#objective_selector').on('change', function(e){
                    let value = e.target.value;
                    
                    handleChangeObjective(
                        value
                    );
                });
            } );
        }
        
    }

    changeObjective(value){
        this.selectedObjective = value;
        this.setState({
            loading: true,
            update: true,
        })
        
    }

    
}

export default ObjectiveEvolution;