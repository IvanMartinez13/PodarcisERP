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

        this.objective = this.props.objective;
        this.indicator = this.props.indicator;
        this.title = this.props.title;

        this.dataSets = [];
        this.years = [];

        this.onlyChart = this.props.onlyChart;
    }


    render(){
        if (this.onlyChart) {

            return(
                <div>
                    <h5 className="text-center" >VARIACIÓN DE {this.indicator}</h5>

                    <canvas id="objective_chart" ></canvas>
                </div>
                
            )
            
        }
        return(
            <div className="ibox">
                <div className="ibox-title bg-primary">
                    <h5>Evolución del {this.title}</h5>
                </div>
                <div className="ibox-content">
                    <div>
                        <canvas id="objective_chart" width="100%"></canvas>
                    </div>
                    
                </div>

                <div className="ibox-footer">
                    Podarcis SL. &copy; 2022
                </div>
            </div>
        )
    }

    componentDidMount(){

        axios.post('/ods/dashboard/objective/evolution', {token: this.objective}).then( (response) => {

            let years = response.data.years;
            let evaluations = response.data.evaluations;
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

        } ).then( () => {

            let ctx = document.getElementById('objective_chart').getContext('2d');
    
            const config = {
                type: 'line',
                
                data:{
                    labels: this.years,
                    datasets: [{
                        label: this.indicator,
                        data: this.dataSets,
                        fill: false,
                        borderColor: '#1AB394',
                        backgroundColor: '#1AB394',
                        tension: 0.2,
                        yAxisID: 'A',
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

                }
            }

            this.chart = new Chart(ctx, config);
        } );
    }

    
}

export default ObjectiveEvolution;