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
require_once './functions/user.php';



if(isset($_POST['hapus'])){
    $id_login = htmlspecialchars($_POST['f_id_login']);

    $User->hapusPelamar($id_login);
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
                                    <th>Asal Sekolah/PT</th>
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
                                    <td><?= $pelamar['jenjang'] == 'pt' ? "Perguruan Tinggi":"SMA/SMK Sederajat";?></td>
                                    <td>
                                        <button type="button" data-target="#hapus<?=$pelamar['f_id_login'];?>"
                                            data-toggle="modal" class="btn btn-sm btn-danger">
                                            Hapus
                                        </button>
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
<?php foreach ($data_pelamar as $pelamar):?>
<div class="modal fade" id="hapus<?=$pelamar['f_id_login'];?>" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="f_id_login" value="<?=$pelamar['f_id_login'];?>">
                        <p>Anda yakin ingin menghapus <strong><?=$pelamar['nama'];?></strong> ?
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" name="hapus" class="btn btn-primary">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach;?>

<?php require './footer.php';?>