import React from "react";
import ReactDOM  from "react-dom";
import General from "./tabs/general/General";
import Visits from "./tabs/visits/Visits";

class Vao extends React.Component{

    constructor(props)
    {
        super(props);

        this.state = {
            loading: true,
        }

        this.vao = this.props.data;

    }

    render()
    {
        if (this.state.loading) {
            return(
                <div className="text-center">
                    <div className="spiner-example">
                        <div className="sk-spinner sk-spinner-double-bounce">
                            <div className="sk-double-bounce1"></div>
                            <div className="sk-double-bounce2"></div>
                        </div>
                    </div>

                    Cargando...
                </div>
            )
        }
        return(
            <div className="animated fadeIn">
                <div className="tabs-container">
                        <ul className="nav nav-tabs" role="tablist">
                            <li><a className="nav-link bg-transparent active" data-toggle="tab" href="#general-tab"> General</a></li>
                            <li><a className="nav-link bg-transparent" data-toggle="tab" href="#visits-tab">Visitas</a></li>
                        </ul>
                        <div className="tab-content">
                            <div role="tabpanel" id="general-tab" className="tab-pane active">
                                <div className="animated fadeIn panel-body bg-transparent">

                                    <General data={this.vao}></General>
                                </div>
                            </div>
                            <div role="tabpanel" id="visits-tab" className="tab-pane">
                                <div className="panel-body bg-transparent animated fadeIn">
                                    <Visits data={this.vao}></Visits>
                                </div>
                            </div>
                        </div>


                    </div>
            </div>

        )
    }

    componentDidMount()
    {
        setTimeout( () =>  {
            this.setState({loading: false});
        }, 1000 )
        
    }


}

export default Vao;

if (document.getElementsByTagName('vao').length >= 1) {
    
    let component = document.getElementsByTagName('vao')[0];
    let data = JSON.parse(component.getAttribute('data'));
    

    ReactDOM.render(<Vao data={data} />, component);
}
