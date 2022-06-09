<?php defined('BASEPATH') or exit('No direct script access allowed');

class Uihelper extends CI_Controller
{   
    function navigasi_get()
    {
        $this->load->library('Navigasi');
        $filter = [];
        if(isset($_GET['j']) && !empty($_GET['j']))
            $filter['jenis'] = $_GET['j'];
        if(isset($_GET['p']) && !empty($_GET['p']))
            $filter['permission'] = $_GET['p'];
        if(isset($_GET['n']) && !empty($_GET['n']))
            $filter['nama'] = $_GET[''];
        if(isset($_GET['dt']))
            $filter['dt'] = $_GET['dt'];
        
        response($this->navigasi->get_navigasi(null, $filter));
    }
    function navigasi_post(){
        $post = $_POST;
        $this->load->library('Navigasi');

        $input = $this->navigasi->persiapanSimpan($post);
        $this->navigasi->simpanNavigasi($input);

    }
    function navigasi_delete(){
        $post = $_POST;
        $ids = $post['ids'];
        if(!isset($post['ids']) || empty($ids))
            response("Gagal, tidak ada id yang dikirim");

        try {
            $this->db->where_in('menu.id', $ids)->delete('menu');
            response("Berhasil Menghapus Menu dengan id " . join(', ', $ids));
        } catch (\Throwable $th) {
            response($th, 500);
        }
    }

    function permission_get(){
        $get = $_GET;
        if(isset($get['dt']) && $get['dt'] == 0){
            $permission = $this->db->select('*')->get('permission')->result();
            response(['data' => $permission]);
        }
        $this->load->library('Datatables');
        $q = $this->db->from('permission');
        $header = array(
            'id' => array('searchable' => false),
            'nama' => array('searchable' => true),
            'desc' => array('searchable' => 'deskripsi', 'field' => 'deskripsi')
        );

        $this->datatables->setHeader($header)
            ->addSelect('permission.*')
            ->setQuery($q);
        $data =  $this->datatables->getData();
        response($data);
    }

    function permission_post(){
        $post = $_POST;
        $isEdit = isset($post['mode']) && $post['mode'] == 'edit';
        $data = array(
            'nama' => $post['nama'],
            'deskripsi' => !empty($post['desc']) ? $post['desc'] : null
        );
        try {
          if(!$isEdit){
                $this->db->insert('permission', $data);
                $new_data = $this->db->order_by('id', 'DESC')->get('permission')->row();
                $new_data->message = "Berhasil menambahkan permission baru";
                response($new_data);
          }else{
                $this->db->where('id', $post['id'])->update('permission', ['nama' => $post['nama'], 'deskripsi' => $post['desc']]);
                response("Berhasil Update Navigasi #" . $post['id'] . " (" . $post['nama'] . ")");
          }

        } catch (\Throwable $th) {
           response("Terjadi kesalahan", 500);
        }
        
    }

    function permission_delete()
    {
        $post = $_POST;
        $ids = $post['ids'];
        if(!isset($post['ids']) || empty($ids))
            response("Gagal, tidak ada id yang dikirim");

        try {
            $this->db->where_in('permission.id', $ids)->delete('permission');
            response("Berhasil Menghapus Permission dengan id " . join(', ', $ids));
        } catch (\Throwable $th) {
            response($th, 500);
        }
    }

    function form_get()
    {

        if (httpmethod())
            response(['message' => 'Ilegal akses'], 403);

        if (!isset($_GET['f']))
            response(['message' => 'File (form) kosong'], 404);
        $skrip = '';
        if(isset($_GET['s']) && !empty($_GET['s']))
            $skrip = $_GET['s'];
            
        $form = $_GET['f'];
        $data = array(
            'ed' => [],
            'sv' => []
        );
        if(isset($_GET['ed']))
            $data['ed'] = json_decode($_GET['ed']);
        if(isset($_GET['sv']))
            $data['sv'] = json_decode($_GET['sv']);

        if (!file_exists(APPPATH . 'views/' . $form . '.php'))
            response(['message' => 'Form ' . $form . ' Tidak ditemukan'], 404);
        else {
            $html =  $this->load->view($form, $data, true);
            
            if(!empty($skrip)){
                $skrip = load_script($skrip, [
                    'form_cache' => json_encode($data['ed']),
                    'form_data' => json_encode($data['sv'])
                ], true);    
            }
            response([
                'html' => $html . $skrip
            ]);
        }
    }
    function skrip_get()
    {
        if (httpmethod())
            response(['message' => 'Ilegal akses'], 403);
            
        $skrip = '';
        if(isset($_GET['s']) && !empty($_GET['s']))
            $skrip = $_GET['s'];
        if(empty($skrip)) response(['skrip' => '']);

        if (!file_exists(ASSETS_PATH . 'js/' . $skrip . '.js'))
            response(['message' => 'Form ' . $skrip . ' Tidak ditemukan'], 404);
        else {
            $data = array(
                'ed' => [],
                'sv' => []
            );
            if(isset($_GET['ed']))
                $data['ed'] = json_decode($_GET['ed']);
            if(isset($_GET['sv']))
                $data['sv'] = json_decode($_GET['sv']);

            response([
                'skrip' => "<script>" . load_script($skrip,[
                    'form_cache' => json_encode($data['ed']),
                    'form_data' => json_encode($data['sv'])
                ], true) . "</script>"
            ]);
        }
    }
}