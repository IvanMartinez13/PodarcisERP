import axios from "axios";
import React from "react";
import ReactDOM from "react-dom";
import ObjectiveEvolution from "./components/ObjectiveEvolution";

class DashboardOds extends React.Component{

    constructor(props){
        super(props);

        this.state = {
            loading: true,
            update: false,
        
        }

        this.objectives = [];
        
        this.objective = '';
        this.indicator = '';
        this.title = '';

    }

    render(){
        if (this.state.loading) {
            return(
                <div className="animated fadeInRight">
                    <div className="spiner-example">
                        <div className="sk-spinner sk-spinner-double-bounce">
                            <div className="sk-double-bounce1"></div>
                            <div className="sk-double-bounce2"></div>
                        </div>
                    </div>
                    <p className="mt-3 text-center"> Cargando... </p>
                </div>


            );
        }
        return(
            

            <div className="row animated fadeInRight">
                <div className="col-12 mb-3">
                    <label htmlFor="objective_selector">
                        Selecciona un objetivo:
                    </label>
                    <select id="objective_selector" defaultValue={this.objective}>
                        {
                            this.objectives.map( (objective, index) => {
                                return(
                                    <option key={objective.token+index} value={objective.token}>{objective.title}</option>
                                );
                            } )
                        }
                    </select>
                    
                </div>

                <div className="col-lg-6">

                   <ObjectiveEvolution objective={this.objective} indicator={this.indicator} title={this.title}></ObjectiveEvolution>
                </div>

                <div className="col-lg-6">
                    <div className="row">

                        <div className="col-lg-6">
                            <div className="ibox">
                                <div className="ibox-title bg-primary">
                                    <h5>Valor objetivo</h5>
                                </div>

                                <div className="ibox-content">
                                    <h1>5,492</h1>
                                    <small>Respecto al año base 2019.</small>
                                </div>

                                <div className="ibox-footer">
                                    Podarcis SL. &copy; 2022
                                </div>
                            </div>
                        </div>

                        <div className="col-lg-6">
                            <div className="ibox">
                                <div className="ibox-title bg-primary">
                                    <h5>Variación respecto al año base</h5>
                                </div>

                                <div className="ibox-content">
                                    <h1>5,492</h1>
                                    <small>Respecto al año base 2019.</small>
                                </div>

                                <div className="ibox-footer">
                                    Podarcis SL. &copy; 2022
                                </div>
                            </div>
                        </div>

                        <div className="col-lg-6">
                            <div className="ibox">
                                <div className="ibox-title bg-primary">
                                    <h5>Variación respecto del valor objetivo</h5>
                                </div>

                                <div className="ibox-content">
                                    <h1>5,492</h1>
                                    <small>Respecto valor objetivo.</small>
                                </div>

                                <div className="ibox-footer">
                                    Podarcis SL. &copy; 2022
                                </div>
                            </div>
                        </div>

                        <div className="col-lg-6">
                            <div className="ibox">
                                <div className="ibox-title bg-primary">
                                    <h5>% de reducción respecto del año base</h5>
                                </div>

                                <div className="ibox-content">
                                    <h1>5,492</h1>
                                    <small>Respecto al año base 2019.</small>
                                </div>

                                <div className="ibox-footer">
                                    Podarcis SL. &copy; 2022
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            
        );

    }

    componentDidMount(){
        axios.post('/ods/dashboard').then( (response) => {

            this.objectives = response.data.objectives;

            this.objective = this.objectives[0]['token'];
            this.indicator = this.objectives[0]['indicator'];
            this.title = this.objectives[0]['title'];

            //CHANGE STATE
            this.setState({
                loading: false
            });
        } ).then( () => {

            $('#objective_selector').select2(
                {
                    placeholder: "Selecciona un objetivo",
                    theme: "bootstrap4",
                    width: "250px"
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
        if (this.state.update == true) {

            axios.post('/ods/dashboard').then( (response) => {

                this.objectives = response.data.objectives;
    
                //CHANGE STATE
                this.setState({
                    loading: false,
                    update:false
                });

            } ).then( () => {
    
                $('#objective_selector').select2(
                    {
                        placeholder: "Selecciona un objetivo",
                        theme: "bootstrap4",
                        width: "250px"
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

    changeObjective(value)
    {
        this.objective = value;

        this.objectives.map( (obj, key) => {
            if (obj.token == this.objective) {
                
                this.indicator = this.objectives[key]['indicator'];
                this.title = this.objectives[key]['title'];
            }

        } );
 

        this.setState({
            loading: true,
            update: true,
        })
        
    }
}

export default DashboardOds;

if (document.getElementsByTagName('dashboard-ods').length >=1) {
    
    let component = document.getElementsByTagName('dashboard-ods')[0];

    ReactDOM.render(<DashboardOds />, component);
}