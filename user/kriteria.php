<?php 
session_start();
unset($_SESSION['menu']);
$_SESSION['menu'] = 'kriteria';
require_once './../includes/header.php';
require_once './functions/kriteria.php';
$id_user = $_SESSION['id_user'];

if(isset($_POST['simpan'])){
    $prioritas1 = $_POST['prioritas_1'];
    $prioritas2 = $_POST['prioritas_2'];
    $prioritas3 = $_POST['prioritas_3'];
    $prioritas4 = $_POST['prioritas_4'];
    $prioritas5 = $_POST['prioritas_5'];

    $dataTampung = [
        $prioritas1,$prioritas2,$prioritas3,$prioritas4,$prioritas5
    ];
    $dataBobotKriteria = [
        $prioritas1 => 0.3,
        $prioritas2 => 0.2,
        $prioritas3 => 0.2,
        $prioritas4 => 0.2,
        $prioritas5 => 0.1,
    ];
    $Kriteria->tambahTampung($dataTampung, $id_user);
    $tambahBobotKriteria = $Kriteria->tambahBobotKriteria($dataBobotKriteria, $id_user);
}
if(isset($_POST['edit'])){
    $id = $_POST['id_tampung'];
    $id_bobot = $_POST['id_bobot'];
    $prioritas1 = $_POST['prioritas_1'];
    $prioritas2 = $_POST['prioritas_2'];
    $prioritas3 = $_POST['prioritas_3'];
    $prioritas4 = $_POST['prioritas_4'];
    $prioritas5 = $_POST['prioritas_5'];
    $dataTampung = [
        $prioritas1,$prioritas2,$prioritas3,$prioritas4,$prioritas5
    ];
    $dataBobotKriteria = [
        $prioritas1 => 0.3,
        $prioritas2 => 0.2,
        $prioritas3 => 0.2,
        $prioritas4 => 0.2,
        $prioritas5 => 0.1,
    ];
    $tambahBobotKriteria = $Kriteria->editBobotKriteria($id_bobot,$dataBobotKriteria);
    $Kriteria->editTampung($id,$dataTampung);
}

$data_Kriteria = $Kriteria->getKriteria($id_user);
$id_bobot = mysqli_fetch_assoc($data_Kriteria);
$dataKriteria = [
    "Fasilitas", "Jarak", "Biaya", "Luas Kamar", "Keamanan"
];


// $stmt = $koneksi->prepare("SELECT * FROM bobot_kriteria WHERE f_id_user=?");
// $stmt->bind_param("i", $id_user);
// $stmt->execute();
// $result = $stmt->get_result();
// $stmt->close();

$dataTampung = $koneksi->query("SELECT * FROM tabel_tampung WHERE f_id_user='$id_user'");


?>
<!-- Tampilkan pesan sukses atau error jika sesi tersebut diatur -->
<?php if (mysqli_num_rows($data_Kriteria) <= 0): ?>
<script>
Swal.fire({
    title: 'Pesan',
    text: 'Pililah kriteria sesuai prioritas yang Anda inginkan pada kos, seperti Fasilitas, Jarak, Biaya, Luas Kamar, dan Keamanan. Misalnya Anda ingin mencari kos dengan meprioritaskan Fasilitas pada prioritas 1, Biaya pada prioritas 2, Luas Kamar pada prioritas 3, Keamanan pada prioritas 4 dan Jarak pada prioritas 5. Dari pilihan prioritas tersebut, sistem akan merekomendasikan kos dengan kriteria kos dengan Fasilitas paling bagus kemudian diikuti dengan kriteria lainnya.',
    icon: 'warning',
    confirmButtonText: 'Paham'
});
</script>
<?php endif; ?>
<?php if (isset($_SESSION['success'])): ?>
<script>
Swal.fire({
    title: 'Sukses!',
    text: '<?php echo $_SESSION['success']; ?>',
    icon: 'success',
    confirmButtonText: 'OK'
});
</script>
<?php unset($_SESSION['success']); // Menghapus session setelah ditampilkan ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
<script>
Swal.fire({
    title: 'Error!',
    text: '<?php echo $_SESSION['error']; ?>',
    icon: 'error',
    confirmButtonText: 'OK'
});
</script>
<?php unset($_SESSION['error']); // Menghapus session setelah ditampilkan ?>
<?php endif; ?>

