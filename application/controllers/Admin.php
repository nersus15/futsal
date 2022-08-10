<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        if(!is_login('pimpinan'))
            redirect(base_url('dashboard'));
    }
    function index(){
        $tabelBooking = $this->getContentView('component/datatables/datatables.responsive', array(
            'dtTitle' => 'Data Admin',
            'dtid' => 'dt-admin',
            'head' => array(
               '', 'Username', 'Nama Lengkap','No. Hp', 'Email', 'Photo'
            ),
            'skrip' => 'dtconfig/dt_admin', //wajib
            'skrip_data' => array('id' => 'dt-admin'),
            'options' => array(
                'source' => 'ws/get_admin',
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
                'id' => 'form-admin',
                'path' => '',
                'nama' => 'Form Admin',
                'skrip' => 'forms/form_admin',
                'formGenerate' => array(
                    [
                        'type' => 'hidden', 'name' => '_http_method', 'id' => 'method',
                    ],
                    [
                        'type' => 'hidden', 'name' => 'role', 'id' => 'role', 'value' => 'admin'
                    ],
                    [
                        'type' => 'hidden', 'name' => 'id', 'id' => 'id'
                    ],
                    [
                        "label" => 'Username', "placeholder" => 'Username',
                        "type" => 'text', "name" => 'username', "id" => 'username'
                    ],
                    [
                        "label" => 'Nama', "placeholder" => 'Nama Lengkap',
                        "type" => 'text', "name" => 'nama', "id" => 'nama',
                    ],
                    [
                        "label" => 'No. HP', "placeholder" => 'Nomor HP',
                        "type" => 'text', "name" => 'hp', "id" => 'hp',
                    ],
                    [
                        "label" => 'Email', "placeholder" => 'Email',
                        "type" => 'email', "name" => 'email', "id" => 'email',
                    ],
                    [
                        "label" => 'Password', "placeholder" => 'Password',
                        "type" => 'password', "name" => 'password', "id" => 'password',
                    ],
                    
                    
                ),
                    'posturl' => 'ws/add_admin',
                    'deleteurl' => 'ws/delete_admin',
                    'updateurl' => '',
                    'buttons' => array(
                        [ "type" => 'reset', "data" => 'data-dismiss="modal"', "text" => 'Batal', "id" => "batal", "class" => "btn btn btn-warning" ],
                        [ "type" => 'submit', "text" => 'Simpan', "id" => "simpan", "class" => "btn btn btn-primary" ]
                )
            ),
            'data_panel' => array(
                'nama' => 'dt-admin',
                'perpage' => 10,
                'pages' => array(1, 2, 10),
                'hilangkan_display_length' => true,
                'toolbar' => array(
                    array(
                        'tipe' => 'buttonset',
                        'tombol' => array(
                            array('tipe' => 'link', 'href' => '#', 'title' => 'Tambah', 'icon' => 'icon-plus simple-icon-paper-plane', 'class' => 'btn-outline-primary tool-add tetap'),
                            array('tipe' => 'link', 'href' => '#', 'title' => 'Update', 'icon' => 'icon-plus simple-icon-pencil', 'class' => 'btn-outline-warning tool-edit tetap'),
                            array('tipe' => 'link', 'href' => '#', 'title' => 'Hapus', 'icon' => 'icon-delete simple-icon-trash', 'class' => 'btn-outline-danger tool-delete tetap'),
                        )
                    ),
                ),
            )
        ), true);
        $data = [
            'resource' => array('main', 'dore','datatables', 'form'),
            'contentHtml' => array($tabelBooking),
            'content' => array(),
            'navbar' => 'component/navbar/navbar.dore',
            'sidebar' => 'component/sidebar/sidebar.dore',
            'pageName' => 'Data Admin',
            'sidebarConf' => config_sidebar('comp', 'pimpinan', 2),
            'navbarConf' => array(
                'adaUserMenu' => true,
                'adaNotif' => false,
                'pencarian' => false,
                'adaSidebar' => true,
                'homePath' => base_url()
            ),
            'bodyClass' => 'menu-hidden sub-hidden'
        ];
        $this->addViews('template/dore', $data);
        $this->render();
    }
}
