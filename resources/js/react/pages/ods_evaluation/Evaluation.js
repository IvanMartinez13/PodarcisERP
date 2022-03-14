import React from "react";
import ReactDOM  from "react-dom";
import axios from "axios";
import RowEvaluation from "./components/RowEvaluation";

class Evaluation extends React.Component{

    constructor(props){

        super(props);

        this.state = {
            loading: true,
            save: false,
            rows: [],
        };

        this.yearToday = new Date().getFullYear();
        this.years = [];

        this.strategy = this.props.strategy;
        this.objective = this.props.objective;
        

        this.updateRows = this.updateRows.bind(this);


    }

    render(){

        {/* LOADING */}
        if (this.state.loading) {
            return(
                <div className="row">
                    <div className="col-lg-9">
                        <div className="ibox">
                            <div className="ibox-title">
                                <h5>{this.strategy.title}</h5>

                                <div className="ibox-tools">
                                    <a className="collapse-link" href="">
                                        <i className="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div className="ibox-content">

                                <div className="spiner-example">   
                                    <div className="sk-spinner sk-spinner-double-bounce">
                                        <div className="sk-double-bounce1"></div>
                                        <div className="sk-double-bounce2"></div>
                                    </div>
                                </div>

                                <p className="text-center">Cargando...</p>

                            </div>
                            <div className="ibox-footer">
                                Podarcis SL. &copy; {this.yearToday} 
                            </div>

                        </div>
                    </div>

                    <div className="col-lg-3 d-none d-lg-block">
                        <h4> {this.objective.title} </h4>

                        <p dangerouslySetInnerHTML={{ __html: this.objective.description }}></p>

                        <small><strong>Año base:</strong> {this.objective.base_year}</small> <br></br>
                        <small><strong>Indicador:</strong> {this.objective.indicator}</small>
                    </div>
                </div>


                );
        }

        {/* EVALUATION TABLE */}
        return(
            <div className="row">
                <div className="col-lg-9">
                    <div className="ibox">
                        <div className="ibox-title">
                            <h5>{this.strategy.title}</h5>

                            <div className="ibox-tools">
                                <a role={'button'} className="collapse-link">
                                    <i className="fa fa-chevron-up" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                        <div className="ibox-content">

                            {/* DESCRIPCIÓN */}
                            <div className="row mb-3">
                                <div className="col-md-6">
                                    <h5>Descripción</h5>
                                    <p dangerouslySetInnerHTML={{ __html: this.strategy.description }}></p>
                                </div>

                                <div className="col-md-6">
                                    <h5>Actuaciones</h5>
                                    <p dangerouslySetInnerHTML={{ __html: this.strategy.performances }}></p>
                                </div>

                                <div className="col-md-6">
                                    <h5>Indicador</h5>
                                    <p>{this.strategy.indicator}</p>
                                </div>

                                <div className="col-md-6">
                                    <h5>Evolución {this.strategy.title}</h5>
                                    <p>gráfico de la evolucion</p>
                                </div>
                            </div>

                            {/* BOTONES */}
                            <div className="row mb-3">
                                <div className="col-6 text-left">
                                    <button className="btn btn-primary" onClick={ () => {
                                        this.newRow()
                                    } }>
                                        Nueva fila...
                                    </button>
                                </div>
                                <div className="col-6 text-right">
                                    <button className="btn btn-primary" onClick={ () => {
                                        this.save();
                                    } }>
                                        Guardar
                                    </button>
                                </div>
                            </div>

                            {/* TABLA */}
                            <div className="table-responsive mb-3">
                                <table className="table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Archivo</th>
                                            <th>Año seleccionado</th>
                                            <th>Valor observado</th>
                                            <th>Eliminar</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        
                                        {   this.state.rows.map( (row, index) => {

                                                return(
                                                    
                                                    <RowEvaluation
                                                        key={row.id}
                                                        id={row.id}
                                                        year={row.year}
                                                        value={row.value}
                                                        years={this.years}
                                                        updateRows={this.updateRows}
                                                        files={row.files}
                                                    ></RowEvaluation>
                                                );
                                            } )
                                        }
                                        
                                    </tbody>
                                </table>
                            </div>

                            {/* BOTONES */} 
                            <div className="row mb-3">
                                <div className="col-6 text-left">
                                    <button className="btn btn-primary">
                                        Nueva fila...
                                    </button>
                                </div>
                                <div className="col-6 text-right">
                                    <button className="btn btn-primary">
                                        Guardar
                                    </button>
                                </div>
                            </div>

                        </div>
                        <div className="ibox-footer">
                            Podarcis SL. &copy; {this.yearToday}
                        </div>
                    </div>
                </div>

                <div className="col-lg-3 d-none d-lg-block">
                    <h4> {this.objective.title} </h4>

                    <p dangerouslySetInnerHTML={{ __html: this.objective.description }}></p>

                    <small><strong>Año base:</strong> {this.objective.base_year}</small> <br></br>
                    <small><strong>Indicador:</strong> {this.objective.indicator}</small>
                </div>
            </div>

        );
    }

    //ON MOUNT
    componentDidMount()
    {
        axios.post('/ods/evaluate/get_evaluations', {token: this.strategy.token}).then( (response) => {

            //GET YEARS
            for (let index = this.objective.base_year; index <= this.objective.target_year; index++) {
                this.years.push(index);
            }

            //PUSH ROWS
            let rows = this.state.rows;

            let evaluations = response.data.evaluations;


            if (evaluations != null) {
                
                //EVALUATIONS NOT NULL
                evaluations.map( (evaluation, index) => {

                    let item = {
                        index: rows.length,
                        id: evaluation.token,
                        year: evaluation.year,
                        value: evaluation.value,
                        files: evaluation.files,
                    }

                    rows.push(item); //PUSH ITEM
                } );
            }else{

                //EVALUATIONS IS NULL
                let item = {
                    index: 0,
                    id: 'row_0',
                    year: '',
                    value: '',
                    files: []
        
                }

                rows.push(item); //PUSH EMPTY ITEM
            }
            
            this.setState({loading:false, rows: rows, save: false});
        });
    }
    
    //METHODS
    newRow(){

        var rows = this.state.rows;

        let item = {
            index: rows.length,
            id: 'row_'+rows.length,
            year: '',
            value: '',
            files: []

        }

        rows.unshift(item);//PUSH TO TOP

        this.setState({
            loading: false,
            rows: rows,
        });

        console.log(rows);

        
    }

    updateRows(data){
        
        let id = data.id;
        let rows = this.state.rows;
        
        rows.map( (row, index) => {
            if (id == row.id) {
                rows[index] = data;
            }
        } );
    }

    save(){

        let rows = this.state.rows;
        let token = this.strategy.token;
        
        this.setState({loading: true});

        axios.post('/ods/evaluate/save', {data: rows, token: token}).then( (response) => {
            let data = response.data;

            if (data.status == "success") {
                
                toastr.success(data.message);
                this.setState({loading: false});

            }else{
                toastr.error(data.message);
                this.setState({loading: false});
            }

        } );
    }
}

export default Evaluation;

if (document.getElementsByTagName('evaluation').length >=1) {
    
    let component = document.getElementsByTagName('evaluation')[0];
    let strategy = JSON.parse(component.getAttribute('strategy'));
    let objective = JSON.parse(component.getAttribute('objective'));

    ReactDOM.render(<Evaluation strategy={strategy} objective={objective} />, component);
}