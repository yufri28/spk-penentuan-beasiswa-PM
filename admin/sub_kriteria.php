<?php 
session_start();
unset($_SESSION['menu']);
$_SESSION['menu'] = 'sub-kriteria';
require_once './header.php';
require_once './functions/sub_kriteria.php';
require_once './functions/kriteria.php';

$data_kriteria = $dataKriteria->getKriteria();
$data_sub_kriteria = $dataSubKriteria->getSubKriteria();


if(isset($_POST['tambah'])){
    $nama_sub_kriteria = htmlspecialchars($_POST['nama_sub_kriteria']);
    $id_kriteria = htmlspecialchars($_POST['id_kriteria']);
    $bobot_sub_kriteria = htmlspecialchars($_POST['bobot_sub_kriteria']);

    $data = [
        'nama_sub_kriteria' => $nama_sub_kriteria,
        'id_kriteria' => $id_kriteria,
        'bobot_sub_kriteria' => $bobot_sub_kriteria
    ];
    $dataSubKriteria->addSubKriteria($data);
}
if(isset($_POST['edit'])){
    $id_sub_kriteria = htmlspecialchars($_POST['id_sub_kriteria']);
    $nama_sub_kriteria = htmlspecialchars($_POST['nama_sub_kriteria']);
    $id_kriteria = htmlspecialchars($_POST['id_kriteria']);
    $bobot_sub_kriteria = htmlspecialchars($_POST['bobot_sub_kriteria']);

    $data = [
        'id_sub_kriteria' => $id_sub_kriteria,
        'nama_sub_kriteria' => $nama_sub_kriteria,
        'id_kriteria' => $id_kriteria,
        'bobot_sub_kriteria' => $bobot_sub_kriteria
    ];
    $dataSubKriteria->editSubKriteria($data);
}
if(isset($_POST['hapus'])){
    $id_sub_kriteria = htmlspecialchars($_POST['id_sub_kriteria']);
    $dataSubKriteria->hapusSubKriteria($id_sub_kriteria);
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
                <!-- Button trigger modal -->
                <button type="button" class="btn mb-2 btn-primary" data-toggle="modal" data-target="#exampleModal">
                    + Tambah Data
                </button>
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Sub Kriteria</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Sub Kriteria</th>
                                    <th>Kriteria</th>
                                    <th>Bobot Sub Kriteria</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data_sub_kriteria as $key => $sub_kriteria):?>
                                <tr>
                                    <th scope="row"><?=$key+1;?></th>
                                    <th><?=$sub_kriteria['nama_sub_kriteria'];?></th>
                                    <th><?=$sub_kriteria['nama_kriteria'];?></th>
                                    <td><?=$sub_kriteria['bobot_sub_kriteria'];?></td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#edit<?=$sub_kriteria['id_sub_kriteria'];?>">Edit</button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#hapus<?=$sub_kriteria['id_sub_kriteria'];?>">Hapus</button>
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <label for="nama_sub_kriteria">Nama Sub Kriteria</label>
                        <input class="form-control form-control-sm" name="nama_sub_kriteria" type="text"
                            placeholder="Sub kriteria">
                    </div>
                    <div class="form-group">
                        <label for="Kriteria">Kriteria</label>
                        <select class="form-control form-control-sm" name="id_kriteria" id="Kriteria">
                            <option value="">-- Pilih Kriteria --</option>
                            <?php foreach ($data_kriteria as $key => $kriteria):?>
                            <option value="<?=$kriteria['id_kriteria'];?>"><?=$kriteria['id_kriteria'];?> -
                                <?=$kriteria['nama_kriteria'];?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="bobot_sub_kriteria">Bobot Sub Kriteria</label>
                        <input class="form-control form-control-sm" name="bobot_sub_kriteria" type="number"
                            placeholder="Bobot Sub kriteria">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php foreach ($data_sub_kriteria as $sub):?>
<div class="modal fade" id="edit<?=$sub['id_sub_kriteria'];?>" tabindex="-1" aria-labelledby="exampleModalLabel"
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
                        <input type="hidden" name="id_sub_kriteria" value="<?=$sub['id_sub_kriteria'];?>">
                        <label for="nama_sub_kriteria">Nama Sub Kriteria</label>
                        <input class="form-control form-control-sm" value="<?=$sub['nama_sub_kriteria'];?>"
                            name="nama_sub_kriteria" type="text" placeholder="Sub kriteria">
                    </div>
                    <div class="form-group">
                        <label for="Kriteria">Kriteria</label>
                        <select class="form-control form-control-sm" name="id_kriteria" id="Kriteria">
                            <option value="">-- Pilih Kriteria --</option>
                            <?php foreach ($data_kriteria as $key => $kriteria):?>
                            <option <?= $kriteria['id_kriteria'] == $sub['f_id_kriteria'] ? 'selected':'';?>
                                value="<?=$kriteria['id_kriteria'];?>"><?=$kriteria['id_kriteria'];?> -
                                <?=$kriteria['nama_kriteria'];?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="bobot_sub_kriteria">Bobot Sub Kriteria</label>
                        <input class="form-control form-control-sm" value="<?=$sub['bobot_sub_kriteria'];?>"
                            name="bobot_sub_kriteria" type="number" placeholder="Bobot Sub kriteria">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" name="edit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach;?>
<?php foreach ($data_sub_kriteria as $sub):?>
<div class="modal fade" id="hapus<?=$sub['id_sub_kriteria'];?>" tabindex="-1" aria-labelledby="exampleModalLabel"
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
                        <input type="hidden" name="id_sub_kriteria" value="<?=$sub['id_sub_kriteria'];?>">
                        <p>Anda yakin ingin menghapus sub kriteria <strong><?=$sub['nama_sub_kriteria'];?></strong> ?
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