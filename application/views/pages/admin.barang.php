<?php
$data = array(
    'dtid' => 'dt-barang',
    'dtTitle' => 'Data Barang',
    'head' => array(
        'Nama Barang',
        'Kategori', 
        'Harga',
        'Penjual',
    )
);
include_view('component/datatables/datatables.responsive', $data);