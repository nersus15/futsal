<?php

class TransaksiLib
{
    function persiapan(&$post, $mode = 'masuk')
    {
        if (!is_login('bendahara'))
            response(['message' => 'Harus login sebagai bendahara dulu', 'type' => 'error'], 401);
        if ($mode != 'masuk' && $mode != 'keluar')
            response(['message' => 'Error, illegal method', 'type' => 'error'], 403);

        switch ($mode) {
            case 'masuk':
                $input = fieldmapping('transaksi_masuk', $post);
                $input['_jenis'] = $mode;

                if (in_array($input['jenis'], PEMASUKAN_DARI_SISWA)) {
                    unset($input['sumber']);
                } else
                    unset($input['siswa']);

                $input['id'] = substr(uniqid(), 0, 25);
                $input['tanggal_catat'] = waktu();

                if (!preg_match('/^[1-2]\d{3}-[0-1]?\d-[0-3]?\d?$/', $input['tanggal']))
                    response(['message' => 'Format tanggal salah', 'type' => 'error'], 405);
                $input['pencatat'] = sessiondata('login', 'username');

                if (!isset($input['saldo_sebelum']) || empty($input['saldo_sebelum'])) {
                    $catatan = $this->hitungSaldo();
                    $input['saldo_sebelum'] = $catatan[0];
                    $input['urutan'] = empty($catatan[1]) ? 1 : $catatan[1]['urutan'] + 1;
                }

                $newinput = $input;
                break;
            case 'keluar':
                $input = fieldmapping('transaksi_keluar', $post);
                $role = sessiondata('login', 'role');
                $input['_jenis'] = $mode;
                $input['id'] = substr(uniqid(), 0, 25);
                $input['tanggal_catat'] = waktu();
                $catatan = $this->hitungSaldo('keluar');
                $input['pencatat'] = sessiondata('login', 'username');
                $input['sumber'] = in_array($input['jenis'], KAS_KECIL) ? 'Kas kecil' : 'Kas besar';

                $input['saldo_sebelum'] = $catatan[0];
                $input['urutan'] = empty($catatan[1]) ? 1 : $catatan[1]['urutan'] + 1;

                if (substr($input['jenis'], 0, 2) == 'KK' && $role != 'bendahara 1')
                    response(['message' => 'Ilegal, anda tidak memiliki akses', 'type' => 'error'], 401);

                $newinput = $input;

                break;
        }

        return array($newinput);
    }

    function simpan($input, $mode = 'masuk')
    {
        
        if (!is_login('bendahara'))
            response(['message' => 'Harus login sebagai bendahara dulu', 'type' => 'error'], 401);

        /** @var CI_Controller $ci */
        $ci = &get_instance();
        unset($input['_jenis']);
        $kasKecil = $ci->db->order_by('urutan', 'DESC')->get('kas_kecil')->row();

        if(empty($kasKecil) && $mode == 'keluar' && in_array($input['jenis'], KAS_KECIL))
            response(['message' => 'Kas kecil kosong', 'type' => 'error'], 500);

        if ($mode == 'masuk')
            $tabel = 'transaksi_masuk';
        elseif ($mode == 'keluar' && !in_array($input['jenis'], KAS_KECIL))
            $tabel = 'transaksi_keluar';
        elseif ($mode == 'keluar' && in_array($input['jenis'], KAS_KECIL)){
            $tabel = 'transaksi_kaskecil';
            $input['saldo_sebelum'] = $kasKecil->sisa;
        }

        
        try {
            $ci->db->insert($tabel, $input);
            if ($mode == 'keluar' && substr($input['jenis'], 0, 2) == 'KK') {
                if(!empty($kasKecil))
                    $ci->db->set('status', 'non aktif')->update('kas_kecil');

                $data = array(
                    'kode' => substr(uniqid(), 0, 15),
                    'tanggal_keluar' => $input['tanggal'],
                    'jumlah' => $input['jumlah'],
                    'sisa' => $input['jumlah'],
                    'status' => 'aktif',
                    'kas_sebelum' => !empty($kasKecil) ? $kasKecil->sisa : 0,
                    'tgl_catat' => waktu(),
                    'urutan' => !empty($kasKecil) ? $kasKecil->urutan + 1 : 1,
                );
                try {
                    $ci->db->insert('kas_kecil', $data);
                } catch (\Throwable $th) {
                    response(['message' => 'Terjadi kesalahan, Gagal melakukan transaksi', 'type' => 'error', 'err' => $th], 500);
                }
            }

            if ($mode == 'keluar' && in_array($input['jenis'], KAS_KECIL)) {
                try {
                    if(!empty($kasKecil))
                    $ci->db->where('status', 'aktif')->set('sisa', intval($kasKecil->sisa) - $input['jumlah'])->update('kas_kecil');
                } catch (\Throwable $th) {
                    response(['message' => 'Terjadi kesalahan, Gagal melakukan transaksi', 'type' => 'error', 'err' => $th], 500);
                }
            }

            response(['message' => 'Berhasil melakukan transaksi', 'data' => $input['jumlah'], 'type' => 'success']);
        } catch (\Throwable $err) {
            response(['message' => 'Terjadi kesalahan, Gagal melakukan transaksi', 'type' => 'error', 'err' => $err], 500);
        }
    }

