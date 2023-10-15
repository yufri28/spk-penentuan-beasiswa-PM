<?php 
session_start();
unset($_SESSION['menu']);
$_SESSION['menu'] = 'data-diri';
require_once '../includes/header.php';
require_once './functions/rayon.php';
require_once './functions/data-diri.php';

$cekDataPelamar = $dataDiri->cekDataPelamar($_SESSION['id_user']);
$fetch_id_pelamar = mysqli_fetch_assoc($cekDataPelamar);
$id_pelamar = $fetch_id_pelamar['id_pelamar'];
$cekPelamarKriteria = $dataDiri->cekPelamarKriteria($id_pelamar);


$dataIpk = $dataDiri->getIPK();


function selectId($params=null, $dataIpk=null){
    $kategori1 = '';
    $kategori2 = '';
    $kategori3 = '';
    $kategori4 = '';
    $kategori5 = '';
    $id_sub = 0;
    foreach ($dataIpk as $key => $value) {
        if($value['bobot_sub_kriteria'] == 5){
            $kategori1 = $value['id_sub_kriteria'];
        }else if($value['bobot_sub_kriteria'] == 4){
            $kategori2 = $value['id_sub_kriteria'];
        }
        else if($value['bobot_sub_kriteria'] == 3){
            $kategori3 = $value['id_sub_kriteria'];
        }
        else if($value['bobot_sub_kriteria'] == 2){
            $kategori4 = $value['id_sub_kriteria'];
        }
        else if($value['bobot_sub_kriteria'] == 1){
            $kategori5 = $value['id_sub_kriteria'];
        }
    }
    if($_SESSION['jenjang'] == 'pt'){
        $ipk = $params;
        switch ($ipk) {
            case $ipk >= 3.76 && $ipk <= 4.00:
                $id_sub = $kategori1;
                break;
            case $ipk >= 3.51 && $ipk <= 3.75:
                $id_sub = $kategori2;
                break;
            case $ipk >= 3.01 && $ipk <= 3.50:
                $id_sub = $kategori3;
                break;
            case $ipk >= 2.51 && $ipk <= 3.00:
                $id_sub = $kategori4;
                break;
            case $ipk <= 2.50:
                $id_sub = $kategori5;
                break;
        } 
    
    }else if($_SESSION['jenjang'] == 'sma'){
        $rata2 = $params;
        switch ($rata2) {
            case $rata2 >= 90 && $rata2 <= 100:
                $id_sub = $kategori1;
                break;
            case $rata2 >= 81 && $rata2 <= 89.99:
                $id_sub = $kategori2;
                break;
            case $rata2 >= 76 && $rata2 <= 80.99:
                $id_sub = $kategori3;
                break;
            case $rata2 >= 65.01 && $rata2 <= 75.99:
                $id_sub = $kategori4;
                break;
            case $rata2 <= 65:
                $id_sub = $kategori5;
                break;
            } 
    }
    return $id_sub;
} 

function filterPendapatan($pendapatan, $kriteriaPendapatan){
    $id_pendapatan = 0;
    foreach ($kriteriaPendapatan as $key => $value) {
        if($pendapatan <= 1000000 && $value['bobot_sub_kriteria'] == 5){
            $id_pendapatan = $value['id_sub_kriteria'];
        }
        elseif(($pendapatan > 1000000 && $pendapatan <= 1500000) && $value['bobot_sub_kriteria'] == 4){
            $id_pendapatan = $value['id_sub_kriteria'];
        }
        elseif(($pendapatan > 1500000 && $pendapatan <= 2000000) && $value['bobot_sub_kriteria'] == 3){
            $id_pendapatan = $value['id_sub_kriteria'];
        }
        elseif(($pendapatan > 2000000 && $pendapatan < 3000000) && $value['bobot_sub_kriteria'] == 2){
            $id_pendapatan = $value['id_sub_kriteria'];
        }
        elseif($pendapatan >= 3000000 && $value['bobot_sub_kriteria'] == 1){
            $id_pendapatan = $value['id_sub_kriteria'];
        }
    }
    return $id_pendapatan;
}

if(mysqli_num_rows($cekDataPelamar) != 1){
    echo '<script>window.location.href = "./add-data-diri.php";</script>';
}else if(mysqli_num_rows($cekDataPelamar) == 1 && mysqli_num_rows($cekPelamarKriteria) == 5){
    echo '<script>window.location.href = "./data_diri.php";</script>';
}

