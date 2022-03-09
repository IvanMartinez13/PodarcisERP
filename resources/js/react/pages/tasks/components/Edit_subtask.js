import axios from "axios";
import React from "react";

class Edit_subtask extends React.Component{

    constructor(props){
        super(props);
        
        this.id = this.props.id;
        this.name = this.props.subtask.name;
        this.description = this.props.subtask.description;
        this.task = this.props.task;
        this.subtask = this.props.subtask;

        this.setLoading = (data) => {
            this.props.setLoading(data);
        }

        this.setSaving = (data) => {
            this.props.setSaving(data);
        }

        
    }

    render(){
        return(
            <div className="modal fade" id={"editModalSubtask"+this.id} tabIndex="-1" role="dialog" aria-labelledby={"editModalSubtaskLabel"+this.id} aria-hidden="true">
                <div className="modal-dialog modal-xl" role="document">
                    <div className="modal-content bg-primary">
                        <div className="modal-header">
                            <h5 className="modal-title" id={"editModalSubtaskLabel"+this.id}>Editar subtarea</h5>
                            <button
                                type="button"
                                className="close"
                                aria-label="Close"
                                onClick={() => {
                                    $('#editModalSubtask'+this.id).modal('hide');
                                }}
                            >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div className="modal-body bg-white text-dark">
                            <div className="row">
                                <div className="col-lg-12 my-3">
                                    <label htmlFor={"name"+this.id}>Nombre:</label>
                                    <input
                                        id={"name"+this.id}
                                        className="form-control"
                                        name="name"
                                        placeholder="Nombre..."
                                        defaultValue={this.subtask.name}
                                    ></input>
                                </div>

                                <div className="col-lg-12 my-3">
                                    <label htmlFor={"description"+this.id}>Descripción:</label>
                                    <textarea
                                        id={"description"+this.id}
                                        className="form-control"
                                        name="description"
                                        placeholder="Descripción..."
                                        rows={5}
                                        defaultValue={this.subtask.description}
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
                            >Editar</button>
                            <button
                                type="button"
                                className="btn btn-secondary"
                                onClick={() => {
                                    $('#editModalSubtask'+this.id).modal('hide');
                                }}
                            >Cerrar</button>
                            
                        </div>
                    </div>
                </div>
            </div>
        );
    }

    componentDidMount(){
        
        $('#description'+this.id).summernote({
            placeholder: "Descripción...",
            height: 200
        });

        const handlePrepareValue = (key, value) => {
            this.prepareData(key, value);
        }

        $("#name"+this.id).on("input", function(e){
            let value = e.target.value;

            handlePrepareValue("name", value);
        })

        $("#description"+this.id).on("summernote.change", function (e) {   // callback as jquery custom event 
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
            task: this.subtask.token,
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
            axios.post('/tasks/project/task/update_subtask', data).then( (response) => {
                if (response.data.status  == 'success') {
                    toastr.success(response.data.message);

                    //CLOSE MODAL
                    $('#editModalSubtask'+this.id).modal('hide');
                    
                    this.description = '';
                    this.name = '';

                    $('#name'+this.id).val(null);
                    $('#description'+this.id).val(null);
                    $('#description'+this.id).summernote('reset');

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

export default Edit_subtask;