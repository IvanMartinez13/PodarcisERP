import axios from "axios";
import React from "react";

class Cards extends React.Component{

    constructor(props)
    {
        super(props)

        this.state = {
            loading: true
        }

        this.objective = this.props.objective;
    }

    render()
    {

        return(
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
        )
    }

    componentDidMount(){

        axios.post('/ods/dashboard/cards', {token: this.objective}).then( (response) => {

            console.log(response.data)
        } )
    }
}

export default Cards;