<?php 

require_once '../config.php';

class SubKriteria{

    private $db;

    public function __construct()
    {
        $this->db = connectDatabase();
    }

    public function getSubKriteria(){
        return $this->db->query("SELECT * FROM `sub_kriteria` sk 
                                JOIN kriteria k ON sk.f_id_kriteria = k.id_kriteria ORDER BY id_sub_kriteria ASC;");
    }

    public function addSubKriteria($data = []){
        if(empty($data)){
            return $_SESSION['error'] = 'Tidak ada data yang dikirim.';
        }else{
            $nama_sub_kriteria = $data['nama_sub_kriteria'];
            $id_kriteria = $data['id_kriteria'];
            $bobot_sub_kriteria = $data['bobot_sub_kriteria'];
            
            $query = "INSERT INTO sub_kriteria (id_sub_kriteria, nama_sub_kriteria, f_id_kriteria, bobot_sub_kriteria) 
                      VALUES (NULL, '$nama_sub_kriteria', '$id_kriteria', '$bobot_sub_kriteria')";
            $insert = $this->db->query($query);
            if ($this->db->affected_rows > 0) {
                $_SESSION['success'] = "Data berhasil disimpan.";
                return $_SESSION['success'];
            } else {
                $_SESSION['error'] = "Data gagal disimpan.";
                return $_SESSION['error'];
            }
            
        }
    }
    public function editSubKriteria($data = []){
        if(empty($data)){
            return $_SESSION['error'] = 'Tidak ada data yang dikirim.';
        }else{

            // echo "<pre>";
            // print_r($data);
            // echo "</pre>";
            // die;
            $id_sub_kriteria = $data['id_sub_kriteria'];
            $nama_sub_kriteria = $data['nama_sub_kriteria'];
            $id_kriteria = $data['id_kriteria'];
            $bobot_sub_kriteria = $data['bobot_sub_kriteria'];            
            $query = "UPDATE sub_kriteria SET nama_sub_kriteria='$nama_sub_kriteria',f_id_kriteria='$id_kriteria',bobot_sub_kriteria=$bobot_sub_kriteria WHERE id_sub_kriteria=$id_sub_kriteria";
            $insert = $this->db->query($query);
            if ($this->db->affected_rows > 0) {
                $_SESSION['success'] = "Data berhasil diedit.";
                return $_SESSION['success'];
            } else {
                $_SESSION['error'] = "Data gagal diedit.";
                return $_SESSION['error'];
            }
            
        }
    }
    public function hapusSubKriteria($id_sub_kriteria = null){
        if($id_sub_kriteria == null){
            return $_SESSION['error'] = 'Tidak ada data yang dikirim.';
        }else{          
            $query = "DELETE FROM sub_kriteria WHERE id_sub_kriteria=$id_sub_kriteria";
            $insert = $this->db->query($query);
            if ($this->db->affected_rows > 0) {
                $_SESSION['success'] = "Data berhasil dihapus.";
                return $_SESSION['success'];
            } else {
                $_SESSION['error'] = "Data gagal dihapus.";
                return $_SESSION['error'];
            }
            
        }
    }


}

$dataSubKriteria = new SubKriteria();

?>