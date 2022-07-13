$(document).ready(function(){
    var form_data = <?= $form_data ?>;
    var edited_data = <?= $form_cache ?>;
    var formid = form_data.formid;
    var components = {
        form: $("#" + formid),
        method: $("#method"),
      
    };

    _persiapan_data().then(data => {
        _add_event_listener(data);
        _persiapan_nilai(data);
    
    });
   



    async function _persiapan_data(){
        var data = {};
        var options = {
            submitError: function(response){
                endLoading();
                var responseText  = JSON.parse(response.responseText)
                console.log(responseText);
                $('#alert_danger small').text(responseText.message).show();
    
                if(isFunction(submitError))
                    submitError(response);
    
            },
            sebelumSubmit: function(input, ){
                showLoading();
                $('#alert_danger small').text('').hide();
                $('#btn-login').prop('disabled', true);
            }, 
            submitSuccess: function(data){
                endLoading();
            }
        };
        
        data.instance = {};
        data.instance.formAjax = components.form.initFormAjax(options);
        return data;
    }


    function _add_event_listener(data){
        $(document).ready(function(){
            $("#lapangan").change(function(){
                var lapangan = $(this).val();
                $("#jadwal option").hide();
                $("#jadwal option[data-lapangan='" + lapangan + "']").show();
                var option = $("#jadwal option[data-lapangan='" + lapangan + "']");
                $(option[0]).prop('selected', true)
            });
            $("#lapangan").trigger('change')
        });
    }


    function _persiapan_nilai(data){
       
    }

});

