<?php 
session_start();
if($_SESSION['level'] != 1){
    header("Location: ./index.php");
}
unset($_SESSION['menu']);
$_SESSION['menu'] = 'belum-verifikasi';
require_once './header.php';
require_once './functions/data_pelamar.php';
require_once './functions/verifikasi.php';
require_once './functions/setting.php';

$data_pelamar = $Verifikasi->getPelamarBelumVerifikasi($_SESSION['id_rayon']);
$periodeActive = $Setting->getPeriodeActive($_SESSION['id_periode']);

?>

<div class="row">
    <!-- Area Chart -->
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="justify-content-center p-5">
                <?php
                    // Tanggal dalam format asli
                    $originalDate = $periodeActive['batas_buka'];

                    // Mengonversi tanggal ke format yang diinginkan
                    $newDate = date('d F Y H:i:s', strtotime($originalDate));

                    if($periodeActive['status'] == 'buka'){
                        // Menampilkan tanggal dalam <marquee>
                        echo "<marquee class='text-danger' behavior=\"\" direction=\"\">Waktu verifikasi untuk periode ".$periodeActive['nama_periode']." akan berakhir pada $newDate</marquee>";
                    }else{
                        // Menampilkan tanggal dalam <marquee>
                        echo "<marquee class='text-danger' behavior=\"\" direction=\"\">Waktu verifikasi untuk periode ".$periodeActive['nama_periode']." telah berakhir pada $newDate</marquee>";
                    }
                ?>

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Belum Terverifikasi</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Asal Sekolah</th>
                                    <th>Rayon</th>
                                    <th>Jenjang</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data_pelamar as $key => $pelamar):?>
                                <tr>
                                    <th scope="row"><?=$key+1;?></th>
                                    <td><?=$pelamar['nama'];?></td>
                                    <td><?=$pelamar['sekolah'];?></td>
                                    <td><?=$pelamar['nama_rayon'];?></td>
                                    <td><?= $pelamar['jenjang'] == 'pt'?'Perguruan Tinggi':'SMA/SMK Sederajat';?></td>
                                    <td>
                                        <?php if($periodeActive['status'] != 'tutup'):?>
                                        <a href="./verifikasi_data.php?id_pel=<?=base64_encode(urlencode($pelamar['id_pelamar']));?>&id_log=<?=base64_encode(urlencode($pelamar['f_id_login']));?>"
                                            class="btn btn-sm btn-primary">
                                            Verifikasi
                                        </a>
                                        <?php else:?>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="orange"
                                            class="bi bi-exclamation-circle-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                        </svg> <small><i>Waktu Verifikasi Habis</i></small>
                                        <?php endif;?>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require './footer.php';?>