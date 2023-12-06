<?php 

session_start();
require_once './config.php';

function modifWaktu($tanggal=null){
    date_default_timezone_set('Asia/Taipei');
    // Menghitung selisih waktu dalam detik antara waktu asli dan waktu sekarang
    $now = date('Y-m-d H:i:s');
    $diff = abs(strtotime($now) - strtotime($tanggal));

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
    return $message;
}

if(isset($_GET['p'])){
    $id = base64_decode($_GET['p']);
    $dataPengumuman = $koneksi->query("SELECT * FROM pengumuman WHERE id_pengumuman='$id'");
    $fetchPengumuman = mysqli_fetch_assoc($dataPengumuman);
}
elseif(isset($_GET['per'])){
    $id = base64_decode($_GET['per']);
    $dataPengumuman = $koneksi->query("SELECT * FROM hasil_akhir h JOIN data_pelamar dp ON h.f_id_pelamar=dp.id_pelamar JOIN rayon r ON r.id_rayon=dp.f_id_rayon JOIN periode p ON p.id_periode=h.f_id_periode WHERE h.f_id_periode='$id'");
    $fetchPengumuman = mysqli_fetch_assoc($dataPengumuman);
    $tahunAnggaran = $fetchPengumuman['deskripsi'];
}
else{
    header("Location: ./404.php");
    exit;
}


?>

<!DOCTYPE html>
<html>

<head>
    <title>SPK Beasiswa</title>
    <style>
    .navbar-transparent {
        background-color: hsl(0, 0%, 96%);
    }

    @media (min-width: 992px) {
        .navbar-transparent {
            margin-bottom: -40px;
        }
    }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&family=Prompt&family=Righteous&family=Roboto:wght@500&display=swap"
        rel="stylesheet" />
</head>

<body>
    <section class="mb-5 pb-5" style="background-color: hsl(0, 0%, 100%)">
        <!-- Section: Design Block -->
        <nav class="navbar fixed-top navbar-transparent">
            <div class="container-fluid d-flex justify-content-end">
                <?php if(isset($_SESSION['login']) && $_SESSION['login'] == true):?>
                <a href="./auth/logout.php" class="btn btn-outline-secondary mt-3 me-md-5">LOGOUT</a>
                <?php else:?>
                <a href="./auth/login.php" class="btn btn-outline-secondary mt-3 me-md-5">LOGIN</a>
                <?php endif;?>
            </div>
        </nav>
        <hr>
        <hr class="navbar-transparent my-3 py-5" style="background-color: hsl(0, 0%, 100%)">
        <!-- Jumbotron -->
        <div class="text-center text-lg-start" style="background-color: hsl(0, 0%, 100%)">
            <div class="container d-flex justify-content-center">
                <div class="row gx-lg-5 align-items-center text-center">
                    <div class="col-lg-12 text-start mb-5 mb-lg-0">
                        <div class="d-flex justify-content-center ">
                            <?php if(isset($_GET['p'])):?>
                            <div class="content col-lg-8">
                                <div class="card p-5">
                                    <div class="card-body">
                                        <h4 class="mb-3" style="color: hsl(217, 10%, 50.8%)">
                                            <?= $fetchPengumuman['judul'];?></i>
                                        </h4>
                                        <small><i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                                    <path
                                                        d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                                                </svg> <?=modifWaktu($fetchPengumuman['tanggal_posting']);?></i></small>
                                        <p style="text-align: justify; margin-top:20px; margin-bottom:40px;">
                                            <?= $fetchPengumuman['isi_pengumuman'];?></p>
                                        <div class="d-flex justify-content-end">
                                            <a href="./home.php#pengumuman" class="btn btn-outline-primary"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                        d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                                                </svg>
                                                Kembali</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php elseif(isset($_GET['per'])): ?>
                                <div class="content col-lg-12 m-5">
                                <div class="card p-5">
                                    <div class="card-body">
                                        <h4 class="mb-3" style="color: hsl(217, 10%, 50.8%)">
                                            Hasil seleksi penerimaan beasiswa <?=$tahunAnggaran;?> </i>
                                        </h4>
                                        <div class="tabel">
                                            <table class="table table-striped table-bordered" id="tabelPengumuman" style="width:100%;">
                                                <thead>
                                                    <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col">Nama</th>
                                                    <th scope="col">Sekolah</th>
                                                    <th scope="col">Jurusan</th>
                                                    <th scope="col">Rayon</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1; ?>
                                                    <?php foreach ($dataPengumuman as $key => $dp):?>
                                                    <tr>
                                                        <th scope="row"><?=$i++?></th>
                                                        <td><?=$dp['nama'];?></td>
                                                        <td><?=$dp['sekolah']?></td>
                                                        <td><?=$dp['jurusan']?></td>
                                                        <td><?=$dp['nama_rayon']?></td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-flex justify-content-end mt-3">
                                            <a href="./home.php#pengumuman" class="btn btn-outline-primary"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                        d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                                                </svg>
                                                Kembali</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section: Design Block -->
    <footer class="bg-white text-center fixed-bottom text-lg-start" style="margin-top:90px;">
        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: #F0F0F0;">
            © 2023 Copyright:
            <a class="text-dark" href="https://www.instagram.com/ilkom19_unc/">Intel'19</a>
        </div>
        <!-- Copyright -->
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<script>
    $(document).ready(function() {
        $('#tabelPengumuman').DataTable();
    });
</script>
</html>