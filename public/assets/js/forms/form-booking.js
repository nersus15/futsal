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
    var defaultCnfigToast = {
        title: 'Submit Feedback',
        message: 'Submit Successfull',
        id: 'defaut-config',
        cara_tempel: 'after',
        autohide: true,
        show: true,
        hancurkan: true,
        wrapper: 'form',
        delay: 5000,
        bg: 'bg-primary'
    };

    async function _persiapan_data(){
        var data = {};
        var options = {
            submitError: function(response){
                endLoading();
                console.log(response.responseText);
                var data;
                if(response.responseText){
                    if(typeof(response.responseText))
                        data = JSON.parse(response.responseText);
                    else
                        data = response.responseText;
                }else{
                    var header = response.getResponseHeader('message');
                    console.log(header);
                    if(header)
                        data = JSON.parse(header);
                }
                console.log(data);
                var toast = defaultCnfigToast;
                toast.message = data.message;
                toast.bg = 'bg-danger';
                toast.time = moment().format('YYYY-MM-DD HH:ss');
                makeToast(toast);
    
            },
            sebelumSubmit: function(input, ){
                showLoading();
                $('#alert_danger small').text('').hide();
                $('#btn-login').prop('disabled', true);
            }, 
            submitSuccess: function(data){
                endLoading();
                if(typeof(data) == 'string')
                    data = JSON.parse(data);
                var toast = defaultCnfigToast;
                toast.title = toast.message;
                toast.message = data.message;
                toast.bg = 'bg-primary'
                toast.time = moment().format('YYYY-MM-DD HH:ss');
                makeToast(toast);
                if(data.id){
                    setTimeout(function(){
                        window.location.href = path + 'home/pembayaran/' + data.id
                    }, 5000);
                }
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
        $("#lihat-booking").click(function(){
            var id = $("#bid").val();
            if(!bid) return;

            window.location.href = path + 'home/pembayaran/' + id;
        })
    }


    function _persiapan_nilai(data){
       
    }

});

