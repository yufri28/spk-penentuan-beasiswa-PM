<?php 
session_start();
unset($_SESSION['menu']);
$_SESSION['menu'] = 'index';
require './header.php';
require_once './functions/index.php';
require_once './functions/setting.php';

$periodeActive = $Setting->getPeriodeActive($_SESSION['id_periode']);

$countPengguna = mysqli_num_rows($Index->countKoordinator()) + mysqli_num_rows($Index->countPelamar());
// $countPelamar = mysqli_num_rows($Index->countDataPelamar());
$countPelamar = $Index->countDataPelamarByRayon();
$countKriteria = mysqli_num_rows($Index->countKriteria());
$countSubKriteria = mysqli_num_rows($Index->countSubKriteria());
?>

<!-- Area Chart -->
<?php if($_SESSION['level'] == 0): ?>
<div class="row">
    <?php foreach ($countPelamar as $key => $value) :?>
    <div class="col-lg-3">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header">
                <h5>Pelamar <?=$value['nama_rayon'];?></h5>
            </div>
            <div class="card-body py-4 d-flex flex-row align-items-center justify-content-between">
                <h1 class="text-center col-12"><?=$value['jumlah_pelamar']; ?></h1>
            </div>
        </div>
    </div>
    <?php endforeach;?>
    <div class="col-lg-3">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header">
                <h5>Pengguna</h5>
            </div>
            <div class="card-body py-4 d-flex flex-row align-items-center justify-content-between">
                <h1 class="text-center col-12"><?=isset($countPengguna)?$countPengguna:'-'; ?></h1>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header">
                <h5>Kriteria</h5>
            </div>
            <div class="card-body py-4 d-flex flex-row align-items-center justify-content-between">
                <h1 class="text-center col-12"><?=isset($countKriteria)?$countKriteria:'-'; ?></h1>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header">
                <h5>Sub Kriteria</h5>
            </div>
            <div class="card-body py-4 d-flex flex-row align-items-center justify-content-between">
                <h1 class="text-center col-12"><?=isset($countSubKriteria)?$countSubKriteria:'-'; ?></h1>
            </div>
        </div>
    </div>
</div>
<?php else:?>
<div class="row d-flex justify-content-center">
    <?php
                    // Tanggal dalam format asli
                    $originalDate = $periodeActive['batas_koor'];

                    // Mengonversi tanggal ke format yang diinginkan
                    $newDate = date('d F Y H:i:s', strtotime($originalDate));

                    if($periodeActive['status'] == 'buka'){
                        // Menampilkan tanggal dalam <marquee>
                        echo "<marquee class='text-danger' behavior=\"\" direction=\"\">Penting: Waktu verifikasi untuk periode ".$periodeActive['nama_periode']." akan berakhir pada $newDate WITA</marquee>";
                    }else{
                        // Menampilkan tanggal dalam <marquee>
                        echo "<marquee class='text-danger' behavior=\"\" direction=\"\">Penting: Waktu verifikasi untuk periode ".$periodeActive['nama_periode']." telah berakhir pada $newDate WITA</marquee>";
                    }
                ?>
    <div class="col-lg-3">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header">
                <h5>Terverifikasi</h5>
            </div>
            <div class="card-body py-4 d-flex flex-row align-items-center justify-content-between">
                <h1 class="text-center col-12"><?=$countVerifikasi['jumlah'];?></h1>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header">
                <h5>Belum Verifikasi</h5>
            </div>
            <div class="card-body py-4 d-flex flex-row align-items-center justify-content-between">
                <h1 class="text-center col-12"><?=$countBelumVerifikasi['jumlah'];?></h1>
            </div>
        </div>
    </div>
</div>
<?php endif;?>

<?php require './footer.php';?>