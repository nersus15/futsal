<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class BarangLib {

    function getData($rule = 'semua', $filter, $pagin = null, $id = null){
        
        /** @var CI_Controller $ci */
        $ci =& get_instance();

        $query = $ci->db->select('barang.*, penjual.username upenjual, pencatat.username upencatat')
                ->join('users as penjual', 'penjual.id = barang.penjual and penjual.role = "penjual"', 'inner')
                ->join('users as pencatat', 'pencatat.id = barang.pencatat and pencatat.role = "admin"', 'inner')
                ->from('barang')
                ->order_by('barang.created', 'DESC');

        if(!empty($id))
            $query->where('barang.id', $id);
        
        if(!empty($filter)){
            foreach($filter as $k => $v)
                $query->where($k, $v);
            
        }

        $results = $query->get()->result();
        try {
            response(['data' => $results]);
        } catch (\Throwable $th) {
            response(['message' => 'Terjadi kesalahan', 'err' => print_r($th, true)], 500);
        }
    }

    function perisapan($post, $mode){
        // $newInput = null;

        // switch($mode){
        //     case 'simpan-barang':
        //         $inputBarang = fieldmapping('barang', $post);
        //     break;
        // }
    }

    function simpanBarang($input){
        $inputBarang = fieldmapping('barang', $input);
        /** @var CI_Controller $ci */
        $ci =& get_instance();

        if(!isset($inputBarang['penjual']) || empty($inputBarang['penjual'])){
            $inputPenjual = fieldmapping('penjual', $input);

            $file =& $_FILES;


            // Upload photo profile
            $ci->load->helper('file_upload');

            if(isset($file['pp']))
                $photo = uploadImage($file['pp'], 'pp');
            else
                $photo = 'default.jpg';

            
            $nama = explode(' ', $inputPenjual['nama_lengkap']);
            $inputUser = array(
                'id' => random(8),
                'username' => $nama[0],
                'password' => password_hash($nama[0], PASSWORD_DEFAULT),
                'role' => 'penjual',
                'photo' => $photo
            );

            try {
                $ci->db->insert('users', $inputUser);
            } catch (\Throwable $th) {
                response(['message' => 'Terjadi kesalahan', 'err' => print_r($th, true)], 500);
            }

            $inputPenjual['uid'] = $inputUser['id'];
            $inputPenjual['id'] = random(8);
            try {
                $ci->db->insert('profile', $inputPenjual);
            } catch (\Throwable $th) {
                response(['message' => 'Terjadi kesalahan', 'err' => print_r($th, true)], 500);
            }

            $inputBarang['penjual'] = $inputUser['id'];
            $inputBarang['pencatat'] = sessiondata('login', 'uid');
            $inputBarang['thumb'] = empty($inputBarang['thumb']) ? 'default.jpg' : $inputBarang['thumb'];
            $inputBarang['id'] = random(8);
            $inputBarang['created'] = waktu();
            try {
                $ci->db->insert('barang', $inputBarang);
                response(['message' => 'Berhasil menambah barang']);
            } catch (\Throwable $th) {
                response(['message' => 'Terjadi kesalahan', 'err' => print_r($th, true)], 500);
            }
        }elseif(isset($inputBarang['penjual']) && !empty($inputBarang['penjual'])){
            $inputBarang['pencatat'] = sessiondata('login', 'uid');
            $inputBarang['id'] = random(8);
            try {
                $ci->db->insert('barang', $inputBarang);

                response(['message' => 'Berhasil menambah barang']);
            } catch (\Throwable $th) {
                response(['message' => 'Terjadi kesalahan', 'err' => print_r($th, true)], 500);
            }
        }

    }
}