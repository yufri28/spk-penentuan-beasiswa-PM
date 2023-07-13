<?php 
session_start();
unset($_SESSION['menu']);
$_SESSION['menu'] = 'pengajuan';
require '../includes/header.php';
require_once './functions/data-diri.php';
require_once './functions/notifikasi.php';
require_once './functions/pengajuan.php';

$cekDataPelamar = $dataDiri->cekDataPelamar($_SESSION['id_user']);
if(!empty($cekDataPelamar) && mysqli_num_rows($cekDataPelamar) > 0){
    $fecthDataPelamar = mysqli_fetch_assoc($cekDataPelamar);
    $admin = mysqli_fetch_assoc($dataDiri->getAdmin($fecthDataPelamar['f_id_rayon']));
}
$num_rows = 0;
$numRowsVerifikasi = 0;

if(mysqli_num_rows($cekDataPelamar) > 0){
    $id_pelamar = $fecthDataPelamar['id_pelamar'];
    $cekPelamarKriteria = $dataDiri->cekPelamarKriteria($id_pelamar);
    $fetchPelamarKriteria = mysqli_fetch_assoc($cekPelamarKriteria);
    $num_rows = mysqli_num_rows($cekPelamarKriteria);
    $dataVerifikasi = $Pengajuan->getVerifikasi($id_pelamar);
}

if(isset($_GET['n'])){
    $id_notif = base64_decode($_GET['n']);
    $Notifikasi->updateNotif($id_notif);
}


if(isset($_POST['ajukan'])){
    $idPelamar = $_POST['id_pelamar'];
    $idPengirim = $_SESSION['id_user'];
    $id_penerima = $admin['id_admin'];
    $namaPelamar = $fecthDataPelamar['nama'];
    $data = [
        'f_id_pelamar' => $idPelamar,
        'f_id_pengirim' => $idPengirim,
        'f_id_penerima' => $id_penerima,
        'nama_pelamar' => $namaPelamar,
    ];
    $Pengajuan->ajukanBeasiswa($data);
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
    <div class="col-lg-10">
        <div class="card shadow mb-4">
            <div class="card-body flex-row align-items-center"
                style="font-family: 'Lato', sans-serif; padding: 60px 60px">
                <h1 class="text-end">Menu Pengajuan Beasiswa</h1>
                <div class="alert alert-warning" role="alert">

                    <!-- jika belum ada data di tabel verifikasi dan sudah ada data di tabel data pelamar -->
                    <?php if(mysqli_num_rows($dataVerifikasi) < 1 && mysqli_num_rows($cekDataPelamar) > 0) :?>
                    <p class="text-end">Setelah data diri anda sudah lengkap, silahkan melakukan
                        pengajuan beasiswa dengan klik menu ajukan.</p>
                    <form action="" method="post">
                        <input type="hidden" name="id_pelamar" value="<?= isset($id_pelamar) ? $id_pelamar:'-';?>">
                        <button type="submit" name="ajukan" class="btn btn-primary px-5">
                            <h5>Ajukan</h5>
                        </button>
                    </form>
                    <?php endif;?>
                    <!-- jika data belum ada di tabel data pelamar -->
                    <?php if(mysqli_num_rows($cekDataPelamar) < 1):?>
                    <p class="text-end">Data diri anda belum lengkap, silahkan <a href="./data_diri.php">lengkapi</a>
                        terlebih dahulu.
                    </p>
                    <?php endif;?>
                    <?php if(mysqli_num_rows($dataVerifikasi) > 0):?>
                    <?php foreach ($dataVerifikasi as $key => $verifikasi):?>
                    <?php if($verifikasi['status'] == 0 ):?>
                    <!-- jika sudah ada data di tabel verifikasi -->
                    <p class="text-end">Anda sudah melakukan pengajuan. Silahkan menunggu verifikasi dari koordinator
                        rayon.</p>
                    <?php else:?>
                    <p class="text-end">Data anda sudah diverifikasi. Silahkan menunggu hasil seleksi.</p>
                    <?php endif;?>
                    <?php endforeach;?>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require '../includes/footer.php';?>