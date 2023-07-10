<?php 

    require_once '../config.php';
    class Pelamar{
        private $db;
        public function __construct()
        {
            $this->db = connectDatabase();
        }

        public function getPelamar(){
            return $this->db->query("SELECT * FROM data_pelamar dp JOIN login_pelamar lp ON dp.f_id_login = lp.id_login JOIN rayon r ON r.id_rayon = dp.f_id_rayon");
        }
    }

    $dataPelamar = new Pelamar();


?>