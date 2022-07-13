<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Member extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        if(!is_login())
            redirect(base_url('auth/login'));
        elseif(sessiondata('login', 'role') != 'member') 
            redirect(base_url('dashboard'));
    }
    function index()
    {
        $data = [
            'resource' => array('main', 'dore'),
            'content' => array(),
            'navbar' => 'component/navbar/navbar.dore',
            'adaThemeSelector' => true,
            'sidebar' => 'component/sidebar/sidebar.dore',
            'pageName' => 'Member',
            'subPageName' => 'Area',
            'sidebarConf' => config_sidebar('comp', 'member', 0),
            'navbarConf' => array(
                'adaUserMenu' => true,
                'adaNotif' => true,
                'pencarian' => false,
                'adaSidebar' => true,
                'homePath' => base_url()
            )
        ];
        $this->addViews('template/dore', $data);
        $this->render();
    }

    function booking() {

    }
}
