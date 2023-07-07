<?php 
require_once '../config.php';

class Setting{
    private $db;
    public function __construct()
    {
        $this->db = connectDatabase();
    }

    public function getRayon(){
        return $this->db->query("SELECT * FROM rayon WHERE nama_rayon!='umum'");
    }
    public function addRayon($nama=null){
        if($nama == null){
            return $_SESSION['error'] = 'Tidak ada data yang dikirim.';
        }else{
            $nama_rayon = $nama;
            $insert = $this->db->query("INSERT INTO rayon(id_rayon,nama_rayon)VALUES(null,'$nama_rayon')");
            if ($this->db->affected_rows > 0) {
                $_SESSION['success'] = "Data rayon berhasil disimpan.";
                return $_SESSION['success'];
            } else {
                $_SESSION['error'] = "Data rayon gagal disimpan.";
                return $_SESSION['error'];
            }
        }
    }
    public function editRayon($id_rayon=null,$nama=null){
        if($nama == null && $id_rayon == null){
            return $_SESSION['error'] = 'Tidak ada data yang dikirim.';
        }else{
            $id = $id_rayon;
            $nama_rayon = $nama;
            $update = $this->db->query("UPDATE rayon SET nama_rayon='$nama_rayon' WHERE id_rayon=$id");
            if ($this->db->affected_rows > 0) {
                $_SESSION['success'] = "Data rayon berhasil diedit.";
                return $_SESSION['success'];
            } else {
                $_SESSION['error'] = "Data rayon gagal diedit.";
                return $_SESSION['error'];
            }
        }
    }
    public function hapusRayon($id_rayon=null){
        if($id_rayon == null){
            return $_SESSION['error'] = 'Tidak ada data yang dikirim.';
        }else{
            $id = $id_rayon;
            $delete = $this->db->query("DELETE FROM rayon WHERE id_rayon=$id");
            if ($this->db->affected_rows > 0) {
                $_SESSION['success'] = "Data rayon berhasil dihapus.";
                return $_SESSION['success'];
            } else {
                $_SESSION['error'] = "Data rayon gagal dihapus.";
                return $_SESSION['error'];
            }
        }
    }
}


$Setting = new Setting();



?>