<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once 'vendor/autoload.php';

use \Firebase\JWT\JWT;


if (!method_exists($this, 'response')) {
    function response($message = '', $code = 200, $type = 'success', $format = 'json')
    {
        http_response_code($code);
        $responsse = array();
        if ($code != 200)
            $type = 'Error';

        if(is_object($message))
            $message = (array) $message;
        if (is_string($message) || is_int($message) || is_bool($message))
            $responsse['message'] = $message;
        else
            $responsse = $message;

        if (!isset($message['type']))
            $responsse['type'] = $type;
        else
            $responsse['type'] = $message['type'];

        if($code != 200 && $format == 'json'){
            header("message: " . json_encode($responsse));
            exit();
        }
        
        if ($format == 'json')
            echo json_encode($responsse);
        elseif ($format == 'html') {
            echo '<script> var path = "' . base_url() . '"</script>';
            echo $responsse['message'];
        }
        exit();
    }
}

if (!method_exists($this, 'httpmethod')) {
    function httpmethod($method = 'POST')
    {
        return $_SERVER['REQUEST_METHOD'] == $method;
    }
}

if (!method_exists($this, 'sessiondata')) {
    function sessiondata($index = 'login', $kolom = null, $default = null)
    {
        // if (!is_login())
        //     return;
        /** @var CI_Controller $CI */
        $CI =& get_instance();

        $data = $CI->session->userdata($index);

        return( empty($kolom) ? $data : (empty($data[$kolom]) ? $default : $data[$kolom]));
    }
}

if (!method_exists($this, 'waktu')) {
    function waktu($waktu = null, $format = MYSQL_TIMESTAMP_FORMAT)
    {
        $waktu = empty($waktu) ? time() : $waktu;
        return date($format, $waktu);
    }
}

if (!method_exists($this, 'myOS')) {
    function myOS()
    {
        $user_agent     =   $_SERVER['HTTP_USER_AGENT'];
        $os_platform    =   "Unknown OS Platform";
        $os_array       =   array(
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        );

        foreach ($os_array as $regex => $value) {

            if (preg_match($regex, $user_agent)) {
                $os_platform    =   $value;
            }
        }

        return $os_platform;
    }
}
if (!method_exists($this, 'config_sidebar')) {
    function config_sidebar($configName = 'comp', $sidebar, int $activeMenu = 0, $subMenuConf = null)
    {
        /** @var CI_Controller $ci */
        $ci =& get_instance();

        $ci->load->config($configName);
        $compConf = $ci->config->item('comp');
        $sidebarConf = $compConf['dore']['sidebar'][$sidebar];
        $sidebarConf['menus'][$activeMenu]['active'] = true;

        if (!empty($subMenuConf)) {
            $sidebarConf['subMenus'][$subMenuConf['sub']]['menus'][$subMenuConf['menu']]['active'] = true;
        }
        
        // Tandai sebagai menu sidebar
        foreach($sidebarConf['menus']  as $k => $m){
            $sidebarConf['menus'][$k]['parrent_element'] = 'sidebar';
            $sidebarConf['menus'][$k]['id'] = '-';

        }

        foreach($sidebarConf['subMenus'] as $k => $sb){
            foreach($sb['menus'] as $k1 => $m){
                $sidebarConf['subMenus'][$k]['menus'][$k1]['parrent_element'] = 'sidebar';
            }
        }
        return $sidebarConf;
    }
}

if (!method_exists($this, 'random')) {
    function random($length = 5, $type = 'string')
    {
        $characters = $type == 'string' ? '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ' : '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $type == 'string' ? $randomString : boolval($randomString);
    }
}
if (!method_exists($this, 'is_login')) {
    function is_login($role = null, $user = null, $callback = null)
    {
        /** @var CI_Controller $ci */
        $ci =& get_instance();

        if (!JWT_AUTH)
            $userdata = $ci->session->userdata('login'); //sessiondata('login')
        else {
            $token = isset($_POST['_token']) ? $_POST['_token'] : null;
            list($isLogin, $data) = verfify_token($token);
        }
        if (!empty($userdata) && SYNC_DATAUSER) {
            $u  = $ci->db->select('users.username, users.role, users.photo,profile.*')
                ->where('username', $userdata['username'])
                ->where('email', $userdata['email'])
                ->from('users')->join('profile', 'users.id = profile.uid')
                ->get()->result_array();
            $ci->db->reset_query();
            if (count($u) > 1 || empty($u))
                return false;
            else
                $ci->session->set_userdata(['login' => $u[0]]);

            $userdata = $ci->session->userdata('login');
        }
        if(!empty($callback) && is_callable($callback))
           return $callback($role, $user, $userdata);

        if (empty($role) && empty($user)) {
            if (JWT_AUTH)
                return $isLogin;
            else
                return !empty($userdata);
        } elseif (!empty($userdata) && !empty($role) && empty($user)) {
            if (JWT_AUTH)
                return $data['role'] == $role;
            elseif (!JWT_AUTH && $role == 'bendahara')
                return $userdata['role'] == 'bendahara 1' || $userdata['role'] == 'bendahara 2';
            elseif (!JWT_AUTH && $role == 'admin')
                return $userdata['role'] == 'admin';
            elseif (!JWT_AUTH && $role != 'bendahara')
                return $userdata['role'] == $role;
        } elseif (!empty($userdata) && empty($role) && !empty($user)) {
            if (JWT_AUTH)
                $data['username'] == $user;
            else
                return $userdata['username'] == $user;
        } elseif (!empty($userdata) && !empty($role) && !empty($user)) {
            if (JWT_AUTH)
                return $data['username'] == $user && $data['role'] == $role;
            else
                return $userdata['username'] == $user && $userdata['role'] == $role;
        }
    }
}

