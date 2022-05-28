<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    function index()
    {
        $data = [
            'resource' => array('main', 'dore'),
            'content' => array('pages/client.index'),
            'navbar' => 'component/navbar/navbar.dore',
            'adaThemeSelector' => true,
            'sidebar' => 'component/sidebar.dore',
            'sidebarConf' => config_sidebar('comp', 'publik', 0),
            'navbarConf' => array(
                'adaUserMenu' => false,
                'adaNotif' => true,
                'pencarian' => true,
                'adaSidebar' => true,
                'homePath' => base_url()
            )
        ];

        $this->add_cachedJavascript('js/pages/client.index.js');
        $this->addViews('template/dore', $data);
        $this->render();
    }
}
