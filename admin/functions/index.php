<?php 

    require_once '../config.php';

    class Index{
        private $db;
        public function __construct()
        {
            $this->db = connectDatabase();
        }
        public function countKoordinator()
        {
            return $this->db->query("SELECT * FROM admin WHERE level!='0'");
        }
        public function countPelamar()
        {
            return $this->db->query("SELECT * FROM login_pelamar");
        }
        public function countDataPelamar()
        {
            return $this->db->query("SELECT * FROM data_pelamar");
        }
          public function countDataPelamarByRayon()
        {
            return $this->db->query(
                "SELECT data_pelamar.f_id_rayon, 
                rayon.nama_rayon, COUNT(*) 
                AS jumlah_pelamar FROM data_pelamar 
                JOIN rayon ON data_pelamar.f_id_rayon=rayon.id_rayon 
                GROUP BY rayon.id_rayon;"
                );
        }
        public function countKriteria()
        {
            return $this->db->query("SELECT * FROM kriteria");
        }
        public function countSubKriteria()
        {
            return $this->db->query("SELECT * FROM sub_kriteria");
        }
    }

    $Index = new Index();

?>