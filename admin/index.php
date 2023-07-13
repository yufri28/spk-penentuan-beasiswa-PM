<?php 
session_start();
unset($_SESSION['menu']);
$_SESSION['menu'] = 'index';
require './header.php';
require_once './functions/index.php';

$countPengguna = mysqli_num_rows($Index->countKoordinator()) + mysqli_num_rows($Index->countPelamar());
$countPelamar = mysqli_num_rows($Index->countDataPelamar());
$countKriteria = mysqli_num_rows($Index->countKriteria());
$countSubKriteria = mysqli_num_rows($Index->countSubKriteria());

?>

<!-- Area Chart -->
<?php if($_SESSION['level'] == 0): ?>
<div class="row">
    <div class="col-lg-4">
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
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header">
                <h5>Pelamar</h5>
            </div>
            <div class="card-body py-4 d-flex flex-row align-items-center justify-content-between">
                <h1 class="text-center col-12"><?=isset($countPelamar)?$countPelamar:'-'; ?></h1>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
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
    <div class="col-lg-4">
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
    <div class="col-lg-4">
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
    <div class="col-lg-4">
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