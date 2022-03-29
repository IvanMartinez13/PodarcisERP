import axios from "axios";
import React from "react";

class DeleteFiles extends React.Component{
    constructor(props){
        super(props)

        this.vao_token = this.props.vao_token

        this.state = { loading: true };

        this.layers = []
    }

    render(){

        if (this.state.loading) {

            return(
                <div className="modal fade" id="deleteFiles" tabIndex="-1" role="dialog" aria-labelledby="modeldeleteFiles" aria-hidden="true">
                    <div className="modal-dialog modal-xl" role="document">
                        <div className="modal-content bg-primary">
                            <div className="modal-header">
                                    <h5 className="modal-title">Eliminar Archivo</h5>
                                        <button
                                            type="button"
                                            className="close"
                                            data-dismiss="modal"
                                            aria-label="Close"
                                            onClick={
                                                () => {
                                                    $("#deleteFiles").modal('hide');
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
                                className="btn btn-secondary"
                                data-dismiss="modal"
                                onClick={
                                    () => {
                                        $("#deleteFiles").modal('hide');
                                    }
                                }>Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            );
            
        }


        return(

            <div className="modal fade" id="deleteFiles" tabIndex="-1" role="dialog" aria-labelledby="deleteFilesLabel" aria-hidden="true">
                <div className="modal-dialog modal-xl" role="document">
                    <div className="modal-content bg-primary">
                        <div className="modal-header">
                            <h5 className="modal-title">Eliminar Archivo</h5>
                                <button
                                    type="button"
                                    className="close"
                                    data-dismiss="modal"
                                    aria-label="Close"
                                    onClick={
                                        () => {
                                            $("#deleteFiles").modal('hide');
                                        }
                                    }
                                ><span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                        <div className="modal-body bg-white text-dark">
                            <div className="container-fluid table-responsive">
                                <table id="deleteLayerTable" className="table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Grupo</th>
                                            <th>Tipo de archivo</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        {
                                            this.layers.map( (layer, index) => {

                                                return(
                                                    <tr key={index+layer.token+index}>
                                                        <td className="align-middle">{layer.name}</td>
                                                        <td className="align-middle">{layer.group.name}</td>
                                                        <td className="align-middle">{layer.type}</td>
                                                        <td className="align-middle text-center">

                                                            <button className="btn btn-link" onClick={() => { this.deleteFile(layer.token) }}>
                                                                <i className="fas fa-trash-alt"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                )
                                            } )
                                        }
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div className="modal-footer bg-white text-dark">

                            <button
                                type="button"
                                className="btn btn-secondary"
                                data-dismiss="modal"
                                onClick={
                                    () => {
                                        $("#deleteFiles").modal('hide');
                                    }
                                }
                            >Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        );
    }

    componentDidMount()
    {
        axios.post('/vao/get_layers', {token: this.vao_token}).then( (response) => {

            this.layers = response.data.layers;

            

            this.setState( { loading: false } )
        }).then( () => {

            //DATA TABLE
            $(document).ready(function(){

                $('#deleteLayerTable thead tr')
                .clone(true)
                .addClass('filtersDelete')
                .appendTo('#deleteLayerTable thead');
            
                $('#deleteLayerTable').DataTable({
                    pageLength: 25,
                    responsive: true,
                    dom: '<"html5buttons"B>lTfgitp',
                    buttons: [
                        'colvis',
                        {extend: 'copy'},
                        {extend: 'csv'},
                        {extend: 'excel', title: 'ExampleFile'},
                        {extend: 'pdf', title: 'ExampleFile'},
            
                        {extend: 'print',
                         customize: function (win){
                                $(win.document.body).addClass('white-bg');
                                $(win.document.body).css('font-size', '10px');
            
                                $(win.document.body).find('table')
                                        .addClass('compact')
                                        .css('font-size', 'inherit');
                        }
                        }
                    ],
                    "language": {
                        "url": "/js/plugins/dataTables/es.json"
                    },
            
                    stateSave: true,
                    colReorder: true,
                    orderCellsTop: true,
                    fixedHeader: true,
            
                    initComplete: function () {
                        var api = this.api();
             
                        // For each column
                        api
                            .columns()
                            .eq(0)
                            .each(function (colIdx) {
                                // Set the header cell to contain the input element
                                var cell = $('.filtersDelete th').eq(
                                    $(api.column(colIdx).header()).index()
                                );
                                var title = $(cell).text();
                                if (title != 'Acciones') {
                                    $(cell).html('<input type="text" class="form-control " placeholder="' + title + '" />');
                                }else{
                                    $(cell).html('');
                                }
                                
             
                                // On every keypress in this input
                                $(
                                    'input',
                                    $('.filtersDelete th').eq($(api.column(colIdx).header()).index())
                                )
                                    .off('keyup change')
                                    .on('keyup change', function (e) {
                                        e.stopPropagation();
             
                                        // Get the search value
                                        $(this).attr('title', $(this).val());
                                        var regexr = '({search})'; //$(this).parents('th').find('select').val();
             
                                        var cursorPosition = this.selectionStart;
                                        // Search the column for that value
                                        api
                                            .column(colIdx)
                                            .search(
                                                this.value != ''
                                                    ? regexr.replace('{search}', '(((' + this.value + ')))')
                                                    : '',
                                                this.value != '',
                                                this.value == ''
                                            )
                                            .draw();
             
                                        $(this)
                                            .focus()[0]
                                            .setSelectionRange(cursorPosition, cursorPosition);
                                    });
                            });
                    },
            
                });
            
            });
            
        } );
    }

    deleteFile(token)
    {

        swal({
            title: "¿Estás seguro?",
            text: "Una vez eliminado, no porás recuperar este layer.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#ed5565",
            confirmButtonText: "Si, deseo eliminarlo",
            closeOnConfirm: false,
            cancelButtonColor: "#ed5565",
            cancelButtonText: "Cancelar",
        }, function () {
            axios.post('/vao/delete_layer', {token: token}).then( (response) => {

                location.reload();
            } );
            
        });
        
    }
}

export default DeleteFiles;