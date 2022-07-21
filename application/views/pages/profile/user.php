<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
    <div class="row">
        <div class="col-md-6">
            <label>username</label>
        </div>
        <div class="col-md-6">
            <input autocomplete="off" class="no-border" type="text" name="username" value="<?php echo $user['username'] ?>" id="username">
            <label class="text-danger" style="display: none;" id="err-username">Username sudah digunakan</label>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <label>Nama Lengkap</label>
        </div>
        <div class="col-md-6">
            <input autocomplete="off" class="no-border" type="text" name="nama" value="<?php echo $user['nama'] ?>" id="nama">
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <label>Email</label>
        </div>
        <div class="col-md-6">
            <input autocomplete="off" class="no-border" type="text" name="email" value="<?php echo $user['email'] ?>" id="email">
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <label>No. HP</label>
        </div>
        <div class="col-md-6">
            <input autocomplete="off" class="no-border" type="text" name="hp" value="<?php echo $user['hp'] ?>" id="hp">
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <label>Password</label>
        </div>
        <div class="col-md-6">
            <input autocomplete="off" class="form-control" type="password" name="password" id="pass" placeholder="Isi jika ingin merubah password">
        </div>
    </div>
</div>