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

<?php require './footer.php';?>