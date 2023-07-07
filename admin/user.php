<?php 
session_start();
if($_SESSION['level'] != 0){
    header("Location: ./index.php");
}
unset($_SESSION['menu']);
$_SESSION['menu'] = 'users';
require_once './header.php';
require_once './functions/data_pelamar.php';
require_once './functions/user.php';

$dataKoordinator = $User->getKoordinator();
$dataPelamar = $User->getPelamar();
$dataRayon = $User->getRayon();

if(isset($_POST['tambah-koordinator'])){
    $level = htmlspecialchars($_POST['level']);
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $id_rayon = htmlspecialchars($_POST['id_rayon']);

    $data = [
        'username' => $username,
        'password' => $password,
        'level' => $level,
        'id_rayon' => $id_rayon
    ];
    $User->addKoordinator($data);
}
if(isset($_POST['edit-koordinator'])){
    $id_admin = htmlspecialchars($_POST['id_admin']);
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $id_rayon = htmlspecialchars($_POST['id_rayon']);

    $data = [
        'id_admin' => $id_admin,
        'username' => $username,
        'password' => $password,
        'id_rayon' => $id_rayon
    ];
    $User->editKoordinator($data);
}
if(isset($_POST['hapus-koordinator'])){
    $id_admin = htmlspecialchars($_POST['id_admin']);
    $User->hapusKoordinator($id_admin);
}
if(isset($_POST['hapus-pelamar'])){
    $id_login = htmlspecialchars($_POST['id_login']);
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
                <button type="button" class="btn mb-2 btn-primary" data-toggle="modal" data-target="#tambahKoordinator">
                    + Tambah Data
                </button>
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Akun Koordinator Rayon</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="koordinator" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Level</th>
                                    <th>Rayon</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dataKoordinator as $key => $koordinator):?>
                                <tr>
                                    <th scope="row"><?=$key+1;?></th>
                                    <td><?=$koordinator['username'];?></td>
                                    <td><?=$koordinator['level'] == 1 ?'Koordinator Rayon '.$koordinator['nama_rayon']:'';?>
                                    </td>
                                    <td><?=$koordinator['nama_rayon'];?></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#editKoordinator<?=$koordinator['id_admin'];?>">Edit
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                            data-target="#hapusKoordinator<?=$koordinator['id_admin'];?>">Hapus
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
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="justify-content-center p-5">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Akun Pelamar</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="pelamar" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Jenjang</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dataPelamar as $key => $pelamar):?>
                                <tr>
                                    <th scope="row"><?=$key+1;?></th>
                                    <td><?=$pelamar['username'];?></td>
                                    <td><?=$pelamar['jenjang'];?></td>
                                    <td> <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                            data-target="#hapusPelamar<?=$pelamar['id_login'];?>">Hapus
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


<!-- modal koordinator -->
<div class="modal fade" id="tambahKoordinator" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <input type="hidden" name="level" value="1">
                        <label for="username">Username <small class="text-danger">*</small></label>
                        <input class="form-control form-control-sm" name="username" type="text" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password <small class="text-danger">*</small></label>
                        <input class="form-control form-control-sm" name="password" type="password"
                            placeholder="******">
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
<?php foreach ($dataKoordinator as $koordinator_rayon):?>
<div class="modal fade" id="editKoordinator<?=$koordinator_rayon['id_admin'];?>" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <input type="hidden" name="id_admin" value="<?=$koordinator_rayon['id_admin'];?>">
                        <label for="username">Username <small class="text-danger">*</small></label>
                        <input class="form-control form-control-sm" value="<?=$koordinator_rayon['username']?>"
                            name="username" type="text" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input class="form-control form-control-sm" name="password" type="password"
                            placeholder="******">
                        <small><i>Jika tidak ingin mengubah password, silahkan kosongkan.</i></small>
                    </div>
                    <div class="form-group">
                        <label for="Rayon">Rayon <small class="text-danger">*</small></label>
                        <select class="form-control form-control-sm" name="id_rayon" id="Rayon">
                            <option value="">-- Pilih Rayon --</option>
                            <?php foreach ($dataRayon as $key => $rayon):?>
                            <option <?=$koordinator_rayon['f_id_rayon'] == $rayon['id_rayon'] ? 'selected':'';?>
                                value="<?=$rayon['id_rayon'];?>">
                                <?=$rayon['nama_rayon'];?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" name="edit-koordinator" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach;?>
<?php foreach ($dataKoordinator as $koordinator_rayon):?>
<div class="modal fade" id="hapusKoordinator<?=$koordinator_rayon['id_admin'];?>" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <input type="hidden" name="id_admin" value="<?=$koordinator_rayon['id_admin'];?>">
                        <p>Anda yakin ingin menghapus akun <strong><?=$koordinator_rayon['username'];?></strong> ?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" name="hapus-koordinator" class="btn btn-primary">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach;?>

<!-- modal pelamar -->
<?php foreach ($dataPelamar as $pelamar):?>
<div class="modal fade" id="hapusPelamar<?=$pelamar['id_login'];?>" tabindex="-1" aria-labelledby="exampleModalLabel"
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
                        <input type="hidden" name="id_login" value="<?=$pelamar['id_login'];?>">
                        <p>Anda yakin ingin menghapus akun <strong><?=$pelamar['username'];?></strong> ?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" name="hapus-pelamar" class="btn btn-primary">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach;?>

<?php require './footer.php';?>