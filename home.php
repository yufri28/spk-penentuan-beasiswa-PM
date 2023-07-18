<?php 
session_start();
// if(isset($_SESSION['login']) && $_SESSION['login'] == true && $_SESSION['role'] == 1){
//     header("Location: ./user/index.php");
// }else if(isset($_SESSION['login']) && $_SESSION['login'] == true && $_SESSION['role'] == 0) {
//     header("Location: ./admin/index.php");
// }
require_once './config.php';
global $koneksi;

$dataPengumuman = $koneksi->query("SELECT * FROM pengumuman");
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
    <section class="">
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
        <hr class="navbar-transparent">
        <!-- Jumbotron -->
        <div class="text-center text-lg-start" style="background-color: hsl(0, 0%, 96%)">
            <div class="container d-flex" style="height:100vh;">
                <div class="row gx-lg-5 align-items-center text-center">
                    <div class="col-lg-6 text-start mb-5 mb-lg-0">
                        <h1 class="my-4 display-5 fw-bolder ls-tight">
                            Sistem Pendukung Keputusan <br />
                            <span style="color:#E7B10A">SELEKSI CALON
                                PENERIMA BEASISWA</span>
                        </h1>
                        <h4 style="color: hsl(217, 10%, 50.8%)">
                            PADA JENJANG PENDIDIKAN
                            SEKOLAH MENENGAH ATAS (SMA) DAN PERGURUAN
                            TINGGI DI GMIT PAULUS KUPANG MENGGUNAKAN
                            METODE PROFILE MATCHING</i>
                        </h4>
                        <a href="#pengumuman" class="btn btn-outline-secondary">Lihat Pengumuman</a>
                    </div>
                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <div class="gambar text-end">
                            <!-- <div class="card-body d-flex justify-content-center" style="width:100%;height:100%;"> -->
                            <img style="width:400px; height:400px; border-radius:0.3em;" class="shadow-lg"
                                src="./assets/images/gereja.jpg" alt="">
                            <!-- </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="pengumuman">
        <div class="text-center text-lg-start bg-white">
            <h2 class="text-center mt-5" style="font-family: 'Righteous', cursive; color:#526D82">Pengumuman</h2>
            <div class="container d-flex justify-content-center">
                <div class="row col-md-9 my-5 px-3 d-flex justify-content-center align-items-center">
                    <?php if(mysqli_num_rows($dataPengumuman) > 0):?>
                    <?php foreach ($dataPengumuman as  $pengumuman): ?>
                    <div class="col-md-4 mt-2">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-secondary fw-bolder"
                                    style="font-family: 'Public Sans', sans-serif;">
                                    <?=$pengumuman['judul'];?></h5>
                                <p class="card-text" style="font-family: 'Public Sans', sans-serif;">
                                    <?=$pengumuman['isi_pengumuman'];?></p>
                                <a href="./pengumuman.php?p=<?=base64_encode($pengumuman['id_pengumuman']);?>">Baca
                                    Selengkapnya...</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;?>
                    <?php else:?>
                    <h4 class="text-center text-secondary" style="font-family: 'Public Sans', sans-serif;"><i>Belum ada
                            Pengumuman</i>
                    </h4>
                    <?php endif;?>
                </div>
            </div>
        </div>
        <!-- Jumbotron -->
    </section>
    <!-- Section: Design Block -->
    <footer class="bg-white text-center text-lg-start">
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

</html>