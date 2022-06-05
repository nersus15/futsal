<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    function index()
    {
        $data = array(
            'resource' => array('main', 'dore')
        );


        $this->renderer->add_cachedJavascript('js/pages/login.js');

        $this->renderer->addViews(array('head/main', 'pages/login', 'foot/main'), $data);
        $this->renderer->render();
    }

    function login()
    {
        $data = array(
            'header' => 'main',
            'footer' => 'main',
            'resource' => array('main', 'softui'),
            'content' => array('pages/softui/login'),
        );
        $this->add_cachedJavascript('pages/auth', 'file', 'body:end', array(
            'formid' => '#form-login',
            'submitSukses' => "function(data){
               
            }"
        ));

        $this->addViews('template/dore', $data);
        $this->render();
    }

    function logout(){
        // if (!httpmethod())
        //     response(["message" => "Error, Tidak ada method logout[GET]", "type" => 'error'], 405);

        if (!is_login())
            response(['message' => 'Anda belum login', 'type' => 'error'], 401);

        try {
            $this->session->unset_userdata('login');
            response(['message' => 'Anda berhasil logout', 'type' => 'success'], 200);
        } catch (\Throwable $th) {
            response(['message' => 'Gagal, Terjadi kesalahan', 'type' => 'error', 'err' => $th], 500);
        }
    }
}
