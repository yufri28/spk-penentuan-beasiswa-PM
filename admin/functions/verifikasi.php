<?php 

require_once '../config.php';

class Verifikasi{

    private $db;
    public function __construct()
    {
        $this->db = connectDatabase();
    }
    public function countVerifikasi($id_rayon=null)
    {
        return $this->db->query("SELECT *, COUNT(*) AS jumlah FROM data_pelamar dp JOIN verifikasi v ON dp.id_pelamar = v.f_id_pelamar JOIN periode p ON p.id_periode = v.f_id_periode WHERE v.status = '1' AND dp.f_id_rayon = $id_rayon")->fetch_assoc();

    }
    public function countBelumVerifikasi($id_rayon=null)
    {
        return $this->db->query("SELECT *, COUNT(*) AS jumlah FROM data_pelamar dp JOIN verifikasi v ON dp.id_pelamar = v.f_id_pelamar JOIN periode p ON p.id_periode = v.f_id_periode WHERE v.status = '0' AND dp.f_id_rayon = $id_rayon")->fetch_assoc();
    }

    public function getPelamarBelumVerifikasi(){
        return $this->db->query("SELECT * FROM `verifikasi` v JOIN data_pelamar dp ON v.f_id_pelamar=dp.id_pelamar JOIN login_pelamar lp ON dp.f_id_login = lp.id_login JOIN rayon r ON r.id_rayon = dp.f_id_rayon WHERE v.status='0';");
    }
    public function getPelamarVerifikasi(){
        return $this->db->query("SELECT * FROM `verifikasi` v JOIN data_pelamar dp ON v.f_id_pelamar=dp.id_pelamar JOIN login_pelamar lp ON dp.f_id_login = lp.id_login JOIN rayon r ON r.id_rayon = dp.f_id_rayon WHERE v.status='1';");
    }
}

$Verifikasi = new Verifikasi();

?>