<?php
$data = array(
    'dtid' => 'dt-penjual',
    'dtTitle' => 'Data Penjual',
    'head' => array(
        'Username',
        'Nama Lengkap',
        'Alamat', 
        'No Hp',
        'Email',
        'Keterangan',
        'Photo',
    )
);
include_view('component/datatables/datatables.responsive', $data);