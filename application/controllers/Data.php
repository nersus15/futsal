<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data extends CI_Controller
{
    function __construct() {
        parent::__construct();
        if(!is_login())
            redirect(base_url('auth/login'));
    }
    function lapangan()
    {
        $tabelLapangan = $this->getContentView('component/datatables/datatables.responsive', array(
            'dtTitle' => 'Daftar Lapangan yang Tersedia',
            'dtid' => 'dt-lapangan',
            'head' => array(
               '','Lapangan', 'Jenis', 'Tempat'
            ),
            'skrip' => 'dtconfig/dt_lapangan', //wajib
            'skrip_data' => array('id' => 'dt-lapangan'),
            'options' => array(
                'source' => 'ws/get_lapangan',
                'search' => 'false',
                'select' => 'multi', //false, true, multi
                'checkbox' => 'true',
                'change' => 'false',
                'dom' => 'rtip',
                'responsive' => 'true',
                'auto-refresh' => 'false',
                'deselect-on-refresh' => 'true',
            ),
            'form' => array(
                'id' => 'form-lapangan',
                'path' => '',
                'nama' => 'Form lapangan',
                'skrip' => 'forms/form-lapangan',
                'formGenerate' => array(
                    [
                        'type' => 'hidden', 'name' => '_http_method', 'id' => 'method'
                    ],
                    [
                        "label" => 'Nama Lapangan/Id', "placeholder" => '',
                        "type" => 'text', "name" => 'id', "id" => 'id', 'attr' => 'readonly'
                    ],
                    [
                        "label" => 'Jenis', "placeholder" => 'Jenis lapangan',
                        "type" => 'select', "name" => 'jenis', "id" => 'jenis', "attr" => 'required', 'options' => array(
                            'Vinyl' => array('text' => 'Vinyl'), 
                            'Rumput Sintetis' => array('text' => 'Rumput Sintetis'),
                            'Semen' => array('text' => 'Semen'),
                            'Parquette' => array('text' => 'Parquette'),
                            'Taraflex' => array('text' => 'Taraflex'),
                            'Karpet Plastik' => array('text' => 'Karpet Plastik'),
                        )
                        
                    ],
                    [
                        "label" => 'Tempat', "placeholder" => 'Lokasi lapangan',
                        "type" => 'textarea', "name" => 'tempat', "id" => 'tempat'
                    ]
                ),
                'posturl' => 'ws/add_lapangan',
                'updateurl' => '',
                'deleteurl' => 'ws/delete_lapangan',
                'buttons' => array(
                    [ "type" => 'reset', "data" => 'data-dismiss="modal"', "text" => 'Batal', "id" => "batal", "class" => "btn btn btn-warning" ],
                    [ "type" => 'submit', "text" => 'Simpan', "id" => "simpan", "class" => "btn btn btn-primary" ]
                )
            ),
            'data_panel' => array(
                'nama' => 'dt-lapangan',
                'perpage' => 10,
                'pages' => array(1, 2, 10),
                'hilangkan_display_length' => true,
                'toolbar' => array(
                    array(
                        'tipe' => 'buttonset',
                        'tombol' => array(
                            array('tipe' => 'link', 'href' => '#', 'title' => 'Tambah', 'icon' => 'icon-plus simple-icon-paper-plane', 'class' => 'btn-outline-primary tool-add tetap'),
                            array('tipe' => 'link', 'href' => '#', 'title' => 'Edit', 'icon' => 'icon-edit simple-icon-note', 'class' => 'tool-edit'),
                            array('tipe' => 'link', 'href' => '#', 'title' => 'Hapus', 'icon' => 'icon-remove simple-icon-trash', 'class' => 'tool-delete'),
                        )
                    ),
                ),
                'toolbarSkrip' => '',
            )
        ), true);
        $data = [
            'resource' => array('main', 'dore','datatables', 'form'),
            'contentHtml' => array($tabelLapangan),
            'content' => array(),
            'navbar' => 'component/navbar/navbar.dore',
            'sidebar' => 'component/sidebar/sidebar.dore',
            'pageName' => 'Master Data',
            'subPageName' => 'Lapangan',
            'sidebarConf' => config_sidebar('comp', 'admin', 1, array('sub' => 0, 'menu' => 0)),
            'navbarConf' => array(
                'adaUserMenu' => true,
                'adaNotif' => true,
                'pencarian' => false,
                'adaSidebar' => true,
                'homePath' => base_url()
            ),
            'bodyClass' => 'menu-hidden sub-hidden'
        ];
        $this->addViews('template/dore', $data);
        $this->render();
    }

    function jadwal(){
        $tabelLapangan = $this->getContentView('component/datatables/datatables.responsive', array(
            'dtTitle' => 'Daftar Jadwal yang Tersedia',
            'dtid' => 'dt-jadwal',
            'head' => array(
               '', 'Lapangan','Waktu', 'Jenis Lapangan', 'Tempat', 'Tarif'
            ),
            'skrip' => 'dtconfig/dt_jadwal', //wajib
            'skrip_data' => array('id' => 'dt-jadwal'),
            'options' => array(
                'source' => 'ws/get_jadwal',
                'search' => 'false',
                'select' => 'multi', //false, true, multi
                'checkbox' => 'true',
                'change' => 'false',
                'dom' => 'rtip',
                'responsive' => 'true',
                'auto-refresh' => 'false',
                'deselect-on-refresh' => 'true',
            ),
            'form' => array(
                'id' => 'form-jadwal',
                'path' => '',
                'nama' => 'Form jadwal',
                'skrip' => 'forms/form-jadwal',
                'formGenerate' => array(
                    [
                        'type' => 'hidden', 'name' => '_http_method', 'id' => 'method'
                    ],
                    [
                        "label" => 'Jam/ Waktu Mulai', "placeholder" => '',
                        "type" => 'text', "name" => 'mulai', "id" => 'mulai', 'attr' => 'required', 'class' => 'timepicker'
                    ],
                    [
                        "label" => 'Jam/ Waktu Selesai', "placeholder" => '',
                        "type" => 'text', "name" => 'selesai', "id" => 'selesai', 'attr' => 'required readonly',
                    ],
                    [
                        "label" => 'Lapangan', "placeholder" => 'lapangan',
                        "type" => 'select', "name" => 'lapangan', "id" => 'lapangan', "attr" => 'required', 'options' => array(
                            '' => array('text' => 'Pilih Lapangan'), 
                        )
                        
                    ],
                    [
                        "label" => 'Tarif', "placeholder" => 'Dalam Rupiah',
                        "type" => 'text', "name" => 'tarif', "id" => 'tarif', 'attr' => 'data-rule-digits=true'
                    ]
                ),
                'posturl' => 'ws/add_jadwal',
                'updateurl' => '',
                'deleteurl' => 'ws/delete_jadwal',
                'buttons' => array(
                    [ "type" => 'reset', "data" => 'data-dismiss="modal"', "text" => 'Batal', "id" => "batal", "class" => "btn btn btn-warning" ],
                    [ "type" => 'submit', "text" => 'Simpan', "id" => "simpan", "class" => "btn btn btn-primary" ]
                )
            ),
            'data_panel' => array(
                'nama' => 'dt-jadwal',
                'perpage' => 10,
                'pages' => array(1, 2, 10),
                'hilangkan_display_length' => true,
                'toolbar' => array(
                    array(
                        'tipe' => 'buttonset',
                        'tombol' => array(
                            array('tipe' => 'link', 'href' => '#', 'title' => 'Tambah', 'icon' => 'icon-plus simple-icon-paper-plane', 'class' => 'btn-outline-primary tool-add tetap'),
                            array('tipe' => 'link', 'href' => '#', 'title' => 'Edit', 'icon' => 'icon-edit simple-icon-note', 'class' => 'tool-edit'),
                            array('tipe' => 'link', 'href' => '#', 'title' => 'Hapus', 'icon' => 'icon-remove simple-icon-trash', 'class' => 'tool-delete'),
                        )
                    ),
                ),
                'toolbarSkrip' => '',
            )
        ), true);
        $data = [
            'resource' => array('main', 'dore','datatables', 'form'),
            'contentHtml' => array($tabelLapangan),
            'content' => array(),
            'navbar' => 'component/navbar/navbar.dore',
            'sidebar' => 'component/sidebar/sidebar.dore',
            'pageName' => 'Master Data',
            'subPageName' => 'Lapangan',
            'sidebarConf' => config_sidebar('comp', 'admin', 1, array('sub' => 0, 'menu' => 1)),
            'navbarConf' => array(
                'adaUserMenu' => true,
                'adaNotif' => true,
                'pencarian' => false,
                'adaSidebar' => true,
                'homePath' => base_url()
            ),
            'bodyClass' => 'menu-hidden sub-hidden'
        ];
        $this->addViews('template/dore', $data);
        $this->render();
    }

    function member(){
        $tabelMember = $this->getContentView('component/datatables/datatables.responsive', array(
            'dtTitle' => 'Daftar Member',
            'dtid' => 'dt-member',
            'head' => array(
               '', 'Nama Tim','Perwakilan', 'No. HP', 'Email', 'Alamat', 'Tanggal Daftar', 'Username', 'Default Password'
            ),
            'skrip' => 'dtconfig/dt_member', //wajib
            'skrip_data' => array('id' => 'dt-member'),
            'options' => array(
                'source' => 'ws/get_member',
                'search' => 'false',
                'select' => 'multi', //false, true, multi
                'checkbox' => 'true',
                'change' => 'false',
                'dom' => 'rtip',
                'responsive' => 'true',
                'auto-refresh' => 'false',
                'deselect-on-refresh' => 'true',
            ),
            'form' => array(
                'id' => 'form-member',
                'path' => '',
                'nama' => 'Form member',
                'skrip' => 'forms/form-member',
                'formGenerate' => array(
                    [
                        'type' => 'hidden', 'name' => '_http_method', 'id' => 'method'
                    ],
                    [
                        'type' => 'hidden', 'name' => 'uid', 'id' => 'uid'
                    ],
                    [
                        "label" => 'ID Member', "placeholder" => '',
                        "type" => 'text', "name" => 'id', "id" => 'id', 'attr' => 'readonly'
                    ],
                    [
                        "label" => 'Nama Tim', "placeholder" => '',
                        "type" => 'text', "name" => 'tim', "id" => 'tim',
                    ],
                    [
                        "label" => 'Nama Penanggung Jawab', "placeholder" => '',
                        "type" => 'text', "name" => 'wakil', "id" => 'wakil',
                    ],
                    [
                        "label" => 'Alamat', "placeholder" => '',
                        "type" => 'textarea', "name" => 'alamat', "id" => 'alamat',
                    ],
                    [
                        "label" => 'Username', "placeholder" => 'Masukkan username baru untuk akun member',
                        "type" => 'text', "name" => 'username', "id" => 'username', 'attr' => 'required'
                    ],
                    [
                        "label" => 'Email', "placeholder" => '',
                        "type" => 'email', "name" => 'email', "id" => 'email',
                    ],
                    [
                        "label" => 'No HP', "placeholder" => '',
                        "type" => 'text', "name" => 'hp', "id" => 'hp', 'attr' => 'data-rule-digits=true required'
                    ],
                ),
                'posturl' => 'ws/add_member',
                'updateurl' => '',
                'deleteurl' => 'ws/delete_member',
                'buttons' => array(
                    [ "type" => 'reset', "data" => 'data-dismiss="modal"', "text" => 'Batal', "id" => "batal", "class" => "btn btn btn-warning" ],
                    [ "type" => 'submit', "text" => 'Simpan', "id" => "simpan", "class" => "btn btn btn-primary" ]
                )
            ),
            'data_panel' => array(
                'nama' => 'dt-member',
                'perpage' => 10,
                'pages' => array(1, 2, 10),
                'hilangkan_display_length' => true,
                'toolbar' => array(
                    array(
                        'tipe' => 'buttonset',
                        'tombol' => array(
                            array('tipe' => 'link', 'href' => '#', 'title' => 'Tambah', 'icon' => 'icon-plus simple-icon-paper-plane', 'class' => 'btn-outline-primary tool-add tetap'),
                            array('tipe' => 'link', 'href' => '#', 'title' => 'Edit', 'icon' => 'icon-edit simple-icon-note', 'class' => 'tool-edit'),
                            array('tipe' => 'link', 'href' => '#', 'title' => 'Hapus', 'icon' => 'icon-remove simple-icon-trash', 'class' => 'tool-delete'),
                        )
                    ),
                ),
                'toolbarSkrip' => '',
            )
        ), true);
        $data = [
            'resource' => array('main', 'dore','datatables', 'form'),
            'contentHtml' => array($tabelMember),
            'content' => array(),
            'navbar' => 'component/navbar/navbar.dore',
            'sidebar' => 'component/sidebar/sidebar.dore',
            'pageName' => 'Master Data',
            'subPageName' => 'Lapangan',
            'sidebarConf' => config_sidebar('comp', 'admin', 1, array('sub' => 0, 'menu' => 2)),
            'navbarConf' => array(
                'adaUserMenu' => true,
                'adaNotif' => true,
                'pencarian' => false,
                'adaSidebar' => true,
                'homePath' => base_url()
            ),
            'bodyClass' => 'menu-hidden sub-hidden'
        ];
        $this->addViews('template/dore', $data);
        $this->render();
    }

    function booking(){
        $tabelBooking = $this->getContentView('component/datatables/datatables.responsive', array(
            'dtTitle' => 'Data bookingan',
            'dtid' => 'dt-booking',
            'head' => array(
               '', 'Lapangan', 'Jadwal', 'Nama Tim','Perwakilan', 'Tanggal Booking', 'Member', 'Tarif', 'Diskon', 'Tagihan', 'Status', 'Bukti Bayar'
            ),
            'skrip' => 'dtconfig/dt_booking', //wajib
            'skrip_data' => array('id' => 'dt-booking'),
            'options' => array(
                'source' => 'ws/get_booking',
                'search' => 'false',
                'select' => 'multi', //false, true, multi
                'checkbox' => 'true',
                'change' => 'false',
                'dom' => 'rtip',
                'responsive' => 'false',
                'auto-refresh' => '10000',
                'deselect-on-refresh' => 'false',
            ),
            'form' => array(
                'id' => 'form-booking',
                'path' => '',
                'nama' => 'Form Booking',
                'skrip' => 'forms/form-booking-admin',
                'formGenerate' => array(
                    [
                        'type' => 'hidden', 'name' => '_http_method', 'id' => 'method'
                    ],
                    [
                        'type' => 'hidden', 'name' => 'id', 'id' => 'id'
                    ],
                    [
                        'type' => 'hidden', 'name' => 'registrar', 'id' => 'registrar', 'value' => sessiondata('login', 'id')
                    ],
                    [
                        "label" => 'ID Member', "placeholder" => '',
                        "type" => 'text', "name" => 'member', "id" => 'member',
                    ],
                    [
                        "label" => 'Nama Tim', "placeholder" => '',
                        "type" => 'text', "name" => 'tim', "id" => 'tim',
                    ],
                    [
                        "label" => 'Nama Penanggung Jawab', "placeholder" => '', 'attr' => 'data-rule-required=true',
                        "type" => 'text', "name" => 'penanggung_jawab', "id" => 'wakil',
                    ],
                    [
                        "label" => 'Tanggal', "placeholder" => '', 'attr' => 'data-rule-required=true',
                        "type" => 'date', "name" => 'tanggal', "id" => 'tanggal',
                    ],
                    [
                        "label" => 'Lapangan', "placeholder" => '', 'attr' => 'data-rule-required=true',
                        "type" => 'select', "name" => 'lapangan', "id" => 'lapangan', 'option' => array()
                    ],
                    [
                        "label" => 'Jadwal', "placeholder" => '', 'attr' => 'data-rule-required=true',
                        "type" => 'select', "name" => 'jadwal', "id" => 'jadwal', 'option' => array()
                    ],
                    
                ),
                    'posturl' => 'ws/booking',
                    'updateurl' => '',
                    'buttons' => array(
                        [ "type" => 'reset', "data" => 'data-dismiss="modal"', "text" => 'Batal', "id" => "batal", "class" => "btn btn btn-warning" ],
                        [ "type" => 'submit', "text" => 'Simpan', "id" => "simpan", "class" => "btn btn btn-primary" ]
                )
            ),
            'data_panel' => array(
                'nama' => 'dt-booking',
                'perpage' => 10,
                'pages' => array(1, 2, 10),
                'hilangkan_display_length' => true,
                'toolbar' => array(
                    array(
                        'tipe' => 'buttonset',
                        'tombol' => array(
                            array('tipe' => 'link', 'href' => '#', 'title' => 'Booking', 'icon' => 'icon-plus simple-icon-paper-plane', 'class' => 'btn-outline-primary tool-add tetap'),
                            array('tipe' => 'link', 'href' => '#', 'title' => 'Edit Data', 'icon' => 'icon-edit simple-icon-note', 'class' => 'tool-edit'),
                            array('tipe' => 'link', 'href' => '#', 'title' => 'Batalkan', 'icon' => 'icon-edit simple-icon-note', 'class' => 'tool-batalkan'),
                            array('tipe' => 'link', 'href' => '#', 'title' => 'Verifikasi', 'icon' => 'icon-edit simple-icon-note', 'class' => 'tool-verify'),
                            array('tipe' => 'link', 'href' => '#', 'title' => 'Check in', 'icon' => 'icon-edit simple-icon-note', 'class' => 'tool-aktif'),
                            array('tipe' => 'link', 'href' => '#', 'title' => 'Check out', 'icon' => 'icon-edit simple-icon-note', 'class' => 'tool-selesai'),
                        )
                    ),
                ),
                'toolbarSkrip' => 'pages/bookinglist',
            )
        ), true);
        $data = [
            'resource' => array('main', 'dore','datatables', 'form'),
            'contentHtml' => array('<h5> Keterangan: </h5> <ul style="list-style:none"><li class="row-batalkan"> Strip merah disamping masing masing data menandakan untuk segera merubah status data tersebut menjadi batal</li><li class="row-selesai mt-2"> Strip hijau disamping masing masing data menandakan untuk segera merubah status data tersebut menjadi selesai</li><li class="row-editable mt-2"> Strip kuning disamping masing masing data menandakan data bisa di edit</li></ul>', $tabelBooking),
            'content' => array(),
            'navbar' => 'component/navbar/navbar.dore',
            'sidebar' => 'component/sidebar/sidebar.dore',
            'pageName' => 'Booking List',
            'sidebarConf' => config_sidebar('comp', 'admin', 2),
            'navbarConf' => array(
                'adaUserMenu' => true,
                'adaNotif' => true,
                'pencarian' => false,
                'adaSidebar' => true,
                'homePath' => base_url()
            ),
            'bodyClass' => 'menu-hidden sub-hidden'
        ];
        $this->add_cachedStylesheet("
        .row-editable{
            border-left: 5px solid #ffb300 !important
        }
        .row-batalkan{
            border-left: 5px solid #b61827 !important
        } 
        .row-selesai{
            border-left: 5px solid #338a3e !important
        }", 'inline', 'head');
        $this->addViews('template/dore', $data);
        $this->render();
    }
}
