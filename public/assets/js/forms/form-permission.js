$(document).ready(function(){
    var form_data = <?= $form_data ?>;
    var edited_data = <?= $form_cache ?>;
    var formid = form_data.formid;
    var components = {
        nama: $("#nama"),
        desc: $("#desc"),
    };

    _persiapan_data().then(data => {
        _add_event_listener(data);
        _persiapan_nilai(data);
    
    });
   



    async function _persiapan_data(){
        var data = {};
        return data;
    }


    function _add_event_listener(data){

    }


    function _persiapan_nilai(data){
        if(form_data.mode == 'edit' && edited_data){
            components.nama.val(edited_data.nama);
            components.desc.val(edited_data.desc);
            $("#" + formid).append("<input type='hidden' name='id' value='" + edited_data.id + "'>");
            $("#" + formid).append("<input type='hidden' name='mode' value='edit'>");
        }
    }

});