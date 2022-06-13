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
               '','Nama', 'URL', 'level', 'Jenis', 'Icon', 'Aktif', 'Hak Akses', 'Deskripsi'
            ),
            'skrip' => 'dtconfig/dt_navigasi', //wajib
            'skrip_data' => array('id' => 'dt-navigasi'),
            'options' => array(
                'source' => 'ws/uihelper/navigasi',
                'search' => 'false',
                'select' => 'multi', //false, true, multi
                'checkbox' => 'true',
                'change' => 'false',
                'dom' => 'rtip',
                'responsive' => 'true',
                'auto-refresh' => '30000',
                'deselect-on-refresh' => 'true',
            ),
            'form' => array(
                'id' => 'form-navigasi',
                'path' => '',
                'nama' => 'Form Navigasi',
                'skrip' => 'forms/form-navigasi',
                'formGenerate' => array(
                    [
                        "label" => 'Nama Navigasi', "placeholder" => 'Masukkan nama navigasi',
                        "type" => 'text', "name" => 'nama', "id" => 'nama', "attr" => 'required'
                    ],
                    [
                        "label" => 'Deskripsi Navigasi', "placeholder" => 'Masukkan deskripsi navigasi',
                        "type" => 'textarea', "name" => 'deskripsi', "id" => 'deskripsi'
                    ],
                    [
                        "label" => 'Url', "placeholder" => '',
                        "type" => 'text', "name" => 'url', "id" => 'url', "attr" => 'required'
                    ],
                    [
                        "label" => 'Level', "placeholder" => 'Level',
                        "type" => 'select', "name" => 'level', "id" => 'level', "attr" => 'required', 'options' => array(
                            '1' => array('text' => 1), '2' => array('text' => 2)
                        )
                    ],
                    [
                        "label" => 'Induk', "placeholder" => '',
                        "type" => 'select', "name" => 'induk', "id" => 'induk', "attr" => 'required', 'fgClass'  => 'd-none'
                    ],
                    [
                        "label" => 'Jenis', "placeholder" => 'Jenis Navigasi',
                        "type" => 'select', "name" => 'jenis', "id" => 'jenis', "attr" => 'required', 'options' => array(
                            'sidebar' => array('text' => 'sidebar'), 'navbar' => array('text' => 'navbar'),
                            'url' => array('text' => 'url'),
                            'page' => array('text' => 'Halaman'),
                        )
                        
                    ],
                    [
                        "label" => 'Icon', "placeholder" => 'Icon',
                        "type" => 'text', "name" => 'icon', "id" => 'icon'
                    ],
                    [
                        'type' => 'custom', 'text' => "<div><h5> Hak Akses </h5><div class='row' id='permission-wrapper'></div></div>"
                    ],
                    [
                        'type' => 'custom', 'text' => " <div class='separator mb-2'>Permission Baru</div>
                        <div id='add-permission-wrapper' class='row mb-4'>
                            <div class='col-12'>
                                <div class='form-group'>
                                    <label> Nama Permission yang baru </label>
                                    <input class='form-control' id='perm_name' type='text' name='perm_name'>
                                    <p class='text-danger' id='perm-warning'></p>
                                </div>
                                <div class='form-group'>
                                    <label> Deskripsi Permission yang baru </label>
                                    <input class='form-control' id='perm_desc' type='text' name='desc_perm'>
                                </div>
                            </div>
                            <div class='col-12' style='text-align:center;'>
                                <button type='button' style='background-color: lightgray' class='btn btn-xs' id='add-permission'>Tambah Permission </button>
                            </div>
                        </div>"
                    ],
                ),
                'posturl' => 'ws/uihelper/navigasi',
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
            'resource' => array('main', 'dore','datatables', 'form'),
            'contentHtml' => array($tabel),
            'data_content' => array(
               
            ),
            'adaThemeSelector' => false,
            'navbar' => 'component/navbar/navbar.dore',
            'sidebar' => 'component/sidebar/sidebar.dore',
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