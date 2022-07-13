<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller{
    function index(){
        $data = array(
            'resource' => array('funden', 'form'),
            'data_content' => array(
               
            ),
            'loading_animation' => false,
            'foot' => 'footer/funden',
            'adaThemeSelector' => false,
            'pageName' => 'Navigasi',
        );
        $this->load->model(['Lapangan', 'Jadwal']);
        $lapangan = $this->Lapangan->get_all();
        $jadwal = $this->Jadwal->get_all();
        $data['lapangan'] = $lapangan->data;
        $data['jadwal'] = $jadwal->data;
        $this->add_javascript('vendor/kamscore/js/Kamscore.js', 'head');
        $this->add_javascript('vendor/kamscore/js/uihelper.js', 'head');

        $this->add_cachedJavascript('forms/form-booking', 'file', 'body:end', array(
            'form_data' => json_encode(array(
                'formid' => 'form-booking',
                'member' => false,
                'mode' => 'baru', 
                'action' => is_login('member') ? base_url('member/add_booking') : base_url('ws/booking')
            )),
            'form_cache' => json_encode(array()),
        ));
        $this->addViews('template/funden', $data);
        $this->render();
    }
}