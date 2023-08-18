<?php 

require_once '../config.php';

class Laporan{
    private $db;

    public function __construct()
    {
        $this->db = connectDatabase();
    }   
    
    public function getPeriode(){
        return $this->db->query(
            "SELECT * FROM periode"
        );
    }
    public function getRayon(){
        return $this->db->query(
            "SELECT * FROM rayon WHERE nama_rayon != 'umum'"
        );
    }
    public function getHasilAkhir($jenjang=null){
        return $this->db->query(
            "SELECT * FROM hasil_akhir ha
            JOIN data_pelamar dp ON dp.id_pelamar=ha.f_id_pelamar
            JOIN periode p ON p.id_periode=ha.f_id_periode
            JOIN rayon r ON dp.f_id_rayon=r.id_rayon
            WHERE ha.jenjang='$jenjang'"
        );
    }

    public function cetakByJenjang($jenjang=null){
        return $this->db->query(
            "SELECT * FROM hasil_akhir ha
            JOIN data_pelamar dp ON dp.id_pelamar=ha.f_id_pelamar
            JOIN login_pelamar lp ON dp.f_id_login=lp.id_login
            JOIN periode p ON p.id_periode=ha.f_id_periode
            JOIN rayon r ON dp.f_id_rayon=r.id_rayon WHERE lp.jenjang='$jenjang'"
        );
    }
    public function cetakByPeriode($id_periode=null){
        return $this->db->query(
            "SELECT * FROM hasil_akhir ha
            JOIN data_pelamar dp ON dp.id_pelamar=ha.f_id_pelamar
            JOIN periode p ON p.id_periode=ha.f_id_periode
            JOIN rayon r ON dp.f_id_rayon=r.id_rayon WHERE p.id_periode=$id_periode"
        );
    }
    public function cetakByRayon($id_rayon=null){
        return $this->db->query(
            "SELECT * FROM hasil_akhir ha
            JOIN data_pelamar dp ON dp.id_pelamar=ha.f_id_pelamar
            JOIN periode p ON p.id_periode=ha.f_id_periode
            JOIN rayon r ON dp.f_id_rayon=r.id_rayon WHERE dp.f_id_rayon=$id_rayon"
        );
    }
    public function cetakAll(){
        return $this->db->query(
            "SELECT * FROM hasil_akhir ha
            JOIN data_pelamar dp ON dp.id_pelamar=ha.f_id_pelamar
            JOIN periode p ON p.id_periode=ha.f_id_periode
            JOIN rayon r ON dp.f_id_rayon=r.id_rayon"
        );
    }
}

$Laporan = new Laporan();



?>