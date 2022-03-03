import axios from "axios";
import React from "react";
import ReactDOM from 'react-dom';
import Create_task from "./components/Create_task";


class Tasks extends React.Component{

    constructor(props){
        super(props);

        this.state = {loading: true};
        this.yearToday = new Date().getFullYear();

        this.project = this.props.project;
        this.departaments = this.props.departaments;
        this.tasks = this.props.tasks;

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

                        <button className="btn btn-link" onClick={() => {
                            $('#addTask').modal('show')
                        }}>
                            <i className="fa-solid fa-circle-plus"></i> Añadir una tarea...
                        </button>

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
                                                            <div style={{width: "0%"}} className="progress-bar progress-bar-striped progress-bar-animated"></div>
                                                        </div>
                                                        <small>0%</small>
                                                    </td>
                                                    <td className="align-middle text-center">
                                                        <div className="btn-group-vertical">
                                                            <button className="btn btn-link">
                                                                <i className="fa fa-pencil" aria-hidden="true"></i>
                                                            </button>

                                                            <a href={"/tasks/project/"+this.project.token+"/task/"+task.token} className="btn btn-link">
                                                                <i class="fa-solid fa-clipboard-check"></i>
                                                            </a>

                                                            <button className="btn btn-link">
                                                                <i className="fa fa-trash-alt" aria-hidden="true"></i>
                                                            </button>
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
                
               
            </div>
        );
    }

    //UPLOAD ON ADD TASK



}

export default Tasks;

if (document.getElementsByTagName('tasks').length >=1) {
    
    let component = document.getElementsByTagName('tasks')[0];
    let tasks = JSON.parse(component.getAttribute('tasks'));
    let project = JSON.parse(component.getAttribute('project'));
    let departaments = JSON.parse(component.getAttribute('departaments'));

    ReactDOM.render(<Tasks tasks={tasks} project={project} departaments={departaments} />, component);
}
