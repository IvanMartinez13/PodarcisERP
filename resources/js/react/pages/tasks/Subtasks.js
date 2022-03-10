import axios from "axios";
import React from "react";
import  ReactDOM  from "react-dom";
import Create_subtask from "./components/Create_subtask";
import Edit_subtask from "./components/Edit_subtask";

class Subtasks extends React.Component{

    constructor(props){
        super(props);

        this.state = {loading: true, save: false}

        this.task = this.props.task;
        this.subtasks = [];

        this.setLoading = this.setLoading.bind(this);
        this.setSaving = this.setSaving.bind(this);

    }

    render(){
        if (this.state.loading) {
            return(
                <div className="animated fadeIn">
                    <div className="spiner-example">   
                        <div className="sk-spinner sk-spinner-double-bounce">
                            <div className="sk-double-bounce1"></div>
                            <div className="sk-double-bounce2"></div>
                        </div>
                    </div>

                    <p className="text-center">Cargando...</p>
                </div>

            );
        }
        return(
            <div className="animated fadeIn">
                <button
                    className="btn btn-link"
                    onClick={() => {
                       $('#modalSubtask').modal('show');
                    }}>
                    <i className="fa fa-plus-circle" aria-hidden="true"></i> Añadir subtarea
                </button>
                
                <div className="table-responsive">
                    <table className="table table-hover table-bordered table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Tarea</th>
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            {
                                this.subtasks.map( (subtask, index) => {
                                    return(
                                        <tr key={"row_"+subtask.token+index}>
                                            <td className="align-middle text-center">
                                                {
                                                    (subtask.is_done == 1) ?
                                                    <input className="i-checks" type={"checkbox"} defaultChecked={true}  defaultValue={subtask.token}></input>
                                                    :
                                                    <input className="i-checks" type={"checkbox"} defaultChecked={false}  defaultValue={subtask.token}></input>
                                                }
                                            </td>
                                            <td className="align-middle">{subtask.name}</td>
                                            <td className="align-middle" dangerouslySetInnerHTML={{
                                                __html: subtask.description
                                            }}></td>
                                            <td className="align-middle text-center">

                                                <div className="btn-group-vertical">
                                                    <button className="btn btn-link"
                                                            onClick={() => {
                                                                $('#editModalSubtask'+subtask.token).modal('show');
                                                            }}
                                                    >
                                                        <i className="fa fa-pencil" aria-hidden="true"></i>
                                                    </button>

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

                <Create_subtask task={this.task} setLoading={this.setLoading} setSaving={this.setSaving}></Create_subtask>

                {
                    this.subtasks.map( (subtask, index) => {
                        return(
                            <Edit_subtask key={"updateSubtask_"+subtask.token} task={this.task} setLoading={this.setLoading} setSaving={this.setSaving} id={subtask.token} subtask={subtask}></Edit_subtask>
                        );
                    })
                }
            </div>

            
        );
    }

    componentDidMount(){

        axios.post('/tasks/project/task/get_subtask', {task: this.task}).then( (response) => {
            let subtasks = response.data.subtasks;
            this.subtasks = subtasks;

            this.setState({loading: false});

        } ).then( () =>{

            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            const handleFinishTask = (data) => {
                this.finishTask(data)
            } 

            $('.i-checks').on('ifChecked', function(event){
                let task = event.target.value;
                
                let data = {
                    task: task,
                    value: true,
                }

                handleFinishTask(data);
                
            });
            $('.i-checks').on('ifUnchecked', function(event){
                let task = event.target.value;
                                
                let data = {
                    task: task,
                    value: false,
                }

                handleFinishTask(data);
            });
        } )
    }

    componentDidUpdate(){
        if (this.state.save) {
            axios.post('/tasks/project/task/get_subtask', {task: this.task}).then( (response) => {
                let subtasks = response.data.subtasks;
                this.subtasks = subtasks;
    
                this.setState({loading: false, save: false});
            } ).then( () =>{

                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
    
                const handleFinishTask = (data) => {
                    this.finishTask(data)
                } 
    
                $('.i-checks').on('ifChecked', function(event){
                    let task = event.target.value;
                    
                    let data = {
                        task: task,
                        value: true,
                    }
    
                    handleFinishTask(data);
                    
                });
                $('.i-checks').on('ifUnchecked', function(event){
                    let task = event.target.value;
                                    
                    let data = {
                        task: task,
                        value: false,
                    }
    
                    handleFinishTask(data);
                });
            } )
        }
    }

    setLoading(value){
        this.setState({loading: value});
    }

    setSaving(value){
        this.setState({save: value})
    }


    finishTask(data){
        axios.post('/tasks/project/task/subtask/changeState', data).then( (response) => {

            console.log(response)
            toastr.success(response.data.message);

            $('#progress').css({'width': response.data.progress+"%"})
            $('#progress_text').text(response.data.progress+"%")
            
        } );
    }



}

export default Subtasks;

if (document.getElementsByTagName('subtasks').length >=1) {
    
    let component = document.getElementsByTagName('subtasks')[0];
    let task = JSON.parse(component.getAttribute('task'));

    ReactDOM.render(<Subtasks task={task} />, component);
}