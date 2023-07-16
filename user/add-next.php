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

if(mysqli_num_rows($cekDataPelamar) != 1){
    echo '<script>window.location.href = "./add-data-diri.php";</script>';
}else if(mysqli_num_rows($cekDataPelamar) == 1 && mysqli_num_rows($cekPelamarKriteria) == 5){
    echo '<script>window.location.href = "./data_diri.php";</script>';
}

if (isset($_POST["simpan"])) {
    // Pastikan ada file gambar yang diunggah
    if ((isset($_FILES['kartu_keluarga']) && $_FILES['kartu_keluarga']['error'] === UPLOAD_ERR_OK) 
    && (isset($_FILES['suket_beasiswa_lain']) && $_FILES['suket_beasiswa_lain']['error'] === UPLOAD_ERR_OK)
    && isset($_FILES['raport_khs']) && $_FILES['raport_khs']['error'] === UPLOAD_ERR_OK) {
        // Array informasi file yang diunggah
        $files = [
            $_FILES['kartu_keluarga'],
            $_FILES['suket_beasiswa_lain'],
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
        $pendapatan = $_POST['data_diri'][3];
        $jumlah_tanggungan = $_POST['data_diri'][4];
        $ipk = $_POST['data_diri'][5];
        $semester = $_POST['data_diri'][6];
    
        $data_diri = [
            'status_jemaat' => $status_jemaat,
            'aktif_kegiatan' => $aktif_kegiatan,
            'status_keluarga' => $status_keluarga,
            'pendapatan' => $pendapatan,
            'jumlah_tanggungan' => $jumlah_tanggungan,
            'ipk' => $ipk,
            'semester' => $semester,
            'kartu_keluarga' => $uploadedFiles[0],
            'suket_beasiswa_lain' => $uploadedFiles[1],
            'raport_khs' => $uploadedFiles[2],
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
                        <label for="pendapatan">Pendapatan Ortu <small class="text-danger">*</small></label>
                        <select required class="form-control form-control-sm" name="data_diri[]" id="pendapatan">
                            <option value="">-- Pilih --</option>
                            <?php foreach ($dataPendapatanOrtu as $key => $pendapatan):?>
                            <option value="<?=$pendapatan['id_sub_kriteria'];?>">
                                <?=$pendapatan['nama_sub_kriteria'];?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_tanggungan">Jumlah Tanggungan Ortu <small
                                class="text-danger">*</small></label>
                        <select required class="form-control form-control-sm" name="data_diri[]" id="jumlah_tanggungan">
                            <option value="">-- Pilih --</option>
                            <?php foreach ($dataJumlahTanggungan as $key => $jumlah_tanggungan):?>
                            <option value="<?=$jumlah_tanggungan['id_sub_kriteria'];?>">
                                <?=$jumlah_tanggungan['nama_sub_kriteria'];?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ipk">IPK <small class="text-danger">*</small></label>
                        <select required class="form-control form-control-sm" name="data_diri[]" id="ipk">
                            <option value="">-- Pilih --</option>
                            <?php foreach ($dataIPK as $key => $IPK):?>
                            <option value="<?=$IPK['id_sub_kriteria'];?>">
                                <?=$IPK['nama_sub_kriteria'];?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="semester">Semester <small class="text-danger">*</small></label>
                        <select required class="form-control form-control-sm" name="data_diri[]" id="semester">
                            <option value="">-- Pilih --</option>
                            <?php foreach ($dataSemester as $key => $semester):?>
                            <option value="<?=$semester['id_sub_kriteria'];?>">
                                <?=$semester['nama_sub_kriteria'];?></option>
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
                        <label for="suket_beasiswa_lain" class="form-label">Suket Beasiswa Lain
                            <small class="text-danger">*</small></label>
                        <input type="file" accept=".jpg, .jpeg, .png" class="form-control" name="suket_beasiswa_lain"
                            id="suket_beasiswa_lain" required />
                    </div>
                    <div class="form-group">
                        <label for="raport_khs" class="form-label">Raport/KHS
                            <small class="text-danger">*</small></label>
                        <input type="file" accept=".jpg, .jpeg, .png" class="form-control" name="raport_khs"
                            id="raport_khs" required />
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