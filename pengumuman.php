<?php 

session_start();
require_once './config.php';


if(isset($_GET['p'])){
    $id = base64_decode($_GET['p']);
    $dataPengumuman = $koneksi->query("SELECT * FROM pengumuman WHERE id_pengumuman='$id'");
    $fetchPengumuman = mysqli_fetch_assoc($dataPengumuman);
}else{
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
                            <div class="content col-lg-8">
                                <h4 class="mb-3" style="color: hsl(217, 10%, 50.8%)">
                                    <?= $fetchPengumuman['judul'];?></i>
                                </h4>
                                <p style="text-align: justify;"><?= $fetchPengumuman['isi_pengumuman'];?></p>
                                <a href="./home.php" class="btn btn-outline-primary"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-arrow-left" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                                    </svg>
                                    Kembali</a>
                            </div>
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

</html>