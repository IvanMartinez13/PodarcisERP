import React from "react";
import FlileManager from "./FileManager";

class Evaluation_row extends React.Component{

    constructor(props){
        super(props);

        //BASE DATA
        this.strategies = this.props.strategies;
        this.objective = this.props.objective;
        this.years = this.props.years;

        //SELECTED DATA
        this.strategy = this.props.strategy;
        this.year = this.props.year;
        this.indicator = this.props.indicator;
        this.value = this.props.value;
        this.id = this.props.id;
        this.files= this.props.files;
        
        this.setFiles = this.setFiles.bind(this);

        this.setRows = (data) => {
            this.props.setRows(data);
        }

    }


    render() {
        return(
            <tr id={'row_'+this.id}>
                <td className="align-middle text-center">
                    {
                        (this.files.length == 0) ?

                        <button id={"buttonFiles"+this.id} className="btn btn-link"  data-toggle="modal" data-target={"#file_manager"+this.id}>
                            <i className="fa-solid fa-file-arrow-up"></i>
                        </button>

                        :

                        <button id={"buttonFiles"+this.id} className="btn btn-link text-navy" data-toggle="modal" data-target={"#file_manager"+this.id}>
                            <i className="fa-solid fa-file-arrow-up"></i>
                        </button>
                    }


                    <FlileManager id={this.id} setFiles={this.setFiles} files={this.files} />
                </td>
                <td className="align-middle">
                    <select id={"strategy_selector_"+this.id} className="form-control" defaultValue={this.strategy.token}>
                        <option></option>
                        {
                            this.strategies.map( (strategy, index) => {
    
                                return(
                                    <option key={strategy.token+index} value={strategy.token}>
                                        {strategy.title}
                                    </option>
                                )
                            } )
                        }
                    </select>
                </td>
                <td className="align-middle" id={"indicator_field_"+this.id}>
                    {this.indicator}
                </td>
                <td className="align-middle">
                    <select id={"year_selector_"+this.id} className="form-control" defaultValue={this.year}>
                        <option></option>
                        {
                            this.years.map( (year, index) => {
                                return(
                                    <option key={year} value={year}>
                                        {year}
                                    </option>
                                )
                            } )
                        }
                    </select>
                </td>
                <td className="align-middle">
                    <input id={"value_input_"+this.id} type={'number'} className="form-control" placeholder="Valor..." min={0} step="any" defaultValue={this.value}></input>
                </td>
                <td className="align-middle text-center">
                    <button className="btn btn-link">
                        <i className="fas fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
        );
    }

    componentDidMount(){
        const id = this.id; //ROW ID

        //MOUNT SELECTOR
        $("#strategy_selector_"+this.id).select2({
            theme: 'bootstrap4',
            placeholder: "Selecciona una estrategia...",
        });

        $("#year_selector_"+this.id).select2({
            theme: 'bootstrap4',
            placeholder: "Selecciona un año...",
        });


        //STRATEGY SELECTOR
        var strategies = this.strategies;

        const handlePrepareData = (key, value) => {this.prepareData(key, value)}; //CALL PREPARE DATA FUNCTION
        
        $('#strategy_selector_'+this.id).on('select2:select', function (e) {
            
            let data = e.params.data;
            let token = data.id;

            strategies.map( (strategy) => {
                if (strategy.token == token) {
                    
                    $('#indicator_field_'+id).text('');
                    $('#description_field').text('');
                    $('#performance_field').text('');

                    $('#indicator_field_'+id).append(strategy.indicator);
                    $('#description_field').append(strategy.description);
                    $('#performance_field').append(strategy.performances);

                    handlePrepareData('strategy', strategy)
                }
            } );

           

           
            
        });


        $("#year_selector_"+this.id).on('select2:select', function(e){

            let year = Number(e.params.data.id); // parse year to number

            handlePrepareData('year', year);
        });

        $("#value_input_"+this.id).on('input', function(){
            let value = Number(this.value);

            handlePrepareData('value', value);
        })



    }

    prepareData(key, value){

        if (key == 'strategy') {
            this.indicator = value.indicator;
            this.strategy = value;
            
        }

        if (key == 'year') {
            this.year = value;
        }

        if (key == 'value') {
            this.value = value;
        }

        if (key == 'files') {
            this.files = value;
        }

        let data = {
            id: this.id,
            strategy: this.strategy,
            indicator: this.indicator,
            year: this.year,
            value: this.value,
            files: this.files

        }

        this.setRows(data);
    }

    setFiles(files){
        this.prepareData('files', files);

        //SET BUTTON COLOR
        if (this.files != []) {
            $('#buttonFiles'+this.id).addClass('text-navy')
        }else{
            $('#buttonFiles'+this.id).removeClass('text-navy')
        }
    }


}

export default Evaluation_row;