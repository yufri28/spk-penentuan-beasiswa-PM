<?php 
session_start();
if($_SESSION['level'] != 0){
    header("Location: ./index.php");
}
unset($_SESSION['menu']);
$_SESSION['menu'] = 'setting';
require_once './header.php';
require_once './functions/setting.php';

$dataRayon = $Setting->getRayon();

if(isset($_POST['tambah-rayon'])){
    $nama_rayon = htmlspecialchars($_POST['nama_rayon']);
    $Setting->addRayon($nama_rayon);
}
if(isset($_POST['edit-rayon'])){
    $id_rayon = htmlspecialchars($_POST['id_rayon']);
    $nama_rayon = htmlspecialchars($_POST['nama_rayon']);
    $Setting->editRayon($id_rayon,$nama_rayon);
}
if(isset($_POST['hapus-rayon'])){
    $id_rayon = htmlspecialchars($_POST['id_rayon']);
    $Setting->hapusRayon($id_rayon);
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
                <button type="button" class="btn mb-2 btn-primary" data-toggle="modal" data-target="#tambahRayon">
                    + Tambah Data
                </button>
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Rayon</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Rayon</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dataRayon as $key => $rayon):?>
                                <tr>
                                    <th scope="row"><?=$key+1;?></th>
                                    <th><?=$rayon['nama_rayon'];?></th>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#editRayon<?=$rayon['id_rayon'];?>">Edit
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                            data-target="#hapusRayon<?=$rayon['id_rayon'];?>">Hapus
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

<!-- modal rayon -->
<div class="modal fade" id="tambahRayon" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <label for="nama_rayon">Nama Rayon</label>
                        <input class="form-control form-control-sm" name="nama_rayon" type="text"
                            placeholder="Cth: Rayon I">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" name="tambah-rayon" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php foreach ($dataRayon as $rayon):?>
<div class="modal fade" id="editRayon<?=$rayon['id_rayon'];?>" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="id_rayon" value="<?=$rayon['id_rayon'];?>">
                        <label for="nama_rayon">Nama Rayon</label>
                        <input class="form-control form-control-sm" value="<?=$rayon['nama_rayon'];?>" name="nama_rayon"
                            type="text" placeholder="Cth: Rayon I">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" name="edit-rayon" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach;?>
<?php foreach ($dataRayon as $rayon):?>
<div class="modal fade" id="hapusRayon<?=$rayon['id_rayon'];?>" tabindex="-1" aria-labelledby="exampleModalLabel"
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
                        <input type="hidden" name="id_rayon" value="<?=$rayon['id_rayon'];?>">
                        <p>Anda yakin ingin menghapus data <strong><?=$rayon['nama_rayon'];?></strong> ?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" name="hapus-rayon" class="btn btn-primary">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach;?>
<?php require './footer.php';?>