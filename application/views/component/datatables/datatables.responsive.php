<?php
    $attributTabel = '';
    if(isset($options) && !empty($options) && is_array($options)){
        foreach($options as $k => $v){
            $attributTabel .= 'data-' . $k . " = '" . $v . "'";
        }
    }
    if(!isset($skrip_data)) $skrip_data = [];
    if(!isset($skrip) || empty($skrip) || !file_exists(get_path(ASSETS_PATH . "js/" . $skrip) . ".js"))
        echo "<script> alert('Skrip datatable " . $dtid. " tidak ditemukan');</script>";
    else
        echo "<script>" . load_script($skrip, $skrip_data, true) . "</script>";

    if(!isset($perpage) && isset($pages) && !empty($pages)) $perpage = 10;

    if(!isset($form)) $form = array('formid'=>'form-'. $dtid, 'posturl' => '', 'path' => '', 'skrip' => '', 'formGenerate' => '');
    else$form = array_merge(array('formid'=>'form-'. $dtid, 'posturl' => '', 'path' => '', 'skrip' => '', 'formGenerate' => '', 'nama' => '', 'skripVar' => (object)[]), $form);
?>
<style>
    tr.selected{
        background-color: white !important;
    }
</style>
<div class="row mb-4 mt-3">
    <div class="col-12 mb-4">
        <?php 
            if(isset($data_panel) && !empty($data_panel)){
                extract($data_panel);
                include_view('component/datatables/toolbar.panel', array(
                    'tabel' => $nama,
                    'perpage' => $perpage,
                    'pages' => $pages,
                    'controls' => isset($controls) ? $controls : null,
                    'custom_search' => isset($custom_search) ? $custom_search : null,
                    'nofilter' => isset($hilangkan_filter) && $hilangkan_filter,
                    'notablelength' => isset($hilangkan_display_length) && $hilangkan_display_length,
                    'toolbar_button' => $toolbar
                ));
            }
        ?>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body card-no-border">
                <h1 class="card-title ml-4"><?php echo $dtTitle ?></h1>
                <?php if(isset($dtAlert)): ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong><?php echo $alert ?>: </strong> <span id="saldo-sebelum"><?php echo $dtAlert?></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php endif ?>
                <div class="table-responsive container-fluid dt-bootstrap4">
                    <table class="dataTable table tabeleditor table-nomargin table-condensed table-no-topborder table-bordered- table-striped- table-hover dataTable no-footer dtr-inline" id="<?php echo $dtid ?>" data-export-title="<?php echo isset($exportTitle) ? $exportTitle : null ?>" <?= $attributTabel ?>>
                        <thead>
                            <tr>
                                <?php foreach($head as $h):?>
                                <th><?php echo $h ?></th>
                                <?php endforeach ?>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script id="toolbar-default-skrip">
    $(document).ready(function(){
        var form = <?= json_encode($form) ?>;
        var dtid = "<?= $dtid?>";

        var defaultCnfigToast = {
            title: 'Submit Feedback',
            message: 'Submit Successfull',
            id: 'defaut-config',
            cara_tempel: 'after',
            autohide: true,
            show: true,
            hancurkan: true,
            wrapper: 'body',
            delay: 5000
        }

        if(!form.buttons){
            form.buttons = [
                
            ];
        }
        var attributTabel = $("#"+dtid).data();
        var panel = $("#displayOptions-" + dtid);
        var addButton = panel.find('.tool-add');
        var editButton = panel.find('.tool-edit');
        var deleteButton = panel.find('.tool-delete');
        var modalid = "modal-" + dtid;
        var modalConfig = {
            modalId: modalid,
            wrapper: "body",
            opt: {
                clickToClose: false,
                type: form.path ? 'form-custom' : 'form',
                ajax: true,
                rules: [
                    {
                        name: 'noSpace',
                        method: function (value, element) { return value.indexOf(" ") < 0; },
                        message: "No space please",
                        field: 'url'
                    }
                ],
                sebelumSubmit: function () {
                    showLoading();
                },
                submitSuccess: function (res) {
                    endLoading();
                    res = JSON.parse(res);
                    defaultCnfigToast.time = moment().format('YYYY-MM-DD HH:ss');
                    defaultCnfigToast.message = res.message;
                    console.log(res);
                    setTimeout(function(){
                        $("#" + modalid).modal('hide');
                    }, 1000);
                    makeToast(defaultCnfigToast);
                    setTimeout(function(){
                       window.location.reload();
                    }, 2000);

                },
                submitError: function(res){
                    endLoading();
                    if(typeof(res) == 'string')
                        res = JSON.parse(res);

                    if (res.message)
                        defaultCnfigToast.message = res.message;
                    else
                        defaultCnfigToast.message = "Sumbit Failed";

                    defaultCnfigToast.time = moment().format('YYYY-MM-DD HH:ss')
                    makeToast(defaultCnfigToast);
                   
                },
                open: true,
                destroy: true,
                modalPos: attributTabel.formPosisi?attributTabel.formPosisi:'rigth',
                saatBuka: (innerOpt) => {
                    var datatable = getInstance('dataTables', dtid);
                    if(!datatable) return;

                    var url = path + 'ws/uihelper/skrip?s=' + form.skrip;
                    if(innerOpt.mode == 'edit'){
                        var rowData = datatable.rows({selected:true}).data();
                        var editedData =rowData[0];
                        if(editedData)
                            url += "&ed=" + JSON.stringify(editedData);

                    }
                    if(form.skripVar)
                        url += "&sv=" + JSON.stringify(form.skripVar);

                    var formEl = fetch(url, {method: 'GET', })
                    .then(res => {
                        if (res.status != 200)
                            return;
                        else
                            return res.json()
                    }).then(res => {
                        if (!res)
                            return;
                        else {
                            $("#" + modalid).after(res.skrip);
                        }
                    });
                },
                saatTutup: () => {
                },
                formOpt: {
                    enctype: 'multipart/form-data',
                    formId: form.formid,
                    formAct: form.posturl,
                    formMethod: 'POST',
                },
                modalTitle: form.nama,
                modalBody: {
                    input: form.formGenerate ? form.formGenerate : [],
                    buttons: form.buttons
                },
            }
        };
        if(addButton.length > 0){
            addButton.click(function(){
                form.skripVar.mode = 'baru';
                form.skripVar.formid = modalConfig.opt.formOpt.formId;
                if(form.path){
                    var url = path + 'ws/uihelper/form/?f=' + form.path 

                    var formEl = fetch(url, {
                        method: 'GET',
                    }).then(res => {
                        if (res.status != 200)
                            return;
                        else
                            return res.json()
                    }).then(res => {
                        if (!res)
                            return;
                        else {
                            modalConfig.opt.modalBody.customBody = res.html;
                            generateModal(modalConfig.modalId, modalConfig.wrapper, modalConfig.opt)
                        }
                    });
                }else{
                    generateModal(modalConfig.modalId, modalConfig.wrapper, modalConfig.opt);
                }
            });
        }

        if(editButton.length > 0){
            editButton.click(function(e){
                e.preventDefault();
                var datatable = getInstance('dataTables', dtid);
                if(!datatable) return;

                modalConfig.opt.mode = 'edit';
                form.skripVar.formid = modalConfig.opt.formOpt.formId;

                var rowData = datatable.rows({selected:true}).data();
                if(rowData.length <= 0){
                    alert("pilih salah satu data untuk melanjutkan");
                    return;
                }
                else if(rowData.length > 1){
                    alert("Hanya bisa mengedit satu data dalam satu waktu"); 
                    return;
                }
                var editedData =rowData[0];
                var url = path + 'ws/uihelper/form/?f=' + form.path + '&s=' + form.skrip + "&ed=" + JSON.stringify(editedData);

                form.skripVar['mode'] = 'edit';
                
                if(form.path){
                    var formEl = fetch(url, {
                        method: 'GET',
                    }).then(res => {
                        if (res.status != 200)
                            return;
                        else
                            return res.json()
                    }).then(res => {
                        if (!res)
                            return;
                        else {
                            modalConfig.opt.formOpt.formAct = form.updateurl != undefined ? form.updateurl : form.posturl;
                            modalConfig.opt.modalBody.customBody = res.html
                            generateModal(modalConfig.modalId, modalConfig.wrapper, modalConfig.opt)
                        }
                    });
                }else{
                    generateModal(modalConfig.modalId, modalConfig.wrapper, modalConfig.opt);
                }
            });
        }

        if(deleteButton.length > 0){
            deleteButton.click(function(e){
                e.preventDefault();
                var datatable = getInstance('dataTables', dtid);
                var rowData = datatable.rows({selected:true}).data();

                if(rowData.length <= 0){
                    alert("pilih salah satu data untuk melanjutkan");
                    return;
                }
                    
                if(!form.deleteurl)
                    form.deleteurl = form.posturl;
                var ids = [];
                var names = [];
                for (let i = 0; i < rowData.length; i++) {
                   ids.push(rowData[i].id);
                   names.push(rowData[i].nama);
                }

                confirm("Yakin Ingin Menghapus data dengen id " + ids.join(', ') + "(" + names.join(', ') + ")")


                fetch(form.deleteurl, {
                    method: 'POST',
                    body: JSON.stringify({
                        '_http_method': 'delete',
                        'ids': ids,
                    })
                }).then(res => {
                    if (res.status != 200)
                        return;
                    else
                        return res.json()
                }).then(res => {
                    if (!res)
                        return;
                        
                    else {
                        if(typeof(res) == 'string')
                            res = JSON.parse(res);

                        if (res.message)
                            defaultCnfigToast.message = res.message;
                        else
                            defaultCnfigToast.message = "Sumbit Berhasil";

                        defaultCnfigToast.time = moment().format('YYYY-MM-DD HH:ss')
                        makeToast(defaultCnfigToast);
                        var dt = getInstance('dataTables', dtid);
                        dt.ajax.reload();
                    }
                });
            

            });
        }
    });

</script>
<script id="toolbar-user-skrip">
<?php
    if(isset($toolbarSkrip) && !empty($toolbarSkrip)){
        load_script($toolbar, $form + array('dtid' => $dtid));
    }
?>
</script>