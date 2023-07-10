<?php 
session_start();
unset($_SESSION['menu']);
$_SESSION['menu'] = 'data-diri';
require_once '../includes/header.php';
require_once './functions/rayon.php';
require_once './functions/data-diri.php';

$cekDataPelamar = $dataDiri->cekDataPelamar($_SESSION['id_user']);
if(mysqli_num_rows($cekDataPelamar) == 1){
    echo '<script>window.location.href = "./add-next.php";</script>';
}


if (isset($_POST["selanjutnya"])) {
    // Pastikan ada file gambar yang diunggah
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $namaFile = $_FILES['foto']['name'];
        $lokasiSementara = $_FILES['foto']['tmp_name'];
        
        // Tentukan lokasi tujuan penyimpanan
        $targetDir = './uploads/profil/';
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
            $nama = $_POST['data_diri'][0];
            $sekolah = $_POST['data_diri'][1];
            $jurusan = $_POST['data_diri'][2];
            $no_hp = $_POST['data_diri'][3];
            $rayon = $_POST['data_diri'][4];
            
            $data_diri = [
                'nama' => $nama,
                'sekolah' => $sekolah,
                'jurusan' => $jurusan,
                'no_hp' => $no_hp,
                'rayon' => $rayon,
                'foto' => $namaFile,
                'f_id_login' => $_SESSION['id_user']
            ];

            $dataDiri->addDataDiri($data_diri);
        } else {
            return $_SESSION['error'] = 'Tidak ada data yang dikirim!';
        }
    } else {
        return $_SESSION['error'] = 'Tidak ada data yang dikirim!';
    }    
  }
  
$dataRayon = $Rayon->getRayon();

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
<div class="row d-flex justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="modal-header">
                <h4>Tambah data diri (Page 1)</h4>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama">Nama Lengkap <small class="text-danger">*</small></label>
                        <input class="form-control form-control-sm" required name="data_diri[]" type="text"
                            placeholder="Nama">
                    </div>
                    <div class="form-group">
                        <label for="sekolah">Nama Sekolah/PT <small class="text-danger">*</small></label>
                        <input class="form-control form-control-sm" required name="data_diri[]" type="text"
                            placeholder="Nama Sekolah/PT">
                    </div>
                    <div class="form-group">
                        <label for="jurusan">Jurusan <small class="text-danger">*</small></label>
                        <input class="form-control form-control-sm" required name="data_diri[]" type="text"
                            placeholder="Jurusan sekolah/PT">
                    </div>
                    <div class="form-group">
                        <label for="no_hp">No HP <small class="text-danger">*</small></label>
                        <input class="form-control form-control-sm" required name="data_diri[]" type="number"
                            placeholder="Nomor HP">
                    </div>
                    <div class="form-group">
                        <label for="foto" class="form-label">Foto Profil <small class="text-danger">*</small></label>
                        <input type="file" accept=".jpg, .jpeg, .png" class="form-control" name="foto" id="foto"
                            required placeholder="Foto profil anda" />
                    </div>
                    <div class="form-group">
                        <label for="Rayon">Rayon <small class="text-danger">*</small></label>
                        <select required class="form-control form-control-sm" name="data_diri[]" id="Rayon">
                            <option value="">-- Pilih Rayon --</option>
                            <?php foreach ($dataRayon as $key => $koordinator_rayon):?>
                            <option value="<?=$koordinator_rayon['id_rayon'];?>">
                                <?=$koordinator_rayon['nama_rayon'];?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="./data_diri.php" class="btn btn-secondary" data-dismiss="modal">Kembali</a>
                    <button type="submit" name="selanjutnya" class="btn btn-primary">Selanjutnya</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require '../includes/footer.php';?>