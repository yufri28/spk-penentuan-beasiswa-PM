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
            "SELECT *,
            MAX(CASE WHEN k.id_kriteria = 'K1' THEN sk.nama_sub_kriteria END) AS C1,
               MAX(CASE WHEN k.id_kriteria = 'K2' THEN sk.nama_sub_kriteria END) AS C2,
               MAX(CASE WHEN k.id_kriteria = 'K3' THEN sk.nama_sub_kriteria END) AS C3,
               MAX(CASE WHEN k.id_kriteria = 'K5' THEN sk.nama_sub_kriteria END) AS C5,
               MAX(CASE WHEN k.id_kriteria = 'K7' THEN sk.nama_sub_kriteria END) AS C7
           FROM hasil_akhir ha
                       JOIN data_pelamar dp ON dp.id_pelamar=ha.f_id_pelamar
                       JOIN login_pelamar lp ON dp.f_id_login=lp.id_login
                       JOIN periode p ON p.id_periode=ha.f_id_periode
                       JOIN pelamar_kriteria pk ON pk.f_id_pelamar = dp.id_pelamar
                       JOIN kriteria k ON k.id_kriteria=pk.f_id_kriteria
                       JOIN sub_kriteria sk ON sk.id_sub_kriteria = pk.f_id_sub_kriteria
                       JOIN rayon r ON dp.f_id_rayon=r.id_rayon WHERE lp.jenjang='$jenjang' GROUP BY ha.id_hasil;"
        );
    }
    // public function getHasilAkhir($jenjang=null){
    //     return $this->db->query(
    //         "SELECT * FROM hasil_akhir ha
    //         JOIN data_pelamar dp ON dp.id_pelamar=ha.f_id_pelamar
    //         JOIN periode p ON p.id_periode=ha.f_id_periode
    //         JOIN rayon r ON dp.f_id_rayon=r.id_rayon
    //         WHERE ha.jenjang='$jenjang'"
    //     );
    // }

    public function cetakByJenjang($jenjang=null){
        return $this->db->query(
            "SELECT *,
            MAX(CASE WHEN k.id_kriteria = 'K1' THEN sk.nama_sub_kriteria END) AS C1,
               MAX(CASE WHEN k.id_kriteria = 'K2' THEN sk.nama_sub_kriteria END) AS C2,
               MAX(CASE WHEN k.id_kriteria = 'K3' THEN sk.nama_sub_kriteria END) AS C3,
               MAX(CASE WHEN k.id_kriteria = 'K5' THEN sk.nama_sub_kriteria END) AS C5,
               MAX(CASE WHEN k.id_kriteria = 'K7' THEN sk.nama_sub_kriteria END) AS C7
           FROM hasil_akhir ha
                       JOIN data_pelamar dp ON dp.id_pelamar=ha.f_id_pelamar
                       JOIN login_pelamar lp ON dp.f_id_login=lp.id_login
                       JOIN periode p ON p.id_periode=ha.f_id_periode
                       JOIN pelamar_kriteria pk ON pk.f_id_pelamar = dp.id_pelamar
                       JOIN kriteria k ON k.id_kriteria=pk.f_id_kriteria
                       JOIN sub_kriteria sk ON sk.id_sub_kriteria = pk.f_id_sub_kriteria
                       JOIN rayon r ON dp.f_id_rayon=r.id_rayon WHERE lp.jenjang='$jenjang' GROUP BY ha.id_hasil;"
        );
    }
    // public function cetakByJenjang($jenjang=null){
    //     return $this->db->query(
    //         "SELECT * FROM hasil_akhir ha
    //         JOIN data_pelamar dp ON dp.id_pelamar=ha.f_id_pelamar
    //         JOIN login_pelamar lp ON dp.f_id_login=lp.id_login
    //         JOIN periode p ON p.id_periode=ha.f_id_periode
    //         JOIN rayon r ON dp.f_id_rayon=r.id_rayon WHERE lp.jenjang='$jenjang'"
    //     );
    // }
    public function cetakByPeriode($id_periode=null){
        return $this->db->query(
            "SELECT *,
            MAX(CASE WHEN k.id_kriteria = 'K1' THEN sk.nama_sub_kriteria END) AS C1,
               MAX(CASE WHEN k.id_kriteria = 'K2' THEN sk.nama_sub_kriteria END) AS C2,
               MAX(CASE WHEN k.id_kriteria = 'K3' THEN sk.nama_sub_kriteria END) AS C3,
               MAX(CASE WHEN k.id_kriteria = 'K5' THEN sk.nama_sub_kriteria END) AS C5,
               MAX(CASE WHEN k.id_kriteria = 'K7' THEN sk.nama_sub_kriteria END) AS C7
           FROM hasil_akhir ha
                       JOIN data_pelamar dp ON dp.id_pelamar=ha.f_id_pelamar
                       JOIN login_pelamar lp ON dp.f_id_login=lp.id_login
                       JOIN periode p ON p.id_periode=ha.f_id_periode
                       JOIN pelamar_kriteria pk ON pk.f_id_pelamar = dp.id_pelamar
                       JOIN kriteria k ON k.id_kriteria=pk.f_id_kriteria
                       JOIN sub_kriteria sk ON sk.id_sub_kriteria = pk.f_id_sub_kriteria
                       JOIN rayon r ON dp.f_id_rayon=r.id_rayon WHERE p.id_periode=$id_periode GROUP BY ha.id_hasil;"
        );
    }
    // public function cetakByPeriode($id_periode=null){
    //     return $this->db->query(
    //         "SELECT * FROM hasil_akhir ha
    //         JOIN data_pelamar dp ON dp.id_pelamar=ha.f_id_pelamar
    //         JOIN periode p ON p.id_periode=ha.f_id_periode
    //         JOIN rayon r ON dp.f_id_rayon=r.id_rayon WHERE p.id_periode=$id_periode"
    //     );
    // }
    public function cetakByRayon($id_rayon=null){
        return $this->db->query(
            "SELECT *,
            MAX(CASE WHEN k.id_kriteria = 'K1' THEN sk.nama_sub_kriteria END) AS C1,
               MAX(CASE WHEN k.id_kriteria = 'K2' THEN sk.nama_sub_kriteria END) AS C2,
               MAX(CASE WHEN k.id_kriteria = 'K3' THEN sk.nama_sub_kriteria END) AS C3,
               MAX(CASE WHEN k.id_kriteria = 'K5' THEN sk.nama_sub_kriteria END) AS C5,
               MAX(CASE WHEN k.id_kriteria = 'K7' THEN sk.nama_sub_kriteria END) AS C7
           FROM hasil_akhir ha
                       JOIN data_pelamar dp ON dp.id_pelamar=ha.f_id_pelamar
                       JOIN login_pelamar lp ON dp.f_id_login=lp.id_login
                       JOIN periode p ON p.id_periode=ha.f_id_periode
                       JOIN pelamar_kriteria pk ON pk.f_id_pelamar = dp.id_pelamar
                       JOIN kriteria k ON k.id_kriteria=pk.f_id_kriteria
                       JOIN sub_kriteria sk ON sk.id_sub_kriteria = pk.f_id_sub_kriteria
                       JOIN rayon r ON dp.f_id_rayon=r.id_rayon WHERE dp.f_id_rayon=$id_rayon GROUP BY ha.id_hasil;"
        );
    }
    // public function cetakByRayon($id_rayon=null){
    //     return $this->db->query(
    //         "SELECT * FROM hasil_akhir ha
    //         JOIN data_pelamar dp ON dp.id_pelamar=ha.f_id_pelamar
    //         JOIN periode p ON p.id_periode=ha.f_id_periode
    //         JOIN rayon r ON dp.f_id_rayon=r.id_rayon WHERE dp.f_id_rayon=$id_rayon"
    //     );
    // }
    public function cetakAll(){
        return $this->db->query(
            "SELECT *,
            MAX(CASE WHEN k.id_kriteria = 'K1' THEN sk.nama_sub_kriteria END) AS C1,
               MAX(CASE WHEN k.id_kriteria = 'K2' THEN sk.nama_sub_kriteria END) AS C2,
               MAX(CASE WHEN k.id_kriteria = 'K3' THEN sk.nama_sub_kriteria END) AS C3,
               MAX(CASE WHEN k.id_kriteria = 'K5' THEN sk.nama_sub_kriteria END) AS C5,
               MAX(CASE WHEN k.id_kriteria = 'K7' THEN sk.nama_sub_kriteria END) AS C7
           FROM hasil_akhir ha
                       JOIN data_pelamar dp ON dp.id_pelamar=ha.f_id_pelamar
                       JOIN login_pelamar lp ON dp.f_id_login=lp.id_login
                       JOIN periode p ON p.id_periode=ha.f_id_periode
                       JOIN pelamar_kriteria pk ON pk.f_id_pelamar = dp.id_pelamar
                       JOIN kriteria k ON k.id_kriteria=pk.f_id_kriteria
                       JOIN sub_kriteria sk ON sk.id_sub_kriteria = pk.f_id_sub_kriteria
                       JOIN rayon r ON dp.f_id_rayon=r.id_rayon GROUP BY ha.id_hasil;"
        );
    }
    // public function cetakAll(){
    //     return $this->db->query(
    //         "SELECT * FROM hasil_akhir ha
    //         JOIN data_pelamar dp ON dp.id_pelamar=ha.f_id_pelamar
    //         JOIN periode p ON p.id_periode=ha.f_id_periode
    //         JOIN rayon r ON dp.f_id_rayon=r.id_rayon"
    //     );
    // }
}

$Laporan = new Laporan();



?>