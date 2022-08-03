<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Member extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        if(!is_login())
            redirect(base_url('auth/login'));
        elseif(sessiondata('login', 'role') != 'member') 
            redirect(base_url('dashboard'));
    }
    function index()
    {
        $dataBooking = $this->db->select('booking.*')->where('member', sessiondata('login', 'memberid'))->get('booking')->result();
        $data = [
            'resource' => array('main', 'dore'),
            'content' => array('pages/dashboard/member'),
            'data_content' => array(
                'booking' => $dataBooking
            ),
            'navbar' => 'component/navbar/navbar.dore',
            'adaThemeSelector' => true,
            'sidebar' => 'component/sidebar/sidebar.dore',
            'pageName' => 'Member Area',
            // 'subPageName' => '',
            'sidebarConf' => config_sidebar('comp', 'member', 0),
            'navbarConf' => array(
                'adaUserMenu' => true,
                'adaNotif' => true,
                'pencarian' => false,
                'adaSidebar' => true,
                'homePath' => base_url()
            )
        ];
        $this->addViews('template/dore', $data);
        $this->render();
    }

    function booking(){
        $tabelBooking = $this->getContentView('component/datatables/datatables.responsive', array(
            'dtTitle' => 'Data bookingan',
            'dtid' => 'dt-booking',
            'head' => array(
               '', 'Lapangan', 'Jadwal','Tanggal Booking', 'Tarif', 'Diskon', 'Tagihan', 'Status', 'Bukti Bayar'
            ),
            'skrip' => 'dtconfig/dt_booking_member', //wajib
            'skrip_data' => array('id' => 'dt-booking'),
            'options' => array(
                'source' => 'ws/get_booking/' . sessiondata('login', 'member'),
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
                        "label" => 'ID Member', "placeholder" => '',
                        "type" => 'text', "name" => 'member', "id" => 'member', 'value' => sessiondata('login', 'member'), 'attr' => 'readonly'
                    ],
                    [
                        "label" => 'Nama Tim', "placeholder" => '', 'attr' => 'readonly',
                        "type" => 'text', "name" => 'tim', "id" => 'tim',
                    ],
                    [
                        "label" => 'Nama Penanggung Jawab', "placeholder" => '', 'attr' => 'data-rule-required=true readonly',
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
                            array('tipe' => 'link', 'href' => '#', 'title' => 'Bayar Tagihan', 'icon' => 'icon-edit simple-icon-note', 'class' => 'tool-detail'),
                            array('tipe' => 'link', 'href' => '#', 'title' => 'Edit Data', 'icon' => 'icon-edit simple-icon-note', 'class' => 'tool-edit'),
                            array('tipe' => 'link', 'href' => '#', 'title' => 'Batalkan', 'icon' => 'icon-edit simple-icon-note', 'class' => 'tool-batalkan'),
                        )
                    ),
                ),
                'toolbarSkrip' => 'pages/bookinglist',
            )
        ), true);
        $data = [
            'resource' => array('main', 'dore','datatables', 'form'),
            'contentHtml' => array('<h5> Keterangan: </h5> <ul style="list-style:none"><li class="row-batalkan"> Strip merah disamping masing masing data menandakan bahwa tagihan untuk data tersebut terlalu lama belum dibayar dan tidak bisa dibayar lagi</li><li class="row-selesai mt-2"> Strip merah disamping masing masing data menandakan bahwa data tersebut sudah selesai (belum dirubah admin)</li></ul>', $tabelBooking),
            'content' => array(),
            'navbar' => 'component/navbar/navbar.dore',
            'sidebar' => 'component/sidebar/sidebar.dore',
            'pageName' => 'History Bookingan',
            'sidebarConf' => config_sidebar('comp', 'member', 1),
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
