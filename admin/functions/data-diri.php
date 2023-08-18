<?php 
require_once '../config.php';

class DataDiri{

    private $db;

    public function __construct()
    {
        $this->db = connectDatabase();
    }
    public function cekDataPelamar($id_login=null,$id_rayon=null){
        return $this->db->query("SELECT * FROM data_pelamar dp JOIN login_pelamar lp ON dp.f_id_login=lp.id_login JOIN rayon r ON dp.f_id_rayon=r.id_rayon WHERE f_id_login='$id_login' AND dp.f_id_rayon='$id_rayon'");
    }
    public function cekPelamarKriteria($id_login=null){
        return $this->db->query("SELECT * FROM pelamar_kriteria pk JOIN kriteria k ON pk.f_id_kriteria=k.id_kriteria JOIN sub_kriteria sk ON sk.id_sub_kriteria = pk.f_id_sub_kriteria JOIN data_pelamar dp ON dp.id_pelamar=pk.f_id_pelamar JOIN login_pelamar lp ON lp.id_login=dp.f_id_login WHERE dp.f_id_login=$id_login GROUP BY pk.f_id_kriteria;");
    }

}

$dataDiri = new DataDiri();

?>