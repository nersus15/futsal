<?php defined('BASEPATH') or exit('No direct script access allowed');

class Uom extends CI_Controller
{
    public function __construct() {
        parent::__construct();
    }
    function index()
    {
        $perm = $this->db->select('id, nama')->get('permission')->result();
        $tabel = $this->getContentView('component/datatables/datatables.responsive', array(
            'dtTitle' => 'Daftar Unit yang Tersedia',
            'dtid' => 'dt-navigasi',
            'head' => array(
               '','Nama', 'Deskripsi'
            ),
            'skrip' => 'dtconfig/dt_permission', //wajib
            'skrip_data' => array('id' => 'dt-navigasi'),
            'options' => array(
                'source' => 'ws/uihelper/uom',
                'search' => 'false',
                'select' => 'multi', //false, true, multi
                'checkbox' => 'true',
                'change' => 'false',
                'dom' => 'rtip',
                'responsive' => 'true',
                'auto-refresh' => '20000',
                'form-posisi'=>'def'
            ),
            'form' => array(
                'id' => 'form-unit',
                'path' => '',
                'nama' => 'Form Permission',
                'skrip' => 'forms/form-uom',
                'formGenerate' => array(
                    [
                        "label" => 'Nama Uom', "placeholder" => 'Masukkan Uom',
                        "type" => 'text', "name" => 'nama', "id" => 'nama', "attr" => 'required'
                    ],
                ),
                'posturl' => 'ws/uihelper/uom',
                'updateurl' => '',
                'deleteurl' => '',
                'buttons' => array(
                    [ "type" => 'reset', "data" => 'data-dismiss="modal"', "text" => 'Batal', "id" => "batal", "class" => "btn btn btn-warning" ],
                    [ "type" => 'submit', "text" => 'Simpan', "id" => "simpan", "class" => "btn btn btn-primary" ]
                )
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
                            array('tipe' => 'link', 'href' => '#', 'title' => 'Edit', 'icon' => 'icon-edit simple-icon-note', 'class' => 'tool-edit'),
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
            'adaThemeSelector' => false,
            'navbar' => 'component/navbar/navbar.dore',
            'sidebar' => 'component/sidebar/sidebar.dore',
            'pageName' => 'Permission',
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