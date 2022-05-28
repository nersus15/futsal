<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller{
    function __construct()
    {
        parent::__construct();

        $this->load->library('BarangLib');
    }
}
?>