$(document).ready(function(){
    var form_data = <?= $form_data ?>;
    var edited_data = <?= $form_cache ?>;
    var formid = form_data.formid;
    var components = {
        id: $('#id'),
        uid: $('#uid'),
        username: $("#username"),
        alamat: $("#alamat"),
        method: $("#method"),
        tim: $("#tim"),
        wakil: $("#wakil"),
        password: $("#password"),
        email: $("#email"),
        hp: $("#hp"),
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
            components.id.val(edited_data.id);
            components.uid.val(edited_data.userid);

            components.alamat.val(edited_data.asal);
            components.tim.val(edited_data.tim);
            components.wakil.val(edited_data.penanggung_jawab);
            components.username.val(edited_data.username).prop('readonly', true);
            components.hp.val(edited_data.hp);
            components.email.val(edited_data.email);

        }else if(form_data.mode == 'baru'){
            components.method.val('POST');
            fetch(path + 'ws/get_member?rid=1&l=1').then(res => res.json()).then(res => {
                var currentID = parseInt(res.message.replace('MBR', ''));
                var nextID = currentID + 1;

                if(nextID.toString().length == 1)
                    nextID = '0' + nextID;
                
                components.id.val('MBR' + nextID);
            });
        }
    }

});