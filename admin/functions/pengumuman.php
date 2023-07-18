<?php 

require_once './config.php';

class Pengumuman{
    private $db;

    public function __construct()
    {
        $this->db = connectDatabase();
    }

    public function getPengumuman(){
        return $this->db->query("SELECT * FROM pengumuman");
    }

    public function getPengumumanById($id=null){
        return $this->db->query("SELECT * FROM pengumuman WHERE id_pengumuman='$id'");
    }
}


?>