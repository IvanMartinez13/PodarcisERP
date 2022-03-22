import axios from "axios";
import React from "react";

class AddLayer extends React.Component{

    constructor(props)
    {
        super(props);

        this.vao_token = this.props.vao_token

        this.state = { loading: true };

        this.layer_groups = [];

        this.data = {
            name: '',
            type: '',
            group:'',
            file: '',
        };
    }

    render()
    {
        if (this.state.loading) {

            return(
                <div className="modal fade" id="addLayer" tabIndex="-1" role="dialog" aria-labelledby="modeladdLayer" aria-hidden="true">
                    <div className="modal-dialog modal-xl" role="document">
                        <div className="modal-content bg-primary">
                            <div className="modal-header">
                                    <h5 className="modal-title">Añadir archivo</h5>
                                        <button
                                            type="button"
                                            className="close"
                                            data-dismiss="modal"
                                            aria-label="Close"
                                            onClick={
                                                () => {
                                                    $("#addLayer").modal('hide');
                                                }
                                            }>
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                            </div>

                            <div className="modal-body bg-white text-dark">
                                <div className="container-fluid text-center">
                                <div className="spiner-example">
                                    <div className="sk-spinner sk-spinner-double-bounce">
                                        <div className="sk-double-bounce1"></div>
                                        <div className="sk-double-bounce2"></div>
                                    </div>
                                </div>
                                    Cargando...
                                </div>
                            </div>
                            <div className="modal-footer bg-white text-dark">
                                
                                <button
                                    type="button"
                                    className="btn btn-primary"
                                >Crear</button>
                                <button
                                type="button"
                                className="btn btn-secondary"
                                data-dismiss="modal"
                                onClick={
                                    () => {
                                        $("#addLayer").modal('hide');
                                    }
                                }>Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            );
            
        }

        return(
            <div className="modal fade" id="addLayer" tabIndex="-1" role="dialog" aria-labelledby="modeladdLayer" aria-hidden="true">
                <div className="modal-dialog modal-xl" role="document">
                    <div className="modal-content bg-primary">
                            <div className="modal-header">
                                    <h5 className="modal-title">Añadir archivo</h5>
                                        <button
                                            type="button"
                                            className="close"
                                            data-dismiss="modal"
                                            aria-label="Close"
                                            onClick={
                                                () => {
                                                    $("#addLayer").modal('hide');
                                                }
                                            }>
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                </div>
                        <div className="modal-body bg-white text-dark">
                            <div className="container-fluid">
                                <div className="row">
                                    <div className="col-lg-6 mb-3">
                                        <label htmlFor="filename">Nombre:</label>
                                        <input
                                            id="filename"
                                            name="name"
                                            className="form-control"
                                            placeholder="Nombre..."
                                        ></input>
                                    </div>

                                    <div className="col-lg-6 mb-3">
                                        <label htmlFor="fileLayer">Archivo:</label>

                                        <div className="input-group">
                                            <div className="custom-file">
                                                <input id="fileLayer" type="file" className="custom-file-input" />
                                                <label className="custom-file-label" htmlFor="fileLayer">Selecciona un archivo...</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div className="col-lg-6 mb-3">
                                        <label htmlFor="filetype">Tipo:</label>
                                        <select
                                            id="filetype"
                                            name="filetype"
                                            className="form-control"
                                        >
                                            <option></option>
                                            <option value={'shape'}>
                                                Shapefile
                                            </option>

                                            <option value={'kml'}>
                                                KML
                                            </option>

                                        </select>
                                    </div>

                                    <div className="col-lg-6 mb-3">
                                        <label htmlFor="groupLayer">Grupo al que pertenece:</label>
                                        <select
                                            id="groupLayer"
                                            name="groupLayer"
                                            className="form-control"
                                        >
                                            <option></option>
                                            {
                                                this.layer_groups.map( (layer_group, index) => {
                                                    return(
                                                        <option
                                                            key={layer_group.token + index}
                                                            value={layer_group.token}>
                                                                {layer_group.name}
                                                        </option>
                                                    );
                                                } )
                                            }

                                        </select>
                                        
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div className="modal-footer bg-white text-dark">
                            
                            <button
                                type="button"
                                className="btn btn-primary"
                                onClick={() => {
                                    this.prepareData();
                                }}
                            >Crear</button>
                            <button
                            type="button"
                            className="btn btn-secondary"
                            data-dismiss="modal"
                            onClick={
                                () => {
                                    $("#addLayer").modal('hide');
                                }
                            }>Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        );
  

        
    }

    componentDidMount()
    {

        axios.post('/vao/addlayer_index', {token: this.vao_token}).then( (response) => {

            var data = response.data.layer_groups;

            this.layer_groups = data;

            this.setState({loading: false});

        } ).then( () => {

            $('#filetype').select2(
                {
                    dropdownParent: $('#addLayer'), //FIXED COMMON PROBLEMS WHEN USES BOOTSTRAP MODAL
                    theme: 'bootstrap4',
                    placeholder: "Selecciona un tipo...",
                    width: '100%'
                }
            );

            $('#groupLayer').select2(
                {
                    dropdownParent: $('#addLayer'), //FIXED COMMON PROBLEMS WHEN USES BOOTSTRAP MODAL
                    theme: 'bootstrap4',
                    placeholder: "Selecciona un tipo...",
                    width: '100%'
                }
            );

            bsCustomFileInput.init();

            const handleChangeValue = (key, value) => { this.changeValue(key, value) };

            $('#filename').on('input', (e) => {
                let value = e.target.value;
                let key = 'name';

                handleChangeValue(key, value);

            } );

            $('#filetype').on('change', (e) => {
                let value = e.target.value;
                let key = 'type';

                handleChangeValue(key, value);

            } );

            $('#groupLayer').on('change', (e) => {
                let value = e.target.value;
                let key = 'group';

                handleChangeValue(key, value);

            } );

            $('#fileLayer').on('change', (e) => {
                let value = e.target.files[0];
                let key = 'file';

                handleChangeValue(key, value);
            })
        } );



        
    }

    changeValue(key, value)
    {
        if (key == 'name') {
            
            this.data.name = value;
        }

        if (key == 'type') {
            
            this.data.type = value;
        }

        if (key == 'group') {
            
            this.data.group = value;
        }

        if (key == 'file') {
            
            this.data.file = value;
        }

        console.log(this.data);

    }


    prepareData()
    {
        let has_error = false;

        if (this.data.name == '') {

            $('#filename').css({ 'border': '1px solid #ed5565' });
            has_error = true;
        }

        if (this.data.type == '') {

            
            has_error = true;
        }

        if (this.data.file == '') {

            
            has_error = true;
        }

        if (has_error) {
            
            toastr.error('Existen campos obligatorios sin rellenar.');
            return null;
        }

        

        this.save();
    }

    save()
    {
       
       this.setState({loading: true});

       let formData = new FormData();

       formData.append('name', this.data.name);
       formData.append('file', this.data.file);
       formData.append('type', this.data.type);
       formData.append('group', this.data.group);
       formData.append('token', this.vao_token);

       axios.post('/vao/addLayer',
        formData,
        {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
        }
        ).then( (response) => {
            $("#addLayer").modal('hide');

            toastr.success(response.data.message);
            this.setState({loading: false});
            
        } );
        
    }
}

export default AddLayer;