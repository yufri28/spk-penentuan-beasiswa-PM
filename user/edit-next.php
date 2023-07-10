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
$fetch_pelamar_kriteria = mysqli_fetch_assoc($cekPelamarKriteria);

if (isset($_POST["simpan"])) {
    // Pastikan ada file gambar yang diunggah
    if (
        (isset($_FILES['suket_aktif_kuliah']) && $_FILES['suket_aktif_kuliah']['error'] === UPLOAD_ERR_OK) ||
        (isset($_FILES['suket_beasiswa_lain']) && $_FILES['suket_beasiswa_lain']['error'] === UPLOAD_ERR_OK) ||
        (isset($_FILES['raport_khs']) && $_FILES['raport_khs']['error'] === UPLOAD_ERR_OK)
    ) {
        // Array informasi file yang diunggah
        $files = [];

        if (isset($_FILES['suket_aktif_kuliah']) && $_FILES['suket_aktif_kuliah']['error'] === UPLOAD_ERR_OK) {
            $files['suket_aktif_kuliah'] = $_FILES['suket_aktif_kuliah'];
        }

        if (isset($_FILES['suket_beasiswa_lain']) && $_FILES['suket_beasiswa_lain']['error'] === UPLOAD_ERR_OK) {
            $files['suket_beasiswa_lain'] = $_FILES['suket_beasiswa_lain'];
        }

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
        $pendapatan = $_POST['data_diri'][3];
        $jumlah_tanggungan = $_POST['data_diri'][4];
        $data_diri = [
            'k1' => $_POST['k1'],
            'k2' => $_POST['k2'],
            'k3' => $_POST['k3'],
            'k4' => $_POST['k4'],
            'k5' => $_POST['k5'],
            'status_jemaat' => $status_jemaat,
            'aktif_kegiatan' => $aktif_kegiatan,
            'status_keluarga' => $status_keluarga,
            'pendapatan' => $pendapatan,
            'jumlah_tanggungan' => $jumlah_tanggungan,
            'suket_aktif_kuliah' => isset($uploadedFiles['suket_aktif_kuliah']) ? $uploadedFiles['suket_aktif_kuliah'] : $_POST["suket_aktif_kuliah_lama"],
            'suket_beasiswa_lain' => isset($uploadedFiles['suket_beasiswa_lain']) ? $uploadedFiles['suket_beasiswa_lain'] : $_POST["suket_beasiswa_lain_lama"],
            'raport_khs' => isset($uploadedFiles['raport_khs']) ? $uploadedFiles['raport_khs'] : $_POST["raport_khs_lama"],
            'id_pelamar' => $id_pelamar
        ];
        $dataDiri->editDataDiriNext($data_diri);
    } else {
        $status_jemaat = $_POST['data_diri'][0];
        $aktif_kegiatan = $_POST['data_diri'][1];
        $status_keluarga = $_POST['data_diri'][2];
        $pendapatan = $_POST['data_diri'][3];
        $jumlah_tanggungan = $_POST['data_diri'][4];
        $data_diri = [
            'k1' => $_POST['k1'],
            'k2' => $_POST['k2'],
            'k3' => $_POST['k3'],
            'k4' => $_POST['k4'],
            'k5' => $_POST['k5'],
            'status_jemaat' => $status_jemaat,
            'aktif_kegiatan' => $aktif_kegiatan,
            'status_keluarga' => $status_keluarga,
            'pendapatan' => $pendapatan,
            'jumlah_tanggungan' => $jumlah_tanggungan,
            'suket_aktif_kuliah' => $_POST["suket_aktif_kuliah_lama"],
            'suket_beasiswa_lain' => $_POST["suket_beasiswa_lain_lama"],
            'raport_khs' => $_POST["raport_khs_lama"],
            'id_pelamar' => $id_pelamar
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
?>


<div class="row d-flex justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="modal-header">
                <h4>Edit data diri (Page 2)</h4>
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
                        <input type="hidden" name="k4" value="<?= $getK4['id_pelamar_kriteria'];?>">
                        <label for="pendapatan">Pendapatan Ortu <small class="text-danger">*</small></label>
                        <select required class="form-control form-control-sm" name="data_diri[]" id="pendapatan">
                            <option value="">-- Pilih --</option>
                            <?php foreach ($dataPendapatanOrtu as $key => $pendapatan):?>
                            <option <?= $getK4['id_sub_kriteria'] == $pendapatan['id_sub_kriteria'] ?'selected':'' ?>
                                value="<?=$pendapatan['id_sub_kriteria'];?>">
                                <?=$pendapatan['nama_sub_kriteria'];?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="k5" value="<?= $getK5['id_pelamar_kriteria'];?>">
                        <label for="jumlah_tanggungan">Jumlah Tanggungan Ortu <small
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
                        <input type="hidden" name="suket_aktif_kuliah_lama"
                            value="<?=$fetch_data_pelamar['s_aktif_sekolah'];?>">
                        <label for="suket_aktif_kuliah" class="form-label">Suket Aktif Sekolah/Kuliah</label>
                        <input type="file" accept=".jpg, .jpeg, .png" class="form-control" name="suket_aktif_kuliah"
                            id="suket_aktif_kuliah" />
                        <small class="text-secondary"><i>Jika tidak ingin mengubah gambar, maka tidak perlu
                                menguploadnya lagi.</i></small>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="suket_beasiswa_lain_lama"
                            value="<?=$fetch_data_pelamar['s_beasiswa_lain'];?>">
                        <label for="suket_beasiswa_lain" class="form-label">Suket Tidak Sedang Menerima Beasiswa Lain
                        </label>
                        <input type="file" accept=".jpg, .jpeg, .png" class="form-control" name="suket_beasiswa_lain"
                            id="suket_beasiswa_lain" />
                        <small class="text-secondary"><i>Jika tidak ingin mengubah gambar, maka tidak perlu
                                menguploadnya lagi.</i></small>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="raport_khs_lama" value="<?=$fetch_data_pelamar['raport_khs'];?>">
                        <label for="raport_khs" class="form-label">Raport/KHS
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