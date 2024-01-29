<?php 
session_start();
unset($_SESSION['menu']);
$_SESSION['menu'] = 'perhitungan';
require_once './header.php';
require_once './functions/perhitungan.php';
require_once './functions/pesan.php';
require_once './functions/setting.php';

$jumlahKuotaSMA = 0;
$jumlahKuotaPT = 0;
$numRowsSMA = 0;
$numRowsPT = 0;
$dataPeriode = $Setting->getPeriode($_SESSION['id_periode']);
if($dataPeriode != null){
    $fetchDataPeriode = mysqli_fetch_assoc($dataPeriode);
    $jumlahKuotaSMA = $fetchDataPeriode['kuota_sma'];
    $jumlahKuotaPT = $fetchDataPeriode['kuota_pt'];
}
$rankingSMA = $Perhitungan->perengkingan('sma',$_SESSION['id_periode']);
$rankingPT = $Perhitungan->perengkingan('pt',$_SESSION['id_periode']);
if($rankingSMA != null){
    $numRowsSMA = count($rankingSMA);
}
if($rankingPT != null){
    $numRowsPT = count($rankingPT);
}
 

$hasilAkhirSMA = $Perhitungan->getHasilAkhir($_SESSION['id_periode'],'sma');
$hasilAkhirPT = $Perhitungan->getHasilAkhir($_SESSION['id_periode'],'pt');


$i = 1;


if(isset($_POST['simpan-sma'])){
    $combinedArray = array();
    $tampungArray = array(); // Array untuk tampung data gabungan

    for ($i = 0; $i < count($_POST['id_pelamar']); $i++) {
        $idPelamar = $_POST['id_pelamar'][$i];
        $nilaiRank = $_POST['nilai_rank'][$i];
        $terima = $_POST['terima'][$i];
        if($terima == '1'){
            $tampungArray[] = array(
                'id_pelamar' => $idPelamar,
                'nilai_rank' => $nilaiRank,
                'f_id_periode' => $_SESSION['id_periode'],
                'jenjang' => "sma"
            );
        }
    }

    if($jumlahKuotaSMA <= $numRowsSMA){
        if(count($tampungArray) > 0){
            for ($j = 0; $j < $jumlahKuotaSMA; $j++) {
                    $combinedArray[] = array(
                        'id_pelamar' => $tampungArray[$j]['id_pelamar'],
                        'nilai_rank' => $tampungArray[$j]['nilai_rank'],
                        'f_id_periode' => $tampungArray[$j]['f_id_periode'],
                        'jenjang' => $tampungArray[$j]['jenjang']
                    );
            }
            $Perhitungan->simpanHasil($combinedArray);
        } 
        else{
            $_SESSION['error'] = "Jumlah pelamar belum mencukupi kuota!";
        }       
    }else{
        $_SESSION['error'] = "Jumlah pelamar belum mencukupi kuota!";
    }
}

if(isset($_POST['simpan-pt'])){
    $combinedArray = array(); // Array untuk menyimpan data gabungan
    $tampungArray = array(); // Array untuk tampung data gabungan

    for ($i = 0; $i < count($_POST['id_pelamar']); $i++) {
        $idPelamar = $_POST['id_pelamar'][$i];
        $nilaiRank = $_POST['nilai_rank'][$i];
        $terima = $_POST['terima'][$i];
        if($terima == '1'){
            $tampungArray[] = array(
                'id_pelamar' => $idPelamar,
                'nilai_rank' => $nilaiRank,
                'f_id_periode' => $_SESSION['id_periode'],
                'jenjang' => "pt"
            );
        }
    }

    if(($jumlahKuotaPT <= $numRowsPT)){
        if(count($tampungArray) > 0){
            for ($j = 0; $j < $jumlahKuotaPT; $j++) {           
                $combinedArray[] = array(
                    'id_pelamar' => $tampungArray[$j]['id_pelamar'],
                    'nilai_rank' => $tampungArray[$j]['nilai_rank'],
                    'f_id_periode' => $tampungArray[$j]['f_id_periode'],
                    'jenjang' => $tampungArray[$j]['jenjang']
                );
                $Perhitungan->simpanHasil($combinedArray);
            }
        }
        else{
            $_SESSION['error'] = "Jumlah pelamar belum mencukupi kuota!";
        }
    }else{
        $_SESSION['error'] = "Jumlah pelamar belum mencukupi kuota!";
    }
}


