<?php 
require_once '../config.php';

class Rayon{
    private $db;
    public function __construct()
    {
        $this->db = connectDatabase();
    }

    public function getRayon(){
        return $this->db->query("SELECT * FROM rayon WHERE nama_rayon!='umum'");
    }
}


$Rayon = new Rayon();



?>