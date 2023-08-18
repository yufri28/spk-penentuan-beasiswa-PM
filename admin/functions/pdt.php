<?php 

require_once '../config.php';

class PDT{
    private $db;

    public function __construct()
    {
        $this->db = connectDatabase();
    }
    public function addPdt($data=[],$f_id_penerima=null,$id_pelamar=null,$f_id_pengirim=null){
       
        if(empty($data)){
            return $_SESSION['error'] = "Tidak ada yang dikirim.";
        }else{
            $fetchPeriode = mysqli_fetch_assoc($this->getPeriode());
            $id_periode = $fetchPeriode['id_periode'];
            foreach ($data as $key => $pdt) {
               $insert = $this->db->query("INSERT INTO pdt(id_pdt,f_id_kriteria,f_id_sub_kriteria,f_id_pelamar,f_id_periode)VALUES(0,'$key',$pdt,$id_pelamar,$id_periode)");
            }
            if($this->db->affected_rows > 0 && $insert){
                $this->db->query("UPDATE verifikasi SET status='1' WHERE f_id_pelamar=$id_pelamar");
                $isi_notif = "Data anda telah diverifikasi.";
                $this->db->query("INSERT INTO notifikasi_pelamar(id_notif,f_id_pengirim,f_id_penerima,isi_notifikasi,tanggal,dibuka)VALUES(0,$f_id_pengirim,$f_id_penerima,'$isi_notif',NOW(),'0')");
                $_SESSION['success'] = "Verifikasi berhasil.";
                echo '<script>window.location.href = "./verifikasi.php";</script>';
            }else{
                return $_SESSION['success'] = "Verifikasi gagal.";
            }
        }
    }
    public function getPeriode(){
        return $this->db->query("SELECT * FROM periode ORDER BY id_periode DESC LIMIT 1");
    }
}

$PDT = new PDT();
?>