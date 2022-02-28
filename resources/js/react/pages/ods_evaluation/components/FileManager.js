import React from "react";
import Dropzone from "dropzone";

class FlileManager extends React.Component{
    constructor(props){
        super(props);
        
        this.id = this.props.id;

        this.state = {files: this.props.files};

        

        this.setFiles = (data) => {
            this.props.setFiles(data);
        }
    }

    render(){
        return(
            <div className="modal fade" id={"file_manager"+this.id} tabIndex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div className="modal-dialog modal-xl" role="document">
                    <div className="modal-content bg-primary">
                            <div className="modal-header">
                                    <h5 className="modal-title">Administrar archivos</h5>
                                        <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                </div>
                        <div className="modal-body bg-white text-dark">
                            <div className="container-fluid">
                                <form id={"newFile"+this.id} className="dropzone">
                                    
                                    
                                    <div className="dz-message" data-dz-message>
                                        <span>Arrasra aqui tus archivos</span>
                                    </div>

                                
                                </form>

                                <div className="mt-4 table-responsive">
                                    <table className="table table-striped table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Nombre del archivo</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            {this.state.files.map( (file, index) =>{
                                                return(
                                                    <tr key={file.name+index}>
                                                        <td>
                                                            <input className="form-control" type={'text'} defaultValue={file.name} onBlur={
                                                                (e) => {
                                                                    let value = e.target.value;
                                                                    this.changeFileName(file, value);
                                                                }
                                                            }></input>
                                                        </td>
                                                        <td>
                                                            <a className="btn btn-link" href={'/storage'+file.path} target={'_blank'}>
                                                                <i className="fa fa-eye" aria-hidden="true"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                );
                                            } )}
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                        </div>
                        <div className="modal-footer bg-white">
                            <button type="button" className="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            
                        </div>
                    </div>
                </div>
            </div>
        );

        

    }

    componentDidMount(){

        const handleAddFile = (file) => {this.addFile(file)}; //CALL ADD FILE FUNCION

        let dropzone = new Dropzone( '#newFile'+this.id, { // The camelized version of the ID of the form element
            url: '/ods/evaluate/save_file',
            // The configuration we've talked about above
            autoProcessQueue: true,
            uploadMultiple: true,
            parallelUploads: 100,
            maxFiles: 100,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
          
            // The setting up of the dropzone
            init: function() {
              var myDropzone = this;
          
              // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
              // of the sending event because uploadMultiple is set to true.
              this.on("sendingmultiple", function() {
                // Gets triggered when the form is actually being sent.
                // Hide the success button or the complete form.
                
              });
              this.on("successmultiple", function(files, response) {
                // Gets triggered when the files have successfully been sent.
                // Redirect user or notify of success.
                response.paths.map( (path, index) => {
                    handleAddFile(path);
                } )
                
                
              });
              this.on("errormultiple", function(files, response) {
                // Gets triggered when there was an error sending the files.
                // Maybe show form again, and notify user of error
              });

              this.on("addedfile" , file => {
                $('.dz-preview').text('');
                
                
                
              })
            }
           
          })
    }

    addFile(path){//ADD FILE

        let files = this.state.files;
        files.push({path: path, name: path.split('/evaluation/')[1]});

        this.setState({files: files});

        this.setFiles(files);
        
    }

    changeFileName(file, value){ //CHANGE NAME FILE
        let files = this.state.files;

        files.map( (item, index) => {
            if(item == file){
                files[index].name = value;
            }
        } )

        this.setState({files: files});

        this.setFiles(files);
    }
}

export default FlileManager;