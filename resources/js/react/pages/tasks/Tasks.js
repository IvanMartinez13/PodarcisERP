import axios from "axios";
import React from "react";
import ReactDOM from 'react-dom';
import Create_task from "./components/Create_task";
import Update_task from "./components/Update_task";


class Tasks extends React.Component{

    constructor(props){
        super(props);

        this.state = {loading: true};
        this.yearToday = new Date().getFullYear();

        this.project = this.props.project;
        this.departaments = this.props.departaments;
        this.tasks = this.props.tasks;

        this.store = this.props.store;
        this.update = this.props.update;
        this.delete = this.props.delete;

    }

    render(){
        return(
            <div>
                <div className="ibox">
                    <div className="ibox-title">
                        <h5>{this.project.name}</h5>
                        <div className="ibox-tools">
                            <a className="collapse-link">
                                <i className="fa fa-chevron-up" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>

                    <div className="ibox-content">
                        {
                            (this.store == 1) ? 
                            <button
                                className="btn btn-link"
                                onClick={() => {
                                    $('#addTask').modal('show')
                                }}
                            >
                                <i className="fa-solid fa-circle-plus"></i> Añadir una tarea...
                            </button>
                            :

                            null
                        }

                        <div className="table-responsive container-fluid mt-3">
                            <table className="table table-hover table-striped table-bordered js_datatable ">
                                <thead>
                                    <tr>
                                        <th>
                                            Tarea
                                        </th>
                                        <th>
                                            Descripción
                                        </th>
                                        <th>
                                            Progreso
                                        </th>
                                        <th>
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    
                                    {
                                        this.tasks.map( (task, index) => {
                                            return(
                                                <tr key={'row_'+task.token}>
                                                    <td className="align-middle">
                                                        {task.name}
                                                    </td>
                                                    <td className="align-middle"
                                                        dangerouslySetInnerHTML={{__html: task.description}}>
                                                    </td>
                                                    <td className="align-middle">
                                                        <div className="progress m-b-1">
                                                            <div style={{width: task.progress+"%"}} className="progress-bar progress-bar-striped progress-bar-animated"></div>
                                                        </div>
                                                        <small>Completado en un <strong>{task.progress}%</strong>.</small>
                                                    </td>
                                                    <td className="align-middle text-center">
                                                        <div className="btn-group-vertical">

                                                            {
                                                                (this.update == 1) ?

                                                                <button
                                                                    className="btn btn-link"
                                                                    onClick={() => {
                                                                        $("#updateTask"+task.token).modal('show')
                                                                    }}
                                                                >
                                                                    <i className="fa fa-pencil" aria-hidden="true"></i>
                                                                </button>

                                                                :

                                                                null
                                                            }

                                                            
                                                            <a href={"/tasks/project/"+this.project.token+"/task/"+task.token} className="btn btn-link">
                                                                <i className="fa-solid fa-clipboard-check"></i>
                                                            </a>

                                                            {
                                                                (this.delete == 1) ?

                                                                <button
                                                                    className="btn btn-link"
                                                                    onClick={
                                                                        () =>  { this.remove(task.token) } 
                                                                    }
                                                                >
                                                                    <i className="fa fa-trash-alt" aria-hidden="true"></i>
                                                                </button>
                                                                
                                                                :

                                                                null
                                                            }

                                                        </div>
                                                        
                                                    </td>
                                                </tr>
                                            );
                                        } )
                                    }
                                    
                                </tbody>

                            </table>
                        </div>


                        

                        
                    </div>

                    <div className="ibox-footer">
                        Podarcis SL. &copy; {this.yearToday}
                    </div>
                </div>


                <Create_task project={this.project}></Create_task>

                {
                    this.tasks.map( (task, index) => {

                        return(
                            <Update_task
                                key={task.token+index}
                                project={this.project}
                                task={task}
                            ></Update_task>
                        );
                    } )
                }
                
            </div>
        );
    }

    //UPLOAD ON ADD TASK

    remove(token){

        

        swal({
            title: "¿Estás seguro?",
            text: "No podrás recuperar esta tarea.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#ed5565",
            confirmButtonText: "Si, deseo eliminarla",
            closeOnConfirm: false,
            cancelButtonColor: "#ed5565",
            cancelButtonText: "Cancelar",
        }, function() {
            
            axios.post('/tasks/projects/delete_task', {token: token}).then( (response) => {
                toastr.success(response.data.message);
                setTimeout( () => {
                    location.reload();
                }, 2000 );
            } )


        });
    }



}

export default Tasks;

if (document.getElementsByTagName('tasks').length >=1) {
    
    let component = document.getElementsByTagName('tasks')[0];
    let tasks = JSON.parse(component.getAttribute('tasks'));
    let project = JSON.parse(component.getAttribute('project'));
    let departaments = JSON.parse(component.getAttribute('departaments'));

    let store = component.getAttribute('store');
    let update = component.getAttribute('update');
    let del = component.getAttribute('delete');

    ReactDOM.render(<Tasks
                        tasks={tasks}
                        project={project}
                        departaments={departaments}
                        store={store}
                        update={update}
                        delete={del}
                    />, component);
}
