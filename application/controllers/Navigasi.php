<?php defined('BASEPATH') or exit('No direct script access allowed');

class Navigasi extends CI_Controller
{
    public function __construct() {
        parent::__construct();
    }
    function index()
    {
        $tabel = $this->getContentView('component/datatables/datatables.responsive', array(
            'dtTitle' => 'Daftar Navigasi yang Tersedia',
            'dtid' => 'dt-navigasi',
            'head' => array(
               'Nama', 'URL', 'level', 'Jenis', 'Aktif', 'Hak Akses'
            ),
            'skrip' => 'dtconfig/dt_navigasi',
            'skrip_data' => array('id' => 'dt-navigasi'),
            'options' => array(
                'source' => 'ws/uihelper/navigasi',
                'search' => 'false',
                'select' => 'multi',
                'checkbox' => 'true',
                'change' => 'false',
                'dom' => 'rtip',
                'responsive' => 'true'
            ),
            'form' => array(
                'id' => 'form-navigasi',
                'path' => 'forms/form-barang',
                'skrip' => 'pages/auth',
                'formGenerate' => '',
                'posturl' => 'ws/uihelper/navigasi',
                'buttons' => array()
            ),
            'data_panel' => array(
                'nama' => 'dt-navigasi',
                'perpage' => 10,
                'pages' => array(1, 2, 10),
                'hilangkan_display_length' => true,
                'toolbar' => array(
                    array(
                        'tipe' => 'buttonset',
                        'tombol' => array(
                            array('tipe' => 'link', 'href' => '#', 'title' => 'Tambah', 'icon' => 'icon-plus simple-icon-paper-plane', 'class' => 'btn-outline-primary tool-add tetap'),
                            array('tipe' => 'link', 'href' => '#', 'title' => 'Edit', 'icon' => 'icon-edit simple-icon-note', 'class' => 'tool-edit satu'),
                            array('tipe' => 'link', 'href' => '#', 'title' => 'Hapus', 'icon' => 'icon-remove simple-icon-trash', 'class' => 'tool-delete'),
                        )
                    ),
                ),
                'toolbarSkrip' => '',
            )
        ), true);
        $data = array(
            'resource' => array('main', 'dore', 'icon', 'datatables', 'form'),
            'contentHtml' => array($tabel),
            'data_content' => array(
               
            ),
            'adaThemeSelector' => true,
            'navbar' => 'component/navbar/navbar.dore',
            'sidebar' => 'component/sidebar/sidebar.dore',
            'sembunyikanSidebar' => true,
            'pageName' => 'Navigasi',
            'navbarConf' => array(
                'adaSidebar' => true,
                'adaUserMenu' => true,
                'adaNotif' => false,
                'pencarian' => false,
                'homePath' => base_url('admin/dashboard')
            ),
            'sidebarConf' => $this->session_info
        );
        $this->addViews('template/dore',$data);
        $this->render();
    }
}