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
    public function getVerifikasi($id_login=null,$id_periode=null){
        return $this->db->query("SELECT * FROM verifikasi v JOIN data_pelamar dp ON dp.id_pelamar=v.f_id_pelamar JOIN login_pelamar lp ON lp.id_login=dp.f_id_login WHERE lp.id_login=$id_login AND v.f_id_periode=$id_periode");
    }

    public function ajukanBeasiswa($data=[]){
        if(empty($data)){
            return $_SESSION['error'] = "Tidak ada data yang dikirim.";
        }else{
            $periode = mysqli_fetch_assoc($this->getPeriode());
            $id_pelamar = $data['f_id_pelamar'];
            $id_periode = $periode['id_periode'];
            $insert = $this->db->query("INSERT INTO verifikasi(id_verifikasi,f_id_pelamar,f_id_periode,status)VALUES(0,$id_pelamar,$id_periode,'0')");
            if($this->db->affected_rows > 0 && $insert){
                $f_id_penerima = $data['f_id_penerima'];
                $f_id_pengirim = $data['f_id_pengirim'];
                $nama_pelamar = $data['nama_pelamar'];
                $isi_notif = $nama_pelamar." melakukan pengajuan beasiswa.";
                $this->db->query("INSERT INTO notifikasi_admin(id_notif,f_id_penerima,f_id_pengirim,isi_notif,tanggal,dibuka,jenis_notif)VALUES(0,$f_id_penerima,$f_id_pengirim,'$isi_notif',NOW(),'0','pengajuan')");
                return $_SESSION['success'] = "Pengajuan berhasil";
            }else{
                return $_SESSION['error'] = "Pengajuan gagal";
            }
        }
    }
    public function getPeriodeById($id_periode=null){
        return $this->db->query("SELECT * FROM periode WHERE id_periode=$id_periode");
    }   

    public function getHasil($id_login=null,$id_periode){
        return $this->db->query("SELECT * FROM hasil_akhir ha JOIN data_pelamar dp ON dp.id_pelamar = ha.f_id_pelamar JOIN login_pelamar lp ON lp.id_login=dp.f_id_login JOIN periode p ON p.id_periode=ha.f_id_periode WHERE lp.id_login = $id_login AND ha.f_id_periode=$id_periode;");
    }

 }

$Pengajuan = new Pengajuan();


?>