<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller{
    function index(){
        $data = array(
            'resource' => array('funden'),
            'data_content' => array(
               
            ),
            'loading_animation' => false,
            'foot' => 'footer/funden',
            'adaThemeSelector' => false,
            'pageName' => 'Navigasi',
        );

        $this->addViews('template/funden', $data);
        $this->render();
    }
}