if (!method_exists($this, 'verify_token')) {

    function verfify_token($token)
    {
        if (empty($token)) {
            response(['messaage' => 'Token kosong!', 'type' => 'error'], 500);
        }

        try {
            $data = JWT::decode($token, 'BQNIT', array('HS256'));
            return [true, $data];
        } catch (\Throwable $err) {
            response(['messaage' => 'Token Invalid!', 'type' => 'error', 'error' => $err], 500);
        }
    }
}

if (!method_exists($this, 'addResourceGroup')) {
    function addResourceGroup($name, $type = null, $pos = null, $return = true)
    {
        $type = empty($type) ? 'semua' : $type;
        $pos = empty($pos) ? 'head' : $pos;

        /** @var CI_Controller $ci */
        $ci =& get_instance();
        $isLoaded = $ci->load->config('themes');
        $resourceText = '';
        $configitem = $ci->config->item('themes');
        if ($type == 'semua') {
            if (!$isLoaded || empty($configitem[$name]))
                return null;

            foreach ($configitem[$name] as $k => $v) {
                foreach ($v as $resource) {
                    if (isset($resource['type']) && $resource['type'] == 'cdn')
                        $resource['src'] = $resource['src'];
                    else
                        $resource['src'] = base_url('public/assets/' . $resource['src']);
                    if ($k == 'js')
                        $resourceText .= $resource['pos'] == $pos ? "<script src='{$resource['src']}'></script>" : null;
                    elseif ($k == 'css')
                        $resourceText .= $resource['pos'] == $pos ? "<link rel='stylesheet' href='{$resource['src']}'></link>" : null;
                }
            }
        } else {
            if (!$isLoaded || empty($configitem[$name][$type]))
                return null;
            foreach ($configitem[$name][$type] as $k => $v) {
                if (isset($v['type']) && $v['type'] == 'cdn')
                    $v['src'] = $v['src'];
                else
                    $v['src'] = base_url('public/assets/' . $v['src']);

                if ($type == 'js') {
                    if ($v['pos'] == $pos)
                        $resourceText .= "<script src='{$v['src']}'></script>";
                }
                if ($type == 'css') {
                    if ($v['pos'] == $pos)
                        $resourceText .= "<link rel='stylesheet' href='{$v['src']}'></link>";
                }
            }
        }
        if($return)
            return $resourceText;
        else
            echo $resourceText;
    }
}

if (!method_exists($this, 'include_view')) {
    function include_view($path, $data = null)
    {
        // if (is_array($data))
        //     extract($data);
        // include get_path(APPPATH . 'views/' . $path . '.php');
        $ci =& get_instance();
        echo $ci->load->view(get_path($path) .".php", $data, true);
    }
}

if (!method_exists($this, 'rupiah_format')) {
    function rupiah_format($angka)
    {
        $hasil_rupiah = "Rp. " . number_format($angka, 2, ',', '.');
        return $hasil_rupiah;
    }
}

// Get CSRF Token like Laravel
if(!method_exists($this, 'csrf_token')){
    function csrf_token($jsonEncode = true){
        /** @var CI_Controller $ci  */
        $ci =& get_instance();

        $ci->load->config('config');
        $isCSRFAktif = $ci->config->item('csrf_protection');
        if(!$isCSRFAktif) return null;
        $csrf = array(
            'name' => $ci->security->get_csrf_token_name(),
            'hash' => $ci->security->get_csrf_hash()
        );
        return $jsonEncode ? json_encode($csrf) : $csrf;
    }
}

// CONVERT PATH
if(!method_exists($this, 'get_path')){
    function get_path($path){
        return DIRECTORY_SEPARATOR == '/' ? str_replace('\\', '/', $path) : str_replace('/', '\\', $path);

    }
}

