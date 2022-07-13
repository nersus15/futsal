$(document).ready(function(){
    var form_data = <?= $form_data ?>;
    var edited_data = <?= $form_cache ?>;
    var formid = form_data.formid;
    var components = {
        id: $('#id'),
        jenis: $("#jenis"),
        tempat: $("#tempat"),
        method: $("#method")
    };

    _persiapan_data().then(data => {
        _add_event_listener(data);
        _persiapan_nilai(data);
    
    });
   



    async function _persiapan_data(){
        var data = {};

        // load data permission
        return data;
    }


    function _add_event_listener(data){
        

    }


    function _persiapan_nilai(data){
        if(form_data.mode == 'edit' && edited_data){
            components.method.val('update');
            components.jenis.find('option[value="' + edited_data.jenis+ '"').prop('selected', true).parent().trigger('change');
            components.tempat.val(edited_data.tempat);
            components.id.val(edited_data.id);
        }else if(form_data.mode == 'baru'){
            components.method.val('POST');
            fetch(path + 'ws/get_lapangan?rid=1&l=1').then(res => res.json()).then(res => {
                var currentID = parseInt(res.message.replace('LPN', ''));
                var nextID = currentID + 1;

                if(nextID.toString().length == 1)
                    nextID = '0' + nextID;
                
                components.id.val('LPN' + nextID);
            });
        }
    }

});