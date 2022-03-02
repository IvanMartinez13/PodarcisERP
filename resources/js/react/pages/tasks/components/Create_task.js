import axios from "axios";
import React from "react";

class Create_task extends React.Component{
    constructor(props){
        super(props);
        this.state = {loading: true}
        this.departaments = [];
        this.selectedDepartaments = [];
        this.project = this.props.project
        this.name = ''
    }

    render(){
        if (this.state.loading) {
            return(
                <div className="modal fade" id="addTask" tabIndex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div className="modal-dialog modal-xl" role="document">
                    <div className="modal-content bg-primary">
                            <div className="modal-header">
                                    <h5 className="modal-title">Añadir una tarea</h5>
                                        <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                </div>
                        <div className="modal-body bg-white text-dark">
                            <div className="spiner-example">
                                <div className="sk-spinner sk-spinner-double-bounce">
                                    <div className="sk-double-bounce1"></div>
                                    <div className="sk-double-bounce2"></div>
                                </div>

                                Cargando...
                            </div>
                        </div>
                        <div className="modal-footer bg-white text-dark">
                            <button type="button" className="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" className="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
            );
        }
        return(
            <div className="modal fade" id="addTask" tabIndex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div className="modal-dialog modal-xl" role="document">
                    <div className="modal-content bg-primary">
                            <div className="modal-header">
                                    <h5 className="modal-title">Añadir una tarea</h5>
                                        <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                </div>
                        <div className="modal-body bg-white text-dark">
                            <div className="container-fluid row">
                                <div className="col-lg-6">
                                    <label htmlFor="name">Nombre:</label>
                                    <input className="form-control" name="name" id="name" placeholder="Nombre..."></input>
                                </div>
                                <div className="col-lg-6">
                                    <label htmlFor="departaments">Departamentos:</label>
                                    <select className="form-control" style={{width: "100%"}} name="departaments" id="departaments" placeholder="Nombre..." multiple="multiple">
                                        
                                        {
                                            this.departaments.map( (departament, index) => {
                                                return(
                                                    <option key={departament.token+index} value={departament.token}>
                                                        {departament.name}
                                                    </option>
                                                );
                                            } )
                                        }
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div className="modal-footer bg-white text-dark">
                            <button type="button" className="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" className="btn btn-primary" data-dismiss="modal" onClick={() => { this.save() } }>Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        );
    }

    componentDidMount(){
        axios.post('/tasks/project/get_departaments').then( (response) => {

            this.departaments = response.data.departaments;
            this.setState({loading: false})
        } ).then( () => {

            $("#departaments").select2({
                theme: 'bootstrap4',
                placeholder: "Selecciona una estrategia...",
                width: 'resolve', // need to override the changed default
                allowClear: true
                
            });

            const handlePrepareValue = (key, value) => { this.prepareValue(key, value) };

            $('#departaments').on('change', (e) => {

                let value = e.target.value;
                if(!Array.isArray(value)){
                    value = [value];
                }
                handlePrepareValue("departaments", value);
            })

            
            $('#name').on('input', (e) => {

                let value = e.target.value;

                handlePrepareValue("name", value);
            })
        } );
    }

    prepareValue(key, value){

        if(key == "departaments"){
            this.selectedDepartaments = value;
        }
        
        if(key == "name"){
            this.name = value;
        }


    }

    save(){

        let data = {
            name: this.name,
            departaments: this.selectedDepartaments,
            project: this.project.id
        }
       
       axios.post('/tasks/project/add_task', data).then( (response) => {

        } )
    }

}

export default Create_task;