<?php 
    $link = base_url();

    if(is_login('member'))
        $link = base_url('member/booking');
    elseif(is_login('admin'))
        $link = base_url('data/booking');

?>
<div class="bg col-md-6 col-lg-6 col-sm-12">
<div class="alert alert-warning" role="alert">
  Untuk keamanan disarankan untuk menyimpan <b> booking id </b> anda (setelah tanda pagar(#))
</div>
    <?php if(empty($booking)):?>
        <div class="card">
            <h1 class="card__msg">Data tidak ditemukan</h1>
        </div>
    <?php else: ?>
        <?php
            $diskon = ($booking->tarif * $booking->diskon)/100;
        ?>
        <div class="card">
            <div class="card-title">
                <a class="float-left" href="<?= $link ?>"> <i class='simple-icon-arrow-left'>Kembali</i> </a>
            </div>
            <h1 class="card__msg">Pembayaran</h1>
            <h2 class="card__submsg">Silahkan Melakukan Pembayaran Untuk Bookingan #<b id="bookingid"><?= $booking->id?></b> <i id="copy-to-clipboard" data-toggle="tooltip" data-placement="bottom" title="Copy booking id anda" style="cursor: pointer;" class="iconsmind-File-Copy2"></i></h2>
            <h2 class="card__submsg">Pembayaraan paling lambat 24 jam setelah melakukan booking, jika tidak maka tidak akan diterima dan dianggap dibatalkan</h2>
            
            <div class="card__body">
            <div class="card__recipient-info">
                <p class="card__recipient">Detail</p>
                <hr>
                <p class="card__email">Dibuat: <?= $booking->dibuat ?></p>
                <p class="card__email">Lapangan: <?= $booking->lapangan . " (" . $booking->jenis . ")" . " - " . $booking->tempat ?></p>
                <p class="card__email">Jadwal: <?= $booking->mulai . "-" . $booking->selesai ?></p>
                <p class="card__email">Penanggung Jawab: <?= !empty($booking->mwakil) ? $booking->mwakil : $booking->penanggung_jawab ?></p>
                <p class="card__email">Tim: <?= !empty($booking->mtim) ? $booking->mtim : $booking->tim ?></p>
                <p class="card__email">Tarif: <?=rupiah_format($booking->tarif) ?></p>
                <p class="card__email">Diskon: <?=  $booking->diskon . "% - " . rupiah_format($diskon) ?></p>
                <p class="card__email">Member ID: <b> <?= !empty($booking->mid) ? $booking->mid : "Bukan Member" ?></b></p>
            </div>
            <br>
            <h1 class="card__price"><?= rupiah_format($booking->tarif - $diskon) ?></h1>
            <h2 class="">Status Booking: <b><?= ucfirst($booking->status) ?></b></h2>
            
            <?php if (!empty($booking->bukti_bayar) && $booking->status == 'baru'): ?>
                <p class="card__method">Status Pembayaran</p>
                <hr>
                <div class="card__payment">
                    <div class="card__card-details">
                        <p class="card__card-type">Sudah dibayar (mengupload bukti bayar)</p>       
                        <p class="card__card-number">Menunggu konfirmasi admin</p>
                    </div>
                </div>   
            <?php elseif(empty($booking->bukit_bayar) && $booking->status == 'baru'):?>
                <p class="card__method">Cara Bayar</p>
                <hr>
                <div class="card__payment">
                    <div class="card__card-details">
                    <p class="card__card-type">Transfer ke bank Mandiri</p>
                    <p class="card__card-number">254209528529829 an (Futsal)</p>          
                    </div>
                </div>
                <div class="card__payment">
                    <div class="card__card-details">
                    <p class="card__card-type">Transfer ke bank BRI</p>
                    <p class="card__card-number">353534532 an (Futsal)</p>          
                    </div>
                </div>
                <div class="card__payment">
                    <div class="card__card-details">
                    <p class="card__card-type">Transfer ke bank BNI</p>
                    <p class="card__card-number">363354232 an (Futsal)</p>          
                    </div>
                </div>
        
                <p class="card__method mt-5">Upload Bukti Pembayaraan dibawah</p>
                <hr>
                    <script>
                        Dropzone.autoDiscover = false;
                    </script>
                    <form>
                        <div data-action="<?= base_url("ws/upload") ?>" class="dropzone dz-clickable">
                        <div class="dz-default dz-message"><span>Drop files here to upload</span></div></div>
                    </form>
                <br>
                </div>   
            <?php endif ?>    
        </div>
        </div>
    <?php endif ?>
<script>
    $(document).ready(function(){
        var dropzone = $(".dropzone");
        var dataid = "<?= $booking->id ?>";
        for (let i = 0; i < dropzone.length; i++) {
          var action = $(dropzone[i]).data('action');
          var id = $(dropzone[i]).attr('id');
          var instance = $(dropzone[i]).dropzone({
            url: action,
            sending: function(file, xhr, formData){
              formData.append('uuid', file.upload.uuid);
              formData.append('id', dataid);
              var removebtn = $(".remove");
              $(removebtn[removebtn.length - 1]).attr("data-uuid", file.upload.uuid)
            },
            complete: function(file){
                if(file.status != "error")
                    setTimeout(function(){window.location.href = path + 'home/pembayaran/' + dataid}, 200);
            },
            thumbnailWidth: 160,
            previewTemplate:
              '<div class="dz-preview dz-file-preview mb-3"><div class="d-flex flex-row "> <div class="p-0 w-30 position-relative"> <div class="dz-error-mark"><span><i class="simple-icon-exclamation"></i>  </span></div>      <div class="dz-success-mark"><span><i class="simple-icon-check-circle"></i></span></div>      <img data-dz-thumbnail class="img-thumbnail border-0" /> </div> <div class="pl-3 pt-2 pr-2 pb-1 w-70 dz-details position-relative"> <div> <span data-dz-name /> </div> <div class="text-primary text-extra-small" data-dz-size /> </div> <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>        <div class="dz-error-message"><span data-dz-errormessage></span></div>            </div><a href="#" data-uuid="" class="remove" data-dz-remove> <i class="simple-icon-trash"></i> </a></div>'
          });
          if(id){
            setInstance('dropzone', id, instance);
          }else{
            setInstance('dropzone', 'dropzone-' + i, instance);
          }
        }

        $(".remove").click(function(){
            var uuid = $(this).data('uuid');
            var dataid = "<?= $booking->id ?>";
            if(!uuid) return;

            $.post({
                url: path + 'ws/cancel_upload',
                data: JSON.stringify({uuid: uuid, dataid: dataid})
            });
        });

        $("#copy-to-clipboard").click(function(){
            var bid = $("#bookingid").text();
            copyToClipboard(bid);
        });
    });

</script>


