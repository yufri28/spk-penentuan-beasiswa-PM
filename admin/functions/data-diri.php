<?php 
require_once '../config.php';

class DataDiri{

    private $db;

    public function __construct()
    {
        $this->db = connectDatabase();
    }

    public function addDataDiri($data=[])
    {
        if(empty($data)){
            return $_SESSION['error'] = "Tidak ada data yang dikirim.";
        }else{
                $nama = $data['nama'];
                $foto = $data['foto'];
                $sekolah = $data['sekolah'];
                $jurusan = $data['jurusan'];
                $no_hp = $data['no_hp'];
                $f_id_rayon = $data['rayon'];
                $f_id_login = $data['f_id_login'];
                
                $insert = $this->db->query(
                    "INSERT INTO data_pelamar
                    (id_pelamar,nama,foto,sekolah,
                    jurusan,no_hp,s_aktif_sekolah,
                    s_beasiswa_lain,
                    raport_khs,f_id_rayon,
                    f_id_login)
                    VALUES(null,'$nama','$foto',
                    '$sekolah','$jurusan','$no_hp',
                    null,null,null,
                    $f_id_rayon,$f_id_login)");

                if($this->db->affected_rows > 0 && $insert){
                    echo '<script>window.location.href = "./add-next.php";</script>';
                }else{
                    return $_SESSION['error'] = "Data gagal disimpan";
                }
        }
    }
    public function addDataDiriNext($data=[])
    {
        if(empty($data)){
            return $_SESSION['error'] = "Tidak ada data yang dikirim.";
        }else{
                $status_jemaat = $data['status_jemaat'];
                $aktif_kegiatan =  $data['aktif_kegiatan'];
                $status_keluarga =  $data['status_keluarga'];
                $pendapatan =  $data['pendapatan'];
                $jumlah_tanggungan =  $data['jumlah_tanggungan'];

                $kriteria_pelamar = [
                    'K1' => $status_jemaat,
                    'K2' => $aktif_kegiatan,
                    'K3' => $status_keluarga,
                    'K4' => $pendapatan,
                    'K5' => $jumlah_tanggungan
                ];
                $suket_aktif_kuliah =  $data['suket_aktif_kuliah'];
                $suket_beasiswa_lain =  $data['suket_beasiswa_lain'];
                $raport_khs =  $data['raport_khs'];
                $id_pelamar = $data['id_pelamar'];
                
                $update = $this->db->query(
                    "UPDATE data_pelamar
                    SET s_aktif_sekolah='$suket_aktif_kuliah',s_beasiswa_lain='$suket_beasiswa_lain',
                    raport_khs='$raport_khs' WHERE id_pelamar=$id_pelamar");
                foreach ($kriteria_pelamar as $key => $kriteria) {
                    $insert = $this->db->query("INSERT INTO pelamar_kriteria(id_pelamar_kriteria,f_id_kriteria,f_id_sub_kriteria,f_id_pelamar) VALUES (0,'$key',$kriteria,$id_pelamar)");
                }
                
                if($this->db->affected_rows > 0){
                    $_SESSION['success'] = "Data berhasil disimpan";
                    echo '<script>window.location.href = "./data_diri.php";</script>';
                }else{
                    return $_SESSION['error'] = "Data gagal disimpan";
                }
        }
    }
    public function editDataDiri($data=[])
    {
        if(empty($data)){
            return $_SESSION['error'] = "Tidak ada data yang dikirim.";
        }else{
                $id_pelamar = $data['id_pelamar'];
                $nama = $data['nama'];
                $foto = $data['foto'];
                $sekolah = $data['sekolah'];
                $jurusan = $data['jurusan'];
                $no_hp = $data['no_hp'];
                $f_id_rayon = $data['rayon'];
                $f_id_login = $data['f_id_login'];
                
                $update = $this->db->query(
                    "UPDATE data_pelamar
                    SET nama='$nama',foto='$foto',
                    sekolah='$sekolah',jurusan='$jurusan',no_hp='$no_hp',
                    f_id_rayon=$f_id_rayon,f_id_login=$f_id_login WHERE id_pelamar=$id_pelamar");
                    
                if($update){
                    echo '<script>window.location.href = "./edit-next.php";</script>';
                }else{
                    return $_SESSION['error'] = "Data gagal diedit";
                }
        }
    }
    public function editDataDiriNext($data=[])
    {
        if(empty($data)){
            return $_SESSION['error'] = "Tidak ada data yang dikirim.";
        }else{
                $status_jemaat = $data['status_jemaat'];
                $aktif_kegiatan =  $data['aktif_kegiatan'];
                $status_keluarga =  $data['status_keluarga'];
                $pendapatan =  $data['pendapatan'];
                $jumlah_tanggungan =  $data['jumlah_tanggungan'];

                $data_kriteria = [
                    'K1' => $data['k1'],
                    'K2' => $data['k2'],
                    'K3' => $data['k3'],
                    'K4' => $data['k4'],
                    'K5' => $data['k5']
                ];
                $kriteria_pelamar = [
                    'K1' => $status_jemaat,
                    'K2' => $aktif_kegiatan,
                    'K3' => $status_keluarga,
                    'K4' => $pendapatan,
                    'K5' => $jumlah_tanggungan
                ];
                $suket_aktif_kuliah =  $data['suket_aktif_kuliah'];
                $suket_beasiswa_lain =  $data['suket_beasiswa_lain'];
                $raport_khs =  $data['raport_khs'];
                $id_pelamar = $data['id_pelamar'];
                
                $update = $this->db->query(
                    "UPDATE data_pelamar
                    SET s_aktif_sekolah='$suket_aktif_kuliah',s_beasiswa_lain='$suket_beasiswa_lain',
                    raport_khs='$raport_khs' WHERE id_pelamar=$id_pelamar");
                foreach ($kriteria_pelamar as $key => $kriteria) {
                    $update = $this->db->query("UPDATE pelamar_kriteria SET f_id_kriteria='$key',f_id_sub_kriteria=$kriteria,f_id_pelamar=$id_pelamar WHERE id_pelamar_kriteria=$data_kriteria[$key]    ");
                }
                if($update){
                    $_SESSION['success'] = "Data berhasil diedit";
                    echo '<script>window.location.href = "./data_diri.php";</script>';
                }else{
                    return $_SESSION['error'] = "Data gagal diedit";
                }
        }
    }

    public function cekDataPelamar($id_login=null,$id_rayon=null){
        return $this->db->query("SELECT * FROM data_pelamar dp JOIN rayon r ON dp.f_id_rayon=r.id_rayon WHERE f_id_login='$id_login' AND dp.f_id_rayon='$id_rayon'");
    }
    public function cekPelamarKriteria($id_login=null){
        return $this->db->query("SELECT * FROM pelamar_kriteria pk JOIN kriteria k ON pk.f_id_kriteria=k.id_kriteria JOIN sub_kriteria sk ON sk.f_id_kriteria = k.id_kriteria JOIN data_pelamar dp ON dp.id_pelamar=pk.f_id_pelamar JOIN login_pelamar lp ON lp.id_login=dp.f_id_login WHERE dp.f_id_login=$id_login GROUP BY pk.f_id_kriteria;");
    }
    public function getK6(){
        return $this->db->query("SELECT * FROM sub_kriteria sk JOIN kriteria k ON sk.f_id_kriteria=k.id_kriteria WHERE sk.nama_sub_kriteria='Ada' AND k.id_kriteria='K6'");
    }
    public function getK7(){
        return $this->db->query("SELECT * FROM sub_kriteria sk JOIN kriteria k ON sk.f_id_kriteria=k.id_kriteria WHERE sk.nama_sub_kriteria='Ada'AND k.id_kriteria='K7'");
    }
    public function getK8(){
        return $this->db->query("SELECT * FROM sub_kriteria sk JOIN kriteria k ON sk.f_id_kriteria=k.id_kriteria WHERE sk.nama_sub_kriteria='Ada'AND k.id_kriteria='K8'");
    }

}

$dataDiri = new DataDiri();

?>