if(isset($_POST['tolak-sma'])){
    $id_pelamar = htmlspecialchars($_POST['id_pelamar']);
    $id_periode = htmlspecialchars($_POST['id_periode']);
    $pesan_sma = htmlspecialchars($_POST['pesan_sma']);
    if($id_pelamar != "" && $id_periode != ""){
        $data = array(
            'id_pelamar' => $id_pelamar,
            'id_periode' => $id_periode
        );
        if($pesan_sma != NULL || $pesan_sma != ""){
            $dataId = $koneksi->query("SELECT f_id_login FROM data_pelamar WHERE id_pelamar='$id_pelamar'")->fetch_assoc();
            $id_pengirim = $_SESSION['id_user'];
            $pesan = [
                'f_id_penerima' => $dataId['f_id_login'],
                'f_id_pengirim' =>$id_pengirim,
                'isi_pesan' => $pesan_sma,
            ];
            $Pesan->kirimPesan($pesan);
        }
        $Perhitungan->tolak($data);
    }else{
        $_SESSION['error'] = "Tidak ada data yang dikirim";
    }
}

if(isset($_POST['tolak-pt'])){
    $id_pelamar = htmlspecialchars($_POST['id_pelamar']);
    $id_periode = htmlspecialchars($_POST['id_periode']);
    $pesan_pt = htmlspecialchars($_POST['pesan_pt']);
    if($id_pelamar != "" && $id_periode != ""){
        $data = array(
            'id_pelamar' => $id_pelamar,
            'id_periode' => $id_periode
        );
        if($pesan_pt != NULL || $pesan_pt != ""){
            $dataId = $koneksi->query("SELECT f_id_login FROM data_pelamar WHERE id_pelamar='$id_pelamar'")->fetch_assoc();
            $id_pengirim = $_SESSION['id_user'];
            $pesan = [
                'f_id_penerima' => $dataId['f_id_login'],
                'f_id_pengirim' =>$id_pengirim,
                'isi_pesan' => $pesan_pt,
            ];
            $Pesan->kirimPesan($pesan);
        }
        $Perhitungan->tolak($data);
    }else{
        $_SESSION['error'] = "Tidak ada data yang dikirim";
    }
}