if ( ! function_exists('attribut_ke_str'))
{
	function attribut_ke_str($attribute, $delimiter = ' ', $dg_quote = true)
	{
		$str = '';
		if (is_array($attribute)) {
			foreach ($attribute as $key => $value) {
				if ($value !== '0' && empty($value))
					$str .= $key;
				else {
					$str .= $key . '=';
					if (is_array($value))
						$value = implode(' ', $value);
					$str .= $dg_quote ? '"' . $value . '"' : $value;
				}
				$str .= $delimiter;
			}
			
			$str = substr($str, 0, strlen($str) - strlen($delimiter));
		}
		return $str;
	}
}

if ( ! function_exists('str_ke_attribut'))
{
	function str_ke_attribut($str, $delimiter = '/[=\n]/')
	{
		$attribute = array();
		
		$a = preg_split($delimiter, $str, -1, PREG_SPLIT_NO_EMPTY);
		for ($i = 0; $i < count($a); $i+=2) {
			$attribute[$a[$i]] = $a[$i+1];
		}
		return $attribute;
	}
}

if (!function_exists('toolbar_items')) {
    function toolbar_items($toolbar, &$items = array()) {
        if ((isset($toolbar['tipe']) && ($toolbar['tipe'] == 'link' || $toolbar['tipe'] == 'dropdown')) || isset($toolbar['href'])) {
            $items[] = $toolbar;
            return;
        }
        if(!is_array($toolbar))
            return;
        
        foreach ($toolbar as $t) {
            if (!is_array($t))
                continue;
            
            foreach ($t as $n) {
                toolbar_items($n, $items);
            }
        }
    }
}

if(!function_exists('load_script')){
    function load_script($script, $data = array(), $return = false){
        $ci =& get_instance();
        $_script = $ci->load->js($script, $data, true);
        if($return)
            return $_script;
        else 
            echo $_script;
    }
}

if(!function_exists('starWith')){
    function startWith( $haystack, $needle ) {
        $length = strlen( $needle );
        return substr( $haystack, 0, $length ) === $needle;
   }
}

if(!function_exists('endWith')){
    function endWith( $haystack, $needle ) {
        $length = strlen( $needle );
        if( !$length ) {
            return true;
        }
        return substr( $haystack, -$length ) === $needle;
    }
}

if(!function_exists('sandi')){
    /**
   * @param String $text
   * @param String $type ['AN', 'AZ'] - [default: 'AN']
   * @return String
   */
    function sandi($text, $type = "AN"){
        $result = null;
        $an = [
            'a' => 'n',
            'b' => 'o',
            'c' => 'p',
            'd' => 'q',
            'e' => 'r',
            'f' => 's',
            'g' => 't',
            'h' => 'u',
            'i' => 'v',
            'j' => 'w',
            'k' => 'x',
            'l' => 'y',
            'm' => 'z',
            'A' => 'N',
            'B' => 'O',
            'C' => 'P',
            'D' => 'Q',
            'E' => 'R',
            'F' => 'S',
            'G' => 'T',
            'H' => 'U',
            'I' => 'V',
            'J' => 'W',
            'K' => 'X',
            'L' => 'Y',
            'M' => 'Z',
            '-' => '+',
            '_' => '=',
            '@' => '#',
            '&' => '!',
            ' ' => '*',
        ];
        $az = [
            'a' => 'z',
            'b' => 'y',
            'c' => 'x',
            'd' => 'w',
            'e' => 'v',
            'f' => 'u',
            'g' => 't',
            'h' => 's',
            'i' => 'r',
            'j' => 'q',
            'k' => 'p',
            'l' => 'o',
            'm' => 'n',
            'n' => 'm',
            'o' => 'l',
            'p' => 'k',
            'q' => 'j',
            'r' => 'i',
            's' => 'h',
            't' => 'g',
            'u' => 'f',
            'v' => 'e',
            'w' => 'd',
            'x' => 'c',
            'y' => 'b',
            'z' => 'a',

            'A' => 'N',
            'B' => 'O',
            'C' => 'P',
            'D' => 'Q',
            'E' => 'R',
            'F' => 'S',
            'G' => 'T',
            'H' => 'U',
            'I' => 'V',
            'J' => 'W',
            'K' => 'X',
            'L' => 'Y',
            'M' => 'Z',

            '-' => '+',
            '_' => '=',
            '@' => '#',
            '&' => '!',
            ' ' => '*',
        ];
        $an_flip = array_flip($an);
        $az_flip = array_flip($az);
        if($type == "AN"){
            foreach(str_split($text) as $char){
                if(isset($an[$char]))
                    $result .= $an[$char];
                elseif(isset($an_flip[$char]))
                    $result .= $an_flip[$char];
            }
        }else if($type == "AZ"){
            foreach(str_split($text) as $char){
                if(isset($az[$char]))
                    $result .= $az[$char];
                elseif(isset($az_flip[$char]))
                    $result .= $az_flip[$char];
            }
        }
        return $result;
    }
}

if(!function_exists('assets_url')){
    function assets_url($path = null){
        return base_url('public/assets/' . $path);
    }
}