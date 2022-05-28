<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjual extends CI_Controller
{
    function __construct() {
        parent::__construct();

        $this->load->library('PenjualLib');
    }
    function select2()
    {
        $q = $_GET['search'];
        $data = $this->penjuallib->data_penjual('select2', $q);
        response(['data' => $data, 'type' => 'success']);
    }

    function tambah()
    {
        
        $post =& $_POST;
        $input = $this->penjuallib->persiapan($post);
        $this->penjuallib->register($input);
    }

    function lists(){
        $data = $this->penjuallib->data_penjual('dt');
        response(['data' => $data, 'type' => 'success']);
    }
}
