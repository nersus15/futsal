<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    function login()
    {
        if(is_login())
            redirect(base_url("dashboard"));
        $data = array(
            'resource' => array('main', 'softui', 'form'),
            'content' => array('forms/login'),
            'hideSpinner' => true
        );
        $this->add_cachedJavascript('pages/auth', 'file', 'body:end', array(
            'formid' => '#form-login',
            'submitSukses' => "function(data){
               window.location.href = path + 'dashboard/". sessiondata('login', 'role') ."';
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
