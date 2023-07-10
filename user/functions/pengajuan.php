<?php 
 require_once '../config.php';

 class Pengajuan{

    private $db;

    public function __construct()
    {
        $this->db = connectDatabase();
    }

    public function getPeriode(){
        return $this->db->query("SELECT * FROM periode ORDER BY id_periode LIMIT 1");
    }
    public function getVerifikasi($id_pelamar){
        return $this->db->query("SELECT * FROM verifikasi WHERE f_id_pelamar=$id_pelamar");
    }

    public function ajukanBeasiswa($id_pelamar){
        $periode = mysqli_fetch_assoc($this->getPeriode());
        $id_periode = $periode['id_periode'];
        $insert = $this->db->query("INSERT INTO verifikasi(id_verifikasi,f_id_pelamar,f_id_periode,status)VALUES(0,$id_pelamar,$id_periode,'0')");

        if($this->db->affected_rows > 0 && $insert){
            return $_SESSION['success'] = "Pengajuan berhasil";
        }else{
            return $_SESSION['error'] = "Pengajuan gagal";
        }
    }

 }

$Pengajuan = new Pengajuan();


?>