<div class="container" style="font-family: 'Prompt', sans-serif">
    <div class="row">
        <div class="d-xxl-flex">
            <div class="col-xxl-3 mb-xxl-3 mt-5">
                <div class="card">
                    <?php if(mysqli_num_rows($data_Kriteria) >= 1):?>
                    <?php foreach ($dataTampung as $tampung) :?>
                    <div class="card-header bg-primary">
                        <h5 class="text-center text-white pt-2 col-12 btn-outline-primary">
                            Edit Prioritas
                        </h5>
                    </div>
                    <form method="post" action="">
                        <div class="card-body">
                            <div class="mb-3 mt-3">
                                <input type="hidden" value="<?=$tampung['id'];?>" name="id_tampung">
                                <input type="hidden" value="<?=$id_bobot['id_bobot'];?>" name="id_bobot">
                                <label for="prioritas_1" class="form-label">Prioritas 1</label>
                                <select class="form-select" id="prioritas_1" name="prioritas_1"
                                    aria-label="Default select example">
                                    <option value="">-- Pilih prioritas 1 --</option>
                                    <?php foreach($dataKriteria as $kriteria):?>
                                    <option <?= $tampung['prio1'] == $kriteria ? 'selected':''?>
                                        value="<?=$kriteria;?>">
                                        <?=$kriteria;?>
                                    </option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="prioritas_2" class="form-label">Prioritas 2</label>
                                <select class="form-select" id="prioritas_2" name="prioritas_2">
                                    <option value="">-- Pilih prioritas 2 --</option>
                                    <?php foreach($dataKriteria as $kriteria):?>
                                    <option <?= $tampung['prio2'] == $kriteria ? 'selected':''?>
                                        value="<?=$kriteria;?>">
                                        <?=$kriteria;?>
                                    </option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="prioritas_3" class="form-label">Prioritas 3</label>
                                <select class="form-select" id="prioritas_3" name="prioritas_3">
                                    <option value="">-- Pilih prioritas 3 --</option>
                                    <?php foreach($dataKriteria as $kriteria):?>
                                    <option <?= $tampung['prio3'] == $kriteria ? 'selected':''?>
                                        value="<?=$kriteria;?>">
                                        <?=$kriteria;?>
                                    </option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="prioritas_4" class="form-label">Prioritas 4</label>
                                <select class="form-select" id="prioritas_4" name="prioritas_4">
                                    <option value="">-- Pilih prioritas 4 --</option>
                                    <?php foreach($dataKriteria as $kriteria):?>
                                    <option <?= $tampung['prio4'] == $kriteria ? 'selected':''?>
                                        value="<?=$kriteria;?>">
                                        <?=$kriteria;?>
                                    </option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="prioritas_5" class="form-label">Prioritas 5</label>
                                <select class="form-select" id="prioritas_5" name="prioritas_5">
                                    <option value="">-- Pilih prioritas 5 --</option>
                                    <?php foreach($dataKriteria as $kriteria):?>
                                    <option <?= $tampung['prio5'] == $kriteria ? 'selected':''?>
                                        value="<?=$kriteria;?>">
                                        <?=$kriteria;?>
                                    </option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <button type="submit" name="edit" class="btn col-12 btn-outline-primary">
                                Simpan
                            </button>
                        </div>
                    </form>
                    <?php endforeach;?>
                    <?php endif;?>
                    <?php if(mysqli_num_rows($data_Kriteria) <= 0):?>
                    <div class="card-header bg-primary">
                        <h5 class="text-center text-white pt-2 col-12 btn-outline-primary">
                            Masukan Prioritas
                        </h5>
                    </div>
                    <form method="post" action="">
                        <div class="card-body">
                            <div class="mb-3 mt-3">
                                <label for="prioritas_1" class="form-label">Prioritas 1</label>
                                <select class="form-select" id="prioritas_1" name="prioritas_1"
                                    aria-label="Default select example">
                                    <option value="">-- Pilih prioritas 1 --</option>
                                    <?php foreach($dataKriteria as $kriteria):?>
                                    <option value="<?=$kriteria;?>">
                                        <?=$kriteria;?>
                                    </option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="prioritas_2" class="form-label">Prioritas 2</label>
                                <select class="form-select" id="prioritas_2" name="prioritas_2">
                                    <option value="">-- Pilih prioritas 2 --</option>
                                    <?php foreach($dataKriteria as $kriteria):?>
                                    <option value="<?=$kriteria;?>">
                                        <?=$kriteria;?>
                                    </option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="prioritas_3" class="form-label">Prioritas 3</label>
                                <select class="form-select" id="prioritas_3" name="prioritas_3">
                                    <option value="">-- Pilih prioritas 3 --</option>
                                    <?php foreach($dataKriteria as $kriteria):?>
                                    <option value="<?=$kriteria;?>">
                                        <?=$kriteria;?>
                                    </option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="prioritas_4" class="form-label">Prioritas 4</label>
                                <select class="form-select" id="prioritas_4" name="prioritas_4">
                                    <option value="">-- Pilih prioritas 4 --</option>
                                    <?php foreach($dataKriteria as $kriteria):?>
                                    <option value="<?=$kriteria;?>">
                                        <?=$kriteria;?>
                                    </option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="prioritas_5" class="form-label">Prioritas 5</label>
                                <select class="form-select" id="prioritas_5" name="prioritas_5">
                                    <option value="">-- Pilih prioritas 5 --</option>
                                    <?php foreach($dataKriteria as $kriteria):?>
                                    <option value="<?=$kriteria;?>">
                                        <?=$kriteria;?>
                                    </option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <button type="submit" name="simpan" class="btn col-12 btn-outline-primary">
                                Simpan
                            </button>
                        </div>
                    </form>
                    <?php endif;?>
                </div>
            </div>
            <div class="col-xxl-9 mt-5 ms-xxl-5">
                <div class="card">
                    <div class="card-header bg-primary text-white">DAFTAR KRITERIA</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered nowrap" style="width:100%" id="table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Sifat</th>
                                        <th scope="col">Bobot</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">

                                    <?php foreach ($data_Kriteria as $key => $kriteria):?>
                                    <tr>
                                        <th scope="row"><?=$key+1;?></th>
                                        <td><?=$kriteria['nama_kriteria'];?></td>
                                        <td><?=$kriteria['jenis_kriteria'];?></td>
                                        <td><?=$kriteria['C'.$key+1];?></td>
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
</div>
<?php 
require_once './../includes/footer.php';
?>

