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
                        <button className="btn btn-link" data-toggle="modal" data-target="#addTask">
                            <i className="fa-solid fa-circle-plus"></i> Añadir una tarea...
                        </button>

                        <Create_task project={this.project}></Create_task>
                        
                    </div>

                    <div className="ibox-footer">
                        Podarcis SL. &copy; {this.yearToday}
                    </div>
                </div>


                
               
            </div>

        );
    }

}

export default Tasks;

if (document.getElementsByTagName('tasks').length >=1) {
    
    let component = document.getElementsByTagName('tasks')[0];
    let tasks = JSON.parse(component.getAttribute('tasks'));
    let project = JSON.parse(component.getAttribute('project'));
    let departaments = JSON.parse(component.getAttribute('departaments'));

    ReactDOM.render(<Tasks tasks={tasks} project={project} departaments={departaments} />, component);
}
