<?php defined('BASEPATH') or exit('No direct script access allowed');

class Navigasi extends CI_Controller
{
    function index()
    {
        $data = array(
            'resource' => array('main', 'dore'),
            'content' => array(),
            'adaThemeSelector' => true,
            'navbar' => 'component/navbar/navbar.dore',
            'sidebar' => 'component/sidebar/sidebar.dore',
            'sembunyikanSidebar' => true,
            'pageName' => 'Dashboard',
            'navbarConf' => array(
                'adaSidebar' => true,
                'adaUserMenu' => true,
                'adaNotif' => false,
                'pencarian' => false,
                'homePath' => base_url('admin/dashboard')
            ),
            'sidebarConf' => $this->session_info
        );
        $this->addViews('template/dore',$data);
        $this->render();
    }
}