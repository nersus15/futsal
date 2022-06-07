<?php defined('BASEPATH') or exit('No direct script access allowed');
class User extends CI_Controller{
    function login_post(){
        $this->load->library('Authentication');

        if(!httpmethod())
            response("Metode akses ilegal");

        list($input) = $this->authentication->persiapan($_POST);
        $this->authentication->login($input);
    }
}