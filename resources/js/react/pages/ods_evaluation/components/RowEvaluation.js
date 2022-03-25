import React from "react";
import FlileManager from "./FileManager";

class RowEvaluation extends React.Component{

    constructor(props){
        super(props);

        this.year = this.props.year;
        this.value = this.props.value;
        this.id = this.props.id;
        this.delete = false;

        this.years = this.props.years;

        this.updateRows = (data) => {
            this.props.updateRows(data);
        }
        this.files = this.props.files;
        
        this.setFiles = this.setFiles.bind(this);

        
        this.update = this.props.update;
        this.del = this.props.del;
    }

    render(){
        return(
            <tr id={this.id} key={this.id}>
                <td className="text-center align-middle">

                    {
                        (this.files.length <= 0) ?

                        <button id={"buttonFiles"+this.id} className="btn btn-link"  data-toggle="modal" data-target={"#file_manager"+this.id}>
                            <i className="fas fa-file-upload"></i>
                        </button>

                        :

                        <button id={"buttonFiles"+this.id} className="btn btn-link text-navy" data-toggle="modal" data-target={"#file_manager"+this.id}>
                            <i className="fas fa-file-upload"></i>
                        </button>
                    }

                    <FlileManager id={this.id} setFiles={this.setFiles} files={this.files} update={this.update} del={this.del} type={'strategy'}/>
                </td>
                <td className="align-middle">
                    
                    <select id={"year_selector_"+this.id} defaultValue={this.year}>
                        <option></option>
                        {this.years.map( (year, index) => {
                            
                            return(
                                <option key={year+index} value={year}>{year}</option>
                            );
                            
                        } )}
                    </select>
                    
                </td>
                <td className="text-center align-middle">
                    <input type={'number'} id={'value_input'+this.id} className="form-control" defaultValue={this.value} placeholder="Valor observado..."></input>
                </td>
                <td className="text-center align-middle">
                    {
                        (this.del==1) ? 

                            <button className="btn btn-link" onClick={() => { this.deleteRow() }}>
                                <i className="fa fa-trash-alt" aria-hidden="true"></i>
                            </button>
                        :

                        <button disabled={true} className="btn btn-link" onClick={() => { this.deleteRow() }}>
                            <i className="fa fa-trash-alt" aria-hidden="true"></i>
                        </button>
                    }

                </td>

                
            </tr>
        );
    }

    componentDidMount(){

        //PREPARE SELECTOR
        $("#year_selector_"+this.id).select2({
            theme: 'bootstrap4',
            placeholder: "Selecciona un año...",
            width: '100%'
        });

        //HANDLE CHANGE VALUE
        const handleChangeValue = (key, value) => this.changeValue(key, value);

        //EVENT TRIGGER
        $("#year_selector_"+this.id).on('change', (event) => {

            let value = event.target.value;

            handleChangeValue('year', value); 
        });

        $("#value_input"+this.id).on('input', (event) => {

            let value = event.target.value;
            
            handleChangeValue('value', value); 
        })


    }

    changeValue(key, value)
    {
        if (key == "year") {
            
            this.year = value;
        }

        if (key == "value") {
            
            this.value = value;
        }

        if (key == "files") {
            
            this.files = value;
        }

        //PREPARE DATA
        let data = {
            id: this.id,
            year: this.year,
            value: this.value,
            files: this.files,
            delete: this.delete,
        }

        //SEND DATA TO PARENT
        this.updateRows(data);
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

    deleteRow(){
        //PREPARE DATA
        let data = {
            id: this.id,
            year: this.year,
            value: this.value,
            files: this.files,
            delete: true,
        }
        
        //SEND DATA TO PARENT
        this.updateRows(data);


        $('#'+this.id).hide();
    }
    
}

export default RowEvaluation;