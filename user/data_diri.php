<?php 
session_start();
unset($_SESSION['menu']);
$_SESSION['menu'] = 'data-diri';
require_once '../includes/header.php';
require_once './functions/rayon.php';
require_once './functions/data-diri.php';

$dataRayon = $Rayon->getRayon();
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
            <?php if(mysqli_num_rows($cekDataPelamar) != 1): ?>
            <img src="../assets/images/no_images.png" style="height:250px;" class="card-img-top" alt="...">
            <?php else:?>
            <img src="./uploads/profil/<?=$fecthDataPelamar['foto'];?>" style="height:250px;" class="card-img-top"
                alt="...">
            <?php endif;?>
            <div class="card-body" style="font-family: 'Lato', sans-serif;">
                <table>
                    <tr>
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
        <div class="col-lg-12">
            <div class="d-flex justify-content-center mb-4">
                <?php if(($num_rows != 5)):?>
                <a href="./add-data-diri.php" class="btn btn-primary">
                    Tambah Data
                </a>
                <?php else:?>
                <a href="./edit-data-diri.php" class="btn btn-secondary ml-2">
                    Edit Data
                </a>
                <?php endif;?>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="alert alert-info" role="alert">
                    <small>
                        <strong>Untuk surat aktif sekolah, surat keterangan tidak sedang menerima beasiswa lain dan
                            Raport/KHS,
                            discan dan diupload berupa file gambar (jpg/jpeg/png).</strong>
                    </small>
                </div>
                <div class="mt-n4 d-flex justify-content-center flex-row align-items-center"
                    style="font-family: 'Lato', sans-serif; padding: 20px 20px">
                    <table style="width:100%">
                        <?php if(mysqli_num_rows($cekDataPelamar) > 0):?>
                        <?php foreach ($cekPelamarKriteria as $key => $pelamar_kriteria) :?>
                        <tr class="border-bottom">
                            <td><?= $pelamar_kriteria['nama_kriteria'];?></td>
                            <td>: </td>
                            <td><?= $pelamar_kriteria['nama_sub_kriteria'];?></td>
                        </tr>
                        <?php endforeach;?>
                        <tr class="border-bottom">
                            <td>Rayon</td>
                            <td>: </td>
                            <td> <?=$fecthDataPelamar['nama_rayon'];?></td>
                        </tr>
                        <tr class="border-bottom">
                            <td>Surat Aktif Sekolah <small><i>(jpg, png, jpeg)</i></small></td>
                            <td>: </td>
                            <td>
                                <a href="./uploads/berkas/<?=$fecthDataPelamar['s_aktif_sekolah'];?>">
                                    <img style="width:100px;height:100px;"
                                        src="./uploads/berkas/<?=$fecthDataPelamar['s_aktif_sekolah'];?>" alt="">
                                </a>
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <td>Suket Beasiswa Lain <small><i>(jpg, png, jpeg)</i></small></td>
                            <td>: </td>
                            <td><a href="./uploads/berkas/<?=$fecthDataPelamar['s_beasiswa_lain'];?>">
                                    <img style="width:100px;height:100px;"
                                        src="./uploads/berkas/<?=$fecthDataPelamar['s_beasiswa_lain'];?>" alt="">
                                </a>
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <td>Raport/KHS <small><i>(jpg, png, jpeg)</i></small></td>
                            <td>: </td>
                            <td><a href="./uploads/berkas/<?=$fecthDataPelamar['raport_khs'];?>">
                                    <img style="width:100px;height:100px;"
                                        src="./uploads/berkas/<?=$fecthDataPelamar['raport_khs'];?>" alt="">
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
                            <td>Rayon</td>
                            <td>: </td>
                            <td> - </td>
                        </tr>
                        <tr class="border-bottom">
                            <td>Surat Aktif Sekolah <small><i>(jpg, png, jpeg)</i></small></td>
                            <td>: </td>
                            <td>
                                <a href="../assets/images/no_images.png">
                                    <img style="width:100px;height:100px;" src="../assets/images/no_images.png" alt="">
                                </a>
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <td>Suket Beasiswa Lain <small><i>(jpg, png, jpeg)</i></small></td>
                            <td>: </td>
                            <td><a href="../assets/images/no_images.png">
                                    <img style="width:100px;height:100px;" src="../assets/images/no_images.png" alt="">
                                </a>
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <td>Raport/KHS <small><i>(jpg, png, jpeg)</i></small></td>
                            <td>: </td>
                            <td><a href="../assets/images/no_images.png">
                                    <img style="width:100px;height:100px;" src="../assets/images/no_images.png" alt="">
                                </a>
                            </td>
                        </tr>
                        <?php endif;?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama">Nama Lengkap <small class="text-danger">*</small></label>
                        <input class="form-control form-control-sm" name="nama" type="text" placeholder="Nama">
                    </div>
                    <div class="form-group">
                        <label for="sekolah">Nama Sekolah/PT <small class="text-danger">*</small></label>
                        <input class="form-control form-control-sm" name="sekolah" type="text"
                            placeholder="Nama Sekolah/PT">
                    </div>
                    <div class="form-group">
                        <label for="jurusan">Jurusan <small class="text-danger">*</small></label>
                        <input class="form-control form-control-sm" name="jurusan" type="text"
                            placeholder="Jurusan sekolah/PT">
                    </div>
                    <div class="form-group">
                        <label for="no_hp">No HP <small class="text-danger">*</small></label>
                        <input class="form-control form-control-sm" name="no_hp" type="number" placeholder="Nomor HP">
                    </div>
                    <div class="form-group">
                        <label for="foto" class="form-label">Foto Profil <small class="text-danger">*</small></label>
                        <input type="file" accept=".jpg, .jpeg, .png" class="form-control" name="foto" id="foto"
                            required placeholder="Foto profil anda" />
                    </div>
                    <div class="form-group">
                        <label for="Rayon">Rayon <small class="text-danger">*</small></label>
                        <select class="form-control form-control-sm" name="id_rayon" id="Rayon">
                            <option value="">-- Pilih Rayon --</option>
                            <?php foreach ($dataRayon as $key => $koordinator_rayon):?>
                            <option value="<?=$koordinator_rayon['id_rayon'];?>">
                                <?=$koordinator_rayon['nama_rayon'];?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" name="tambah-koordinator" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require '../includes/footer.php';?>