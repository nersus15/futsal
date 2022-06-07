<?php defined('BASEPATH') or exit('No direct script access allowed');

class Uihelper extends CI_Controller
{   
    function navigasi_get()
    {
        $this->load->library('Navigasi');
        response($this->navigasi->get_navigasi());
    }
    function navigasi_post(){
        response("Ok");
    }
    function navigasi_delete(){
        response($_POST);
    }
    function form_get()
    {

        if (httpmethod())
            response(['message' => 'Ilegal akses'], 403);

        if (!isset($_GET['f']))
            response(['message' => 'File (form) kosong'], 404);
        $skrip = '';
        if(isset($_GET['s']) && !empty($_GET['s']))
            $skrip = $_GET['s'];
            
        $form = $_GET['f'];
        $data = array(
            'ed' => [],
            'sv' => []
        );
        if(isset($_GET['ed']))
            $data['ed'] = json_decode($_GET['ed']);
        if(isset($_GET['sv']))
            $data['sv'] = json_decode($_GET['sv']);

        if (!file_exists(APPPATH . 'views/' . $form . '.php'))
            response(['message' => 'Form yang ' . $form . ' Tidak ditemukan'], 404);
        else {
            response([
                'html' => $this->load->view($form, $data, true) . "<script>" . load_script($skrip, $data, true) . "</script>"
            ]);
        }
    }
    function skrip_get()
    {
        if (httpmethod())
            response(['message' => 'Ilegal akses'], 403);
            
        $skrip = '';
        if(isset($_GET['s']) && !empty($_GET['s']))
            $skrip = $_GET['s'];
        if(empty($skrip)) response(['skrip' => '']);

        if (!file_exists(APPPATH . 'js/' . $skrip . '.php'))
            response(['message' => 'Form yang ' . $skrip . ' Tidak ditemukan'], 404);
        else {
            $data = array(
                'ed' => [],
                'sv' => []
            );
            if(isset($_GET['ed']))
                $data['ed'] = json_decode($_GET['ed']);
            if(isset($_GET['sv']))
                $data['sv'] = json_decode($_GET['sv']);

            response([
                'skrip' => "<script>" . load_script($skrip, $data, true) . "</script>"
            ]);
        }
    }
}