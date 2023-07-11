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

$data_pelamar = $Verifikasi->getPelamarBelumVerifikasi();
?>

<div class="row">
    <!-- Area Chart -->
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="justify-content-center p-5">
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
                                    <td><?=$pelamar['jenjang'];?></td>
                                    <td>
                                        <a href="./verifikasi_data.php?id_pel=<?=base64_encode(urlencode($pelamar['id_pelamar']));?>&id_log=<?=base64_encode(urlencode($pelamar['f_id_login']));?>"
                                            class="btn btn-sm btn-primary">
                                            Verifikasi
                                        </a>
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