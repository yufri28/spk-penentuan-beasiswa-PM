<?php 
require_once '../config.php';
require_once './functions/verifikasi.php';
if(!isset($_SESSION['login']) && $_SESSION['login'] != true){
    header("Location: ../index.php");
}
else if($_SESSION['level'] != 0 && $_SESSION['level'] != 1){
    header("Location: ../404.php");
    exit;
}

if($_SESSION['id_rayon'] != 1 && $_SESSION['level'] == 1){
    $countVerifikasi = $Verifikasi->countVerifikasi((int)$_SESSION['id_rayon']);
    $countBelumVerifikasi = $Verifikasi->countBelumVerifikasi((int)$_SESSION['id_rayon']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>SPK Seleksi Beasiswa</title>

    <!-- Custom fonts for this template-->
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet" />
    <!-- Custom styles for this page -->
    <link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="../assets/lightbox2/css/lightbox.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
    #accordionSidebar {
        background-color: #D49B54;
    }
    </style>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
                <div class="sidebar-brand-icon rotate-n-15" style="display: none">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3"></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0" />
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Admin <sup><?=$_SESSION['username'];?></sup></div>
            </a>
            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?= $_SESSION['menu'] == 'index' ? 'active':'';?>">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <!-- Nav Item - Charts -->
            <?php if($_SESSION['level'] == 0): ?>
            <li class="nav-item <?= $_SESSION['menu'] == 'pelamar' ? 'active':'';?>">
                <a class="nav-link" href="./data_pelamar.php">
                    <i class="fas fa-user"></i>
                    <span>Data Pelamar</span></a>
            </li>
            <!-- Nav Item - Tables -->
            <li class="nav-item <?= $_SESSION['menu'] == 'kriteria' ? 'active':'';?>">
                <a class="nav-link" href="./kriteria.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Kriteria</span></a>
                <!-- Nav Item - Tables -->
            <li class="nav-item <?= $_SESSION['menu'] == 'sub-kriteria' ? 'active':'';?>">
                <a class="nav-link" href="./sub_kriteria.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Sub Kriteria</span></a>
            </li>
            <li class="nav-item <?= $_SESSION['menu'] == 'users' ? 'active':'';?>">
                <a class="nav-link" href="./user.php">
                    <i class="fas fa-user"></i>
                    <span>Data user</span></a>
            </li>
            <li class="nav-item <?= $_SESSION['menu'] == 'setting' ? 'active':'';?>">
                <a class="nav-link" href="./setting.php">
                    <i class="fa fa-cog"></i>
                    <span>Setting</span></a>
            </li>
            <?php endif;?>
            <!-- data pelamar koordinator rayon -->
            <?php if($_SESSION['level'] == 1): ?>
            <li
                class="nav-item <?= $_SESSION['menu'] == 'verifikasi' || $_SESSION['menu'] == 'belum-verifikasi' ? 'active':'';?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-user"></i>
                    <span>Data Pelamar</span></a>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item <?= $_SESSION['menu'] == 'verifikasi' ? 'active':'';?>"
                            href="verifikasi.php">Terverifikasi <strong class="text-white bg-primary"
                                style="border-radius:100%; padding:1px 5px;"><?=$countVerifikasi['jumlah'];?></strong></a>
                        <a class="collapse-item <?= $_SESSION['menu'] == 'belum-verifikasi' ? 'active':'';?>"
                            href="belum_verifikasi.php">Belum Verifikasi <strong class="text-white bg-primary"
                                style="border-radius:100%; padding:1px 5px;"><?=$countBelumVerifikasi['jumlah'];?></strong></a>
                    </div>
                </div>
            </li>
            <?php endif;?>
            <li class="nav-item">
                <a class="nav-link" href="../auth/logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block" />

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- notifikasi -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">Alerts Center</h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for
                                        your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>
                        <!-- end notifikasi -->
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-none d-lg-inline text-gray-600 small"><?=$_SESSION['username'];?></span>
                                <img class="rounded-circle ml-2" style="width:30px; height:30px;"
                                    src="../assets/img/undraw_profile_2.svg" />
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../auth/logout.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>

                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <!-- <h1 class="h3 mb-0 text-gray-800">Dashboard</h1> -->
                        <!-- <a
                href="#"
                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
                ><i class="fas fa-download fa-sm text-white-50"></i> Generate
                Report</a
              > -->
                    </div>
                    <!-- Content Row -->