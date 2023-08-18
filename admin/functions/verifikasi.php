<?php 

require_once '../config.php';

class Verifikasi{

    private $db;
    public function __construct()
    {
        $this->db = connectDatabase();
    }
    public function countVerifikasi($id_rayon=null,$id_periode=null)
    {
        return $this->db->query("SELECT *, COUNT(*) AS jumlah FROM data_pelamar dp JOIN verifikasi v ON dp.id_pelamar = v.f_id_pelamar JOIN periode p ON p.id_periode = v.f_id_periode WHERE v.status = '1' AND dp.f_id_rayon = $id_rayon AND v.f_id_periode=$id_periode")->fetch_assoc();

    }
    public function countBelumVerifikasi($id_rayon=null,$id_periode=null)
    {
        return $this->db->query("SELECT *, COUNT(*) AS jumlah FROM data_pelamar dp JOIN verifikasi v ON dp.id_pelamar = v.f_id_pelamar JOIN periode p ON p.id_periode = v.f_id_periode WHERE v.status = '0' AND dp.f_id_rayon = $id_rayon AND v.f_id_periode=$id_periode")->fetch_assoc();
    }

    public function getPelamarBelumVerifikasi($id_rayon=null){
        return $this->db->query("SELECT * FROM `verifikasi` v JOIN data_pelamar dp ON v.f_id_pelamar=dp.id_pelamar JOIN login_pelamar lp ON dp.f_id_login = lp.id_login JOIN rayon r ON r.id_rayon = dp.f_id_rayon WHERE v.status='0' AND dp.f_id_rayon=$id_rayon;");
    }
    public function getPelamarVerifikasi($id_rayon=null,$id_periode=null){
        return $this->db->query("SELECT * FROM `verifikasi` v JOIN data_pelamar dp ON v.f_id_pelamar=dp.id_pelamar JOIN login_pelamar lp ON dp.f_id_login = lp.id_login JOIN rayon r ON r.id_rayon = dp.f_id_rayon WHERE v.status='1' AND dp.f_id_rayon=$id_rayon AND v.f_id_periode=$id_periode;");
    }

    public function cekVerifikasiUser($id_login=null,$id_rayon=null,$id_periode=null){
        // return $this->db->query("SELECT * FROM verifikasi WHERE f_id_pelamar=$id_pelemar")->fetch_assoc();
        return $this->db->query("SELECT * FROM `verifikasi` v JOIN data_pelamar dp ON dp.id_pelamar=v.f_id_pelamar JOIN rayon r ON r.id_rayon=dp.f_id_rayon JOIN login_pelamar lp ON dp.f_id_login=lp.id_login WHERE dp.f_id_rayon=$id_rayon AND dp.f_id_login=$id_login AND v.f_id_periode=$id_periode;")->fetch_assoc();
    }
}

$Verifikasi = new Verifikasi();

?>