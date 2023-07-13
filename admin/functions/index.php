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