    function getCatatanSebelum($tabel = 'transaksi_masuk')
    {
        /** @var CI_Controller $ci */
        $ci = &get_instance();
        return $ci->db->order_by('urutan', 'DESC')->get($tabel)->row();
    }

    function hitungSaldo($mode = 'masuk', $tipe = 'sebelumnya')
    {
        /** @var CI_Controller $ci */
        $ci = &get_instance();

        if($mode == 'kas_kecil'){
            $hasil = $ci->db->select('(sisa + kas_sebelum) as saldo')->where('status', 'aktif')->get('kas_kecil')->row();
            return [$hasil->saldo, null];
        }
            

        $catatan_keluar =  $ci->db->order_by('urutan', 'DESC')->get('transaksi_keluar')->result_array();
        $catatan_masuk =  $ci->db->order_by('urutan', 'DESC')->get('transaksi_masuk')->result_array();
        
        if (!empty($catatan_keluar) && !empty($catatan_masuk)) {
           
            $tgl_keluar = $catatan_keluar[0]['tanggal_catat'];
            $tgl_masuk = $catatan_masuk[0]['tanggal_catat'];

            // var_dump(strtotime($tgl_keluar) > strtotime($tgl_masuk));die;
            if(strtotime($tgl_keluar) > strtotime($tgl_masuk))
                $saldoSekarang = $catatan_keluar[0]['saldo_sebelum'] - $catatan_keluar[0]['jumlah'];
            else
                $saldoSekarang = $catatan_masuk[0]['saldo_sebelum'] + $catatan_masuk[0]['jumlah'];

        } elseif (empty($catatan_keluar) && !empty($catatan_masuk)) {
            $saldoSekarang = $catatan_masuk[0]['jumlah'] + $catatan_masuk[0]['saldo_sebelum'];
        } elseif (!empty($catatan_keluar) && empty($catatan_masuk)) {
            // response(['message' => 'Saldo kosong'], 500);
        } elseif (empty($catatan_keluar) && empty($catatan_masuk)) {
            return [0, null];
        }

        if (!empty($catatan_masuk) && !empty($catatan_keluar)) {
            if ($mode == 'masuk')
                return [$saldoSekarang, $catatan_masuk[0]];
            else
                return [$saldoSekarang, $catatan_keluar[0]];
        } elseif (empty($catatan_masuk) && !empty($catatan_keluar)) {
            if ($mode == 'masuk')
                return [$saldoSekarang, null];
            else
                return [$saldoSekarang, $catatan_keluar[0]];
        } elseif (!empty($catatan_masuk) && empty($catatan_keluar)) {
            if ($mode == 'masuk')
                return [$saldoSekarang, $catatan_masuk[0]];
            else
                return [$saldoSekarang, null];
        } elseif (empty($catatan_masuk) && empty($catatan_keluar)) {
           return [$saldoSekarang, null];
        }
    }
}
