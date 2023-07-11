<?php 
require_once '../config.php';

class Pesan{
    private $db;
    public function __construct()
    {
        $this->db = connectDatabase();
    }

    public function getPesan($id_penerima)
    {
        return $this->db->query("SELECT * FROM pesan p JOIN admin a ON a.id_admin=p.f_id_pengirim WHERE f_id_penerima=$id_penerima");
    }
    public function countBelumDibaca($id_penerima=null)
    {
        return $this->db->query("SELECT * FROM pesan WHERE f_id_penerima=$id_penerima AND dibuka='0'");
    }
    public function updatePesan($id_pesan=null){
        $update = $this->db->query("UPDATE pesan SET dibuka='1' WHERE id_pesan=$id_pesan");
        if($update){
            echo '<script>window.location.href = "";</script>';
        }
    }
}
$Pesan = new Pesan();

?>