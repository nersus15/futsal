<input type="hidden" name="thumb" value="" id="tlist">
<input type="hidden" value="" id="tkey">
<div id="halaman-1">
    <div class="form-group">
        <label for="nama">Nama Barang</label>
        <input id="nama" required name="nama" class="form-control"></input>
    </div>

    <div class="form-group">
        <label for="satuan">Satuan</label>
        <input id="satuan" required name="satuan" class="form-control"></input>
    </div>

    <div class="form-group">
        <label for="harga">Harga</label>
        <input id="harga" min="1" required name="harga" type="number" class="form-control"></input>
    </div>

    <div class="form-group">
        <label for="deskripsi">Deskripsi</label>
        <textarea rows="5" col="32" id="deskripsi" required name="deskripsi" class="form-control"></textarea>
    </div>

    <div class="form-group">
        <label for="">Upload gambar barang</label>
        <div id="thumb"  class="h-100 dropzone dz-clickable">
            <div class="dz-default dz-message"><span>Drop files here to upload</span></div>
        </div>
        <small class="text-danger">ketika di drop atau dipilih gambar akan otomatis di upload</small>

    </div>

    <div class="form-group">
        <label for="">Penjual</label>
        <select name="penjual" id="penjual" class="select2 form-group"></select>
        <small class="text-danger">Jika penjual tidak ditemukan maka klik "tambah penjual baru"</small>
    </div>
    <p>Atau</p> 
    <div class="form-group">
        <button id="tambah-penjual" class="btn btn-xs btn-info" type="button">Tambah Penjual</button>
    </div>
</div>
<div id="halaman-2" style="display: none;">
    <?php include_view('forms/sub/penjual') ?>
</div>