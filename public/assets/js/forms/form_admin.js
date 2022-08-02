$(document).ready(function(){
    var form_data = <?= $form_data ?>;
    var edited_data = <?= $form_cache ?>;
    var formid = form_data.formid;
    var components = {
        form: $("#" + formid),
        method: $("#method"),
        username: $('#username'),
        nama: $('#nama'),
        id: $('#id'),
        hp: $('#hp'),
        email: $('#email'),
        password: $('#password'),
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
        if(data.lapangan){
            Object.keys(data.lapangan).forEach(k => {
                if(k == 'type') return;
                components.lapangan.append("<option value='" + data.lapangan[k].id + "'>" + data.lapangan[k].id + " - " + data.lapangan[k].jenis +"</option>");
            });
        }

        if(form_data.mode == 'edit' && edited_data){
            components.method.val('update');
            components.id.val(edited_data.id);
            components.email.val(edited_data.email);
            components.nama.val(edited_data.nama);
            components.username.val(edited_data.username);
            components.hp.val(edited_data.hp);
            components.password.parent().hide();
        }else if(form_data.mode == 'baru'){
            components.method.val('POST');
        }
    }

});