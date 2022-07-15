<?php defined('BASEPATH') or exit('No direct script access allowed');
class Ws extends CI_Controller{
    function login(){
        $this->load->library('Authentication');

        if(!httpmethod())
            response("Metode akses ilegal");

        list($input) = $this->authentication->persiapan($_POST);
        $this->authentication->login($input);
    }
    function logout(){
        if (!is_login())
            response(['message' => 'Anda belum login', 'type' => 'error'], 401);

        try {
            $this->session->unset_userdata('login');
            response(['message' => 'Anda berhasil logout', 'type' => 'success'], 200);
        } catch (\Throwable $th) {
            response(['message' => 'Gagal, Terjadi kesalahan', 'type' => 'error', 'err' => $th], 500);
        }
    }
    function get_lapangan(){
        $this->load->model('Lapangan');
        if(isset($_GET['rid']) && $_GET['rid'] == 1){
            if(isset($_GET['l']) && $_GET['l'] == 1){
                response($this->Lapangan->get_lastid());
            }else{
                $lapangan = $this->Lapangan->get_last();
                response($lapangan);
            }
        }
        $data = $this->Lapangan->get_all();
        response($data);
    }

    function add_lapangan(){
        $post = $_POST;
        $this->load->model('Lapangan');
        if($_SERVER['REQUEST_METHOD'] != 'UPDATE'){
            list($_,$res) = $this->Lapangan->create($post);
            response($res, $_ ? 200 : 500);
        }else{
            list($_,$res) = $this->Lapangan->update($post);
            response($res, $_ ? 200 : 500);
        }
            
    }

    function delete_lapangan(){
        $post = $_POST;
        $this->load->model('Lapangan');
        if(isset($post['ids']) && !empty($post['ids'])){
            list($_, $res) = $this->Lapangan->delete($post['ids']);
            response($res, $_ ? 200 : 500);
        }
    }

    function get_jadwal(){
        $this->load->library('Datatables');
        $q = $this->db->from('jadwal')->join('lapangan', 'lapangan.id = jadwal.lapangan');

        $this->datatables->setHeader(array(
            'id' => array('searchable' => false),
            'mulai' => array('searchable' => true),
            'selesai' => array('searchable' => true),
            'lapangan' => array('searchable' => true, 'field' => 'jadwal.lapangan'),
            'tarif' => array('searhcable' => true),
            'jenis' => array('searchable' => true, 'field' => 'jadwal.jenis'),
            'tempat' => array('searchable' => true, 'field' => 'tempat')
        ));
        $this->datatables->addSelect('jadwal.*, lapangan.jenis, lapangan.tempat');
        $this->datatables->setQuery($q);
        $data = $this->datatables->getData();
        response($data);
    }

    function add_jadwal(){
        $post = $_POST;
        $post = $_POST;
        $this->load->model('Jadwal');
        if($_SERVER['REQUEST_METHOD'] != 'UPDATE'){
            list($_,$res) = $this->Jadwal->create($post);
            response($res, $_ ? 200 : 500);
        }else{
            list($_,$res) = $this->Jadwal->update($post);
            response($res, $_ ? 200 : 500);
        }
    }
    function delete_jadwal(){
        $post = $_POST;
        $this->load->model('Lapangan');
        if(isset($post['ids']) && !empty($post['ids'])){
            list($_, $res) = $this->Lapangan->delete($post['ids']);
            response($res, $_ ? 200 : 500);
        }
    }

    function get_member(){
        $this->load->model('Member');
        if(isset($_GET['rid']) && $_GET['rid'] == 1){
           response($this->Member->get_lastid());
        }
        $data = $this->Member->get_all();
        response($data);
    }
    function add_member(){
        $this->load->model('Member');
        $post = $_POST;
        if($_SERVER['REQUEST_METHOD'] != 'UPDATE'){
           list($_, $res) = $this->Member->create($post);
           response($res, $_ ? 200 : 500);
        }else{
           list($_, $res) = $this->Member->update($post);
           response($res, $_ ? 200 : 500);
        }
    }
    function delete_member(){
        $this->load->model('Member');
        $post = $_POST;
        if(isset($post['ids']) && !empty($post['ids'])){
           list($_, $res) = $this->Member->delete($post['ids']);
           response($res, $_ ? 200 : 500);
        }
    }

    function booking(){
        $this->load->model('Booking');
        $post = $_POST;
        list($_, $res, $data) = $this->Booking->create($post);
        response(['message' => $res, 'id' => isset($data['id']) ? $data['id'] : null], $_ ? 200 : 500);
    }

    function upload(){
        $this->load->helper('file_upload_helper');
        $fname = uploadImage($_FILES['file'], 'file', 'booking');
        $newId = random(15);
        $this->db->insert('file_upload', array(
            'id' => $newId,
            'nama' => $fname,
            'uuid' => $_POST['uuid']
        ));
        $this->db->where('id', $_POST['id'])->update('booking', array('bukti_bayar' => $newId));
    }
    function cancel_upload(){
    }

    function cekjadwal(){
        if(!isset($_GET['j']) || !isset($_GET['t']))
            response("Parameter yang dibutuhkan tidak tersedia", 500);

        $tanggal = $_GET['t'];
        $jadwal = $_GET['j'];
        $boleh = true;
        $data = $this->db->select('*')
            ->where('tanggal', $tanggal)
            ->where('jadwal', $jadwal)
            ->get('booking')->result();
        
        if(!empty($data)){
            foreach($data as $v){
                if($v->status != 'selesai' && $v->status != 'batal'){
                    $boleh =  false;
                    continue;
                }
            }
        }

        response(['kosong' => $boleh]);
    }
}