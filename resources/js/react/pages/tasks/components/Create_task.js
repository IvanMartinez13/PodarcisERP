import axios from "axios";
import React from "react";

class Create_task extends React.Component{
    constructor(props){
        super(props);

        this.state = {loading: true}
        this.departaments = [];
        this.project = this.props.project;

        this.selectedDepartaments = [];
        this.description = '';
        this.name = '';
    }

    render(){
        if (this.state.loading) {
            return(
                <div className="modal fade" id="addTask" tabIndex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                    <div className="modal-dialog modal-xl" role="document">
                        <div className="modal-content bg-primary">
                                <div className="modal-header">
                                        <h5 className="modal-title">Añadir una tarea</h5>
                                            <button type="button" className="close" aria-label="Close" onClick={() => {
                                    $('#addTask').modal('hide')
                                }}>
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
                                <button type="button" className="btn btn-primary">Crear</button>
                                <button type="button"
                                        className="btn btn-secondary"
                                        onClick={() => {
                                            $('#addTask').modal('hide')
                                        }}>
                                    Cerrar
                                </button>
                                
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
                                        <button
                                            type="button"
                                            className="close"
                                            onClick={() => {
                                                $('#addTask').modal('hide')
                                            }}
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                </div>
                        <div className="modal-body bg-white text-dark">
                            <div className="container-fluid row">
                                <div className="col-lg-6 mb-3">
                                    <label htmlFor="name">Nombre:</label>
                                    <input className="form-control" name="name" id="name" placeholder="Nombre..."></input>
                                </div>
                                <div className="col-lg-6 mb-3">
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

                                <div className="col-lg-12 mb-3">
                                    <label htmlFor="description">Descripción:</label>
                                    <textarea className="form-control" name="description" id="description" placeholder="Descripción..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div className="modal-footer bg-white text-dark">

                            <button type="button" className="btn btn-primary" onClick={() => { this.save() } }>Crear</button>

                            <button
                                type="button"
                                className="btn btn-secondary"
                                onClick={() => {
                                            $('#addTask').modal('hide')
                                        }}>
                                Cerrar
                            </button>
                            
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
                dropdownParent: $('#addTask'), //FIXED COMMON PROBLEMS WHEN USES BOOTSTRAP MODAL
                theme: 'bootstrap4',
                placeholder: "Selecciona un departamento...",
                width: '100%', // need to override the changed default
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
            });

            $('#description').summernote({
                placeholder: "Descripción...",
                height: '100px',
            });

            $("#description").on("summernote.change", function (e) {   // callback as jquery custom event 
                let value = e.target.value;

                handlePrepareValue("description", value);
            });
        } );
    }

    prepareValue(key, value){

        if(key == "departaments"){
            this.selectedDepartaments = value;
        }
        
        if(key == "name"){
            this.name = value;
        }

        if(key == "description"){
            this.description = value;
        }
        

    }

    save(){

        let data = {
            name: this.name,
            description: this.description,
            departaments: this.selectedDepartaments,
            project: this.project.id,
        }

        //VALIDATE DATA
        let has_errors=false;

        if (data.name == '' || data.name == null) {
            has_errors=true;
            toastr.error('El campo Nombre es obligatorio')
        }

        
        if (data.description == '' || data.description == null) {
            has_errors=true;
            toastr.error('El campo Descripción es obligatorio')
        }

        if (data.departaments == '' || data.departaments == null || data.departaments == []) {
            has_errors=true;
            toastr.error('El campo Departamentos es obligatorio')
        }

        if (!has_errors) {
            //SEND DATA
            axios.post('/tasks/project/add_task', data).then( (response) => {

                if (response.data.status  == 'success') {
                    toastr.success(response.data.message);
                    //CLOSE MODAL
                    $('#addTask').modal('hide');
                    
                    this.selectedDepartaments = [];
                    this.description = '';
                    this.name = '';

                    $('#departaments').empty();
                    $('#name').val(null);
                    $('#description').val(null);
                    $('#description').summernote('reset');

                    location.reload();

                }

                if (response.data.status  == 'error') {
                    toastr.error(response.data.message);
                }
            } )
        }
    }

}

export default Create_task;