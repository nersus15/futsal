<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller{
    function __construct() {
        parent::__construct();
        if(!is_login('admin'))
            response(['message' => 'Anda tidak memiliki akses', 'type' => 'error'], 403);

    }
    function dashboard(){
        $data = array(
            'resource' => array('main', 'dore'),
            'content' => array(),
            'adaThemeSelector' => true,
            'navbar' => 'component/navbar/navbar.dore',
            'sidebar' => 'component/sidebar.dore',
            'sembunyikanSidebar' => true,
            'pageName' => 'Dashboard',
            'navbarConf' => array(
                'adaSidebar' => true,
                'adaUserMenu' => true,
                'adaNotif' => true,
                'pencarian' => true,
                'homePath' => base_url('admin/dashboard')
            ),
            'sidebarConf' => config_sidebar('comp', 'admin')

        );
        $this->renderer->addViews('template/dore',$data);
        $this->render();
    }

    function barang(){
        $data = array(
            'resource' => array('main', 'dore', 'datatables'),
            'content' => array('pages/admin.barang'),
            'adaThemeSelector' => true,
            'navbar' => 'component/navbar/navbar.dore',
            'sidebar' => 'component/sidebar.dore',
            'pageName' => 'Data',
            'sembunyikanSidebar' => true,
            'subPageName' => 'Barang',
            'navbarConf' => array(
                'adaSidebar' => true,
                'adaUserMenu' => true,
                'adaNotif' => true,
                'pencarian' => true,
                'homePath' => base_url('admin/dashboard')
            ),
            'sidebarConf' => config_sidebar('comp', 'admin', 1, array('sub' => 0, 'menu' => 0))
        );

        $this->add_cachedJavascript('js/pages/admin.barang.js');

        $this->add_javascript(array(
            ['src' => 'vendor/select2/dist/js/select2.js', 'type' => 'file', 'pos' => 'head'],
            ['src' => 'vendor/dropzone/js/dropzone.min.js', 'type' => 'file', 'pos' => 'head']
        ));

        $this->add_stylesheet(array(
            ['src' => 'vendor/select2/dist/css/select2.css', 'pos' => 'head', 'type' => 'file'],
            ['src' => 'vendor/dropzone/css/dropzone.min.css', 'pos' => 'head', 'type' => 'file'],
        ));
        $this->addViews('template/dore', $data);
        $this->render();
    }

    function penjual(){
        $data = array(
            'resource' => array('main', 'dore', 'datatables'),
            'content' => array('pages/admin.penjual'),
            'adaThemeSelector' => true,
            'navbar' => 'component/navbar/navbar.dore',
            'sidebar' => 'component/sidebar.dore',
            'pageName' => 'Data',
            'sembunyikanSidebar' => true,
            'subPageName' => 'Barang',
            'navbarConf' => array(
                'adaSidebar' => true,
                'adaUserMenu' => true,
                'adaNotif' => true,
                'pencarian' => true,
                'homePath' => base_url('admin/dashboard')
            ),
            'sidebarConf' => config_sidebar('comp', 'admin', 1, array('sub' => 0, 'menu' => 1))
        );

        $this->add_cachedJavascript('js/pages/admin.penjual.js');

        $this->add_javascript(array(
            ['src' => 'vendor/select2/dist/js/select2.js', 'type' => 'file', 'pos' => 'head'],
            ['src' => 'vendor/dropzone/js/dropzone.min.js', 'type' => 'file', 'pos' => 'head']
        ));

        $this->add_stylesheet(array(
            ['src' => 'vendor/select2/dist/css/select2.css', 'pos' => 'head', 'type' => 'file'],
            ['src' => 'vendor/dropzone/css/dropzone.min.css', 'pos' => 'head', 'type' => 'file'],
        ));
        $this->addViews('template/dore', $data);
        $this->render();
    }

    function settings($type){

        $data = array(
            'resource' => array('main', 'dore'),
            'adaThemeSelector' => true,
            'navbar' => 'component/navbar/navbar.dore',
            'sidebar' => 'component/sidebar.dore',
            'pageName' => 'Settings',
            'sembunyikanSidebar' => true,
            'navbarConf' => array(
                'adaSidebar' => true,
                'adaUserMenu' => true,
                'adaNotif' => true,
                'pencarian' => true,
                'homePath' => base_url('admin/dashboard')
            ),
            'sidebarConf' => config_sidebar('comp', 'admin', 1, array('sub' => 0, 'menu' => 1))
        );
        switch($type){
            case 'carousel':
                
                $data['subPageName'] = 'Carousel';
                $data['content'] = array('pages/admin.settings.carousel');
                $data['data_content'] = array(
                    'type' => 'carousel',
                );
            break;
            
        }
        $this->add_cachedJavascript('js/pages/admin.settings.js');
        $this->add_javascript(
            array(
                array('src' => CDN_PATH . 'owl/js/owl-carousel.js', 'type' => 'cdn', 'pos' => 'head')
            )
        );
        $this->add_stylesheet(
            array(
                ['src' => CDN_PATH . 'owl/css/owl-carousel.min.css', 'type' => 'cdn', 'pos' => 'head']
            )
        );
        $this->addViews('template/dore', $data);
        $this->render();
    }
}