<?php 
session_start();
unset($_SESSION['menu']);
$_SESSION['menu'] = 'kriteria';
require_once './header.php';
require_once './functions/kriteria.php';

$data_kriteria = $dataKriteria->getKriteria();

?>

<div class="row">
    <!-- Area Chart -->
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="justify-content-center p-5">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Kriteria</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Bobot</th>
                                    <th>Faktor</th>
                                    <th>Profil Target</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data_kriteria as $key => $kriteria):?>
                                <tr>
                                    <th scope="row"><?=$key+1;?></th>
                                    <th><?=$kriteria['id_kriteria'];?></th>
                                    <th><?=$kriteria['nama_kriteria'];?></th>
                                    <td><?=$kriteria['bobot_kriteria'];?></td>
                                    <td><?=$kriteria['faktor'];?></td>
                                    <td><?=$kriteria['profile_target'];?></td>
                                    <td>
                                        <button type="button" data-target="#edit<?=$kriteria['id_kriteria'];?>"
                                            data-toggle="modal" class="btn btn-sm btn-primary">Edit</button>
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

<?php foreach ($data_kriteria as $kriteria):?>
<div class="modal fade" id="edit<?=$kriteria['id_kriteria'];?>" tabindex="-1" aria-labelledby="exampleModalLabel"
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
                        <label for="bobot_kriteria">Bobot Kriteria</label>
                        <input class="form-control form-control-sm" value="<?=$kriteria['bobot_kriteria'];?>"
                            name="bobot_kriteria" type="text" placeholder="Bobot Kriteria">
                    </div>
                    <div class="form-group">
                        <label for="faktor">Faktor</label>
                        <select class="form-control form-control-sm" name="id_kriteria" id="Kriteria">
                            <option value="">-- Pilih Faktor --</option>
                            <option <?=$kriteria['faktor'] == 'CF' ? 'selected':'';?> value="CF">CF</option>
                            <option <?=$kriteria['faktor'] == 'SF' ? 'selected':'';?>value="SF">SF</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="profil_target">Profil Target</label>
                        <input class="form-control form-control-sm" value="<?=$kriteria['profile_target'];?>"
                            name="profil_target" type="number" placeholder="Profil Target">
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

<?php require './footer.php';?>