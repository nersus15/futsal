$(document).ready(function(){
    var dtid = "<?= $dtid?>";
    var panel = $("#displayOptions-" + dtid);
    var batalkan = panel.find('.tool-batalkan');
    var verifikasi = panel.find('.tool-verify');
    var mulai = panel.find('.tool-aktif');
    var selesai = panel.find('.tool-selesai');
    var detail = panel.find('.tool-detail');
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
    if(batalkan.length == 1){
        batalkan.click(function(e){
            e.preventDefault();
            update_status('Batal');
        });
    }
    if(verifikasi.length == 1){
        verifikasi.click(function(e){
            e.preventDefault();
            update_status('Terverifikasi');
        });
    }
    if(mulai.length == 1){
        mulai.click(function(e){
            e.preventDefault();
            update_status('Aktif');
        });
    }
    if(selesai.length == 1){
        selesai.click(function(e){
            e.preventDefault();
            update_status('Selesai');
        });
    }

    if(detail.length == 1){
        detail.click(function(e){
            e.preventDefault();
            var datatable = getInstance('dataTables', dtid);
            var rowData = datatable.rows({selected:true}).data();

            if(rowData.length != 1){
                alert("Pilih Satu data untuk aksi ini");
                return;
            }
                
            window.open(path + 'pembayaran/' + rowData[0].id)
        });
    }

    function update_status(status){
        var datatable = getInstance('dataTables', dtid);
        var rowData = datatable.rows({selected:true}).data();

        if(rowData.length <= 0){
            alert("pilih salah satu data untuk melanjutkan");
            return;
        }
        var ids = [];
        for (let i = 0; i < rowData.length; i++) {
            if(!rowData[i].bukti_bayar && status != 'Batal'){
                alert('Bookingan dengan ID '+ rowData[i].id +' belum dibayar');
                continue;
            }
            ids.push(rowData[i].id);
        }

        if(status == 'Terverifikasi' && ids.length == 0)
            return;

        confirm("Yakin Ingin Mengubah data dengen id " + ids.join(', ') + " menjadi " + status);
        fetch(path + 'ws/update_status_booking/' + status.toLowerCase(), {
            method: 'POST',
            body: JSON.stringify({
                '_http_method': 'delete',
                'ids': ids,
            })
        }).then(res => {
            if (res.status != 200){
                if(typeof(res) == 'string')
                    res = JSON.parse(res);

                if (res.message)
                    defaultCnfigToast.message = res.message;
                else
                    defaultCnfigToast.message = "Gagal";

                defaultCnfigToast.time = moment().format('YYYY-MM-DD HH:ss')
                makeToast(defaultCnfigToast);
                var dt = getInstance('dataTables', dtid);
                dt.ajax.reload();
            }
                
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
                    defaultCnfigToast.message = "Berhasil";

                defaultCnfigToast.time = moment().format('YYYY-MM-DD HH:ss')
                makeToast(defaultCnfigToast);
                var dt = getInstance('dataTables', dtid);
                dt.ajax.reload();
            }
        }).catch(res => {
            if (!res)
                    return;
                    
                else {
                    if(typeof(res) == 'string')
                        res = JSON.parse(res);

                    if (res.message)
                        defaultCnfigToast.message = res.message;
                    else
                        defaultCnfigToast.message = "Gagal";

                    defaultCnfigToast.time = moment().format('YYYY-MM-DD HH:ss')
                    makeToast(defaultCnfigToast);
                    var dt = getInstance('dataTables', dtid);
                    dt.ajax.reload();
                }
        });
    }

    function customizeTabel(){
        var datatable = getInstance('dataTables', dtid);
        var rowData = datatable.rows().data().toArray();
        for (let i = 0; i < rowData.length; i++) {
            var data = rowData[i];
            var row = $("#" + dtid).find('tbody tr');
            row = row[i];
            var column = $(row).find('td');
            var selesai = data.tanggal + " " + data.selesai;
            if(moment(selesai).diff(moment(), 'minutes') < 0 && data.status == 'terverifikasi')
                $(column[0]).addClass('row-selesai');
            else
                $(column[0]).removeClass('row-selesai');

            if(data.registrar != null && data.registrar != undefined)
                $(column[0]).addClass('row-editable');
            else
                $(column[0]).removeClass('row-editable');

            if(moment(data.dibuat).diff(moment(), 'minutes') < -18 && data.status == 'baru' && !data.bukti_bayar){
                $(column[0]).addClass('row-batalkan');
            }else{
                $(column[0]).removeClass('row-batalkan');
            }

        }
    };
   setInterval(customizeTabel, 1000)

});