// foreach ($ranking as $key => $value) {
//     echo ($i++) . ". " . $value['nama'] . " - Nilai Akhir: " . $value['nilaiAkhir'] . "<br>";
// }
$j = 1;
$k = 1;

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
<div class="row">
    <!-- Area Chart -->
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="justify-content-center p-5">
                <form action="" method="post">
                    <?php if($rankingSMA != null && mysqli_num_rows($hasilAkhirSMA) < 1):?>
                    <?php foreach ($rankingSMA as $key => $rank):?>
                    <input type="hidden" name="id_pelamar[]" value="<?=$rank['id_pelamar']?>">
                    <input type="hidden" name="nilai_rank[]" value="<?=$rank['nilaiAkhir']?>">
                    <input type="hidden" name="terima[]" value="<?=$rank['terima']?>">
                    <?php endforeach;?>
                    <button type="submit" name="simpan-sma" class="btn btn-primary mb-2">
                        Simpan Hasil
                    </button>
                    <?php endif;?>
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Hasil Perhitungan (SMA)</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered nowrap" id="hasil-sma" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Rayon</th>
                                        <th>Status jemaat</th>
                                        <th>Keaktifan kegiatan bergereja</th>
                                        <th>Status keluarga</th>
                                        <th>Pendapatan orang tua/wali</th>
                                        <th>Jumlah tanggungan orang tua/wali</th>
                                        <th>IPK/Nilai Raport</th>
                                        <th>Kelas</th>
                                        <th>Kartu Keluarga</th>
                                        <th>Raport/KHS</th>
                                        <th>Kartu Pelajar/KTM</th>
                                        <th>Nilai Akhir</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rankingSMA as $key => $rank):?>
                                    <input type="hidden" name="id_pelamar[]" value="<?=$rank['id_pelamar']?>">
                                    <input type="hidden" name="nilai_rank[]" value="<?=$rank['nilaiAkhir']?>">
                                    <tr>
                                        <th scope="row"><?=$j++;?>. </th>
                                        <th><?=$rank['nama'];?></th>
                                        <th><?=$rank['nama_rayon'];?></th>
                                        <th><?=$rank['kriteriaSatu'];?></th>
                                        <th><?=$rank['kriteriaDua'];?></th>
                                        <th><?=$rank['kriteriaTiga'];?></th>
                                        <th>Rp.<?=$rank['pendapatan_ortu'];?></th>
                                        <th><?=$rank['kriteriaLima'];?></th>
                                        <th><?=$rank['ipk'];?></th>
                                        <th><?= explode("/",$rank['kriteriaTujuh'])[1];?></th>
                                        <td>
                                            <?php if($rank['kartu_keluarga'] == "" || $rank['kartu_keluarga'] == NULL): ?>
                                            <img src="../assets/images/no_images.png" style="height:90px; width:90px;"
                                                class="card-img" alt="...">
                                            <?php else:?>
                                            <a href="../user/uploads/berkas/<?=$rank['kartu_keluarga'];?>"
                                                target="_blank">
                                                <img src="../user/uploads/berkas/<?=$rank['kartu_keluarga'];?>"
                                                    style="height:90px; width:90px;" class="card-img" alt="...">
                                            </a>
                                            <?php endif;?>
                                        </td>
                                        <td>
                                            <?php if($rank['raport_khs'] == "" || $rank['raport_khs'] == NULL): ?>
                                            <img src="../assets/images/no_images.png" style="height:90px; width:90px;"
                                                class="card-img" alt="...">
                                            <?php else:?>
                                            <a href="../user/uploads/berkas/<?=$rank['raport_khs'];?>" target="_blank">
                                                <img src="../user/uploads/berkas/<?=$rank['raport_khs'];?>"
                                                    style="height:90px; width:90px;" class="card-img" alt="...">
                                            </a>
                                            <?php endif;?>
                                        </td>
                                        <td>
                                            <?php if($rank['kartu_pelajar'] == "" || $rank['kartu_pelajar'] == NULL): ?>
                                            <img src="../assets/images/no_images.png" style="height:90px; width:90px;"
                                                class="card-img" alt="...">
                                            <?php else:?>
                                            <a href="../user/uploads/berkas/<?=$rank['kartu_pelajar'];?>"
                                                target="_blank">
                                                <img src="../user/uploads/berkas/<?=$rank['kartu_pelajar'];?>"
                                                    style="height:90px; width:90px;" class="card-img" alt="...">
                                            </a>
                                            <?php endif;?>
                                        </td>
                                        <td><?=$rank['nilaiAkhir'];?></td>
                                        <td>
                                            <?php if($rank['terima'] == 1): ?>
                                            <button type="button" disabled
                                                class="btn btn-sm btn-success">Diterima</button>
                                            <?php else: ?>
                                            <button type="button" disabled
                                                class="btn btn-sm btn-danger">Ditolak</button>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($rankingSMA != null && mysqli_num_rows($hasilAkhirSMA) < 1 && $rank['terima'] == 1):?>
                                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                                data-target="#hapus<?=$rank['id_pelamar'].$rank['f_id_periode'];?>">Tolak</button>
                                            <?php else: ?>
                                            <button type="button" disabled class="btn btn-sm btn-secondary">Tidak ada
                                                aksi</button>
                                            <?php endif; ?>

                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="justify-content-center p-5">
                <form action="" method="post">
                    <?php if($rankingPT != null && mysqli_num_rows($hasilAkhirPT) < 1):?>
                    <?php foreach ($rankingPT as $key => $rank):?>
                    <input type="hidden" name="id_pelamar[]" value="<?=$rank['id_pelamar']?>">
                    <input type="hidden" name="nilai_rank[]" value="<?=$rank['nilaiAkhir']?>">
                    <input type="hidden" name="terima[]" value="<?=$rank['terima']?>">
                    <?php endforeach;?>
                    <button type="submit" name="simpan-pt" class="btn btn-primary mb-2">
                        Simpan Hasil
                    </button>
                    <?php endif;?>
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Hasil Perhitungan (Perguruan Tinggi)</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered nowrap" id="hasil-pt" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Rayon</th>
                                        <th>Status jemaat</th>
                                        <th>Keaktifan kegiatan bergereja</th>
                                        <th>Status keluarga</th>
                                        <th>Pendapatan orang tua/wali</th>
                                        <th>Jumlah tanggungan orang tua/wali</th>
                                        <th>IPK/Nilai Raport</th>
                                        <th>Kelas</th>
                                        <th>Kartu Keluarga</th>
                                        <th>Raport/KHS</th>
                                        <th>Kartu Pelajar/KTM</th>
                                        <th>Nilai Akhir</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rankingPT as $key => $rank):?>
                                    <input type="hidden" name="id_pelamar[]" value="<?=$rank['id_pelamar']?>">
                                    <input type="hidden" name="nilai_rank[]" value="<?=$rank['nilaiAkhir']?>">
                                    <tr>
                                        <th scope="row"><?=$k++;?>. </th>
                                        <th><?=$rank['nama'];?></th>
                                        <th><?=$rank['nama_rayon'];?></th>
                                        <th><?=$rank['kriteriaSatu'];?></th>
                                        <th><?=$rank['kriteriaDua'];?></th>
                                        <th><?=$rank['kriteriaTiga'];?></th>
                                        <th>Rp.<?=$rank['pendapatan_ortu'];?></th>
                                        <th><?=$rank['kriteriaLima'];?></th>
                                        <th><?=$rank['ipk'];?></th>
                                        <th><?= explode("/",$rank['kriteriaTujuh'])[1];?></th>
                                        <td>
                                            <?php if($rank['kartu_keluarga'] == "" || $rank['kartu_keluarga'] == NULL): ?>
                                            <img src="../assets/images/no_images.png" style="height:90px; width:90px;"
                                                class="card-img" alt="...">
                                            <?php else:?>
                                            <a href="../user/uploads/berkas/<?=$rank['kartu_keluarga'];?>"
                                                target="_blank">
                                                <img src="../user/uploads/berkas/<?=$rank['kartu_keluarga'];?>"
                                                    style="height:90px; width:90px;" class="card-img" alt="...">
                                            </a>
                                            <?php endif;?>
                                        </td>
                                        <td>
                                            <?php if($rank['raport_khs'] == "" || $rank['raport_khs'] == NULL): ?>
                                            <img src="../assets/images/no_images.png" style="height:90px; width:90px;"
                                                class="card-img" alt="...">
                                            <?php else:?>
                                            <a href="../user/uploads/berkas/<?=$rank['raport_khs'];?>" target="_blank">
                                                <img src="../user/uploads/berkas/<?=$rank['raport_khs'];?>"
                                                    style="height:90px; width:90px;" class="card-img" alt="...">
                                            </a>
                                            <?php endif;?>
                                        </td>
                                        <td>
                                            <?php if($rank['kartu_pelajar'] == "" || $rank['kartu_pelajar'] == NULL): ?>
                                            <img src="../assets/images/no_images.png" style="height:90px; width:90px;"
                                                class="card-img" alt="...">
                                            <?php else:?>
                                            <a href="../user/uploads/berkas/<?=$rank['kartu_pelajar'];?>"
                                                target="_blank">
                                                <img src="../user/uploads/berkas/<?=$rank['kartu_pelajar'];?>"
                                                    style="height:90px; width:90px;" class="card-img" alt="...">
                                            </a>
                                            <?php endif;?>
                                        </td>
                                        <td><?=$rank['nilaiAkhir'];?></td>
                                        <td>
                                            <?php if($rank['terima'] == 1): ?>
                                            <button type="button" disabled
                                                class="btn btn-sm btn-success">Diterima</button>
                                            <?php else: ?>
                                            <button type="button" disabled
                                                class="btn btn-sm btn-danger">Ditolak</button>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($rankingPT != null && mysqli_num_rows($hasilAkhirPT) < 1 && $rank['terima'] == 1):?>
                                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                                data-target="#hapus<?=$rank['id_pelamar'].$rank['f_id_periode'];?>">Tolak</button>
                                            <?php else: ?>
                                            <button type="button" disabled class="btn btn-sm btn-secondary">Tidak ada
                                                aksi</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php foreach ($rankingSMA as $rank):?>
