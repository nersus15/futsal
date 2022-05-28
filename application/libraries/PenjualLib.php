<?php

class PenjualLib{
    protected $CI;
    function __construct() {
        $this->CI =& get_instance();
    }
    function data_penjual($jenis = 'select2', $filters = null){
        $data = null;
        switch($jenis){
            case "select2":
                if(!is_array($filters))
                    $q = $filters;
                $data = $this->CI->db->select('users.id, profile.nama_lengkap, profile.alamat')
                    ->like('profile.nama_lengkap', $q, 'both', null)
                    ->or_like('profile.alamat', $q, 'both', null)
                    ->join('profile', 'users.id = profile.uid and users.role != "admin"')
                    ->get('users')
                    ->result();
            break;
            case "dt":
                $data = $this->CI->db->select('users.username, users.photo, profile.*')
                    ->join('profile', 'users.id = profile.uid and users.role != "admin"')
                    ->get('users')
                    ->result();
        }  
        
        return $data;
    }

    function persiapan($post, $jenis = 'register', $xtra = null){
        $newInput = null;

        switch($jenis){
            case "register":
                $input = fieldmapping('penjual', $post);
                $this->CI->load->helper('file_upload');

                if(!empty($input['photo']))
                    $photo = $input['photo'];
                else
                    $photo = 'default.jpg';

                $namaLengkap = explode(' ', $input['nama_lengkap']);
                $inputUser = array(
                    'id' => random(8),
                    'username' => $namaLengkap[0],
                    'password' => password_hash($namaLengkap[0], PASSWORD_DEFAULT),
                    'role' => 'penjual',
                    'photo' => $photo,
                );

                unset($input['photo']);
                $inputProfile = $input;
                $inputProfile['uid'] = $inputUser['id'];
                $inputProfile['id'] = random(8);

                $newInput = array(
                    'user' => $inputUser,
                    'profile' => $inputProfile
                );

            break;
        }

        return $newInput;
    }

    function register($input){
        try {
            $this->CI->db->insert('users', $input['user']);
        } catch (\Throwable $th) {
            response(['message' => 'Terjadi kesalahan', 'err' => print_r($th, true)], 500);
        }

        try {
            $this->CI->db->insert('profile', $input['profile']);
        } catch (\Throwable $th) {
            response(['message' => 'Terjadi kesalahan', 'err' => print_r($th, true)], 500);
        }

        response(['message' => 'Berhasil mendaftarkan penjual']);
    }
}