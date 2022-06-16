$(document).ready(function(){
    var form_data = <?= $form_data ?>;
    var edited_data = <?= $form_cache ?>;
    var formid = form_data.formid;
    var components = {
        level: $("#level"),
        induk: $("#induk"),
        nama: $("#nama"),
        url: $("#url"),
        icon: $("#icon"),
        jenis: $("#jenis"),
        permission: $("#permission-wrapper"),
        add_permission: $("#add-permission"),
        name_perm: $("#perm_name"),
        perm_warning: $("#perm-warning"),
        perm_desc: $("#perm_desc")
    };

    _persiapan_data().then(data => {
        _add_event_listener(data);
        _persiapan_nilai(data);
    
    });
   



    async function _persiapan_data(){
        var data = {};

        // load data permission
        data.permission = await fetch('ws/uihelper/permission?dt=0', {method: 'GET'}).then(res => res.json()).then(res => res.data).catch(err => { console.log(err); return []});
        data.menu = await fetch('ws/uihelper/navigasi?j=sidebar&l=1&dt=0', {method: 'GET'}).then(res => res.json()).then(res => res.data).catch(err => { console.log(err); return []});
        return data;
    }


    function _add_event_listener(data){
        components.level.change(function(){
            var val = $(this).val();
            if(val > 1){
                components.induk.parent().removeClass('d-none');
                components.induk.prop('required', true);

                // components.url.parent().removeClass('d-none');
                // components.url.prop('required', true);
            }else{
                components.induk.parent().addClass('d-none');
                components.induk.prop('required', false);
                
                // components.url.parent().addClass('d-none');
                // components.url.val('').prop('required', false);
            }
        });

        components.add_permission.click(function(e){
            e.preventDefault();
            var value = components.name_perm.val();
            if(!value){
                components.perm_warning.text("Nama Permission Kosong").show();
            }else{
                components.perm_warning.text("").hide();
                add_permission(data, value, components.perm_desc.val());
            }
        });


    }


    function _persiapan_nilai(data){
        if(data.menu){
            var option = '<option value = ""> Pilih Induk </option>';
            data.menu.forEach(m => {
                option += "<option value='" + m.id + "'>" + m.nama + "</option>";
            });

            components.induk.append(option);
        }

        // Buat Checkbox Permission
        if(data.permission){
           render_checkbox_permission(data.permission);
        }


        if(form_data.mode == 'edit' && edited_data){
            if(edited_data.id_permission){
                edited_data.id_permission.forEach(p => {
                    $("#" + p).prop('checked', true);
                })
            }
            components.nama.val(edited_data.nama);
            components.url.val(edited_data.url);
            components.icon.val(edited_data.icon);
            components.jenis.find('option[value="' + edited_data.jenis + '"]').prop('selected', true).parent().trigger('change');
            components.level.find('option[value="' + edited_data.level + '"]').prop('selected', true).parent().trigger('change');
            $("#" + formid).append("<input type='hidden' name='id' value='" + edited_data.id + "'>");
            $("#" + formid).append("<input type='hidden' name='mode' value='edit'>");
        }
    }



    function render_checkbox_permission(data){
        components.permission.empty();
        var checkbox = "";
                                             data.forEach(p => {
            checkbox += '<div class="mb-4 col-6">' +
                            '<div class="custom-control custom-checkbox mb-4">' +
                                '<input type="checkbox" class="custom-control-input" name="permission[]" id="'+ p.id +'" value="'+ p.id +'">' +
                                '<label class="custom-control-label" for="'+ p.id +'">'+ p.nama +'</label>' +
                            '</div>' +
                        '</div>'
        });

        components.permission.append(checkbox);
    }

    function add_permission(data, perm, desc){
        fetch('ws/uihelper/permission', {method: 'POST', body: JSON.stringify({nama: perm, desc: desc})}).then(res => res.json()).then(res => {
            data.permission.push({
                id: res.id,
                nama: res.nama
            });
            render_checkbox_permission(data.permission)
        });
    }

});