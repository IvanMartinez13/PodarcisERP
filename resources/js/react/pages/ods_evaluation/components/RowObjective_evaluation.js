import React from "react";
import FileManager from "./FileManager";

class RowObjective_evaluation extends React.Component{

    constructor(props){
        super(props);

        this.year = this.props.year;
        this.value = this.props.value;
        this.years = this.props.years;
        this.id = this.props.id;
        this.delete = this.props.delete;

        this.del = this.props.del;
        this.update = this.props.update;

        this.files = this.props.files;

        this.updateRows = (data) => {
            this.props.updateRows(data);
        }

        this.setFiles = this.setFiles.bind(this);

    }

    render(){
        if (this.delete) {
            return(
                <tr id={this.id} style={{display: 'none'}}>
                    <td className="align-middle text-center">

                        {
                            (this.files.length <= 0) ?

                            <button id={"buttonFiles"+this.id} className="btn btn-link" data-toggle="modal" data-target={"#file_manager"+this.id}>
                                <i className="fa-solid fa-file-arrow-up"></i>
                            </button>

                            :

                            <button id={"buttonFiles"+this.id} className="btn btn-link text-navy" data-toggle="modal" data-target={"#file_manager"+this.id}>
                                <i className="fa-solid fa-file-arrow-up"></i>
                            </button>
                        }

                        <FileManager id={this.id} setFiles={this.setFiles} files={this.files} update={this.update} del={this.del} type={'objective'} />
                    </td>
                    <td className="align-middle">
                        <select id={this.id+"year_selector"} className="form-control" defaultValue={this.year}>
    
                            <option></option>
                            {
                                this.years.map( (year, index) => {
    
                                    return(
                                        <option key={index+year} value={year}>
                                            {year}
                                        </option>
                                    );
    
                                })
                            }
                        </select>
                    </td>
                    <td className="align-middle">
                        <input
                            type={'number'}
                            className="form-control"
                            id={this.id+"value_input"}
                            placeholder="Valor obervado..."
                            step='any'
                            defaultValue={this.value}
                        ></input>
                    </td>
                    <td className="align-middle text-center">
                        <button onClick={ () => { this.deleteRow() }} className="btn btn-link">
                            <i className="fa-solid fa-trash-can"></i>
                        </button>
                    </td>
                </tr>
            );
        }
        return(
            <tr id={this.id}>
                <td className="align-middle text-center">
                    {
                        (this.files.length <= 0) ?

                        <button id={"buttonFiles"+this.id} className="btn btn-link" data-toggle="modal" data-target={"#file_manager"+this.id}>
                            <i className="fa-solid fa-file-arrow-up"></i>
                        </button>

                        :

                        <button id={"buttonFiles"+this.id} className="btn btn-link text-navy" data-toggle="modal" data-target={"#file_manager"+this.id}>
                            <i className="fa-solid fa-file-arrow-up"></i>
                        </button>
                    }
                    
                    <FileManager id={this.id} setFiles={this.setFiles} files={this.files} update={this.update} del={this.del} type={'objective'} />
                </td>
                <td className="align-middle">
                    <select id={this.id+"year_selector"} className="form-control" defaultValue={this.year}>

                        <option></option>
                        {
                            this.years.map( (year, index) => {

                                return(
                                    <option key={index+year} value={year}>
                                        {year}
                                    </option>
                                );

                            })
                        }
                    </select>
                </td>
                <td className="align-middle">
                    <input
                        type={'number'}
                        className="form-control"
                        id={this.id+"value_input"}
                        placeholder="Valor obervado..."
                        step='any'
                        defaultValue={this.value}
                    ></input>
                </td>
                <td className="align-middle text-center">
                    {
                        (this.del==1) ? 

                            <button onClick={ () => { this.deleteRow() }} className="btn btn-link">
                                <i className="fa-solid fa-trash-can"></i>
                            </button>
                        :

                        <button disabled={true} onClick={ () => { this.deleteRow() }} className="btn btn-link">
                            <i className="fa-solid fa-trash-can"></i>
                        </button>
                    }

                </td>
            </tr>
        );
    }

    //ON MOUNT
    componentDidMount(){

        $(`#${this.id}year_selector`).select2(
            {
                theme: 'bootstrap4',
                placeholder: 'Selecciona un año...',
                width: '100%',
            }
        );

        const handleChangeValue = (key, value) => { this.changeValue(key, value) }

        $(`#${this.id}year_selector`).on('change', (e) => {

            let value = e.target.value;
            handleChangeValue('year', value);
        });


        $(`#${this.id}value_input`).on('input', (e) => {

            let value = e.target.value;
            handleChangeValue('value', value);
        });
    }

    changeValue(key, value){

        if (key == 'year') {

            this.year = value;
        }

        if (key == 'value') {
            
            this.value = value;
        }

        if(key == 'files'){
            this.files = value;
        }

        let data = {
            id: this.id,
            year: this.year,
            value: this.value,
            files: this.files,
            delete: this.delete,
        }

        


        this.updateRows(data);
    }

    deleteRow(){

        this.delete = true;

        let data = {
            id: this.id,
            year: this.year,
            value: this.value,
            files: [],
            delete: this.delete,
        }

        this.updateRows(data);

        $('#'+this.id).hide();
    }

    setFiles(files){
        this.changeValue('files', files);

        //SET BUTTON COLOR
        if (this.files != []) {
            $('#buttonFiles'+this.id).addClass('text-navy')
        }else{
            $('#buttonFiles'+this.id).removeClass('text-navy')
        }
    }
}

export default RowObjective_evaluation;