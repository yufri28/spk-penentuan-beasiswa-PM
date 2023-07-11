<?php 
session_start();
unset($_SESSION['menu']);
$_SESSION['menu'] = 'pesan';
require '../includes/header.php';
require_once '../user/functions/pesan.php';

$countBelumDibaca = $Pesan->countBelumDibaca($_SESSION['id_user']);
$getPesan = $Pesan->getPesan($_SESSION['id_user']);
$dataPesan = mysqli_fetch_assoc($getPesan);
$jumlah_pesan =  mysqli_num_rows($countBelumDibaca);
date_default_timezone_set('Asia/Taipei');
// Menghitung selisih waktu dalam detik antara waktu asli dan waktu sekarang
$now = date('Y-m-d H:i:s');
$diff = abs(strtotime($now) - strtotime($dataPesan['tanggal_kirim']));

// Mengonversi selisih waktu ke detik, menit, jam, hari, bulan, dan tahun
$seconds = $diff;
$minutes = round($diff / 60);
$hours = round($diff / 3600);
$days = round($diff / 86400);
$months = round($diff / 2592000);
$years = round($diff / 31536000);

// Membentuk pesan dengan format yang sesuai
$message = '';
if ($seconds < 60) {
    $message = $seconds . " detik yang lalu";
} elseif ($minutes < 60) {
    $message = $minutes . " menit yang lalu";
} elseif ($hours < 24) {
    $message = $hours . " jam yang lalu";
} elseif ($days < 30) {
    $message = $days . " hari yang lalu";
} elseif ($months < 12) {
    $message = $months . " bulan yang lalu";
} else {
    $message = $years . " tahun yang lalu";
}

if(isset($_GET['id_psn'])){
    echo $_GET['id_psn'];
}

?>

<div class="row d-flex justify-content-center">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-body" style="font-family: 'Lato', sans-serif; padding: 60px 60px">
                <h3 class="text-center">PESAN</h3>
                <label class="mt-3">
                    Dari : <strong><?=$dataPesan['username']?></strong>
                </label><br>
                <label for="isi_pesan">Isi Pesan : </label>
                <div class="alert alert-info" role="alert">
                    <p class="text-end"><?=$dataPesan['pesan']?></p>
                </div>
                <div class="d-flex justify-content-end">
                    <small class="text-end"><i><?=$message;?></i></small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require '../includes/footer.php';?>