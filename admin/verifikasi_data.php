<?php 
session_start();
if($_SESSION['level'] != 1){
    header("Location: ./index.php");
}
unset($_SESSION['menu']);
$_SESSION['menu'] = 'verifikasi-data';
require_once './header.php';
require_once './functions/data-diri.php';
require_once './functions/notifikasi.php';
require_once './functions/data_pelamar.php';
require_once './functions/pesan.php';
require_once './functions/pdt.php';
require_once './functions/verifikasi.php';

// $data_pelamar = $dataPelamar->getPelamar();
// jika pengajuan beasiswa
if(isset($_GET['id_pel']) && isset($_GET['id_log']) && isset($_GET['n'])){
    $id_pelamar = base64_decode($_GET['id_pel']);
    $id_login = base64_decode($_GET['id_log']);
    $id_notif = base64_decode($_GET['n']);
    
    if($id_notif != null && $id_login != null){
        // update notif
        $Notifikasi->updateNotif($id_notif);
        // cek verifikasi 
        $cekVerifikasiUser = $Verifikasi->cekVerifikasiUser($id_login,$_SESSION['id_rayon']);
        if($cekVerifikasiUser['status'] == 1){
            echo '<script>window.location.href = "./verifikasi.php";</script>';
        }else if($cekVerifikasiUser['status'] == 0){
            echo '<script>window.location.href = "./belum_verifikasi.php";</script>';
        }
    }
    
}
else if(isset($_GET['id_pel']) && isset($_GET['id_log'])){
    if(isset($_GET['n'])){
        $id_notif = base64_decode($_GET['n']);
        $Notifikasi->updateNotif($id_notif);
    }
    $id_pelamar = base64_decode($_GET['id_pel']);
    $id_login = base64_decode($_GET['id_log']);
    // cek verifikasi 
    $cekVerifikasiUser = $Verifikasi->cekVerifikasiUser($id_login,$_SESSION['id_rayon']);
    $cekDataPelamar = $dataDiri->cekDataPelamar($id_login,$_SESSION['id_rayon']);
    $fecthDataPelamar = mysqli_fetch_assoc($cekDataPelamar);
}else{
    if(isset($_GET['n'])){
        $id_notif = base64_decode($_GET['n']);
        $Notifikasi->updateNotif($id_notif);
    }
    $id_login = base64_decode($_GET['id_log']);
    $cekVerifikasiUser = $Verifikasi->cekVerifikasiUser($id_login,$_SESSION['id_rayon']);
    $cekDataPelamar = $dataDiri->cekDataPelamar($id_login,$_SESSION['id_rayon']);
    $fecthDataPelamar = mysqli_fetch_assoc($cekDataPelamar);
}



$num_rows = 0;

if(mysqli_num_rows($cekDataPelamar) > 0){
    $cekPelamarKriteria = $dataDiri->cekPelamarKriteria($id_login);
    $fetchPelamarKriteria = mysqli_fetch_assoc($cekPelamarKriteria);
    $num_rows = mysqli_num_rows($cekPelamarKriteria);
}

// kirim pesan
if(isset($_POST['kirim-pesan'])){
    $f_id_penerima = htmlspecialchars($_POST['id_penerima']);
    $isi_pesan = htmlspecialchars($_POST['isi_pesan']);
    $id_pengirim = $_SESSION['id_user'];
    $pesan = [
        'f_id_penerima' => $f_id_penerima,
        'f_id_pengirim' =>$id_pengirim,
        'isi_pesan' => $isi_pesan,
    ];
    $Pesan->kirimPesan($pesan);
}

// $fecthK6 = mysqli_fetch_assoc($dataDiri->getK6()); 
// $fecthK7 = mysqli_fetch_assoc($dataDiri->getK7()); 
// $fecthK8 = mysqli_fetch_assoc($dataDiri->getK8()); 


// verifikasi
if(isset($_POST['lengkap'])){
    $data = [
        $_POST['kriteria'][0] => $_POST['sub_kriteria'][0],
        $_POST['kriteria'][1] => $_POST['sub_kriteria'][1],
        $_POST['kriteria'][2] => $_POST['sub_kriteria'][2],
        $_POST['kriteria'][3] => $_POST['sub_kriteria'][3],
        $_POST['kriteria'][4] => $_POST['sub_kriteria'][4],
        $_POST['kriteria'][5] => $_POST['sub_kriteria'][5],
        $_POST['kriteria'][6] => $_POST['sub_kriteria'][6],
    ];
    
    $PDT->addPdt($data,$_POST['f_id_login'],$_POST['id_pelamar'],$_SESSION['id_user']);
}
?>

