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
?>
<div class="row">   
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
                <h5 class="card-title mb-0">Data Bookingan Bulan Ini<span class="float-right"><?= count($month_booking) ?></span></h5>
                <p class="mt-0">Sisa Diskon <span class="float-right"><?= (count($month_booking) < 3 ? 3 - count($month_booking) : 0) . 'x' ?></span></p>

                <p>
                    <a class="text-white more" data-toggle="collapse" href="#data-booking-bulanan" role="button" aria-expanded="false" aria-controls="data-booking-bulanan">
                        Lihat detail <span class="float-right"><i class="simple-icon-arrow-right"></i></span>
                    </a>
                </p>
                <div class="collapse" id="data-booking-bulanan">
                    <div class="col-12">
                        <p>Bookingan Batal <span class="float-right"><?= count($month_cancel) ?></span></p>
                        <p>Bookingan Terverifikasi <span class="float-right"><?= count($month_verify) ?></span></p>
                        <p>Bookingan Selesai <span class="float-right"><?= count($month_end) ?></span> </p>
                        <p>Bookingan Belum Bayar <span class="float-right"><?= count($month_unpay) ?></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $("#card-booking a.more, #card-booking-bulanan a.more").click(function() {
        if ($(this).find('i').hasClass('simple-icon-arrow-right')) {
            $(this).find('i').removeClass('simple-icon-arrow-right');
            $(this).find('i').addClass('simple-icon-arrow-down');
        } else if ($(this).find('i').hasClass('simple-icon-arrow-down')) {
            $(this).find('i').removeClass('simple-icon-arrow-down');
            $(this).find('i').addClass('simple-icon-arrow-right');
        }
    });
</script>