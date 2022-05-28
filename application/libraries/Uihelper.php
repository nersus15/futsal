<?php


class Uihelperlib
{
    function jenisTransaksi()
    {
        if(httpmethod('POS'))
            response(['message' => 'tidak ada controller jenistransaksi dengan method[POS]', 'type' => 'error'], 404);
        if(!is_login('bendahara'))
            response(['message' => 'Anda tidak memiliki akses', 'type' => 'error'], 401);

        /** @var CI_Controller $ci */
        $ci = &get_instance();

        $jenis_transaksi = $ci->db->get('jenisTransaksi')->result();
        response($jenis_transaksi);
    }
}
