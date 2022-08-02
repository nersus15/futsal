<?php
defined('BASEPATH') or exit('No direct script access allowed');

$config['comp']['dore']['sidebar'] = array(
    'admin' => array(
        'menus' => array(
            array('text' => 'Dashboard', 'icon' => 'iconsmind-Home', 'link' => base_url('admin/dashboard')),
            array('text' => 'Data', 'link' =>  '#data', 'icon' => 'iconsmind-Big-Data'),
            array('text' => 'Booking List', 'link' => base_url('data/booking'), 'icon' => 'iconsmind-Bar-Chart'),
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

        )
    ),
    'pimpinan' => array(
        'menus' => array(
            array('text' => 'Laporan', 'icon' => 'iconsmind-Bar-Chart', 'link' => '#laporan'),
            array('text' => 'Kelola Admin', 'icon' => 'simple-icon-people', 'link' => base_url('admin')),
        ),
        'subMenus' => array(
            array(
                'induk' => 'laporan',
                'menus' => array(
                    array('text' => 'Booking', 'link' => base_url('report/booking'), 'icon' => 'iconsmind-Check'),
                    array('text' => 'Member', 'link' => base_url('report/member'), 'icon' => 'simple-icon-people'),
                )
            )
        )
    ),
    'member' => array(
        'menus' => array(
            array('text' => 'Dashboard', 'icon' => 'iconsmind-Home', 'link' => base_url()),
            array('text' => 'Riwayat Booking', 'icon' => 'iconsmind-Home', 'link' => base_url('member/booking')),
            // array('text' => 'Penjual', 'link' =>  base_url('penjual'), 'icon' => 'simple-icon-people'),
            // array('text' => 'Pesanan', 'link' =>  '#', 'icon' => 'iconsmind-Full-Cart'),
            // array('text' => 'Siswa', 'link' =>  base_url('siswa'), 'icon' => 'iconsmind-Students'),
        ),
        'subMenus' => array(
           
        )
    )
);
