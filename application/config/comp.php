<?php
defined('BASEPATH') or exit('No direct script access allowed');

$config['comp']['dore']['sidebar'] = array(
    'admin' => array(
        'menus' => array(
            array('text' => 'Dashboard', 'icon' => 'iconsmind-Home', 'link' => base_url('admin/dashboard')),
            array('text' => 'Data', 'link' =>  '#data', 'icon' => 'iconsmind-Big-Data'),
            array('text' => 'Booking List', 'link' => '#laporan', 'icon' => 'iconsmind-Bar-Chart'),
            array('text' => 'Settings', 'link' => '#settings', 'icon' => 'simple-icon-settings')
        ),
        'subMenus' => array(
            array(
                'induk' => 'data',
                'menus' => array(
                    array('text' => 'Lapangan', 'link' => base_url('data/lapangan')),
                    array('text' => 'Jadwal', 'link' => base_url('data/jadwal')),
                    array('text' => 'Member', 'link' => base_url('data/member')),
                )
            ),
            array(
                'induk' => 'laporan',
                'menus' => array(
                    array('text' => 'Data transaksi', 'link' => base_url('laporan')),
                    array('text' => 'Pembayaran SPP', 'link' => base_url('laporan/spp')),
                    array('text' => 'Grafik', 'link' => base_url('laporan/grafik')),
                )
            ),
            array(
                'induk' => 'settings',
                'menus' => array(
                    array('text' => 'Carousel', 'link' => base_url('admin/settings/carousel'))
                ),
            )

        )
    ),
    // 'member' => array(
    //     'menus' => array(
    //         array('text' => 'Dashboard', 'icon' => 'iconsmind-Home', 'link' => base_url()),
    //         array('text' => 'Barang', 'icon' => 'iconsmind-Home', 'link' => base_url('barang')),
    //         array('text' => 'Penjual', 'link' =>  base_url('penjual'), 'icon' => 'simple-icon-people'),
    //         array('text' => 'Pesanan', 'link' =>  '#', 'icon' => 'iconsmind-Full-Cart'),
    //         // array('text' => 'Siswa', 'link' =>  base_url('siswa'), 'icon' => 'iconsmind-Students'),
    //     )
    //     // 'subMenus' => array(
    //     //     array(
    //     //         'induk' => 'transaksi',
    //     //         'menus' => array(
    //     //             array('text' => 'Masuk', 'active' => true, 'link' => base_url('transaksi/masuk')),
    //     //             array('text' => 'Keluar', 'link' => base_url('transaksi/keluar')),
    //     //         )
    //     //     )
    //     // )
    // )
);
