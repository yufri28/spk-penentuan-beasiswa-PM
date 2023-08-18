<?php 
session_start();
unset($_SESSION['menu']);
$_SESSION['menu'] = 'hasil-seleksi';
require '../includes/header.php';
require_once './functions/data-diri.php';
require_once './functions/notifikasi.php';
require_once './functions/pengajuan.php';


$dataPeriode = "";
if(isset($_SESSION['id_periode'])){
    $dataPeriode = mysqli_fetch_assoc($Pengajuan->getPeriodeById($_SESSION['id_periode']));
}

$isSelesai = mysqli_num_rows($Pengajuan->isSelesai($_SESSION['id_periode']));

$getHasil = mysqli_fetch_assoc($Pengajuan->getHasil($_SESSION['id_user'],$_SESSION['id_periode']));

$dataVerifikasi = $Pengajuan->getVerifikasi($_SESSION['id_user'],$_SESSION['id_periode']);
$numRowsVerifikasi = mysqli_num_rows($dataVerifikasi);

// $Pengajuan->getHasilAkhir($_SESSION['id_periode'])
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
<?php if ($numRowsVerifikasi <= 0 || $isSelesai <= 0): ?>
<script>
var pesan =
    'Mohon maaf! Belum ada informasi hasil seleksi.';
Swal.fire({
    title: 'Peringatan!',
    text: pesan,
    icon: 'warning',
    confirmButtonText: 'OK',
    allowOutsideClick: false,
    allowEscapeKey: false
}).then(function(result) {
    if (result.isConfirmed) {
        window.location.href = './index.php';
    }
});
</script>
<?php unset($_SESSION['error']); // Menghapus session setelah ditampilkan ?>
<?php endif; ?>
<div class="row d-flex justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow mb-4">
            <div class="card-body flex-row align-items-center"
                style="font-family: 'Lato', sans-serif; padding: 60px 60px">
                <h1 class="text-end">Hasil Seleksi Beasiswa</h1>
                <div class="alert alert-<?=$getHasil != null ?'success':'danger';?>" role="alert">
                    <?php if($getHasil != null):?>
                    <p>Selamat! Kamu lolos seleksi beasiswa pendidikan pada jenjang Sekolah Menengah Atas (SMA) dan
                        Perguruan Tinggi di GMIT Paulus Kupang <?=$getHasil['deskripsi']?>.</p>
                    <?php else: ?>
                    <p>Mohon maaf! Kamu tidak lolos seleksi beasiswa pendidikan pada jenjang Sekolah Menengah Atas (SMA)
                        dan Perguruan Tinggi di GMIT Paulus Kupang <?=$dataPeriode['deskripsi']?>.</p>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require '../includes/footer.php';?>