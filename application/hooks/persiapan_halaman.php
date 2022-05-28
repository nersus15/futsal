<?php defined('BASEPATH') OR exit('No direct script access allowed');
$currentUrl;
class PersiapanHalaman {
    public function __construct() {
        $this->currentUrl = str_replace(base_url('index.php/'), '', current_url());
    }
    function handleMenu(){
        /** @var CI_Controller $ci */
        $ci =& get_instance();
        if(!$this->isWebService()){
            $allMenu = $ci->db->select('menu.*, menu_permission.permission')
                ->join('menu_permission',  'menu_permission.menu= menu.id')
                ->where('aktif', 1)
                ->get('menu')
                ->result();

            $menuWithCurrentUrl = array_filter($allMenu, function($menu){
                return $this->currentUrl == $menu->url;
            });
            list($harusLogin, $perm)= $this->mustLogin($menuWithCurrentUrl);
            if(is_null($perm)){
                $ci->load->view('errors/html/error_404', ['heading' => '404 Page Not Found', 'message' => 'The page you requested was not found.']);
            }

            $ci->session_info = array(
                'permission' => $perm,
                'harusLogin' => $harusLogin,
                'menus' => []
            );

            if($harusLogin){
                // Cek apakah user sudah login dan sesuai hak akses
                $userdata = $ci->session->userdata('login');
                if(is_null($userdata))
                    $ci->load->view('errors/html/error_404', ['heading' => 'ACCESS DENIED', 'message' => 'You dont have permission to access this page']);

                // Sync user permission from database to app
                $userPerm = $ci->db->select('permission_id')->where('username', $userdata['username'])->get('user_permission')->result();
                $userdata['permission'] = [];

                foreach($userPerm as $v)
                    $userdata['permission'][] = $v->permission_id;

                $ci->session->set_userdata('login', $userdata);
                $tidakAdaSama = true;
                foreach($perm as $p){
                    if(in_array($p, $userdata['permission'])){
                        $tidakAdaSama = false;
                        break;
                    }
                }
                if($tidakAdaSama)
                    $ci->load->view('errors/html/error_404', ['heading' => 'ACCESS DENIED', 'message' => 'You dont have permission to access this page']);
                    
            }

            $m = array();
            foreach($allMenu as $menu){
                if($menu->aktif == 1 && !isset($m[$menu->id])){
                    $ci->session_info['menus'][$menu->id] = array(
                        'induk' => $menu->parent,
                        'lvl' => $menu->lvl,
                        'text' => $menu->nama,
                        'icon' => $menu->icon,
                        'link' => $menu->url,
                        'parrent_element' => $menu->parrent_element,
                        'active' => $this->currentUrl == $menu->url
                    );
                }

            }
        }

    }

    private function isWebService(){
        $ci = &get_instance();
        $ci->load->config('config');
        $url = $this->currentUrl;
        $web_servcices = $ci->config->item('web_services');

        if(!empty($web_servcices)) return in_array($url, $web_servcices);
        else return false;
    }
    private function mustLogin($array){
        $harusLogin = true;
        if(!empty($array)){
            $p = [];
            foreach($array as $v){
                $p[] = $v->permission;
                if(in_array($v->permission, [0, 3])) $harusLogin = false;
            }
            return [$harusLogin, $p];
        }else{
            return [false, null];
        }

    }
}