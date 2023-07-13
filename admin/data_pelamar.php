<?php 
session_start();
unset($_SESSION['menu']);
require_once './functions/data_pelamar.php';
if($_SESSION['level'] == 1){
    $_SESSION['menu'] = 'belum-verifikasi';
    $data_pelamar = $dataPelamar->getPelamar();
}else if($_SESSION['level'] == 0){
    $_SESSION['menu'] = 'pelamar';
    $data_pelamar = $dataPelamar->getAllPelamar();
}
require_once './header.php';

?>

<div class="row">
    <!-- Area Chart -->
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="justify-content-center p-5">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Pelamar</h6>
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
                                    <th><?=$pelamar['nama'];?></th>
                                    <td><?=$pelamar['sekolah'];?></td>
                                    <td><?=$pelamar['nama_rayon'];?></td>
                                    <td><?=$pelamar['jenjang'];?></td>
                                    <td>Hapus</td>
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