<div class="modal fade" id="hapus<?=$rank['id_pelamar'].$rank['f_id_periode'];?>" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Tolak</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="id_pelamar" value="<?=$rank['id_pelamar'];?>">
                        <input type="hidden" name="id_periode" value="<?=$rank['f_id_periode'];?>">
                        <p>Apakah anda yakin ingin menolak <strong><?=$rank['nama'];?> </strong>sebagai calon penerima
                            beasiswa? Setelah ditolak, data tidak dapat diubah lagi!
                        </p>
                    </div>
                    <div class="form-group">
                        <label for="floatingTextarea2"><strong>Pesan/Alasan ditolak</strong><small
                                class="text-danger">*</small></label>
                        <textarea class="form-control" placeholder="Masukkan pesan atau alasan ditolak..." required
                            name="pesan_sma" id="floatingTextarea2" cols="30" rows="10"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" name="tolak-sma" class="btn btn-primary">Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach;?>
<?php foreach ($rankingPT as $rank):?>
<div class="modal fade" id="hapus<?=$rank['id_pelamar'].$rank['f_id_periode'];?>" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Tolak</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="id_pelamar" value="<?=$rank['id_pelamar'];?>">
                        <input type="hidden" name="id_periode" value="<?=$rank['f_id_periode'];?>">
                        <p>Apakah anda yakin ingin menolak <strong><?=$rank['nama'];?> </strong>sebagai calon penerima
                            beasiswa? Setelah ditolak, data tidak dapat diubah lagi!
                        </p>
                    </div>
                    <div class="form-group">
                        <label for="floatingTextarea2"><strong>Pesan/Alasan ditolak</strong><small
                                class="text-danger">*</small></label>
                        <textarea class="form-control" placeholder="Masukkan pesan atau alasan ditolak..." required
                            name="pesan_pt" id="floatingTextarea2" cols="30" rows="10"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" name="tolak-pt" class="btn btn-primary">Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach;?>

<?php require './footer.php';?>