if (isset($_POST["simpan"])) {
    // Pastikan ada file gambar yang diunggah
    if ((isset($_FILES['kartu_keluarga']) && $_FILES['kartu_keluarga']['error'] === UPLOAD_ERR_OK)
    && isset($_FILES['raport_khs']) && $_FILES['raport_khs']['error'] === UPLOAD_ERR_OK) {
        // Array informasi file yang diunggah
        $files = [
            $_FILES['kartu_keluarga'],
            $_FILES['raport_khs']
        ];

        $targetDir = './uploads/berkas/';
        $uploadedFiles = [];

        // Loop untuk mengunggah setiap file gambar
        foreach ($files as $index => $file) {
            $namaFile = $file['name'];
            $lokasiSementara = $file['tmp_name'];
            $targetFilePath = $targetDir . $namaFile;

            // Cek apakah nama file sudah ada dalam direktori target
            if (file_exists($targetFilePath)) {
                $fileInfo = pathinfo($namaFile);
                $baseName = $fileInfo['filename'];
                $extension = $fileInfo['extension'];
                $counter = 1;

                // Loop hingga menemukan nama file yang unik
                while (file_exists($targetFilePath)) {
                    $namaFile = $baseName . '_' . $counter . '.' . $extension;
                    $targetFilePath = $targetDir . $namaFile;
                    $counter++;
                }
            }

            // Pindahkan file gambar dari lokasi sementara ke lokasi tujuan
            if (move_uploaded_file($lokasiSementara, $targetFilePath)) {
                $uploadedFiles[$index] = $namaFile;
            } else {
                return $_SESSION['error'] = 'Gagal mengunggah file gambar!';
            }
        }

        // Setelah semua file diunggah, lakukan proses lanjutan
        $status_jemaat = $_POST['data_diri'][0];
        $aktif_kegiatan = $_POST['data_diri'][1];
        $status_keluarga = $_POST['data_diri'][2];
        // $pendapatan = $_POST['data_diri'][3];
        $range_pendapatan = filterPendapatan(str_replace('.', '', $_POST['data_diri'][3]),$dataDiri->getPendapatanOrtu());
        $jumlah_tanggungan = $_POST['data_diri'][4];
        // $ipk = $_POST['data_diri'][5];
        $ipks = $_POST['data_diri'][5];
        $ipk = str_replace(",",".",$ipks);
        $id_sub_ipk = selectId($ipk, $dataIpk);
        $semester = $_POST['data_diri'][6];
    
        $data_diri = [
            'status_jemaat' => $status_jemaat,
            'aktif_kegiatan' => $aktif_kegiatan,
            'status_keluarga' => $status_keluarga,
            'range_pendapatan' => $range_pendapatan,
            'pendapatan' => str_replace('.', '', $_POST['data_diri'][3]),
            'jumlah_tanggungan' => $jumlah_tanggungan,
            'ipks' => $ipks,
            'ipk' => $id_sub_ipk,
            'semester' => $semester,
            'kartu_keluarga' => $uploadedFiles[0],
            'raport_khs' => $uploadedFiles[1],
            'id_pelamar' =>$id_pelamar
        ];

        $dataDiri->addDataDiriNext($data_diri);
    } else {
        return $_SESSION['error'] = 'Tidak ada file gambar yang diunggah!';
    }

}
  
$dataRayon = $Rayon->getRayon();
$dataStatusJemaat = $dataDiri->getStatusJemaat();
$dataKeaktifan = $dataDiri->getKeaktifan();
$dataStatusKeluarga = $dataDiri->getStatusKeluarga();
$dataPendapatanOrtu = $dataDiri->getPendapatanOrtu();
$dataJumlahTanggungan = $dataDiri->getJumlahTanggungan();
$dataIPK = $dataDiri->getIPK();
$dataSemester = $dataDiri->getSemester();
?>


