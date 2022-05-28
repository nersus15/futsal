<?php
require_once APPPATH . 'third_party/PHPExcel/PHPExcel.php';
class Excel_reader extends PHPExcel{
    function __construct()
    {
        parent::__construct();
    }

    function read($files){
        // var_dump($files);
        $path = $files['tmp_name'];
        $object = PHPExcel_IOFactory::load($path);
        $worksheet = $object->getWorksheetIterator();

        foreach($worksheet as $w){
            $highestRow = $w->getHighestRow();
            $highestColumn = $w->getHighestColumn();
            for($row=2; $row<=$highestRow; $row++){
                $nis = $w->getCellByColumnAndRow(0, $row)->getValue();
                $nama = $w->getCellByColumnAndRow(1, $row)->getValue();
                $alamat = $w->getCellByColumnAndRow(2, $row)->getValue();
                $kelamin = $w->getCellByColumnAndRow(3, $row)->getValue();
                $kelas = $w->getCellByColumnAndRow(4, $row)->getValue();
                $angkatan = $w->getCellByColumnAndRow(5, $row)->getValue();

                $data[] = array(
                    'nomerInduk' => $nis,
                    'nama' => $nama,
                    'alamat' => $alamat,
                    'kelamin' => $kelamin,
                    'kelas' => $kelas,
                    'angkatan' => $angkatan,
                );
            }
        }

        return $data;
    }

    function insert_data($data, $table){
        /** @var CI_Controller $ci */

        $ci =& get_instance();

        try {
            $ci->db->insert_batch($table, $data);
            response(['message' => 'Berhasil upload data dari excel', 'type' => 'success']);

        } catch (\Throwable $th) {
            response(['message' => 'Gagal, terjadi kesalahan', 'err' => print_r($th, true), 'type' => 'error'], 500);
        }        
    }
}