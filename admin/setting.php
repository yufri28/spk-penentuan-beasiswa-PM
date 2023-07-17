<?php 
session_start();
if($_SESSION['level'] != 0){
    header("Location: ./index.php");
}
unset($_SESSION['menu']);
$_SESSION['menu'] = 'setting';
require_once './header.php';
require_once './functions/setting.php';
require_once './functions/user.php';

$dataKoordinator = $User->getKoordinator();
$dataRayon = $Setting->getRayon();
$dataPeriode = $Setting->getPeriode($_SESSION['id_periode']);
$dataAllPeriode = $Setting->getAllPeriode();

// if(isset($_POST['tambah-koordinator'])){
//     $level = htmlspecialchars($_POST['level']);
//     $username = htmlspecialchars($_POST['username']);
//     $password = htmlspecialchars($_POST['password']);
//     $id_rayon = htmlspecialchars($_POST['id_rayon']);

//     $data = [
//         'username' => $username,
//         'password' => $password,
//         'level' => $level,
//         'id_rayon' => $id_rayon
//     ];
//     $User->addKoordinator($data);
// }


if(isset($_POST['tambah-rayon'])){
    $level = htmlspecialchars($_POST['level']);
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $nama_rayon = htmlspecialchars($_POST['nama_rayon']);

    $data = [
        'nama_rayon' => $nama_rayon,
        'username' => $username,
        'password' => $password,
        'level' => $level,
    ];
    $Setting->addRayon($data);
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


if(isset($_POST['tambah-periode'])){
    $periode = htmlspecialchars($_POST['periode'][0]);
    $deskripsi = htmlspecialchars($_POST['periode'][1]);
    $kuota_sma = htmlspecialchars($_POST['periode'][2]);
    $kuota_pt = htmlspecialchars($_POST['periode'][3]);
    $status = htmlspecialchars($_POST['periode'][4]);

    $data = [
        'periode' => $periode,
        'deskripsi' => $deskripsi,
        'kuota_sma' => $kuota_sma,
        'kuota_pt' => $kuota_pt,
        'status' => $status,
    ];
    $Setting->addPeriode($data);
}

if(isset($_POST['edit-periode'])){
    $id_periode = htmlspecialchars($_POST['periode'][0]);
    $nama_periode = htmlspecialchars($_POST['periode'][1]);
    $deskripsi = htmlspecialchars($_POST['periode'][2]);
    $kuota_sma = htmlspecialchars($_POST['periode'][3]);
    $kuota_pt = htmlspecialchars($_POST['periode'][4]);
    $status = htmlspecialchars($_POST['periode'][5]);

    $data = [
        'id_periode' => $id_periode,
        'nama_periode' => $nama_periode,
        'deskripsi' => $deskripsi,
        'kuota_sma' => $kuota_sma,
        'kuota_pt' => $kuota_pt,
        'status' => $status,
    ];

    $Setting->editPeriode($data);
}
if(isset($_POST['hapus-periode'])){
    $id_periode = htmlspecialchars($_POST['id_periode']);
    $Setting->hapusPeriode($id_periode);
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
<div class="row">
    <!-- Area Chart -->
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="justify-content-center p-5">
                <button type="button" class="btn mb-2 btn-primary" data-toggle="modal" data-target="#tambahPeriode">
                    + Tambah Data
                </button>
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Periode</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Periode</th>
                                    <th>Deskripsi</th>
                                    <th>Kuota SMA</th>
                                    <th>Kuota PT</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dataAllPeriode as $key => $periode):?>
                                <tr>
                                    <th scope="row"><?=$key+1;?></th>
                                    <th><?=$periode['nama_periode'];?></th>
                                    <th><?=$periode['deskripsi'];?></th>
                                    <th><?=$periode['kuota_sma'];?></th>
                                    <th><?=$periode['kuota_pt'];?></th>
                                    <th><?=$periode['status'];?></th>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#editPeriode<?=$periode['id_periode'];?>">Edit
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                            data-target="#hapusPeriode<?=$periode['id_periode'];?>">Hapus
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
                    <strong>Data Rayon</strong>
                    <div class="form-group">
                        <label for="nama_rayon">Nama Rayon <small class="text-danger">*</small></label>
                        <input class="form-control form-control-sm" required name="nama_rayon" type="text"
                            placeholder="Cth: Rayon I">
                    </div>
                    <strong>Data Koordinator Rayon</strong>
                    <div class="form-group">
                        <input type="hidden" name="level" value="1">
                        <label for="username">Username <small class="text-danger">*</small></label>
                        <input class="form-control form-control-sm" required name="username" type="text"
                            placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password <small class="text-danger">*</small></label>
                        <input class="form-control form-control-sm" required name="password" type="password"
                            placeholder="******">
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
                        <input class="form-control form-control-sm" required value="<?=$rayon['nama_rayon'];?>"
                            name="nama_rayon" type="text" placeholder="Cth: Rayon I">
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
                        <input type="hidden" name="id_rayon" required value="<?=$rayon['id_rayon'];?>">
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
<!-- modal periode -->
<div class="modal fade" id="tambahPeriode" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <label for="periode">Periode <small class="text-danger">*</small></label>
                        <input class="form-control form-control-sm" required name="periode[]" type="text"
                            placeholder="Cth: 20231">
                    </div>
                    <div class="form-group">
                        <label for="periode">Deskripsi <small class="text-danger">*</small></label>
                        <textarea required name="periode[]" class="form-control form-control-sm" cols="5"
                            rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="kuota_sma">Kuota SMA <small class="text-danger">*</small></label>
                        <input class="form-control form-control-sm" required name="periode[]" type="num"
                            placeholder="Cth: 10">
                    </div>
                    <div class="form-group">
                        <label for="kuota_pt">Kuota PT <small class="text-danger">*</small></label>
                        <input class="form-control form-control-sm" required name="periode[]" type="num"
                            placeholder="Cth: 10">
                    </div>
                    <label hidden for="Status">Status <small class="text-danger">*</small></label>
                    <select hidden required class="form-control form-control-sm" name="periode[]">
                        <option value="">-- Pilih --</option>
                        <option selected value="buka">Buka</option>
                        <option value="tutup">Tutup</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" name="tambah-periode" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php foreach ($dataAllPeriode as $periode):?>
<div class="modal fade" id="editPeriode<?=$periode['id_periode'];?>" tabindex="-1" aria-labelledby="exampleModalLabel"
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
                        <label for="periode">Periode <small class="text-danger">*</small></label>
                        <input class="form-control form-control-sm" required name="periode[]" type="hidden"
                            value="<?=$periode['id_periode'];?>">
                        <input class="form-control form-control-sm" required name="periode[]" type="text"
                            placeholder="Cth: 20231" value="<?=$periode['nama_periode'];?>">
                    </div>
                    <div class="form-group">
                        <label for="periode">Deskripsi <small class="text-danger">*</small></label>
                        <textarea name="periode[]" class="form-control form-control-sm" cols="5"
                            rows="5"><?=$periode['deskripsi'];?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="kuota_sma">Kuota SMA <small class="text-danger">*</small></label>
                        <input class="form-control form-control-sm" value="<?=$periode['kuota_sma'];?>" required
                            name="periode[]" type="num" placeholder="Cth: 10">
                    </div>
                    <div class="form-group">
                        <label for="kuota_pt">Kuota PT <small class="text-danger">*</small></label>
                        <input class="form-control form-control-sm" value="<?=$periode['kuota_pt'];?>" required
                            name="periode[]" type="num" placeholder="Cth: 10">
                    </div>
                    <label hidden for="Status">Status <small class="text-danger">*</small></label>
                    <select required class="form-control form-control-sm" name="periode[]">
                        <option value="">-- Pilih --</option>
                        <option <?=$periode['status'] == 'buka' ?'selected':'';?> value="buka">Buka</option>
                        <option value="tutup" <?=$periode['status'] == 'tutup' ?'selected':'';?>>Tutup</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" name="edit-periode" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach;?>
<?php foreach ($dataAllPeriode as $periode):?>
<div class="modal fade" id="hapusPeriode<?=$periode['id_periode'];?>" tabindex="-1" aria-labelledby="exampleModalLabel"
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
                        <input type="hidden" name="id_periode" required value="<?=$periode['id_periode'];?>">
                        <p>Anda yakin ingin menghapus periode <strong><?=$periode['nama_periode'];?></strong> ?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" name="hapus-periode" class="btn btn-primary">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach;?>
<?php require './footer.php';?>