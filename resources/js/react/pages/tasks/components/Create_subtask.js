import axios from "axios";
import React from "react";

class Create_subtask extends React.Component{

    constructor(props){
        super(props);
        
        this.name = '';
        this.description = '';
        this.task = this.props.task;

        this.setLoading = (data) => {
            this.props.setLoading(data);
        }

        this.setSaving = (data) => {
            this.props.setSaving(data);
        }

        
    }

    render(){
        return(
            <div className="modal fade" id="modalSubtask" tabIndex="-1" role="dialog" aria-labelledby="modalSubtaskLabel" aria-hidden="true">
                <div className="modal-dialog modal-xl" role="document">
                    <div className="modal-content bg-primary">
                        <div className="modal-header">
                            <h5 className="modal-title" id="modalSubtaskLabel">Añadir subtarea</h5>
                            <button
                                type="button"
                                className="close"
                                aria-label="Close"
                                onClick={() => {
                                    $('#modalSubtask').modal('hide');
                                }}
                            >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div className="modal-body bg-white text-dark">
                            <div className="row">
                                <div className="col-lg-12 my-3">
                                    <label htmlFor="name">Nombre:</label>
                                    <input
                                        id="name"
                                        className="form-control"
                                        name="name"
                                        placeholder="Nombre..."
                                    ></input>
                                </div>

                                <div className="col-lg-12 my-3">
                                    <label htmlFor="description">Descripción:</label>
                                    <textarea
                                        id="description"
                                        className="form-control"
                                        name="description"
                                        placeholder="Descripción..."
                                        rows={5}
                                    ></textarea>
                                </div>
                            </div>
                        </div>
                        <div className="modal-footer bg-white text-dark">
                            <button
                                type="button"
                                className="btn btn-primary"
                                onClick={() => {
                                    this.save();
                                }}
                            >Crear</button>
                            <button
                                type="button"
                                className="btn btn-secondary"
                                onClick={() => {
                                    $('#modalSubtask').modal('hide');
                                }}
                            >Cerrar</button>
                            
                        </div>
                    </div>
                </div>
            </div>
        );
    }

    componentDidMount(){
        
        $('#description').summernote({
            placeholder: "Descripción...",
            height: 200
        });

        const handlePrepareValue = (key, value) => {
            this.prepareData(key, value);
        }

        $("#name").on("input", function(e){
            let value = e.target.value;

            handlePrepareValue("name", value);
        })

        $("#description").on("summernote.change", function (e) {   // callback as jquery custom event 
            let value = e.target.value;

            handlePrepareValue("description", value);
        });

        
    }

    prepareData(key, value){
        
        if (key == "name") {
            this.name = value;
        }

        if (key == "description") {
            this.description = value;
        }

    }

    save(){

        let data = {
            name: this.name,
            description: this.description,
            task: this.task,
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

        if (!has_errors) {
            axios.post('/tasks/project/task/add_subtask', data).then( (response) => {
                if (response.data.status  == 'success') {
                    toastr.success(response.data.message);

                    //CLOSE MODAL
                    $('#modalSubtask').modal('hide');
                    
                    this.description = '';
                    this.name = '';

                    $('#name').val(null);
                    $('#description').val(null);
                    $('#description').summernote('reset');

                    //UPLOAD PARENT
                    this.setLoading(true);
                    this.setSaving(true);

                }

                if (response.data.status  == 'error') {
                    toastr.error(response.data.message);
                }
            } );
        }

        
    }
}

export default Create_subtask;