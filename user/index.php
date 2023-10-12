<?php 
session_start();
unset($_SESSION['menu']);
$_SESSION['menu'] = 'index';
require '../includes/header.php';
require_once './functions/data-diri.php';
require_once '../admin/functions/setting.php';

$periodeActive = $Setting->getPeriodeActive($_SESSION['id_periode']);

$cekDataPelamar = $dataDiri->cekDataPelamar($_SESSION['id_user']);
$fecthDataPelamar = mysqli_fetch_assoc($cekDataPelamar);
$num_rows = 0;

if(mysqli_num_rows($cekDataPelamar) > 0){
    $id_pelamar = $fecthDataPelamar['id_pelamar'];
    $cekPelamarKriteria = $dataDiri->cekPelamarKriteria($id_pelamar);
    $fetchPelamarKriteria = mysqli_fetch_assoc($cekPelamarKriteria);
    $num_rows = mysqli_num_rows($cekPelamarKriteria);
}
?>

<div class="row d-flex justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow mb-4">
            <div class="card-body flex-row align-items-center"
                style="font-family: 'Lato', sans-serif; padding: 60px 60px">
                <?php
                    // Tanggal dalam format asli
                    $originalDate = $periodeActive['batas_pelamar'];

                    // Mengonversi tanggal ke format yang diinginkan
                    $newDate = date('d F Y H:i:s', strtotime($originalDate));

                    if($periodeActive['status'] == 'buka'){
                        // Menampilkan tanggal dalam <marquee>
                        echo "<marquee class='text-danger' behavior=\"\" direction=\"\">Penting: Batas pengajuan beasiswa untuk periode ".$periodeActive['nama_periode']." akan berakhir pada $newDate WITA</marquee>";
                    }else{
                        // Menampilkan tanggal dalam <marquee>
                        echo "<marquee class='text-danger' behavior=\"\" direction=\"\">Penting: Batas pengajuan beasiswa untuk periode ".$periodeActive['nama_periode']." telah berakhir pada $newDate WITA</marquee>";
                    }
                ?>
                <h1 class="text-end">SPK Seleksi Beasiswa GMIT Paulus Kupang</h1>
                <p class="text-end text-justify mt-4">Shalom, selamat datang di website "Sistem pendukung keputusan
                    seleksi calon
                    Penerima Beasiswa GMIT Paulus Kupang".</p>
                <p class="text-end text-justify mt-n2">Website ini berguna untuk menyeleksi calon penerima beasiswa GMIT
                    Paulus
                    Kupang sesuai dengan kriteria yang ditentukan oleh badan Diakonat GMIT Paulus Kupang.</p>
                <p class="text-end text-justify mt-n2">
                    Setiap pelamar diharapkan mengisi data yang aktual untuk menunjang proses seleksi.
                    Data yang telah dimasukan akan diverifikasi kembali oleh koordinator rayon/badan diakonat,
                    untuk itu pastikan data anda sudah sesuai.</p>
                <?php if(mysqli_num_rows($cekDataPelamar) < 1) :?>
                <div class="alert alert-warning" role="alert">
                    <p class="text-end">Saat ini data anda belum lengkap silahkan <a href="./data_diri.php"
                            class="text-primary">lengkapi</a>
                        terlebih
                        dahulu.</p>
                </div>
                <?php endif;?>

                <p class="text-end mt-3">
                    Terima kasih Tuhan Yesus memberkati.</p>
            </div>
        </div>
    </div>
</div>

<?php require '../includes/footer.php';?>