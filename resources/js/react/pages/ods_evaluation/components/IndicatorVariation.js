import axios from "axios";
import React from "react";
import Chart from 'chart.js/auto';

class IndicatorVariation extends React.Component{

    constructor(props){
        super(props);

        this.state = { loading: true }

        this.objective = this.props.objective;

        this.dataSets = [];
        this.years = [];
        this.chart = {};

        this.target = 0;
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

        return(
            <div className="text-center">
                
                <canvas id="indicator_variation" height={'200px'}></canvas>
            </div>
        )

    }

    componentDidMount(){

        axios.post('/ods/objective/variationChart', {token: this.objective.token}).then( (response) => {

            let years = response.data.years;
            let variation = response.data.variation;

            this.target = response.data.targetValue;

            if ( typeof this.target == 'number') {
                $('#target_value').text( this.target.toFixed(6)+" "+this.objective.indicator );
            }else{
                $('#target_value').text( this.target );
            }
            

            let data = [];

            years.map( (year) => {

                data.push( variation[year] );
            } )

            this.years = years;
            this.dataSets = data;

            

            this.setState({loading: false})
        } ).then( () => {

            let ctx = document.getElementById('indicator_variation').getContext('2d');
    
            const config = {
                type: 'line',
                
                data:{
                    labels: this.years,

                    datasets: [{
                        label:  this.objective.indicator,
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
                                text: this.objective.indicator,
                                color: '#343a40',
                                font: {
                                  size: 12,
                                  weight: 'bold',
                                  lineHeight: 1.2,
                                  family: '"Roboto", "Helvetica Neue", Helvetica, Arial, sans-serif',
                                  
                                },
                                padding: {top: 0, left: 0, right: 0, bottom: 20},
                              
                            },


                            suggestedMin: this.target,
                           
                        }
                    }

                }
            }

            this.chart = new Chart(ctx, config);


            

        } ); 
    }

}

export default IndicatorVariation;