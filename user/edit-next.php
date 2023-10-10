<?php 
session_start();
unset($_SESSION['menu']);
$_SESSION['menu'] = 'data-diri';
require_once '../includes/header.php';
require_once './functions/rayon.php';
require_once './functions/data-diri.php';

$cekDataPelamar = $dataDiri->cekDataPelamar($_SESSION['id_user']);
$fetch_data_pelamar = mysqli_fetch_assoc($cekDataPelamar);
$id_pelamar = $fetch_data_pelamar['id_pelamar'];
$cekPelamarKriteria = $dataDiri->cekPelamarKriteria($id_pelamar);
$getK1 = mysqli_fetch_assoc($dataDiri->getK1($id_pelamar));
$getK2 = mysqli_fetch_assoc($dataDiri->getK2($id_pelamar));
$getK3 = mysqli_fetch_assoc($dataDiri->getK3($id_pelamar));
$getK4 = mysqli_fetch_assoc($dataDiri->getK4($id_pelamar));
$getK5 = mysqli_fetch_assoc($dataDiri->getK5($id_pelamar));
$getK6 = mysqli_fetch_assoc($dataDiri->getK6($id_pelamar));
$getK7 = mysqli_fetch_assoc($dataDiri->getK7($id_pelamar));
$fetch_pelamar_kriteria = mysqli_fetch_assoc($cekPelamarKriteria);
$getAdmin = $dataDiri->getAdmin($fetch_data_pelamar['id_rayon']);
$id_penerima = mysqli_fetch_assoc($getAdmin);



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


