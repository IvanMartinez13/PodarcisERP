import axios from "axios";
import React from "react";
import ReactDOM  from "react-dom";
import AddLayer from "./components/AddLayer";
import CreateGroup from "./components/CreateGroup";
import MapVao from "./components/MapVao";

class Vao extends React.Component{

    constructor(props)
    {
        super(props);

        this.state = {
            loading: true,
        }

        this.vao = this.props.data;

    }

    render()
    {
        if (this.state.loading) {
            return(
                <div className="text-center">
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
            <div className="animated fadeIn">
                <div className="row">
                    <div className="col-lg-6 mb-lg-0 mb-4 animated fadeInLeft">
                        <MapVao vao_token={this.vao.token} location={this.vao.location}></MapVao>
                    </div>

                    <div className="col-lg-6 mb-lg-0 mb-4 animated fadeInRight">
                        <div className="row">
                            {/* DETAILS */}
                            <div className="col-lg-12">
                                <div className="ibox">
                                    <div className="ibox-title bg-primary">
                                        <h5>{this.vao.title}</h5>
                    
                                        <div className="ibox-tools">
                                            <a role="button" className="collapse-link">
                                                <i className="fa fa-chevron-up text-white" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                    
                                    <div className="ibox-content">
                                        <div className="row">
                    
                                            <div className="col-lg-12 mb-3 mb-lg-0">
                                                <strong>Descripción: </strong>
                                                <p
                                                    dangerouslySetInnerHTML={{__html: this.vao.description }}></p>
                                                
                                            </div>
                    
                                            
                                            <div className="col-lg-4 mb-3 mb-lg-0">
                                                <strong>Dirección: </strong>
                                                <br />
                                                { this.vao.direction }
                                            </div>
                    
                                            <div className="col-lg-4 mb-3 mb-lg-0">
                                                <strong>Código: </strong>
                                                <br />
                                                { this.vao.code }
                                            </div>
                    
                    
                                            <div className="col-lg-4 mb-3 mb-lg-0">
                                                <strong className="w-100 pb-5">Estado: </strong>
                                                <h4>
                                                    {
                                                        this.formatStatus(this.vao.state)
                                                    }


                                                    
                                                </h4>
                    
                                            </div>
                                        </div>
                    
                                    </div>
                    
                                    <div className="ibox-footer">
                                        Podarcis SL. &copy; 
                                    </div>
                                </div>
                            </div>

                            {/* MAP FILES */}
                            <div className="col-lg-6">
                                <div className="ibox">
                                    <div className="ibox-title bg-primary">
                                        <h5>Administrar archivos cartograficos</h5>
                                        <div className="ibox-tools">
                                            <a role={'button'} className="collapse-link">
                                                <i className="fa fa-chevron-up text-white" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div className="ibox-content">
                                        <div className="btn btn-group-vertical w-100">
                                            <button className="btn btn-secondary btn-block mb-3 rounded" onClick={
                                                () => {
                                                    $("#createGroup").modal('show');
                                                }
                                            }>
                                                Crear grupo de layers...
                                            </button>

                                            <button className="btn btn-secondary btn-block mb-3 rounded" onClick={
                                                () => {
                                                    $("#addLayer").modal('show');
                                                }
                                            }>
                                                Añadir archivo...
                                            </button>

                                            <button className="btn btn-secondary btn-block mb-3 rounded">
                                                Editar archivo...
                                            </button>

                                            <button className="btn btn-danger btn-block rounded">
                                                Eliminar archivo...
                                            </button>
                                        </div>
                                    </div>

                                    <div className="ibox-footer">
                                        Podarcis SL. &copy;
                                    </div>
                                </div>
                            </div>

                            {/* COMPILANCE */}
                            <div className="col-lg-6">
                                <div className="ibox">
                                    <div className="ibox-title bg-primary">
                                        <h5>TITULO</h5>
                                        <div className="ibox-tools">
                                            <a role={'button'} className="collapse-link">
                                                <i className="fa fa-chevron-up text-white" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div className="ibox-content"></div>

                                    <div className="ibox-footer">
                                        Podarcis SL. &copy;
                                    </div>
                                </div>
                            </div>

                            {/* GRAPHS */}
                            <div className="col-lg-12">
                                <div className="ibox">
                                    <div className="ibox-title bg-primary">
                                        <h5>TITULO</h5>
                                        <div className="ibox-tools">
                                            <a role={'button'} className="collapse-link">
                                                <i className="fa fa-chevron-up text-white" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div className="ibox-content"></div>

                                    <div className="ibox-footer">
                                        Podarcis SL. &copy;
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <CreateGroup vao_token={this.vao.token}></CreateGroup>
                <AddLayer vao_token={this.vao.token}></AddLayer>
            </div>

        )
    }

    componentDidMount()
    {
        setTimeout( () =>  {
            this.setState({loading: false});
        }, 1000 )
        
    }

    formatStatus(state)
    {
        switch (state) {
            case('pending'):
                return(
                    <span className="p-2 badge badge-success">Pendiente de inicio</span>
                );
            
            break;
        case('process'):
            return(
                <span className="p-2 badge badge-warning">En proceso</span>
            );
            break;

        case('stopped'):
            return(
                <span className="p-2 badge badge-danger">Parado</span>
            );
            break;

        case('finished'):
            return(
                <span className="p-2 badge badge-primary">Finalizado</span>
            );

            break;
        default:
            return(
                <span className="p-2 badge badge-dark">Sin definir</span>
            )
            
            break;
        }
    }
}

export default Vao;

if (document.getElementsByTagName('vao').length >= 1) {
    
    let component = document.getElementsByTagName('vao')[0];
    let data = JSON.parse(component.getAttribute('data'));
    

    ReactDOM.render(<Vao data={data} />, component);
}