<script>
$(document).ready(function() {
    $("#prioritas_1").change(function() {
        var prioritas_1 = $("#prioritas_1").val();
        $.ajax({
            type: 'POST',
            url: "./functions/pilihan.php",
            data: {
                prioritas_1: [prioritas_1]
            },
            cache: false,
            success: function(msg) {
                $("#prioritas_2").html(msg);
            }
        });
    });

    $("#prioritas_2").change(function() {
        var prioritas_1 = $("#prioritas_1").val();
        var prioritas_2 = $("#prioritas_2").val();
        $.ajax({
            type: 'POST',
            url: "./functions/pilihan.php",
            data: {
                prioritas_2: [prioritas_1, prioritas_2]
            },
            cache: false,
            success: function(msg) {
                $("#prioritas_3").html(msg);
            }
        });
    });

    $("#prioritas_3").change(function() {
        var prioritas_1 = $("#prioritas_1").val();
        var prioritas_2 = $("#prioritas_2").val();
        var prioritas_3 = $("#prioritas_3").val();
        $.ajax({
            type: 'POST',
            url: "./functions/pilihan.php",
            data: {
                prioritas_3: [prioritas_1, prioritas_2, prioritas_3]
            },
            cache: false,
            success: function(msg) {
                $("#prioritas_4").html(msg);
            }
        });
        $("#prioritas_4").change(function() {
            var prioritas_1 = $("#prioritas_1").val();
            var prioritas_2 = $("#prioritas_2").val();
            var prioritas_3 = $("#prioritas_3").val();
            var prioritas_4 = $("#prioritas_4").val();
            $.ajax({
                type: 'POST',
                url: "./functions/pilihan.php",
                data: {
                    prioritas_4: [prioritas_1, prioritas_2, prioritas_3,
                        prioritas_4
                    ]
                },
                cache: false,
                success: function(msg) {
                    $("#prioritas_5").html(msg);
                }
            });
        });
    });
});
</script>