$('#branches').on('select2:select', function (e) {
    var data = e.params.data;

    let object = {value: data.id, name: data.text};

    branches_selected.push(object);

    branchesChanged(branches_selected , branches);//FUNCION TO MANAGE USERS OPTIONS
});

$('#branches').on('select2:unselect', function (e) {
    var data = e.params.data;

    let object = {value: data.id, name: data.text};

    branches_selected.map( (branch, index) => {
        if(branch.value == object.value){
            branches_selected.splice(index, 1); // 2nd parameter means remove one item only
        }
    } )

    branchesChanged(branches_selected , branches);//FUNCION TO MANAGE USERS OPTIONS
});

function branchesChanged(branches_selected, branches){
    
    
    if(branches_selected.length == 0){
        
        $('#departaments').val(null).trigger('change');
        departaments_options = [];
        $('#departaments').text('').trigger('change')
        return null;
    }

    

    branches.map( (branch, index) => {
        //<option value="{{ $user->id }}">{{ $user->name }}</option>

        branches_selected.map( (branch_selected, key) => {
            if(branch.id == branch_selected.value){
                
                branch.departaments.forEach( departament => {

                    var abort = false;

                    departaments_options.forEach( option => {
                        if(option.value == departament.id){
                            abort = true;
                        }
                    } )

                    if (!abort) {
                        departaments_options.push({
                            value: departament.id,
                            name: departament.name
                        })
                    }

                } )

            }
        } )

        

        //SET ALL THE OPTIONS TO USER

        $('#departaments').text('').trigger('change')
        departaments_options.map( option => {
            let op = `<option value="${option.value}">${option.name}</option>`;
            $('#departaments').append(op).trigger('change');
        } )
            
        

        
    } )

}