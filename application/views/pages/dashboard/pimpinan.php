<?php
$cancel = [];
$end = [];
$unpay = [];
$verify = [];
if (!empty($booking)) {
    $cancel = array_filter($booking, function ($arr) {
        return $arr->status == 'batal';
    });
    $end = array_filter($booking, function ($arr) {
        return $arr->status == 'selesai';
    });
    $unpay = array_filter($booking, function ($arr) {
        return $arr->status == 'baru';
    });
    $verify = array_filter($booking, function ($arr) {
        return $arr->status == 'terverifikasi';
    });
}
$thisMonth = date('Y-m');
$month_booking = array_filter($booking, function ($arr) use ($thisMonth) {
    return substr($arr->dibuat, 0, 7) == $thisMonth;
});
$daftar_bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

$month_cancel = [];
$month_end = [];
$month_unpay = [];
$month_verify = [];
if (!empty($booking)) {
    $month_cancel = array_filter($month_booking, function ($arr) {
        return $arr->status == 'batal';
    });
    $month_end = array_filter($month_booking, function ($arr) {
        return $arr->status == 'selesai';
    });
    $month_unpay = array_filter($month_booking, function ($arr) {
        return $arr->status == 'baru';
    });
    $month_verify = array_filter($month_booking, function ($arr) {
        return $arr->status == 'terverifikasi';
    });
}
$dataMemberBulanan = [
    'sebelumnya' => 0,
    'tahun_ini' => 0
];

foreach ($daftar_bulan as $v) {
    $dataMemberBulanan[$v] = 0;
}
array_map(function ($arr) use (&$dataMemberBulanan, $daftar_bulan) {
    $tgldaftar = $arr->dibuat;
    if (substr($tgldaftar, 0, 4) != date('Y')) {
        $dataMemberBulanan['sebelumnya'] = $dataMemberBulanan['sebelumnya'] + 1;
    } else {
        $bulan = intval(substr($tgldaftar, 6, 7));
        $dataMemberBulanan[$daftar_bulan[$bulan - 1]] = $dataMemberBulanan[$daftar_bulan[$bulan - 1]] + 1;
        $dataMemberBulanan['tahun_ini'] = $dataMemberBulanan['tahun_ini'] + 1;
    }
}, $member);


?>
<div class="row">
    <div class="col-sm-8 col-md-6 mt-3">
        <div class="card bg-primary" id="card-lapangan">
            <div class="card-body">
                <h5 class="card-title mb-0">Jumlah Admin <span class="float-right"><?= count($admin) ?></span></h5>
                <hr>
                <h5 class="card-title mb-0">Jumlah Lapangan <span class="float-right"><?= count($lapangan) ?></span></h5>
                <hr>
                <h5 class="card-title mb-0">Jumlah Jadwal <span class="float-right"><?= count($jadwal) ?></span></h5>

            </div>
        </div>
    </div>
    <div class="col-sm-8 col-md-6 mt-3">
        <div class="card bg-primary" id="card-booking">
            <div class="card-body">
                <h5 class="card-title">Data Bookingan<span class="float-right"><?= count($booking) ?></span></h5>

                <p>
                    <a class="text-white more" data-toggle="collapse" href="#data-booking" role="button" aria-expanded="false" aria-controls="data-booking">
                        Lihat detail <span class="float-right"><i class="simple-icon-arrow-right"></i></span>
                    </a>
                </p>
                <div class="collapse" id="data-booking">
                    <div class="col-12">
                        <p>Bookingan Batal <span class="float-right"><?= count($cancel) ?></span></p>
                        <p>Bookingan Terverifikasi <span class="float-right"><?= count($verify) ?></span></p>
                        <p>Bookingan Selesai <span class="float-right"><?= count($end) ?></span> </p>
                        <p>Bookingan Belum Bayar <span class="float-right"><?= count($unpay) ?></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-8 col-md-6 mt-3">
        <div class="card bg-primary" id="card-booking-bulanan">
            <div class="card-body">
                <h5 class="card-title">Data Bookingan Bulan Ini<span class="float-right"><?= count($month_booking) ?></span></h5>
                <p>
                    <a class="text-white more" data-toggle="collapse" href="#data-booking-bulanan" role="button" aria-expanded="false" aria-controls="data-booking-bulanan">
                        Lihat detail <span class="float-right"><i class="simple-icon-arrow-right"></i></span>
                    </a>
                </p>
                <div class="collapse" id="data-booking-bulanan">
                    <div class="col-12">
                        <p>Daftar <span class="float-right"><?= count($month_cancel) ?></span></p>
                        <p>Bookingan Terverifikasi <span class="float-right"><?= count($month_verify) ?></span></p>
                        <p>Bookingan Selesai <span class="float-right"><?= count($month_end) ?></span> </p>
                        <p>Bookingan Belum Bayar <span class="float-right"><?= count($month_unpay) ?></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-8 col-md-6 mt-3">
        <div class="card bg-primary" id="card-member">
            <div class="card-body">
                <h5 class="card-title mb-0">Jumlah Member <span class="float-right"><?= count($member) ?></span></h5>
                <hr>
                <p class="mt-2 mb-0">Terdaftar Tahun Sebelumnya <span class="float-right"><?= $dataMemberBulanan['sebelumnya'] ?></span></p>
                <p class="mt-0">Member Baru (Tahun ini)<span class="float-right"><?= $dataMemberBulanan['tahun_ini'] ?></span></p>

                <p>
                    <a class="text-white more" data-toggle="collapse" href="#data-member" role="button" aria-expanded="false" aria-controls="data-member">
                        Lihat detail <span class="float-right"><i class="simple-icon-arrow-right"></i></span>
                    </a>
                </p>
                <div class="collapse" id="data-member">
                    <div class="col-12">
                        <p style="text-align: center;">Member Baru </p>
                        <hr>
                        <?php foreach ($dataMemberBulanan as $k => $v) : ?>
                            <p><?= $k ?> <span class="float-right"><?= $v ?></span></p>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<script>
    $("a.more").click(function() {
        if ($(this).find('i').hasClass('simple-icon-arrow-right')) {
            $(this).find('i').removeClass('simple-icon-arrow-right');
            $(this).find('i').addClass('simple-icon-arrow-down');
        } else if ($(this).find('i').hasClass('simple-icon-arrow-down')) {
            $(this).find('i').removeClass('simple-icon-arrow-down');
            $(this).find('i').addClass('simple-icon-arrow-right');
        }
    });
</script>