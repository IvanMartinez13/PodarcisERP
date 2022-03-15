import axios from "axios";
import React from "react";
import Chart from 'chart.js/auto';

class StrategyEvolution extends React.Component{

    constructor(props){
        super(props);

        this.strategy = this.props.strategy;

        this.state = {loading: true};

        this.dataSets = [];
        this.years = [];
    }

    render(){
        if (this.state.loading) {
            return(
                <div>
                    <div className="spiner-example">
                        <div className="sk-spinner sk-spinner-double-bounce">
                            <div className="sk-double-bounce1"></div>
                            <div className="sk-double-bounce2"></div>
                        </div>
                    </div>
                    <p className="mt-3 text-center"> Cargando... </p>       
                </div>
            )
        }
        return(
            <canvas id="strategy_evolution" className="animated fadeIn" height={200}></canvas>
        )
    }

    componentDidMount()
    {
        axios.post('/ods/strategy/evolution_chart', {token: this.strategy.token}).then( (response) => {
            let evaluations = response.data.evaluations;
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

            this.setState({loading: false});
        } ).then( () => {

            let ctx = document.getElementById('strategy_evolution').getContext('2d');
    
                const config = {
                    type: 'line',
                    
                    data:{
                        labels: this.years,
                        datasets: [{
                            label: this.strategy.indicator,
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

export default StrategyEvolution;