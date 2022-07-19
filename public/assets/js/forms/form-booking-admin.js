$(document).ready(function(){
    var form_data = <?= $form_data ?>;
    var edited_data = <?= $form_cache ?>;
    var formid = form_data.formid;
    var components = {
        form: $("#" + formid),
        id: $("#id"),
        method: $("#method"),
        member: $("#member"),
        tim: $("#tim"),
        wakil: $("#wakil"),
        tanggal: $("#tanggal"),
        lapangan: $("#lapangan"),
        jadwal: $("#jadwal"),
    };

    _persiapan_data().then(data => {
        _add_event_listener(data);
        setTimeout(function(){
            _persiapan_nilai(data)
        }, 500);
    
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
    var jadwalKosong = false;

    async function _persiapan_data(){
        var data = {};
        var options = {
            submitError: function(response){
                endLoading();
                var data;
                if(response.responseText){
                    if(typeof(response.responseText))
                        data = JSON.parse(response.responseText);
                    else
                        data = response.responseText;
                }else{
                    var header = response.getResponseHeader('message');
                    if(header)
                        data = JSON.parse(header);
                }
                var toast = defaultCnfigToast;
                toast.message = data.message;
                toast.bg = 'bg-danger';
                toast.time = moment().format('YYYY-MM-DD HH:ss');
                makeToast(toast);
    
            },
            sebelumSubmit: function(input){
                alert(jadwalKosong)
                if(!jadwalKosong)
                    return false;
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
                        window.location.href = path + 'pembayaran/' + data.id
                    }, 5000);
                }
            }
        };
        
        data.instance = {};
        renderLapangan();
        renderJadwal();
        data.instance.formAjax = components.form.initFormAjax(options);
        return data;
    }

    function renderLapangan(def){
        $.get(path + 'ws/get_lapangan').then(res => {
           var data = res.data;
           var row = '';
           data.forEach(d => {
               row += "<option value='" + d.id + "'>" + d.id + " ("+ d.jenis +") - " + d.tempat + "</option>";
           });
           $("#lapangan").empty().append(row);
        });
    }

    function renderJadwal(){
        $.get(path + 'ws/get_jadwal').then(res => {
            var data = res.data;
            var row = '<option id="no-lp">Tidak ada Jadwal dilapangan ini';
            var i = 0;
            data.forEach(d => {
                if(edited_data.jadwal == d.id)
                    row += "<option selected data-lapangan='"+ d.lapangan +"' value='" + d.id + "'>" + d.mulai + " - " + d.selesai + " (Rp. "+ d.tarif.rupiahFormat() +") </option>";
                else if(i == 0)
                    row += "<option selected data-lapangan='"+ d.lapangan +"' value='" + d.id + "'>" + d.mulai + " - " + d.selesai + " (Rp. "+ d.tarif.rupiahFormat() +") </option>";
                else    
                    row += "<option data-lapangan='"+ d.lapangan +"' value='" + d.id + "'>" + d.mulai + " - " + d.selesai + " (Rp. "+ d.tarif.rupiahFormat() +") </option>";
                i++;
            });
            $("#jadwal").empty().append(row);
         });
    }


    function _add_event_listener(data){
        $(document).ready(function(){
            $("#lapangan").change(function(){
                var lapangan = $(this).val();
                $("#jadwal option").hide();
                $("#jadwal option[data-lapangan='" + lapangan + "']").show();
                var option = $("#jadwal option[data-lapangan='" + lapangan + "']");
                if(option.length == 0)
                    $("#no-lp").show().prop('selected', true).parent().trigger('change');
                else
                    components.jadwal.trigger('change');
            });
            $("#lapangan").trigger('change')
        });
       
        $("#jadwal, #tanggal").change(function(){
            var tanggal = $("#tanggal").val();
            var jadwal = $("#jadwal").val();
            if(form_data.mode == 'edit' && jadwal == edited_data.jadwal){
                $("button[type='submit']").prop('disabled', false)
                return;
            }

            if(!jadwal) return;
            $.get(path + 'ws/cekjadwal/?t=' + tanggal + '&j=' + jadwal).then(res =>{
                if(!res.kosong){
                   alert("Sudah dibooking, silahkan pilih jam atau tanggal lain");
                    $("button[type='submit']").prop('disabled', true)
                }else
                    $("button[type='submit']").prop('disabled', false)
            });
        });

        $("#member").blur(function(){
            var member = $(this).val();
            if(member){
                $.get(path + 'ws/get_memberby?member-id=' + member).then(res => {
                    components.tim.val("");
                    components.wakil.val("");
                    if(res.data.length == 0)
                        return
                    var data = res.data[0];
                    components.tim.val(data.tim);
                    components.wakil.val(data.penanggung_jawab);
                });
            }
        })
    }


    function _persiapan_nilai(data){
        if(form_data.mode == 'edit' && edited_data){
            components.method.val('update');
            components.id.val(edited_data.id);
            components.member.val(edited_data.mid).trigger('blur');

            if(!edited_data.member){
                components.tim.val(edited_data.tim);
                components.wakil.val(edited_data.wakil);
            }
            components.tanggal.val(edited_data.tanggal);
            var option = $("#lapangan option[value='" + edited_data.lapangan + "']").prop('selected', true).trigger('change');
          
            setTimeout(function(){
                components.jadwal.find('optiion[value="' + edited_data.jadwal + '"]').prop('selected', true).trigger('change');
            }, 500);
            console.log(edited_data.registrar);
            if(edited_data.registrar == null || edited_data.registrar == undefined){
                $("#" + formid + " input, select, button[type='submit']").prop('disabled', true);
                alert("Tidak bisa edit data yang didaftar bukan oleh admin");
            }
        }else if(form_data.mode == 'baru'){
            var option = $("#lapangan option");
            if(option.length > 0)
                $(option[0]).prop('selected', true).parent().trigger('change');
            components.method.val('post');
        }
        components.member.trigger('blur');
    }

});

