import axios from "axios";
import React from "react";

class Visits extends React.Component{

    constructor(props)
    {
        super(props);

        this.state = {
            loading: true,
        }

        this.vao = this.props.data;

        this.visits = [];

    }

    render(){
        if (this.state.loading) {
            return(
                <div className="text-center animated fadeInRight">
                    <div className="spiner-example">
                        <div className="sk-spinner sk-spinner-double-bounce">
                            <div className="sk-double-bounce1"></div>
                            <div className="sk-double-bounce2"></div>
                        </div>
                    </div>

                    Cargando...
                </div>
            )
        }
        return(
            <div className="animated fadeInRight">

                <div className="ibox">
                    <div className="ibox-title">
                        <h5>Visitas</h5>

                        <a href={"/vao/"+this.vao.token+"/visits/create"} className="ml-2 btn btn-primary">Crear</a>

                    </div>

                    <div className="ibox-content">

                        <div className="table-responsive">
                            <table id="tableVisits" className="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Fecha de inicio</th>
                                        <th>Fecha de fin</th>
                                        <th>Cumplimiento</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    {
                                        this.visits.map( (visit, index) => {
                                            return(
                                                <tr key={visit.token+index}>
                                                    <td className="align-middle">{visit.name}</td>
                                                    <td className="align-middle">{visit.description}</td>
                                                    <td className="align-middle">{ this.formatDate(visit.starts_at) }</td>
                                                    <td className="align-middle">{ this.formatDate(visit.ends_at)}</td>
                                                    <td className="align-middle">
                                                        <div className="progress m-b-1">
                                                            <div style={{width: visit.compilance+"%"}} className="progress-bar progress-bar-striped progress-bar-animated"></div>
                                                        </div>
                                                        <small>{visit.compilance}% de cumplimiento.</small>
                                                        
                                                    </td>
                                                    <td className="align-middle text-center">
                                                        <div className="btn-group-vertical">
                                                            <a href={"/vao/"+visit.token+"/edit"} className="btn btn-link">
                                                                <i className="fa fa-pencil" aria-hidden="true"></i>
                                                            </a>

                                                            <a href={"/vao/visit/"+visit.token} className="btn btn-link">
                                                                <i className="fa fa-eye" aria-hidden="true"></i>
                                                            </a>

                                                            <button onClick={() => this.deleteVisit(visit.token)} className="btn btn-link">
                                                                <i className="fa fa-trash-alt" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            )
                                        } )
                                    }
                                </tbody>

                            </table>
                        </div>
                    </div>

                    <div className="ibox-footer">
                        Podarcis SL &copy; 2022
                    </div>
                </div>
            </div>

        )
    }

    componentDidMount()
    {

        axios.post('/vao/get_visits', {token: this.vao.token}).then( (response) => {

            this.visits = response.data.visits;


            this.setState({loading: false});

        } ).then( () => {

                    //DATA TABLE
                    $(document).ready(function(){

                        $('#tableVisits thead tr')
                        .clone(true)
                        .addClass('filters')
                        .appendTo('#tableVisits thead');
                    
                        $('#tableVisits').DataTable({
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
                                        var cell = $('#tableVisits thead .filters th').eq(
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
                                            $('#tableVisits thead .filters th').eq($(api.column(colIdx).header()).index())
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
        } )

    }

    formatDate(str)
    {
        let date = new Date(str);

        return date.toLocaleDateString('es');
    }

    deleteVisit(token)
    {
        swal({
            title: "¿Estas seguro?",
            text: "No porás recuperar esta visita.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#ed5565",
            confirmButtonText: "Si, deseo eliminarla",
            closeOnConfirm: false,
            cancelButtonColor: "#ed5565",
            cancelButtonText: "Cancelar",
        }, function () {
            axios.post('/vao/delete_visit', {token: token}).then( (response) => {
                toastr.success(response.data.message);
                
                setTimeout( () => {
                    
                    location.reload();
                }, 2000 )

            } );

            
        });
    }
}


export default Visits