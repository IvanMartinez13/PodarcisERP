import axios from "axios";
import React from "react";
import Chart from 'chart.js/auto';

class EvolutionObjective extends React.Component{

    constructor(props){
        super(props);

        this.state = { loading: true }

        this.objective = this.props.objective;

        this.dataSets = [];
        this.years = [];

        this.chart = {};

        this.error = false;
    }

    render(){

        if (this.state.loading == true) {
            return(
                <div className="text-center">
                   <div className="spiner-example">   
                        <div className="sk-spinner sk-spinner-double-bounce">
                            <div className="sk-double-bounce1"></div>
                            <div className="sk-double-bounce2"></div>
                        </div>
                    </div>

                    <p className="text-center">Cargando...</p>
                </div>
            )
        }

        if (this.error) {
            return(
                <div className="text-center">
                    No existe ningún valor en el año de referencia.
                </div>
            )
        }

        return(
            <div>
                <canvas id="evolution_chart" height={'200px'}></canvas>
            </div>
        )
    }

    componentDidMount(){

        axios.post('/ods/objective/evolutionChart', {token: this.objective.token}).then( (response) => {

            let years = response.data.years;
            let percent = response.data.percent;

            let data = [];

            if (response.data.error != false) {
                this.error = true;
            }else{
                years.map( (year) => {

                    data.push( percent[year] );
                } )
    
                this.years = years;
                this.dataSets = data;
            }



     

            this.setState({loading: false});


        } ).then( () => {

            if (this.error == false) {

                let ctx = document.getElementById('evolution_chart').getContext('2d');
        
                const config = {
                    type: 'line',
                    
                    data:{
                        labels: this.years,

                        datasets: [{
                            label: '% de cumplimiento',
                            data: this.dataSets,
                            fill: false,
                            borderColor: '#1AB394',
                            backgroundColor: '#1AB394',
                            tension: 0.2,
                            
                        }],
                    },

                    options: {
                        responsive: true,

                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },

                        plugins: {
                            legend: {
                                position: 'top',
                            },
                        },
                
                        hover: {
                            mode: 'nearest',
                            intersect: true
                        },

                        scales: {

                            x:{
                                title: {
                                    display: true,
                                    text: 'Años',
                                    color: '#343a40',
                                    font: {
                                    size: 12,
                                    weight: 'bold',
                                    lineHeight: 1.2,
                                    family: '"Roboto", "Helvetica Neue", Helvetica, Arial, sans-serif',
                                    
                                    },
                                    padding: {top: 20, left: 0, right: 0, bottom: 0}
                                }
                            },

                            y:{
                                title: {
                                    display: true,
                                    text: '% de cumplimiento',
                                    color: '#343a40',
                                    font: {
                                    size: 12,
                                    weight: 'bold',
                                    lineHeight: 1.2,
                                    family: '"Roboto", "Helvetica Neue", Helvetica, Arial, sans-serif',
                                    
                                    },
                                    padding: {top: 0, left: 0, right: 0, bottom: 20}
                                },

                                beginAtZero: true,   // minimum value will be 0.
                                suggestedMax: 100,    // minimum will be 0, unless there is a lower value.

                            }
                        }

                    }
                }

                this.chart = new Chart(ctx, config);
            }
        } ); 
    }

}

export default EvolutionObjective;