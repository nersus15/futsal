<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['form']['login'] = array(
    'user' => 'user',
    'pass' => 'password'
);

$config['form']['barang'] = array(
    'nama' => 'nama',
    'satuan' => 'satuan',
    'harga' => 'harga',
    'deskripsi' => 'deskripsi',
    'penjual' => 'penjual',
    'thumb' => 'thumb'
);

$config['form']['penjual'] = array(
    'nama_penjual' => 'nama_lengkap',
    'alamat' => 'alamat', 
    'hp' => 'nohp',
    'email' => 'email',
    'desc' => 'keterangan',
    'profile' => 'photo'
);

// $config['form']['user'] = array(
//     '_username' => '_username',
//     'username' => 'username',
//     'email' => 'email',
//     'role' => 'role',
//     'nama_lengkap' => 'nama_lengkap',
//     '_mode' => '_mode',
//     'nohp' => 'nohp',
//     'jabatan' => 'jabatan',
//     'id_info' => 'id_info',
//     'active' => 'isActive',
//     'password' => 'password'
// );
$config['form']['edit-user'] = array(
    '_username' => '_username',
    'username' => 'username',
    'email' => 'email',
    'role' => 'role',
    'nama' => 'nama_lengkap',
    '_mode' => '_mode',
    'hp' => 'nohp',
    'jabatan' => 'jabatan',
    'alamat' => 'alamat',
    'ktp' => 'alamat_ktp',
    'id_info' => 'id_info',
    'active' => 'isActive',
    'password' => 'password',
    'kelamin' => 'kelamin'
);

$config['form']['siswa'] = array(
    'nis' => 'nomerInduk',
    'nama' => 'nama',
    'alamat' => 'alamat',
    'kelamin' => 'kelamin',
    'kelas' => 'kelas',
    'angkatan' => 'angkatan',
);
$config['form']['transaksi_masuk'] = array(
    'jenis_transaksi' => 'jenis',
    'sumber' => 'sumber',
    'tanggal' => 'tanggal',
    'sebelum' => 'saldo_sebelum',
    'catatan' => 'catatan',
    'sumber' => 'sumber',
    'siswa' => 'siswa',
    'jenis' => 'jenis',
    'jumlah' => 'jumlah'

);
$config['form']['transaksi_keluar'] = array(
    'jenis_transaksi' => 'jenis',
    'sumber' => 'sumber',
    'tanggal' => 'tanggal',
    'sebelum' => 'saldo_sebelum',
    'catatan' => 'catatan',
    'siswa' => 'siswa',
    'jenis' => 'jenis',
    'jumlah' => 'jumlah'

);


$config['form']['navigasi-menu'] = array(
    'id' => 'id',
    'nama' =>  'nama',
    'level' => 'lvl',
    'induk' => 'parent',
    'jenis' => 'parrent_element',
    'icon' => 'icon',
    'aktif' => 'aktif',
    'url' => 'url',
);
$config['form']['navigasi-permission'] = array(
    'permission' =>  'permission',
);