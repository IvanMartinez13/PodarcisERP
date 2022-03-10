import axios from "axios";
import React from "react";
import ReactDOM from "react-dom";
import ObjectiveEvolution from "./components/ObjectiveEvolution";

class DashboardOds extends React.Component{

    constructor(props){
        super(props);

        this.state = {
            loading: true
        }

        this.objectives = []
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


            );
        }
        return(
            <div>
                <div className="row">
                    <div className="col-lg-4">
                        
                        <ObjectiveEvolution objectives={this.objectives}></ObjectiveEvolution>
                        
                    </div>

                    <div className="col-lg-4">

                    </div>

                    <div className="col-lg-4">

                    </div>
                </div>
            </div>
        );
    }

    componentDidMount(){
        axios.post('/ods/dashboard').then( (response) => {

            this.objectives = response.data.objectives;

            //CHANGE STATE
            this.setState({
                loading: false
            });
        } );
    }
}

export default DashboardOds;

if (document.getElementsByTagName('dashboard-ods').length >=1) {
    
    let component = document.getElementsByTagName('dashboard-ods')[0];

    ReactDOM.render(<DashboardOds />, component);
}