import axios from 'axios';
import React from 'react';

class CreateGroup extends React.Component{

    constructor(props){
        super(props);

        this.state = {
            loading: false,
        }

        this.name = '';

        this.vao_token = this.props.vao_token;
    }

    save()
    {
        if (this.name != '') {
            axios.post('/vao/create_layer_group', {token: this.vao_token, name: this.name}).then( (response) => {
                if (response.data.status == 'success') {
                    toastr.success(response.data.message);
                    $("#createGroup").modal('hide');
                    $("#group_name").val('');
                    this.name = '';
                }
            } );
        }else{
            toastr.error('El campo Nombre es obligatorio.');
        }
    }

    render(){
        return(

            <div className="modal fade" id="createGroup" tabIndex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div className="modal-dialog modal-lg" role="document">
                    <div className="modal-content bg-primary">
                            <div className="modal-header">
                                    <h5 className="modal-title"> Crear grupo de layers</h5>
                                        <button
                                                type="button"
                                                className="close"
                                                aria-label="Close"
                                                onClick={
                                                    () => {
                                                        $("#createGroup").modal('hide');
                                                    }
                                                }
                                        >
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                </div>
                        <div className="modal-body bg-white text-dark">
                            <div className="container-fluid">
                                
                                <div className='row'>
                                    <div className='col-lg-12'>
                                        <label htmlFor='group_name'>Nombre:</label>
                                        <input className='form-control' name='name' id="group_name" placeholder='Nombre...' onInput={
                                            (e) => {
                                                this.name = e.target.value;
                                                
                                            }
                                        }/>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div className="modal-footer bg-white text-dark">
                            <button type="button" className="btn btn-primary" onClick={
                                () => {
                                    this.save();
                                }
                            } >Crear</button>
                            <button type="button" className="btn btn-secondary"
                                onClick={
                                    () => {
                                        $("#createGroup").modal('hide');
                                    }
                                }
                                >Cancelar</button>
                            
                        </div>
                    </div>
                </div>
            </div>
            

        );
    }
}

export default CreateGroup;





