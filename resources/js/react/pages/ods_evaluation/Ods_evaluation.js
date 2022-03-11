import axios from "axios";
import React from "react";
import ReactDOM from 'react-dom';
import Evaluation_row from './components/Evaluation_row';



class Ods_evaluation extends React.Component{

    constructor(props){
        super(props)

        this.state = {  
                        loading: true,
                        rows: []
                        
                    }

        this.strategies = this.props.strategies;
        this.objective = this.props.objective;
        this.yearToday = new Date().getFullYear();

        this.years = [];

        this.setRows = this.setRows.bind(this);
        
    }

    

    render(){
        {/* LOADING */}
        if (this.state.loading) {
            return(

                <div className="ibox">
                    <div className="ibox-title">
                        <h5>{this.objective.title}</h5>

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

                );
        }
        {/* TABLE */}
        return(
            <div className="ibox">
                <div className="ibox-title">
                    <h5>{this.objective.title}</h5>

                    <div className="ibox-tools">
                        <a className="collapse-link" href="">
                            <i className="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div className="ibox-content">
                    <div className="row">
                        <div className="col-lg-6">
                            <h5>
                                Descripción del objetivo
                            </h5>
                            <p   dangerouslySetInnerHTML={{
                                    __html: this.objective.description
                                }}>     
                            </p>
                        </div>

                        <div className="col-lg-6">
                            <h5>
                                Indicador del objetivo
                            </h5>
                            <p>
                                {this.objective.indicator}
                            </p>
                        </div>

                        <div className="col-lg-6">
                            <h5>
                                Descripción de la estrategia
                            </h5>
                            <p id="description_field">     
                            </p>
                        </div>

                        <div className="col-lg-6">
                            <h5>
                                Actuaciones de la estrategia
                            </h5>
                            <p id="performance_field">
                               
                            </p>
                        </div>
                    </div>
                    
                    <div className="row my-3">
                        <div className="col-6 text-left">
                            <button className="btn btn-primary" onClick={() => {

                                this.addRow();

                            }}>
                                Nueva fila...
                            </button>
                        </div>
                        <div className="col-6 text-right">
                            <button className="btn btn-primary" onClick={() => {
                                this.save();
                            }}>
                                Guardar
                            </button>
                        </div>
                    </div>

                    <div className="table-responsive">
                        
                        <table className="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th style={{width: "10%"}}>Archivo</th>
                                    <th style={{width: "20%"}}>Estrategia</th>
                                    <th style={{width: "20%"}}>Indicador</th>
                                    <th style={{width: "20%"}}>Año</th>
                                    <th style={{width: "20%"}}>Valor</th>
                                    <th style={{width: "10%"}}>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                {
                                    this.state.rows.map( (row, index) => {
                                        return(
                                            <Evaluation_row key={index}
                                                id={row.id}
                                                years={this.years}
                                                strategies={this.strategies}
                                                objective={this.objective}
                                                strategy ={row.strategy}
                                                year = {row.year}
                                                indicator = {row.indicator}
                                                value = {row.value}
                                                setRows={this.setRows}
                                                files={row.files}

                                                
                                            ></Evaluation_row>
                                        );
                                    }
                                        
                                    )
                                }

                                {/* SAVED ENTRIES SHOW HERE */}
                                
                            </tbody>
                        </table>
                    </div>

                    <div className="row my-3">
                        <div className="col-6 text-left">
                            <button className="btn btn-primary" onClick={() => {

                                this.addRow();

                            }}>
                                Nueva fila...
                            </button>
                        </div>
                        <div className="col-6 text-right">
                            <button className="btn btn-primary" onClick={() => {
                                this.save();
                            }}>
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>

                <div className="ibox-footer">
                    Podarcis SL. &copy; {this.yearToday} 
                </div>
            </div>
        )
    }

    componentDidMount(){

        axios.post('/ods/evaluate/get_evaluations', {token: this.objective.token}).then( (response) => {
            for (let index = this.objective.base_year; index <= this.objective.target_year; index++) {
                this.years.push(index);
            }
            //push all the rows
            let rows = this.state.rows;
            let evaluations = response.data.evaluations;
            
            if (evaluations != null) {
                evaluations.map( (evaluation) => {
                    let item = {
                        index: rows.length,
                        id: evaluation.token,
                        strategy: evaluation.strategy,
                        indicator: evaluation.strategy.indicator,
                        year: evaluation.year,
                        value: evaluation.value,
                        files: evaluation.files,
                    }

                    rows.push(item)
    
                    
                } )
            }else{

                let item ={
                    index: 0,
                    id: 0,
                    strategy: '',
                    indicator:'',
                    year: '',
                    value: '',
                    files: []

                }

                rows.push(item)
    
            }


            console.log(evaluations)
            this.setState({loading:false, rows: rows});
        } )



        
    }

    addRow(){

        var rows = this.state.rows;

        let item = {
            index: rows.length,
            id: rows.length,
            strategy: '',
            indicator:'',
            year: '',
            value: '',
            files: []

        }



        rows.push(item);

        this.setState({
            loading: false,
            rows: rows,
        });

        

    }

    save(){
        this.setState({loading: true});

        console.log(this.state.rows);

        axios.post('/ods/evaluate/save',
        
            {
                rows: this.state.rows,
            },

        
        ).then( (response) => {
            if (response.data.status == 'success') {
                toastr.success(response.data.message);
                this.setState({loading: false});
            }else{
                toastr.error(response.data.message);
                this.setState({loading: false});
            }
        } );
    }

    setRows(childData){

        //1) GET DATA
        let data = {
            index: 0,
            id: childData.id,
            strategy: childData.strategy,
            indicator: childData.indicator,
            year: childData.year,
            value: childData.value,
            files: childData.files,

        }

        //2) VALIDATE DATA
        let canPush = true;
        if (data.strategy == null || data.strategy == {}) {
            canPush = false;
        }

        if (data.indicator == null || data.indicator == '') {
            canPush = false;
        }

        if (data.year == null || data.year == '' || data.year == 0) {
            canPush = false;
        }

        if (data.value == null || data.value == '') {
            canPush = false;
        }

        let rows  = this.state.rows;

        rows.map( (row, index) => {
            if(row.id == childData.id){
                //UPDATE ROW
                data.index = row.index;
                rows[index] = data;
            }
        } )


        this.setState({loading: false, rows: rows});

        
    }
}

export default Ods_evaluation;

if (document.getElementsByTagName('ods-evaluation').length >=1) {
    
    let component = document.getElementsByTagName('ods-evaluation')[0];
    let strategies = JSON.parse(component.getAttribute('strategies'));
    let objective = JSON.parse(component.getAttribute('objective'));

    ReactDOM.render(<Ods_evaluation strategies={strategies} objective={objective} />, component);
}