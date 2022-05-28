<?php


class UihelperLib
{
    function jenisTransaksi($tipe = null)
    {
        if (httpmethod('POS'))
            response(['message' => 'tidak ada controller jenistransaksi dengan method[POS]', 'type' => 'error'], 404);
        if (!is_login('bendahara'))
            response(['message' => 'Anda tidak memiliki akses', 'type' => 'error'], 401);


        if (!empty($tipe) && $tipe != 'masuk' && $tipe != 'keluar')
            response(['message' => 'Tipe data yang di cari tidak tersedia', 'type' => 'error'], 500);

        /** @var CI_Controller $ci */
        $ci = &get_instance();
        $ci->db->reset_query();

        if ($tipe == 'keluar' && sessiondata('login', 'role') == 'bendahara 2')
            $query = $ci->db->select('jenisTransaksi.*')->from('jenisTransaksi')->where('tipe', $tipe)->where("SUBSTRING(jenisTransaksi.id, 1, 2) != 'KK'", null, null);

        elseif ($tipe == 'keluar' && sessiondata('login', 'role') == 'bendahara 1')
            $query = $ci->db->select('jenisTransaksi.*')->from('jenisTransaksi')->where("SUBSTRING(jenisTransaksi.id, 1, 2) = 'KK'", null, null);

        elseif ($tipe == 'masuk')
            $query = $ci->db->select('jenisTransaksi.*')->from('jenisTransaksi')->where('tipe', $tipe);

        elseif (empty($tipe))
            $query = $ci->db->select('jenisTransaksi.*')->from('jenisTransaksi');


        return $query->get()->result();
    }

    function data_user($username = null)
    {
        /** @var CI_Controller $ci */
        $ci = &get_instance();
        $ci->db->reset_query();

        $query = $ci->db->select('users.username, users.role, users.email, users.isActive,user_info.*')->from('users')
            ->join('user_info', 'users.username = user_info.user', 'INNER')->where("users.role !='kepala ketua yayasan'", null);

        if (sessiondata('login', 'role') == 'kepala sekolah')
            $query->where("users.role != 'kepala sekolah'", null);

        if (!empty($username))
            $query->where('username', $username);

        $hasil = $query->get()->result();

        $query = $ci->db->select('permission.permission, user_acsess.user')->from('permission')
            ->join('user_acsess', 'user_acsess.permission = permission.id');

        if (!empty($username))
            $query->where('user', $username);
        else {
            foreach ($hasil as $user) {
                $query->or_where('user', $user->username);
            }
        }

        $permission = $query->get()->result();
        $hak_akses = [];
        foreach ($permission as $p) {
            $hak_akses[$p->user][] = $p->permission;
        }
        response(['users' => $hasil, 'permission' => $hak_akses, 'type' => 'success']);
    }

    function datasiswa($mode)
    {
        /** @var CI_Controller $ci */
        $ci = &get_instance();

        switch ($mode) {
            case 'select2':
                $q = $_GET['search'];
                $data = $ci->db->like('nomerInduk', $q, 'both', null)
                    ->or_like('nama', $q, 'both', null)
                    ->get('siswa')
                    ->result();

                response(['data' => $data, 'type' => 'success']);
            case 'full':
                $k = isset($_GET['k']) ? $_GET['k'] : null;
                $a = isset($_GET['a']) ? $_GET['a'] : null;
                $query = $ci->db->select('siswa.*')->from('siswa');
                if (!empty($k) && $k != 'Semua')
                    $query->where('kelas', $k);
                if (!empty($a) && $a != 'Semua')
                    $query->where('angkatan', $a);
                $data = $query->get()->result();
                response(['data' => $data, 'type' => 'success']);
                break;
        }
    }

    function persiapansimpan($post, $table)
    {
        $newInput = null;
        switch ($table) {
            case 'siswa':
                $input = fieldmapping('siswa', $post);

                if (strlen($input['angkatan']) > 4)
                    response(['message' => 'Input angkatan tidak valid', 'type' => 'error'], 500);
                $newInput = $input;
                break;
        }

        return array($newInput);
    }

    function simpan($input, $table)
    {
        /** @var CI_Controller $ci */
        $ci = &get_instance();

        switch ($table) {
            case 'siswa':
                try {
                    $ci->db->insert('siswa', $input);
                    response(['message' => 'Berhasil menambah data siswa', 'type' => 'success']);
                } catch (\Throwable $th) {
                    response(['message' => 'Gagal, menambah data siswa', 'err' => print_r($th, true), 'type' => 'error']);
                }
                break;
        }
    }
    // function getDashboard(){
    //     if(httpmethod('POS'))
    //         response(['message' => 'tidak ada controller jenistransaksi dengan method[POS]', 'type' => 'error'], 404);
    //     if(!is_login())
    //         response(['message' => 'Anda tidak memiliki akses', 'type' => 'error'], 401);

    //     /** @var CI_Controller $ci */
    //     $ci =& get_instance();

    //     $ci->db->select('')
    // }
}
