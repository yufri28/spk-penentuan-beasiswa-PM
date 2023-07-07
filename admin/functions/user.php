<?php 

require_once '../config.php';

class User{
    private $db;

    public function __construct()
    {
        $this->db = connectDatabase();
    }

    public function getKoordinator(){
        return $this->db->query("SELECT * FROM admin a JOIN rayon r ON a.f_id_rayon=r.id_rayon WHERE username!='admin'");
    }
    public function addKoordinator($data=[]){

        
        if(empty($data)){
            return $_SESSION['error'] = 'Tidak ada data yang dikirim.';
        }else{
            $level = $data['level'];
            $username = $data['username'];
            $password = $data['password'];
            $id_rayon = $data['id_rayon'];
            $password_hash = password_hash($password,PASSWORD_BCRYPT);
            $insert = $this->db->query("INSERT INTO admin(id_admin,username,password,level,f_id_rayon)VALUES(null,'$username','$password_hash',$level,$id_rayon)");
            if ($this->db->affected_rows > 0) {
                $_SESSION['success'] = "Akun berhasil dibuat.";
                return $_SESSION['success'];
            } else {
                $_SESSION['error'] = "Akun gagal dibuat.";
                return $_SESSION['error'];
            }
        }
    }
    public function editKoordinator($data=[]){
        if(empty($data)){
            return $_SESSION['error'] = 'Tidak ada data yang dikirim.';
        }else{
            $id_admin = $data['id_admin'];
            $username = $data['username'];
            $password = $data['password'];
            $id_rayon = $data['id_rayon'];

            if($password == '' || $password == null){
                $update = $this->db->query("UPDATE admin SET username='$username',f_id_rayon=$id_rayon WHERE id_admin=$id_admin");
                if ($update) {
                    $_SESSION['success'] = "Akun berhasil diedit.";
                    return $_SESSION['success'];
                } else {
                    $_SESSION['error'] = "Akun gagal diedit.";
                    return $_SESSION['error'];
                }
            }else{
                $password_hash = password_hash($password,PASSWORD_BCRYPT);
                $update = $this->db->query("UPDATE admin SET username='$username',password='$password_hash',f_id_rayon=$id_rayon WHERE id_admin=$id_admin");
                if ($this->db->affected_rows > 0) {
                    $_SESSION['success'] = "Akun berhasil diedit.";
                    return $_SESSION['success'];
                } else {
                    $_SESSION['error'] = "Akun gagal diedit.";
                    return $_SESSION['error'];
                }
            }
            
        }
    }
    public function hapusKoordinator($id_admin=null){
        if($id_admin == null){
            return $_SESSION['error'] = 'Tidak ada data yang dikirim.';
        }else{
            $delete = $this->db->query("DELETE FROM admin WHERE id_admin=$id_admin");
            if ($this->db->affected_rows > 0) {
                $_SESSION['success'] = "Akun berhasil dihapus.";
                return $_SESSION['success'];
            } else {
                $_SESSION['error'] = "Akun gagal dihapus.";
                return $_SESSION['error'];
            }
        }
    }
    public function hapusPelamar($id_login=null){
        if($id_login == null){
            return $_SESSION['error'] = 'Tidak ada data yang dikirim.';
        }else{
            $delete = $this->db->query("DELETE FROM login_pelamar WHERE id_login=$id_login");
            if ($this->db->affected_rows > 0) {
                $_SESSION['success'] = "Akun berhasil dihapus.";
                return $_SESSION['success'];
            } else {
                $_SESSION['error'] = "Akun gagal dihapus.";
                return $_SESSION['error'];
            }
        }
    }
    public function getPelamar(){
        return $this->db->query("SELECT * FROM login_pelamar");
    }
    public function getRayon(){
        return $this->db->query("SELECT * FROM rayon WHERE nama_rayon!='umum'");
    }
}


$User = new User();

?>