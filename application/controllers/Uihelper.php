<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Uihelper extends CI_Controller
{
    function form()
    {
        if (httpmethod())
            response(['message' => 'Ilegal akses'], 403);

        if (!isset($_GET['f']))
            response(['message' => 'File (form) kosong'], 404);
        $form = $_GET['f'];

        if (!file_exists(APPPATH . 'views/' . $form . '.php'))
            response(['message' => 'Form yang ' . $form . ' Tidak ditemukan'], 404);
        else {
            $this->addViews($form);
            $this->render();
        }
    }

    function upload($tipe = 'gambar', $jenis = 'thumb')
    {
        if (httpmethod('GET'))
            response(['message' => 'Ilegal akses'], 403);

        $this->load->helper('file_upload');
        $file = &$_FILES['file'];
        $img = uploadImage($file, 'file', $jenis);

        response(['message' => 'Berhasil upload gambar', 'img' => $img, 'key' => $file['name']]);
    }

    function delete_file($tipe, $nama)
    {
        if ($tipe == 'profile')
            $path = ASSETS_PATH . 'img/profile/' . $nama;
        if ($tipe == 'thumb')
            $path = ASSETS_PATH . 'img/barang/' . $nama;

        try {
            unlink($path);
        } catch (\Throwable $th) {
            response(['message' => 'Terjadi kesalahan', 'err' => print_r($th, true)], 500);
        }

        response(['message' => 'Berhasil delete file ' . $nama]);
    }

    function carousel($jenis)
    {
        if ($jenis == 'get') {
            $data = file_get_contents(ROOT . 'public/docs/.carousel-map.json');
            if (empty($data))
                response(['data' => null]);

            $data = json_decode($data, true);
            response(['data' => $data]);
        } elseif ($jenis == 'set') {
            $post = &$_POST;
            $carousel = array();

            if(isset($post['carousel_img'])){
                for ($i=0; $i < count($post['carousel_img']) ; $i++) { 
                    $carousel[] = array(
                        'img' => $post['carousel_img'][$i],
                        'text' => $post['carousel_text'][$i],
                        'badge' => $post['carousel_badge'][$i]
                    );
                }
            }

            $data = json_encode($carousel);

            try {
                file_put_contents(ROOT . 'public/docs/.carousel-map.json', $data);
            } catch (\Throwable $th) {
                response(['message' => 'Terjadi kesalahan', 'err' => print_r($th, true)]);
            }

            response(['message' => 'Berhasil setting carousel']);
        }
        elseif($jenis == 'delete'){
            file_put_contents(ROOT . 'public/docs/.carousel-map.json', '');

            response(['message' => 'Berhasil hapus carousel']);
        }        
    }

    function get_files($return = false)
    {
        $path = $_GET['p'];
        if(empty($path))
            response(['message' => 'Tidak ada path yang dikirim']);
        try {
            $files = scandir(ROOT . $path);
        } catch (\Throwable $th) {
            response(['message' => 'Terjadi kesalahan', 'err' => print_r($ht, true)]);
        }
        unset($files[0], $files[1]);
        response(['data' => $files]);

        if($return)
            return $files;
    }
}
