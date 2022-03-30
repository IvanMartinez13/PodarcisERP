import axios from "axios";
import React from "react";
import ReactDOM  from "react-dom";
import RowObjective_evaluation from "./components/RowObjective_evaluation";
import IndicatorVariation from "./components/IndicatorVariation";
import EvolutionObjective from "./components/EvolutionObjective";

class Objective_evaluation extends React.Component{

    constructor(props){
        super(props)

        this.update = this.props.update;
        this.del = this.props.delete;

        this.objective = this.props.objective;
        this.years = [];

        this.state = {
            loading: true,
            save: false,
            saved: false,
            rows: [],
        };

        this.updateRows = this.updateRows.bind(this);

    }

    render(){
        {/* LOADING */}
        if (this.state.loading) {
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


                );
        }

        return(
            <div className="animated fadeInRight">

                <div className="row mx-1 mb-3">

                    <div className="col-lg-4">
                        <h5>Descripción</h5>
                        <p dangerouslySetInnerHTML={{ __html: this.objective.description }}>
                        </p>

                        <h5>Indicador</h5>
                        <p>
                            {this.objective.indicator}
                        </p>
                    </div>

                    <div className="col-lg-4">

                        <div className="row">
                            <div className="col-lg-6">
                                <h5>Año de referencia</h5>
                                {this.objective.base_year}

                                <h5>Año del objetivo</h5>
                                {this.objective.target_year}
                            </div>

                            <div className="col-lg-6">
                                <h5>Reducción Objetivo(%)</h5>
                                {this.objective.target} %

                                <h5>Valor objetivo</h5>
                                <span id="target_value"></span>
                            </div>
                        </div>
                        
                    </div>

                    <div className="col-lg-4">
                        <h5 className="text-center">VARIACIÓN de {this.objective.indicator}</h5>
                        <IndicatorVariation objective={this.objective} />
                    </div>
                </div>

                {
                    (this.update == 1) ?  
                    
                    <div className="row mx-1 mb-3">
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
                    :  
                    <div className="alert alert-warning">No tienes permisos para modificar esta tabla</div>
                }

                <div className="container-fluid table-responsive">
                    <table className="table table-hover table-bordered table-striped">

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
                                        
                                        <RowObjective_evaluation
                                            key={row.id+index}
                                            id={row.id}
                                            year={row.year}
                                            value={row.value}
                                            years={this.years}
                                            files={row.files}
                                            updateRows={this.updateRows}
                                            delete={row.delete}
                                            update={this.update}
                                            del={this.del}
                                        />
                                    );
                                } )
                            }
          
                        </tbody>

                    </table>
                </div>


                {
                    (this.update == 1) ?  
                    
                    <div className="row mx-1 mb-3">
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
                    :  
                    <div className="alert alert-warning">No tienes permisos para modificar esta tabla</div>
                }

 
            </div>

        )
    }


    newRow(){

        var rows = this.state.rows;

        let item = {
            index: rows.length,
            id: 'row_'+rows.length,
            year: '',
            value: '',
            files: [],
            delete: false,

        }

        rows.unshift(item);//PUSH TO TOP

        this.setState({
            loading: false,
            rows: rows,
        });


    }

    //ON MOUNT
    componentDidMount(){

        axios.post('/ods/objective/get_evaluations', {token: this.objective.token}).then( (response) => {

            let evaluations = response.data.evaluations;

            var rows = this.state.rows;

            if (evaluations.length == 0) {//EVALUATIONS IS EMPTY
               this.newRow();
            }

            
            evaluations.map( (evaluation, index) => {//EVALUATION MAP

                let item = {
                    index: index,
                    id: evaluation.token,
                    year: evaluation.year,
                    value: evaluation.value,
                    files: evaluation.files,
                    delete: false,
        
                }

                rows.push(item); //PUSH TO TOP
            } );


            for (let index = this.objective.base_year; index <= this.objective.target_year; index++) {
                this.years.push(index)
            }

            this.setState({
                loading: false,
                rows: rows,
            });
        } )





    }

    componentDidUpdate(){

        if (this.state.saved == true) {
            axios.post('/ods/objective/get_evaluations', {token: this.objective.token}).then( (response) => {

                let evaluations = response.data.evaluations;
                var rows = [];
    
                if (evaluations.length == 0) {//EVALUATIONS IS EMPTY
                   this.newRow();
                }
    
                
                evaluations.map( (evaluation, index) => {//EVALUATION MAP
    
                    let item = {
                        index: index,
                        id: evaluation.token,
                        year: evaluation.year,
                        value: evaluation.value,
                        files: evaluation.files,
                        delete: false,
            
                    }
    
                    rows.push(item); //PUSH TO TOP
                } );

                this.years = [];
    
                for (let index = this.objective.base_year; index <= this.objective.target_year; index++) {
                    this.years.push(index)
                }
    
                this.setState({
                    loading: false,
                    save: false,
                    saved: false,
                    rows: rows,
                });
            } )
    
        }


    }

    updateRows(data){

        let id = data.id;
        let rows = this.state.rows;
        
        rows.map( (row, index) => {
            if (id == row.id) {
                rows[index] = data;
            }
        } );


        this.setState({
            loading: false,
            rows: rows,
        });
    }

    save(){


        let rows = this.state.rows;
        let token = this.objective.token;

        this.setState({loading: true, save: true});

        axios.post('/ods/objective/evaluate/save', {data: rows, token: token}).then( (response) => {
            if (response.data.status == 'success') {
                
                toastr.success( response.data.message )

                this.setState({saved: true});
            }else{
                
                toastr.error( response.data.message )

                this.setState({saved: true});
            }
        })
    }


}

export default Objective_evaluation;

if (document.getElementsByTagName('objective-evaluation').length >=1) {
    
    let component = document.getElementsByTagName('objective-evaluation')[0];
    let update = component.getAttribute('update');
    let del = component.getAttribute('delete');
    let objective = JSON.parse(component.getAttribute('objective'));
    /*let strategy = JSON.parse(component.getAttribute('strategy'));
    let objective = JSON.parse(component.getAttribute('objective'));
    let update = component.getAttribute('update');
    let del = component.getAttribute('delete');*/
    

    ReactDOM.render(<Objective_evaluation update={update} objective={objective} delete={del} />, component);
}