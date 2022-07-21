<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
    <div class="row">
        <div class="col-md-6">
            <label>ID Member</label>
        </div>
        <div class="col-md-6">
            <input readonly class="no-border" type="text" name="memberid" value="<?php echo $user['memberid'] ?>" id="memberid">
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <label>Nama Tim</label>
        </div>
        <div class="col-md-6">
            <input class="no-border" type="text" name="tim" value="<?php echo $user['tim'] ?>" id="tim">
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <label>Alamat</label>
        </div>
        <div class="col-md-6">
            <textarea class="no-border" name="asal" id="asal" cols="20" rows="3"><?php echo $user['asal'] ?></textarea>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <label>Tanggal Daftar</label>
        </div>
        <div class="col-md-6">
            <input class="no-border" readonly type="text" name="dibuat" value="<?php echo substr($user['dibuat'], 0, 10) ?>" id="Tanggal Daftar">
        </div>
    </div>
    <hr>
</div>