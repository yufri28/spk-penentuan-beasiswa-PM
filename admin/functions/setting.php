<?php 
require_once '../config.php';

class Setting{
    private $db;
    public function __construct()
    {
        $this->db = connectDatabase();
    }

    public function getPeriode($id_periode=null){
        return $this->db->query("SELECT * FROM periode WHERE id_periode=$id_periode");
    }
    public function getRayon(){
        return $this->db->query("SELECT * FROM rayon WHERE nama_rayon!='umum'");
    }
    public function addRayon($data=null){
        if($data == null){
            return $_SESSION['error'] = 'Tidak ada data yang dikirim.';
        }else{
            $nama_rayon = $data['nama_rayon'];
            $insertRayon = $this->db->query("INSERT INTO rayon(id_rayon,nama_rayon)VALUES(null,'$nama_rayon')");
            
            if ($this->db->affected_rows > 0 && $insertRayon) {
                $selectIdRayon = $this->db->query("SELECT id_rayon FROM rayon WHERE nama_rayon='$nama_rayon'")->fetch_assoc();
                $level = $data['level'];
                $username = $data['username'];
                $password = $data['password'];
                $id_rayon = $selectIdRayon['id_rayon'];
                $password_hash = password_hash($password,PASSWORD_BCRYPT);
                $insertKoor = $this->db->query("INSERT INTO admin(id_admin,username,password,level,f_id_rayon)VALUES(null,'$username','$password_hash',$level,$id_rayon)");
                if($insertKoor && $this->db->affected_rows > 0){
                    $_SESSION['success'] = "Data rayon berhasil disimpan.";
                }else{
                    $this->db->query("DELETE FROM rayon WHERE id_rayon=$id_rayon");
                    $_SESSION['error'] = "Data rayon gagal disimpan.";
                    return $_SESSION['error'];
                }
                // return $_SESSION['success'];
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