<?php if (isset($_SESSION['success'])): ?>
<script>
var success = '<?php echo $_SESSION["success"]; ?>';
Swal.fire({
    title: 'Success!',
    text: success,
    icon: 'success',
    confirmButtonText: 'OK'
}).then(function(result) {
    if (result.isConfirmed) {
        window.location.href = '';
    }
});
</script>
<?php unset($_SESSION['success']); // Menghapus session setelah ditampilkan ?>
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
<script>
var error = '<?php echo $_SESSION["error"]; ?>';
Swal.fire({
    title: 'Error!',
    text: error,
    icon: 'error',
    confirmButtonText: 'OK'
}).then(function(result) {
    if (result.isConfirmed) {
        window.location.href = '';
    }
});
</script>
<?php unset($_SESSION['error']); // Menghapus session setelah ditampilkan ?>
<?php endif; ?>
<div class="row d-flex justify-content-center">
    <div class="col-lg-3">
        <div class="card shadow mb-4">
            <form action="" method="post">
                <?php if(mysqli_num_rows($cekDataPelamar) != 1): ?>
                <img src="../assets/images/no_images.png" style="height:250px;" class="card-img-top" alt="...">
                <?php else:?>
                <img src="../user/uploads/profil/<?=$fecthDataPelamar['foto'];?>" style="height:250px;"
                    class="card-img-top" alt="...">
                <?php endif;?>
                <div class="card-body" style="font-family: 'Lato', sans-serif;">
                    <table>
                        <tr>
                            <input type="hidden"
                                value="<?= isset($fecthDataPelamar['id_pelamar']) ? $fecthDataPelamar['id_pelamar']:'-';?>"
                                name="id_pelamar">
                            <input type="hidden"
                                value="<?= isset($fecthDataPelamar['f_id_login']) ? $fecthDataPelamar['f_id_login']:'-';?>"
                                name="f_id_login">
                            <td>Nama</td>
                            <td>: </td>
                            <td> <?= isset($fecthDataPelamar['nama']) ? $fecthDataPelamar['nama']:'-';?></td>
                        </tr>
                        <tr>
                            <td>Sekolah/PT</td>
                            <td>: </td>
                            <td> <?= isset($fecthDataPelamar['sekolah']) ? $fecthDataPelamar['sekolah']: '-';?></td>
                        </tr>
                        <tr>
                            <td>Jurusan</td>
                            <td>: </td>
                            <td> <?= isset($fecthDataPelamar['jurusan']) ? $fecthDataPelamar['jurusan']:'-';?></td>
                        </tr>
                        <tr>
                            <td>No HP</td>
                            <td>: </td>
                            <td><?= isset($fecthDataPelamar['no_hp']) ? $fecthDataPelamar['no_hp']:'-';?></td>
                        </tr>
                    </table>
                </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-body">
                <?php if(isset($cekVerifikasiUser['status']) && $cekVerifikasiUser['status'] != 1):?>
                <div class="alert alert-warning" role="alert">
                    <small>
                        <strong>Jika data belum lengkap silahkan kirim pesan kepada pelamar melalui No WA/menu Kirim
                            pesan yang tersedia untuk pelamar melengkapi data
                            diri.</strong>
                    </small>
                </div>
                <div class="mt-n4 d-flex justify-content-center flex-row align-items-center"
                    style="font-family: 'Lato', sans-serif; padding: 20px 20px">
                    <?php else:?>
                    <div class="d-flex justify-content-center flex-row align-items-center"
                        style="font-family: 'Lato', sans-serif; padding: 20px 20px">
                        <?php endif;?>
                        <table style="width:100%">
                            <?php if(mysqli_num_rows($cekDataPelamar) > 0):?>
                            <?php foreach ($cekPelamarKriteria as $key => $pelamar_kriteria) :?>
                            <tr class="border-bottom">
                                <input type="hidden" name="kriteria[]" value="<?=$pelamar_kriteria['id_kriteria'];?>">
                                <td><?= $pelamar_kriteria['nama_kriteria'];?></td>
                                <td>: </td>
                                <input type="hidden" name="sub_kriteria[]"
                                    value="<?=$pelamar_kriteria['id_sub_kriteria'];?>">
                                <td><?= $pelamar_kriteria['nama_sub_kriteria'];?></td>
                            </tr>
                            <?php endforeach;?>
                            <tr class="border-bottom">
                                <td>Rayon</td>
                                <td>: </td>
                                <td> <?=$fecthDataPelamar['nama_rayon'];?></td>
                            </tr>
                            <tr class="border-bottom">
                                <td>Kartu Keluarga <small><i>(jpg, png, jpeg)</i></small></td>
                                <td>: </td>
                                <td><a href="../user/uploads/berkas/<?=$fecthDataPelamar['kartu_keluarga'];?>">
                                        <img style="width:100px;height:100px;"
                                            src="../user/uploads/berkas/<?=$fecthDataPelamar['kartu_keluarga'];?>"
                                            alt="">
                                    </a>
                                </td>
                            </tr>
                            <tr class="border-bottom">
                                <td>Suket Beasiswa Lain <small><i>(jpg, png, jpeg)</i></small></td>
                                <td>: </td>
                                <td><a href="../user/uploads/berkas/<?=$fecthDataPelamar['s_beasiswa_lain'];?>">
                                        <img style="width:100px;height:100px;"
                                            src="../user/uploads/berkas/<?=$fecthDataPelamar['s_beasiswa_lain'];?>"
                                            alt="">
                                    </a>
                                </td>
                            </tr>
                            <tr class="border-bottom">
                                <td>Raport/KHS <small><i>(jpg, png, jpeg)</i></small></td>
                                <td>: </td>
                                <td><a href="../user/uploads/berkas/<?=$fecthDataPelamar['raport_khs'];?>">
                                        <img style="width:100px;height:100px;"
                                            src="../user/uploads/berkas/<?=$fecthDataPelamar['raport_khs'];?>" alt="">
                                    </a>
                                </td>
                            </tr>
                            <?php else:?>
                            <tr class="border-bottom">
                                <td>Status Jemaat</td>
                                <td>: </td>
                                <td>-</td>
                            </tr>
                            <tr class="border-bottom">
                                <td>Keaktifan kegiatan bergereja</td>
                                <td>: </td>
                                <td>-</td>
                            </tr>
                            <tr class="border-bottom">
                                <td>Status keluarga</td>
                                <td>: </td>
                                <td>-</td>
                            </tr>
                            <tr class="border-bottom">
                                <td>Pendapatan orang tua</td>
                                <td>: </td>
                                <td>-</td>
                            </tr>
                            <tr class="border-bottom">
                                <td>Jumlah tanggungan orang tua</td>
                                <td>: </td>
                                <td>-</td>
                            </tr>
                            <tr class="border-bottom">
                                <td>IPK/Nilai Raport</td>
                                <td>: </td>
                                <td> - </td>
                            </tr>
                            <tr class="border-bottom">
                                <td>Semester</td>
                                <td>: </td>
                                <td> - </td>
                            </tr>
                            <tr class="border-bottom">
                                <td>Rayon</td>
                                <td>: </td>
                                <td> - </td>
                            </tr>
                            <tr class="border-bottom">
                                <td>Kartu Keluarga <small><i>(jpg, png, jpeg)</i></small></td>
                                <td>: </td>
                                <td><a href="../assets/images/no_images.png">
                                        <img style="width:100px;height:100px;" src="../assets/images/no_images.png"
                                            alt="">
                                    </a>
                                </td>
                            </tr>
                            <tr class="border-bottom">
                                <td>Suket Beasiswa Lain <small><i>(jpg, png, jpeg)</i></small></td>
                                <td>: </td>
                                <td><a href="../assets/images/no_images.png">
                                        <img style="width:100px;height:100px;" src="../assets/images/no_images.png"
                                            alt="">
                                    </a>
                                </td>
                            </tr>
                            <tr class="border-bottom">
                                <td>Raport/KHS <small><i>(jpg, png, jpeg)</i></small></td>
                                <td>: </td>
                                <td><a href="../assets/images/no_images.png">
                                        <img style="width:100px;height:100px;" src="../assets/images/no_images.png"
                                            alt="">
                                    </a>
                                </td>
                            </tr>
                            <?php endif;?>

                        </table>
                    </div>
                    <div class="d-flex justify-content-center mb-4">
                        <a href="./belum_verifikasi.php" class="btn btn-secondary">
                            Kembali
                        </a>
                        <?php if(isset($cekVerifikasiUser['status']) && $cekVerifikasiUser['status'] != 1):?>
                        <button type="submit" name="lengkap" class="btn btn-primary ml-2">
                            Simpan
                        </button>
                        <?php endif;?>
                        <button type="button" class="btn btn-info ml-2" data-toggle="modal" data-target="#pesan">
                            Kirim pesan
                        </button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- modal pesan -->
    <!-- Modal -->
    <div class="modal fade" id="pesan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pesan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Penerima :
                                <?= isset($fecthDataPelamar['nama']) ? $fecthDataPelamar['nama']:'-';?></label>
                            <input type="hidden" name="id_penerima"
                                value="<?= isset($fecthDataPelamar['f_id_login']) ? $fecthDataPelamar['f_id_login']:'-';?>"
                                class="form-control" id="exampleFormControlInput1">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Pesan</label>
                            <textarea name="isi_pesan" class="form-control" id="exampleFormControlTextarea1"
                                rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        <button type="submit" name="kirim-pesan" class="btn btn-primary">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php require './footer.php';?>