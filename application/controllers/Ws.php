<?php defined('BASEPATH') or exit('No direct script access allowed');
class WS extends CI_Controller{
    function login(){
        $this->load->library('Authentication');

        if(!httpmethod())
            response("Metode akses ilegal");

        list($input) = $this->authentication->persiapan($_POST);
        $this->authentication->login($input);
    }
}