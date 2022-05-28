<input type="hidden" name="profile" id="plist">
<input type="hidden" id="pkey">
<div class="form-group">
    <label for="nama_penjual">Nama Penjual</label>
    <input id="nama_penjual" required name="nama_penjual" class="form-control"></input>
</div>
<div class="form-group">
    <label for="alamat">Alamat</label>
    <textarea rows="3" col="32" id="alamat" required name="alamat" class="form-control"></textarea>
</div>
<div class="form-group">
    <label for="hp">No Hp</label>
    <input id="hp" maxlength="15" name="hp" class="form-control"></input>
</div>
<div class="form-group">
    <label for="email">E mail</label>
    <input id="email" type="email" name="email" class="form-control"></input>
</div>
<div class="form-group">
    <label for="desc">Keterangan</label>
    <textarea rows="3" col="32" id="desc" required name="desc" class="form-control"></textarea>
</div>
<div class="form-group">
    <label for="">Upload photo profile</label>
    <div id="pp"  class="h-100 dropzone dz-clickable">
        <div class="dz-default dz-message"><span>Drop files here to upload</span></div>
    </div>
    <small class="text-danger">ketika di drop atau dipilih gambar akan otomatis di upload</small>

</div>