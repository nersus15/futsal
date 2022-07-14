<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function uploadImage($file, $iname, $type = 'profile')
{
    /** @var CI_Controller $ci */
    $ci =& get_instance();
    $file = explode('.', $file['name']);
    $file_name = uniqid(8) . '.'.$file[count($file) - 1];
    $isLoaded = $ci->load->config('upload_path');
    $pathConfig = $ci->config->item('image');

    if($isLoaded && isset($pathConfig[$type]))
        $config['upload_path'] = get_path($pathConfig[$type]);
    else
        $config['upload_path'] = ASSETS_PATH;

    $config['allowed_types'] = 'gif|jpg|png|jpeg';
    $config['max_size'] = '';
    $config['file_name'] = $file_name;
    
    
    $ci->load->library('upload', $config);  
    $ci->upload->initialize($config);

    if (!$ci->upload->do_upload($iname)) {
        response(['message' => print_r($ci->upload->display_errors(), true), 'type' => 'error'], 500);
    }

    return $file_name;
}

function delete_img($nama, $type = 'profile'){
    $ci =& get_instance();
    $isLoaded = $ci->load->config('upload_path');
    $pathConfig = $ci->config->item('image');
    if($isLoaded && isset($pathConfig[$type]))
       $upload_path = get_path($pathConfig[$type]);
    else
       $upload_path = ASSETS_PATH;
    unlink($upload_path . $nama);
}
