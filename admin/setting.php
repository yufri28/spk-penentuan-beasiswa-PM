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
    $batas_pelamar = htmlspecialchars($_POST['periode'][5]);
    $batas_koor = htmlspecialchars($_POST['periode'][6]);

    $data = [
        'periode' => $periode,
        'deskripsi' => $deskripsi,
        'kuota_sma' => $kuota_sma,
        'kuota_pt' => $kuota_pt,
        'status' => $status,
        'batas_koor' => $batas_koor,
        'batas_pelamar' => $batas_pelamar,
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
    $batas_pelamar = htmlspecialchars($_POST['periode'][6]);
    $batas_koor = htmlspecialchars($_POST['periode'][7]);

    $data = [
        'id_periode' => $id_periode,
        'nama_periode' => $nama_periode,
        'deskripsi' => $deskripsi,
        'kuota_sma' => $kuota_sma,
        'kuota_pt' => $kuota_pt,
        'status' => $status,
        'batas_koor' => $batas_koor,
        'batas_pelamar' => $batas_pelamar
    ];

    $Setting->editPeriode($data);
}
if(isset($_POST['hapus-periode'])){
    $id_periode = htmlspecialchars($_POST['id_periode']);
    $Setting->hapusPeriode($id_periode);
}

// ==============================================
// =============== PENGUMUMAN ===================
// ==============================================
$dataPengumuman = $Setting->getPengumuman();

if(isset($_POST['tambah-pengumuman'])){

    $judul = $_POST['pengumuman'][0];
    $tanggal_berakhir = $_POST['pengumuman'][1];
    $isi = $_POST['pengumuman'][2];

    $data = [
        'judul' => $judul,
        'isi' => $isi,
        'tanggal_berakhir' => $tanggal_berakhir,
    ];
    
    $Setting->simpanPengumuman($data);
}
if(isset($_POST['edit-pengumuman'])){
    $id_pengumuman = $_POST['pengumuman'][0];
    $judul = $_POST['pengumuman'][1];
    $tanggal_berakhir = $_POST['pengumuman'][2];
    $isi = $_POST['pengumuman'][3];

    $data = [
        'id_pengumuman' => $id_pengumuman,
        'judul' => $judul,
        'isi' => $isi,
        'tanggal_berakhir' => $tanggal_berakhir,
    ];
    
    $Setting->editPengumuman($data);
}

if(isset($_POST['hapus-pengumuman'])){
    $id_pengumuman = htmlspecialchars($_POST['id_pengumuman']);
    $Setting->hapusPengumuman($id_pengumuman);
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
                <button type="button" class="btn mb-2 btn-primary" data-toggle="modal" data-target="#tambahPengumuman">
                    + Tambah Pengumuman
                </button>
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Pengumuman</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="pengumuman" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Isi</th>
                                    <th>Tanggal Diposting</th>
                                    <th>Tanggal Berakhir</th>
                                    <th cclass="text-nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dataPengumuman as $key => $pengumuman):?>
                                <tr>
                                    <td scope="row"><?=$key+1;?></td>
                                    <td><?=$pengumuman['judul'];?></td>
                                    <td><?=$pengumuman['isi_pengumuman'];?></td>
                                    <td><?=date("d-m-Y : H:i:s", strtotime($pengumuman['tanggal_posting']));?></td>
                                    <td><?=date("d-m-Y : H:i:s", strtotime($pengumuman['tanggal_berakhir']));?></td>
                                    <td class="text-nowrap">
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#editPengumuman<?=$pengumuman['id_pengumuman'];?>">Edit
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                            data-target="#hapusPengumuman<?=$pengumuman['id_pengumuman'];?>">Hapus
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
                                    <td scope="row"><?=$key+1;?></td>
                                    <td><?=$rayon['nama_rayon'];?></td>
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
                        <table class="table table-bordered" id="periode" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Periode</th>
                                    <th>Deskripsi</th>
                                    <th>Kuota SMA</th>
                                    <th>Kuota PT</th>
                                    <th>Status</th>
                                    <th>Batas Buka (Pelamar)</th>
                                    <th>Batas Buka (Koordinator)</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dataAllPeriode as $key => $periode):?>
                                <tr>
                                    <td scope="row"><?=$key+1;?></td>
                                    <td><?=$periode['nama_periode'];?></td>
                                    <td><?=$periode['deskripsi'];?></td>
                                    <td><?=$periode['kuota_sma'];?></td>
                                    <td><?=$periode['kuota_pt'];?></td>
                                    <td><?=$periode['status'];?></td>
                                    <td class="text-nowrap"><?=$periode['batas_pelamar'];?></td>
                                    <td class="text-nowrap"><?=$periode['batas_koor'];?></td>
                                    <td class="text-nowrap">
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

