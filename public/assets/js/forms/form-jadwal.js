$(document).ready(function(){
    var form_data = <?= $form_data ?>;
    var edited_data = <?= $form_cache ?>;
    var formid = form_data.formid;
    var components = {
        form: $("#" + formid),
        method: $("#method"),
        mulai: $("#mulai"),
        selesai: $("#selesai"),
        lapangan: $("#lapangan"),
        tarif: $("#tarif"),
    };

    _persiapan_data().then(data => {
        _add_event_listener(data);
        _persiapan_nilai(data);
    
    });
   



    async function _persiapan_data(){
        var data = {};
        data.instance = {};
        data.instance.timepicker = {
            mulai: components.mulai.timepicker({
                timeFormat: 'HH:mm',
                interval: 60,
                minTime: '07',
                maxTime: '23:00',
                startTime: '07:00',
                dynamic: false,
                dropdown: true,
                defaultTime: form_data.mode == 'edit' && edited_data.mulai ? edited_data.mulai : '07:00',
                scrollbar: true,
                zindex: 10000,
                change: function(time) {
                    // the input field
                    var element = $(this);
                    components.selesai.val((parseInt(element.val()) + 1) + ":00")

                }
            }),
        }

        data.lapangan = await fetch(path + "ws/get_lapangan?rid=1").then(res => res.json()).then(res => res);
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
            components.form.append("<input name='id' type='hidden' value='" + edited_data.id + "'/>");
            components.lapangan.find('option[value="' + edited_data.lapangan+ '"').prop('selected', true).parent().trigger('change');
            components.tarif.val(edited_data.tarif)
        }else if(form_data.mode == 'baru'){
            components.method.val('POST');
        }
    }

});