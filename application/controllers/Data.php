<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data extends CI_Controller
{
    function lapangan()
    {
        $data = [
            'resource' => array('main', 'dore'),
            'content' => array(),
            'navbar' => 'component/navbar/navbar.dore',
            'adaThemeSelector' => true,
            'sidebar' => 'component/sidebar/sidebar.dore',
            'pageName' => 'Master Data',
            'subPageName' => 'Lapangan',
            'sidebarConf' => config_sidebar('comp', 'admin', 1, array('sub' => 0, 'menu' => 0)),
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
}