<div class="row d-flex justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="modal-header">
                <h4>Tambah data diri (Page 2)</h4>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="status_jemaat">Status Jemaat <small class="text-danger">*</small></label>
                        <select required class="form-control form-control-sm" name="data_diri[]" id="status_jemaat">
                            <option value="">-- Pilih --</option>
                            <?php foreach ($dataStatusJemaat as $key => $status_jemaat):?>
                            <option value="<?=$status_jemaat['id_sub_kriteria'];?>">
                                <?=$status_jemaat['nama_sub_kriteria'];?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="aktif_kegiatan">Aktif Kegiatan <small class="text-danger">*</small></label>
                        <select required class="form-control form-control-sm" name="data_diri[]" id="aktif_kegiatan">
                            <option value="">-- Pilih --</option>
                            <?php foreach ($dataKeaktifan as $key => $aktif_kegiatan):?>
                            <option value="<?=$aktif_kegiatan['id_sub_kriteria'];?>">
                                <?=$aktif_kegiatan['nama_sub_kriteria'];?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status_keluarga">Status Keluarga <small class="text-danger">*</small></label>
                        <select required class="form-control form-control-sm" name="data_diri[]" id="status_keluarga">
                            <option value="">-- Pilih --</option>
                            <?php foreach ($dataStatusKeluarga as $key => $status_keluarga):?>
                            <option value="<?=$status_keluarga['id_sub_kriteria'];?>">
                                <?=$status_keluarga['nama_sub_kriteria'];?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pendapatan">Pendapatan Ortu/wali (per bulan) <small
                                class="text-danger">*</small></label>
                        <input required class="form-control form-control-sm" placeholder="Contoh: 1.000.000" type="text"
                            name="data_diri[]" id="pendapatan">
                        <div id="error-message" class="text-danger"></div>
                        <!-- <select required class="form-control form-control-sm" name="data_diri[]" id="pendapatan">
                            <option value="">-- Pilih --</option>
                            <?php foreach ($dataPendapatanOrtu as $key => $pendapatan):?>
                            <option value="<?=$pendapatan['id_sub_kriteria'];?>">
                                <?=$pendapatan['nama_sub_kriteria'];?></option>
                            <?php endforeach;?>
                        </select> -->
                    </div>
                    <div class="form-group">
                        <label for="jumlah_tanggungan">Jumlah Tanggungan Ortu/wali <small
                                class="text-danger">*</small></label>
                        <select required class="form-control form-control-sm" name="data_diri[]" id="jumlah_tanggungan">
                            <option value="">-- Pilih --</option>
                            <?php foreach ($dataJumlahTanggungan as $key => $jumlah_tanggungan):?>
                            <option value="<?=$jumlah_tanggungan['id_sub_kriteria'];?>">
                                <?=$jumlah_tanggungan['nama_sub_kriteria'];?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <!-- <div class="form-group">
                        <label for="ipk"><?= $_SESSION['jenjang'] == 'pt' ? 'IPK ':'Nilai Rata-rata Raport ';?> <small
                                class="text-danger">*</small></label>
                        <select required class="form-control form-control-sm" name="data_diri[]" id="ipk">
                            <option value="">-- Pilih --</option>
                            <?php foreach ($dataIPK as $key => $IPK):?>
                            <option value="<?=$IPK['id_sub_kriteria'];?>">
                                <?= $_SESSION['jenjang'] == 'pt' ? explode("/",$IPK['nama_sub_kriteria'])[1]:explode("/",$IPK['nama_sub_kriteria'])[0];?>
                            </option>
                            <?php endforeach;?>
                        </select>
                    </div> -->
                    <?php if($_SESSION['jenjang'] == 'pt'):?>
                    <div class="form-group">
                        <label for="ipk">IPK <small class="text-danger">*</small></label>
                        <input class="form-control form-control-sm" required name="data_diri[]" type="text"
                            id="ipkInput" placeholder="Cth: 3.87">
                        <div id="ipkValidationMessage" class="text-danger"></div>
                        <!-- <small id="ipkValidationMessage" class="text-danger"></small> -->
                    </div>
                    <?php else:?>
                    <div class="form-group">
                        <label for="rata2">Rata-rata nilai raport <small class="text-danger">*</small></label>
                        <input class="form-control form-control-sm" required name="data_diri[]" type="text"
                            id="rata2Input" placeholder="Cth: 89.00">
                        <div id="rata2ValidationMessage" class="text-danger"></div>
                        <!-- <small id="rata2ValidationMessage" class="text-danger"></small> -->
                    </div>
                    <?php endif;?>
                    <div class="form-group">
                        <label for="semester"><?= $_SESSION['jenjang'] == 'pt' ? 'Semester ':'Kelas ';?> <small
                                class="text-danger">*</small></label>
                        <select required class="form-control form-control-sm" name="data_diri[]" id="semester">
                            <option value="">-- Pilih --</option>
                            <?php foreach ($dataSemester as $key => $semester):?>
                            <option value="<?=$semester['id_sub_kriteria'];?>">
                                <?= $_SESSION['jenjang'] == 'pt' ? explode("/",$semester['nama_sub_kriteria'])[0]:explode("/",$semester['nama_sub_kriteria'])[1];?>
                            </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kartu_keluarga" class="form-label">Kartu Keluarga
                            <small class="text-danger">*</small></label>
                        <input type="file" accept=".jpg, .jpeg, .png" class="form-control" name="kartu_keluarga"
                            id="kartu_keluarga" required />
                    </div>
                    <div class="form-group">
                        <label for="raport_khs"
                            class="form-label"><?= $_SESSION['jenjang'] == 'pt' ? 'KHS ':'Raport ';?>
                            <small class="text-danger">*</small></label>
                        <input type="file" accept=".jpg, .jpeg, .png" class="form-control" name="raport_khs"
                            id="raport_khs" required />
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="./data_diri.php" class="btn btn-secondary" data-dismiss="modal">Kembali</a>
                    <button id="submitBtn" type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    const pendapatanInput = $("#pendapatan");
    const errorMessage = $("#error-message");

    pendapatanInput.on("input", function() {
        console.log('masulk');
        const inputValue = $(this).val();
        const validPattern = /^\d+(\.\d{1,3})*$/;

        if (validPattern.test(inputValue)) {
            pendapatanInput.removeClass("is-invalid");
            pendapatanInput.addClass("is-valid");
            errorMessage.text(""); // Hapus pesan kesalahan
        } else {
            pendapatanInput.removeClass("is-valid");
            pendapatanInput.addClass("is-invalid");
            errorMessage.text("Hanya masukkan angka dan titik.");
        }
    });
});


