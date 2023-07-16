<?php 
session_start();
unset($_SESSION['menu']);
$_SESSION['menu'] = 'perhitungan';
require_once './header.php';
require_once './functions/perhitungan.php';
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
$rankingSMA = $Perhitungan->perengkingan('sma');
$rankingPT = $Perhitungan->perengkingan('pt');
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
    if($jumlahKuotaSMA <= $numRowsSMA){
        for ($i = 0; $i < $jumlahKuotaSMA; $i++) {
            $idPelamar = $_POST['id_pelamar'][$i];
            $nilaiRank = $_POST['nilai_rank'][$i];
            $combinedArray[] = array(
                'id_pelamar' => $idPelamar,
                'nilai_rank' => $nilaiRank,
                'f_id_periode' => $_SESSION['id_periode'],
                'jenjang' => "sma"
            );
        }
        $Perhitungan->simpanHasil($combinedArray);
    }else{
        $_SESSION['error'] = "Jumlah pelamar belum mencukupi kuota!";
    }
}

if(isset($_POST['simpan-pt'])){
    $combinedArray = array(); // Array untuk menyimpan data gabungan
    if($jumlahKuotaPT <= $numRowsPT){
        for ($i = 0; $i < $jumlahKuotaPT; $i++) {
            $idPelamar = $_POST['id_pelamar'][$i];
            $nilaiRank = $_POST['nilai_rank'][$i];
            $combinedArray[] = array(
                'id_pelamar' => $idPelamar,
                'nilai_rank' => $nilaiRank,
                'f_id_periode' => $_SESSION['id_periode'],
                'jenjang' => "pt"
            );
        }
        
        $Perhitungan->simpanHasil($combinedArray);
    }else{
        $_SESSION['error'] = "Jumlah pelamar belum mencukupi kuota!";
    }
}


// foreach ($ranking as $key => $value) {
//     echo ($i++) . ". " . $value['nama'] . " - Nilai Akhir: " . $value['nilaiAkhir'] . "<br>";
// }
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
                            <table class="table table-bordered" id="hasil-sma" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Rayon</th>
                                        <th>Nilai Akhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rankingSMA as $key => $rank):?>
                                    <input type="hidden" name="id_pelamar[]" value="<?=$rank['id_pelamar']?>">
                                    <input type="hidden" name="nilai_rank[]" value="<?=$rank['nilaiAkhir']?>">
                                    <tr>
                                        <th scope="row"><?=$i++;?>. </th>
                                        <th><?=$rank['nama'];?></th>
                                        <th><?=$rank['nama_rayon'];?></th>
                                        <td><?=$rank['nilaiAkhir'];?></td>
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
                            <table class="table table-bordered" id="hasil-pt" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Rayon</th>
                                        <th>Nilai Akhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rankingPT as $key => $rank):?>
                                    <input type="hidden" name="id_pelamar[]" value="<?=$rank['id_pelamar']?>">
                                    <input type="hidden" name="nilai_rank[]" value="<?=$rank['nilaiAkhir']?>">
                                    <tr>
                                        <th scope="row"><?=$i++;?>. </th>
                                        <th><?=$rank['nama'];?></th>
                                        <th><?=$rank['nama_rayon'];?></th>
                                        <td><?=$rank['nilaiAkhir'];?></td>
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

<?php require './footer.php';?>