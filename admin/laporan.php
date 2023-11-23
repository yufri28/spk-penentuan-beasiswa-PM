<?php 
session_start();
unset($_SESSION['menu']);
$_SESSION['menu'] = 'laporan';
require_once './header.php';
require_once './functions/laporan.php';
require_once './functions/setting.php';

$dataPeriode = $Laporan->getPeriode();
$dataRayon = $Laporan->getRayon();
$penerimaBeasiswaSMA = $Laporan->getHasilAkhir('sma');
$penerimaBeasiswaPT = $Laporan->getHasilAkhir('pt');


$j = 1;
$k = 1;

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
        <div class="card shadow mb-2">
            <div class="card-header">
                <h5 class="text-center">Cetak Laporan PDF</h5>
            </div>
            <div class="card-body mb-1">
                <div class="d-flex justify-content-center">
                    <div class="btn-group px-2 pb-2 col-md-2">
                        <a href="./cetak_laporan.php" class="btn btn-secondary">Cetak Semua</a>
                    </div>
                    <div class="btn-group px-2 pb-2 col-md-2">
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"
                            aria-expanded="false">
                            Jenjang
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="./cetak_laporan.php?order_jenjang=sma">SMA/SMK</a></li>
                            <li><a class="dropdown-item" href="./cetak_laporan.php?order_jenjang=pt">Perguruan
                                    Tinggi</a>
                            </li>
                        </ul>
                    </div>
                    <div class="btn-group px-2 pb-2 col-md-2">
                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"
                            aria-expanded="false">
                            Periode
                        </button>
                        <ul class="dropdown-menu">
                            <?php foreach ($dataPeriode as $periode):?>
                            <li><a class="dropdown-item"
                                    href="./cetak_laporan.php?order_periode=<?=$periode['id_periode'];?>"><?=$periode['nama_periode'];?></a>
                            </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                    <div class="btn-group px-2 pb-2 col-md-2">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                            aria-expanded="false">
                            Rayon
                        </button>
                        <ul class="dropdown-menu">
                            <?php foreach ($dataRayon as $rayon):?>
                            <li><a class="dropdown-item"
                                    href="./cetak_laporan.php?order_rayon=<?=$rayon['id_rayon'];?>"><?=$rayon['nama_rayon'];?></a>
                            </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="justify-content-center p-5">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Penerima Beasiswa (SMA)</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="hasil-sma" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Nomor HP</th>
                                    <th>Asal Sekolah/PT</th>
                                    <th>Pendapatan Ortu/Wali (per bulan)</th>
                                    <th>IPK/Rata-rata Raport</th>
                                    <th>Status Jemaat</th>
                                    <th>Keaktifan kegiatan bergereja</th>
                                    <th>Status keluarga</th>
                                    <th>Jumlah tanggungan orang tua/wali
                                    </th>
                                    <th>Semester/Kelas
                                    </th>
                                    <th>Rayon</th>
                                    <th>Nilai Akhir</th>
                                    <th>Periode</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($penerimaBeasiswaSMA as $key => $penerimaBeasiswa):?>
                                <tr>
                                    <th scope="row"><?=$j++;?>. </th>
                                    <td><?=$penerimaBeasiswa['nama'];?></td>
                                    <td><?=$penerimaBeasiswa['no_hp'];?></td>
                                    <td><?=$penerimaBeasiswa['sekolah'];?></td>
                                    <td><?=$penerimaBeasiswa['pendapatan_ortu'];?></td>
                                    <td><?=$penerimaBeasiswa['ipk'];?></td>
                                    <td><?=$penerimaBeasiswa['C1'];?></td>
                                    <td><?=$penerimaBeasiswa['C2'];?></td>
                                    <td><?=$penerimaBeasiswa['C3'];?></td>
                                    <td><?=$penerimaBeasiswa['C5'];?></td>
                                    <td><?=$penerimaBeasiswa['C7'];?></td>

                                    <td><?=$penerimaBeasiswa['nama_rayon'];?></td>
                                    <td><?=$penerimaBeasiswa['nilai_rank'];?></td>
                                    <td><?=$penerimaBeasiswa['nama_periode'];?></td>
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
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Penerima Beasiswa (Perguruan Tinggi)</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="hasil-pt" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Nomor HP</th>
                                    <th>Asal Sekolah/PT</th>
                                    <th>Pendapatan Ortu/Wali (per bulan)</th>
                                    <th>IPK/Rata-rata Raport</th>
                                    <th>Status Jemaat</th>
                                    <th>Keaktifan kegiatan bergereja</th>
                                    <th>Status keluarga</th>
                                    <th>Jumlah tanggungan orang tua/wali
                                    </th>
                                    <th>Semester/Kelas
                                    </th>
                                    <th>Rayon</th>
                                    <th>Nilai Akhir</th>
                                    <th>Periode</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($penerimaBeasiswaPT as $key => $penerimaBeasiswa):?>
                                <tr>
                                    <th scope="row"><?=$k++;?>. </th>
                                    <td><?=$penerimaBeasiswa['nama'];?></td>
                                    <td><?=$penerimaBeasiswa['no_hp'];?></td>
                                    <td><?=$penerimaBeasiswa['sekolah'];?></td>
                                    <td><?=$penerimaBeasiswa['pendapatan_ortu'];?></td>
                                    <td><?=$penerimaBeasiswa['ipk'];?></td>
                                    <td><?=$penerimaBeasiswa['C1'];?></td>
                                    <td><?=$penerimaBeasiswa['C2'];?></td>
                                    <td><?=$penerimaBeasiswa['C3'];?></td>
                                    <td><?=$penerimaBeasiswa['C5'];?></td>
                                    <td><?=$penerimaBeasiswa['C7'];?></td>

                                    <td><?=$penerimaBeasiswa['nama_rayon'];?></td>
                                    <td><?=$penerimaBeasiswa['nilai_rank'];?></td>
                                    <td><?=$penerimaBeasiswa['nama_periode'];?></td>
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