$(document).ready(function() {
    const ipkInput = $('#ipkInput');
    const ipkValidationMessage = $('#ipkValidationMessage');
    const submitBtn = $("#submitBtn");

    ipkInput.on('input', function() {
        const inputValue = ipkInput.val();
        const ipkPattern = /^([0-3](\.\d{1,2})?|4(\.0{1,2})?)$/;

        if (!ipkPattern.test(inputValue)) {
            ipkValidationMessage.text(
                'Format IPK tidak valid. Harap masukkan angka antara 0.00 dan 4.00');
            ipkInput.removeClass("is-valid");
            ipkInput.addClass("is-invalid");
            submitBtn.prop("disabled", true); // Nonaktifkan tombol "Submit"
            ipkInput[0].setCustomValidity('Format IPK tidak valid');
        } else {
            ipkInput.removeClass("is-invalid");
            ipkInput.addClass("is-valid");
            ipkValidationMessage.text('');
            submitBtn.prop("disabled", false); // Aktifkan tombol "Submit"
            ipkInput[0].setCustomValidity('');
        }
    });

    const rata2Input = $('#rata2Input');
    const rata2ValidationMessage = $('#rata2ValidationMessage');

    rata2Input.on('input', function() {
        const inputValue = rata2Input.val();
        const rata2Pattern = /^(100(\.00?)?|[0-9]{1,2}(\.\d{1,2})?)$/;

        if (!rata2Pattern.test(inputValue)) {
            rata2ValidationMessage.text(
                'Format nilai tidak valid. Harap masukkan angka antara 0.00 dan 100.00');
            rata2Input.removeClass("is-valid");
            rata2Input.addClass("is-invalid");
            submitBtn.prop("disabled", true); // Nonaktifkan tombol "Submit"
            rata2Input[0].setCustomValidity('Format nilai tidak valid');
        } else {
            submitBtn.prop("disabled", false); // Aktifkan tombol "Submit"
            rata2Input.removeClass("is-invalid");
            rata2Input.addClass("is-valid");
            rata2ValidationMessage.text('');
            rata2Input[0].setCustomValidity('');
        }
    });
});

// const ipkInput = document.getElementById('ipkInput');
// const ipkValidationMessage = document.getElementById('ipkValidationMessage');

// ipkInput.addEventListener('input', function() {
//     const inputValue = ipkInput.value;
//     // const ipkPattern = /^([0-9]\.[0-9]{1,2}|[1-3]\.[0-9]{1,2}|4\.00)$/;
//     const ipkPattern = /^([0-3](\.\d{1,2})?|4(\.0{1,2})?)$/; // Pattern untuk IPK antara 0.00 dan 4.00

//     if (!ipkPattern.test(inputValue)) {
//         ipkValidationMessage.textContent =
//             'Format IPK tidak valid. Harap masukkan angka antara 0.00 dan 4.00';
//         ipkInput.setCustomValidity('Format IPK tidak valid');
//     } else {
//         ipkValidationMessage.textContent = '';
//         ipkInput.setCustomValidity('');
//     }
// });

// const rata2Input = document.getElementById('rata2Input');
// const rata2ValidationMessage = document.getElementById('rata2ValidationMessage');

// rata2Input.addEventListener('input', function() {
//     const inputValue = rata2Input.value;
//     // const rata2Pattern = /^(100|0|[1-9][0-9]?)$/; // Pattern untuk nilai antara 0 dan 100
//     const rata2Pattern = /^(100(\.00?)?|[0-9]{1,2}(\.\d{1,2})?)$/; // Pattern untuk nilai antara 0.00 dan 100.00

//     if (!rata2Pattern.test(inputValue)) {
//         rata2ValidationMessage.textContent =
//             'Format nilai tidak valid. Harap masukkan angka antara 0.00 dan 100.00';
//         rata2Input.setCustomValidity('Format nilai tidak valid');
//     } else {
//         rata2ValidationMessage.textContent = '';
//         rata2Input.setCustomValidity('');
//     }
// });
</script>
<?php require '../includes/footer.php';?>