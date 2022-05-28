<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!method_exists($this,'fieldmapping')){
    function fieldmapping($config, $input, $defaultValue = array(), $petaNilai = array()){

        /** @var CI_Controller $ci */
        $ci =& get_instance();
        $isLoaded = $ci->load->config('forms');
        $configitem = $ci->config->item('form');
        $adaDefault = count($defaultValue) > 0;
        $adaPeta = count($petaNilai) > 0;
        $field = array();
        if(!$isLoaded || empty($configitem[$config]))
            response(['message' => 'Config form ' . $config . ' Tidak ditemukan'], 404);
        
        foreach($configitem[$config] as $k => $v){
            if(isset($input[$k]))
                $field[$v] = html_escape($input[$k]);
            elseif(!isset($input[$k]) && $adaDefault && isset($defaultValue[$k]))
                $field[$v] = $defaultValue[$k];
        }

        if($adaPeta){
            foreach($petaNilai as $f){
                foreach($f as $k => $v){
                    if($field[$f] == $k)
                        $field[$f] = $v;
                }
            }
        }
        return $field;
    }
}