<!-- modal pengumuman -->
<div class="modal fade" id="tambahPengumuman" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <label for="judul">Judul <small class="text-danger">*</small></label>
                        <input class="form-control form-control-sm" required name="pengumuman[]" type="text"
                            placeholder="Judul pengumuman">
                    </div>
                    <div class="form-group">
                        <label for="tanggal_berakhir">Tanggal Berakhir <small class="text-danger">*</small></label>
                        <input class="form-control form-control-sm" required name="pengumuman[]" type="datetime-local">
                        <small><i>Batas tanggal pengumuman akan ditampilkan pada pengguna.</i></small>
                    </div>
                    <div class="form-group">
                        <label for="isi_pengumuman">Isi Pengumuman <small class="text-danger">*</small></label>
                        <textarea required name="pengumuman[]" class="form-control form-control-sm" cols="5"
                            rows="5"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" name="tambah-pengumuman" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php foreach ($dataPengumuman as $pengumuman):?>
<div class="modal fade" id="editPengumuman<?=$pengumuman['id_pengumuman'];?>" tabindex="-1"
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
                        <input type="hidden" name="pengumuman[]" value="<?=$pengumuman['id_pengumuman'];?>">
                        <label for="judul">Judul <small class="text-danger">*</small></label>
                        <input class="form-control form-control-sm" value="<?=$pengumuman['judul'];?>" required
                            name="pengumuman[]" type="text" placeholder="Judul pengumuman">
                    </div>
                    <div class="form-group">
                        <label for="tanggal_berakhir">Tanggal Berakhir <small class="text-danger">*</small></label>
                        <input class="form-control form-control-sm" value="<?=$pengumuman['tanggal_berakhir'];?>"
                            required name="pengumuman[]" type="datetime-local">
                        <small><i>Batas tanggal pengumuman akan ditampilkan pada pengguna.</i></small>
                    </div>
                    <div class="form-group">
                        <label for="isi_pengumuman">Isi Pengumuman <small class="text-danger">*</small></label>
                        <textarea required name="pengumuman[]" class="form-control form-control-sm" cols="5"
                            rows="5"><?=$pengumuman['isi_pengumuman'];?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" name="edit-pengumuman" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach;?>
<?php foreach ($dataPengumuman as $pengumuman):?>
<div class="modal fade" id="hapusPengumuman<?=$pengumuman['id_pengumuman'];?>" tabindex="-1"
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
                        <input type="hidden" name="id_pengumuman" required value="<?=$pengumuman['id_pengumuman'];?>">
                        <p>Anda yakin ingin menghapus pengumuman <strong><?=$pengumuman['judul'];?></strong> ?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" name="hapus-pengumuman" class="btn btn-primary">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach;?>

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
                    <div class="form-group">
                        <label for="batas_pelamar">Batas Buka (<small>Pelamar</small>)<small
                                class="text-danger">*</small></label>
                        <input class="form-control form-control-sm" required name="periode[]" type="datetime-local">
                    </div>
                    <div class="form-group">
                        <label for="batas_koor">Batas Buka (<small>Koordinator</small>) <small
                                class="text-danger">*</small></label>
                        <input class="form-control form-control-sm" required name="periode[]" type="datetime-local">
                    </div>
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
                    <div class="form-group">
                        <label hidden for="Status">Status <small class="text-danger">*</small></label>
                        <select required class="form-control form-control-sm" name="periode[]">
                            <option value="">-- Pilih --</option>
                            <option <?=$periode['status'] == 'buka' ?'selected':'';?> value="buka">Buka</option>
                            <option value="tutup" <?=$periode['status'] == 'tutup' ?'selected':'';?>>Tutup</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="batas_pelamar">Batas Buka (<small>Pelamar</small>) <small
                                class="text-danger">*</small></label>
                        <input class="form-control form-control-sm" value="<?=$periode['batas_pelamar'];?>" required
                            name="periode[]" type="datetime-local">
                    </div>
                    <div class="form-group">
                        <label for="batas_koor">Batas Buka (<small>Koordinator</small>) <small
                                class="text-danger">*</small></label>
                        <input class="form-control form-control-sm" value="<?=$periode['batas_koor'];?>" required
                            name="periode[]" type="datetime-local">
                    </div>

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