if (isset($_POST["simpan"])) {
    // Pastikan ada file gambar yang diunggah
    if ((isset($_FILES['kartu_keluarga']) && $_FILES['kartu_keluarga']['error'] === UPLOAD_ERR_OK) ||
        (isset($_FILES['raport_khs']) && $_FILES['raport_khs']['error'] === UPLOAD_ERR_OK)) {
        // Array informasi file yang diunggah
        $files = [];
        if (isset($_FILES['kartu_keluarga']) && $_FILES['kartu_keluarga']['error'] === UPLOAD_ERR_OK) {
            $files['kartu_keluarga'] = $_FILES['kartu_keluarga'];
        }

        // if (isset($_FILES['suket_beasiswa_lain']) && $_FILES['suket_beasiswa_lain']['error'] === UPLOAD_ERR_OK) {
        //     $files['suket_beasiswa_lain'] = $_FILES['suket_beasiswa_lain'];
        // }

        if (isset($_FILES['raport_khs']) && $_FILES['raport_khs']['error'] === UPLOAD_ERR_OK) {
            $files['raport_khs'] = $_FILES['raport_khs'];
        }

        $targetDir = './uploads/berkas/';
        $uploadedFiles = [];

        // Loop untuk mengunggah setiap file gambar
        foreach ($files as $fieldName => $file) {
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
                if (isset($_POST["{$fieldName}_lama"])) {
                    $fileLama = $_POST["{$fieldName}_lama"];
                    if (file_exists($targetDir . $fileLama)) {
                        unlink($targetDir . $fileLama);
                    }
                }
                $uploadedFiles[$fieldName] = $namaFile;
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
        $ipk = $_POST['data_diri'][5];
        $semester = $_POST['data_diri'][6];
        $data_diri = [
            'k1' => $_POST['k1'],
            'k2' => $_POST['k2'],
            'k3' => $_POST['k3'],
            'k4' => $_POST['k4'],
            'k5' => $_POST['k5'],
            'k6' => $_POST['k6'],
            'k7' => $_POST['k7'],
            'status_jemaat' => $status_jemaat,
            'aktif_kegiatan' => $aktif_kegiatan,
            'status_keluarga' => $status_keluarga,
            'range_pendapatan' => $range_pendapatan,
            'pendapatan' => str_replace('.', '', $_POST['data_diri'][3]),
            'jumlah_tanggungan' => $jumlah_tanggungan,
            'ipk' => $ipk,
            'semester' => $semester,
            'kartu_keluarga' => isset($uploadedFiles['kartu_keluarga']) ? $uploadedFiles['kartu_keluarga'] : $_POST["kartu_keluarga_lama"],
            // 'suket_beasiswa_lain' => isset($uploadedFiles['suket_beasiswa_lain']) ? $uploadedFiles['suket_beasiswa_lain'] : $_POST["suket_beasiswa_lain_lama"],
            'raport_khs' => isset($uploadedFiles['raport_khs']) ? $uploadedFiles['raport_khs'] : $_POST["raport_khs_lama"],
            'id_pelamar' => $id_pelamar,
            'f_id_pengirim' => $_SESSION['id_user'],
            'nama_pengirim' => $fetch_data_pelamar['nama'],
            'f_id_penerima' => $id_penerima['id_admin']
        ];

        $dataDiri->editDataDiriNext($data_diri);
    } else {
        $status_jemaat = $_POST['data_diri'][0];
        $aktif_kegiatan = $_POST['data_diri'][1];
        $status_keluarga = $_POST['data_diri'][2];
        // $pendapatan = $_POST['data_diri'][3];
        $range_pendapatan = filterPendapatan(str_replace('.', '', $_POST['data_diri'][3]),$dataDiri->getPendapatanOrtu());
        $jumlah_tanggungan = $_POST['data_diri'][4];
        $ipk = $_POST['data_diri'][5];
        $semester = $_POST['data_diri'][6];
        $data_diri = [
            'k1' => $_POST['k1'],
            'k2' => $_POST['k2'],
            'k3' => $_POST['k3'],
            'k4' => $_POST['k4'],
            'k5' => $_POST['k5'],
            'k6' => $_POST['k6'],
            'k7' => $_POST['k7'],
            'status_jemaat' => $status_jemaat,
            'aktif_kegiatan' => $aktif_kegiatan,
            'status_keluarga' => $status_keluarga,
            'range_pendapatan' => $range_pendapatan,
            'pendapatan' => str_replace('.', '', $_POST['data_diri'][3]),
            'jumlah_tanggungan' => $jumlah_tanggungan,
            'ipk' => $ipk,
            'semester' => $semester,
            'kartu_keluarga' => $_POST["kartu_keluarga_lama"],
            // 'suket_beasiswa_lain' => $_POST["suket_beasiswa_lain_lama"],
            'raport_khs' => $_POST["raport_khs_lama"],
            'id_pelamar' => $id_pelamar,
            'f_id_pengirim' => $_SESSION['id_user'],
            'nama_pengirim' => $fetch_data_pelamar['nama'],
            'f_id_penerima' => $id_penerima['id_admin']
        ];
        
        $dataDiri->editDataDiriNext($data_diri);
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
                <h4>Edit data diri (Page 2) </h4>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="k1" value="<?= $getK1['id_pelamar_kriteria'];?>">
                        <label for="status_jemaat">Status Jemaat <small class="text-danger">*</small></label>
                        <select required class="form-control form-control-sm" name="data_diri[]" id="status_jemaat">
                            <option value="">-- Pilih --</option>
                            <?php foreach ($dataStatusJemaat as $key => $status_jemaat):?>
                            <option <?= $getK1['id_sub_kriteria'] == $status_jemaat['id_sub_kriteria'] ?'selected':'' ?>
                                value="<?=$status_jemaat['id_sub_kriteria'];?>">
                                <?=$status_jemaat['nama_sub_kriteria'];?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="k2" value="<?= $getK2['id_pelamar_kriteria'];?>">
                        <label for="aktif_kegiatan">Aktif Kegiatan <small class="text-danger">*</small></label>
                        <select required class="form-control form-control-sm" name="data_diri[]" id="aktif_kegiatan">
                            <option value="">-- Pilih --</option>
                            <?php foreach ($dataKeaktifan as $key => $aktif_kegiatan):?>
                            <option
                                <?= $getK2['id_sub_kriteria'] == $aktif_kegiatan['id_sub_kriteria'] ?'selected':'' ?>
                                value="<?=$aktif_kegiatan['id_sub_kriteria'];?>">
                                <?=$aktif_kegiatan['nama_sub_kriteria'];?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="k3" value="<?= $getK3['id_pelamar_kriteria'];?>">
                        <label for="status_keluarga">Status Keluarga <small class="text-danger">*</small></label>
                        <select required class="form-control form-control-sm" name="data_diri[]" id="status_keluarga">
                            <option value="">-- Pilih --</option>
                            <?php foreach ($dataStatusKeluarga as $key => $status_keluarga):?>
                            <option
                                <?= $getK3['id_sub_kriteria'] == $status_keluarga['id_sub_kriteria'] ? 'selected':'' ?>
                                value="<?=$status_keluarga['id_sub_kriteria'];?>">
                                <?=$status_keluarga['nama_sub_kriteria'];?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <?php
                                $pendapatan_ortu = $fetch_data_pelamar['pendapatan_ortu'];
                                $pendapatan_formatted = number_format($pendapatan_ortu, 0, ',', '.');
                                foreach ($dataPendapatanOrtu as $key => $pendapatan){
                                    if($getK4['id_sub_kriteria'] == $pendapatan['id_sub_kriteria']){
                                        $id_pel = $getK4['id_pelamar_kriteria'];
                                    } 
                                }
                                // Kemudian, gunakan $pendapatan_formatted dalam HTML
                            ?>
                        <input type="hidden" name="k4" value="<?=$id_pel;?>">
                        <label for="pendapatan">Pendapatan Ortu/wali <small class="text-danger">*</small></label>
                        <input required class="form-control form-control-sm" placeholder="Contoh: 1.000.000" type="text"
                            name="data_diri[]" value="<?=$pendapatan_formatted;?>" id="pendapatan">
                        <!-- <select required class="form-control form-control-sm" name="data_diri[]" id="pendapatan">
                            <option value="">-- Pilih --</option>
                            <?php foreach ($dataPendapatanOrtu as $key => $pendapatan):?>
                            <option <?= $getK4['id_sub_kriteria'] == $pendapatan['id_sub_kriteria'] ?'selected':'' ?>
                                value="<?=$pendapatan['id_sub_kriteria'];?>">
                                <?=$pendapatan['nama_sub_kriteria'];?></option>
                            <?php endforeach;?>
                        </select> -->
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="k5" value="<?= $getK5['id_pelamar_kriteria'];?>">
                        <label for="jumlah_tanggungan">Jumlah Tanggungan Ortu/wali <small
                                class="text-danger">*</small></label>
                        <select required class="form-control form-control-sm" name="data_diri[]" id="jumlah_tanggungan">
                            <option value="">-- Pilih --</option>
                            <?php foreach ($dataJumlahTanggungan as $key => $jumlah_tanggungan):?>
                            <option
                                <?= $getK5['id_sub_kriteria'] == $jumlah_tanggungan['id_sub_kriteria'] ?'selected':'' ?>
                                value="<?=$jumlah_tanggungan['id_sub_kriteria'];?>">
                                <?=$jumlah_tanggungan['nama_sub_kriteria'];?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="k6" value="<?= $getK6['id_pelamar_kriteria'];?>">
                        <label for="ipk"><?= $_SESSION['jenjang'] == 'pt' ? 'IPK ':'Nilai Rata-rata Raport ';?><small
                                class="text-danger">*</small></label>
                        <select required class="form-control form-control-sm" name="data_diri[]" id="ipk">
                            <option value="">-- Pilih --</option>
                            <?php foreach ($dataIPK as $key => $IPK):?>
                            <option <?= $getK6['id_sub_kriteria'] == $IPK['id_sub_kriteria'] ?'selected':'' ?>
                                value="<?=$IPK['id_sub_kriteria'];?>">
                                <?= $_SESSION['jenjang'] == 'pt' ? explode("/",$IPK['nama_sub_kriteria'])[1]:explode("/",$IPK['nama_sub_kriteria'])[0];?>
                            </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="k7" value="<?= $getK7['id_pelamar_kriteria'];?>">
                        <label for="semester"><?= $_SESSION['jenjang'] == 'pt' ? 'Semester':'Kelas';?> <small
                                class="text-danger">*</small></label>
                        <select required class="form-control form-control-sm" name="data_diri[]" id="semester">
                            <option value="">-- Pilih --</option>
                            <?php foreach ($dataSemester as $key => $semester):?>
                            <option <?= $getK7['id_sub_kriteria'] == $semester['id_sub_kriteria'] ?'selected':'' ?>
                                value="<?=$semester['id_sub_kriteria'];?>">
                                <?= $_SESSION['jenjang'] == 'pt' ? explode("/", $semester['nama_sub_kriteria'])[0]:explode("/",$semester['nama_sub_kriteria'])[1];?>
                            </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="kartu_keluarga_lama"
                            value="<?=$fetch_data_pelamar['kartu_keluarga'];?>">
                        <label for="kartu_keluarga" class="form-label">Kartu Keluarga
                        </label>
                        <input type="file" accept=".jpg, .jpeg, .png" class="form-control" name="kartu_keluarga"
                            id="kartu_keluarga" />
                        <small class="text-secondary"><i>Jika tidak ingin mengubah gambar, maka tidak perlu
                                menguploadnya lagi.</i></small>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="raport_khs_lama" value="<?=$fetch_data_pelamar['raport_khs'];?>">
                        <label for="raport_khs" class="form-label"><?= $_SESSION['jenjang'] == 'pt' ? 'KHS':'Raport';?>
                        </label>
                        <input type="file" accept=".jpg, .jpeg, .png" class="form-control" name="raport_khs"
                            id="raport_khs" />
                        <small class="text-secondary"><i>Jika tidak ingin mengubah gambar, maka tidak perlu
                                menguploadnya lagi.</i></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="./data_diri.php" class="btn btn-secondary" data-dismiss="modal">Kembali</a>
                    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require '../includes/footer.php';?>
