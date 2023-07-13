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
                $f_id_penerima = $data['f_id_penerima'];
                $f_id_pengirim = $data['f_id_pengirim'];
                $nama_pengirim = $data['nama_pengirim'];
                
                $update = $this->db->query(
                    "UPDATE data_pelamar
                    SET s_aktif_sekolah='$suket_aktif_kuliah',s_beasiswa_lain='$suket_beasiswa_lain',
                    raport_khs='$raport_khs' WHERE id_pelamar=$id_pelamar");
                foreach ($kriteria_pelamar as $key => $kriteria) {
                    $update = $this->db->query("UPDATE pelamar_kriteria SET f_id_kriteria='$key',f_id_sub_kriteria=$kriteria,f_id_pelamar=$id_pelamar WHERE id_pelamar_kriteria=$data_kriteria[$key]");
                }
                if($update){
                    $isi_notif = $nama_pengirim." telah memperbaharui data dirinya.";
                    $this->db->query("INSERT INTO notifikasi_admin(id_notif,f_id_penerima,f_id_pengirim,isi_notif,tanggal,dibuka,jenis_notif)VALUES(0,$f_id_penerima,$f_id_pengirim,'$isi_notif',NOW(),'0','data-diri')");
                    $_SESSION['success'] = "Data berhasil diedit";
                    echo '<script>window.location.href = "./data_diri.php";</script>';
                }else{
                    return $_SESSION['error'] = "Data gagal diedit";
                }
        }
    }

    public function getStatusJemaat(){
        return $this->db->query("SELECT * FROM sub_kriteria WHERE f_id_kriteria='K1'");
    }
    public function getKeaktifan(){
        return $this->db->query("SELECT * FROM sub_kriteria WHERE f_id_kriteria='K2'");
    }
    public function getStatusKeluarga(){
        return $this->db->query("SELECT * FROM sub_kriteria WHERE f_id_kriteria='K3'");
    }
    public function getPendapatanOrtu(){
        return $this->db->query("SELECT * FROM sub_kriteria WHERE f_id_kriteria='K4'");
    }
    public function getJumlahTanggungan(){
        return $this->db->query("SELECT * FROM sub_kriteria WHERE f_id_kriteria='K5'");
    }
    public function cekDataPelamar($id_login){
        return $this->db->query("SELECT * FROM data_pelamar dp JOIN rayon r ON dp.f_id_rayon=r.id_rayon WHERE f_id_login='$id_login'");
    }
    public function cekPelamarKriteria($id_pelamar){
        return $this->db->query("SELECT * FROM pelamar_kriteria pk JOIN kriteria k ON pk.f_id_kriteria=k.id_kriteria JOIN sub_kriteria sk ON sk.f_id_kriteria = k.id_kriteria WHERE pk.f_id_pelamar=$id_pelamar GROUP BY pk.f_id_kriteria;");
    }
    public function getK1($id_pelamar){
        return $this->db->query("SELECT * FROM pelamar_kriteria pk JOIN kriteria k ON pk.f_id_kriteria=k.id_kriteria JOIN sub_kriteria sk ON sk.f_id_kriteria = k.id_kriteria WHERE pk.f_id_pelamar=$id_pelamar AND k.id_kriteria='K1' GROUP BY pk.f_id_kriteria LIMIT 1;");
    }
    public function getK2($id_pelamar){
        return $this->db->query("SELECT * FROM pelamar_kriteria pk JOIN kriteria k ON pk.f_id_kriteria=k.id_kriteria JOIN sub_kriteria sk ON sk.f_id_kriteria = k.id_kriteria WHERE pk.f_id_pelamar=$id_pelamar AND k.id_kriteria='K2' GROUP BY pk.f_id_kriteria LIMIT 1;");
    }
    public function getK3($id_pelamar){
        return $this->db->query("SELECT * FROM pelamar_kriteria pk JOIN kriteria k ON pk.f_id_kriteria=k.id_kriteria JOIN sub_kriteria sk ON sk.f_id_kriteria = k.id_kriteria WHERE pk.f_id_pelamar=$id_pelamar AND k.id_kriteria='K3' GROUP BY pk.f_id_kriteria LIMIT 1;");
    }
    public function getK4($id_pelamar){
        return $this->db->query("SELECT * FROM pelamar_kriteria pk JOIN kriteria k ON pk.f_id_kriteria=k.id_kriteria JOIN sub_kriteria sk ON sk.f_id_kriteria = k.id_kriteria WHERE pk.f_id_pelamar=$id_pelamar AND k.id_kriteria='K4' GROUP BY pk.f_id_kriteria LIMIT 1;");
    }
    public function getK5($id_pelamar){
        return $this->db->query("SELECT * FROM pelamar_kriteria pk JOIN kriteria k ON pk.f_id_kriteria=k.id_kriteria JOIN sub_kriteria sk ON sk.f_id_kriteria = k.id_kriteria WHERE pk.f_id_pelamar=$id_pelamar AND k.id_kriteria='K5' GROUP BY pk.f_id_kriteria LIMIT 1;");
    }
    public function getAdmin($id_rayon=null){
        return $this->db->query("SELECT * FROM admin WHERE f_id_rayon=$id_rayon");
    }

}

$dataDiri = new DataDiri();

?>