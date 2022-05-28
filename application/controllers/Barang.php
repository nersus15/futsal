<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller{
    function __construct()
    {
        parent::__construct();

        $this->load->library('BarangLib');
    }
    function lists($limit = null){
        if(httpmethod())
            response(['message' => 'Tidak ada controller barang/lists dengan method [POST]'], 403);

        $filter = array();

        $get =& $_GET;
        if(isset($get['n']))
            $filter['nama'] = $get['n'];
        if(isset($get['h']))
            $filter['harga'] = $get['h'];

        /** @var BarangLib $this->baranglib */
        $this->baranglib->getData('semua', $filter);
    }

    function add(){
        if(!is_login('admin'))
            response(['message' => 'Anda tidak memiliki akses'], 403);

        if(!httpmethod())
            response(['message' => 'Tidak ada controller barang/add dengan method [GET]'], 404);

        $post =& $_POST;
        /** @var BarangLib $this->baranglib */
        $this->baranglib->simpanBarang($post);
    }
}
