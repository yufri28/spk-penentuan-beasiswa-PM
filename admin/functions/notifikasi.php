<?php 
require_once '../config.php';

class Notifikasi{
    private $db;
    public function __construct()
    {
        $this->db = connectDatabase();
    }
    
    public function getNotifikasi($id_penerima=null)
    {
        return $this->db->query("SELECT * FROM notifikasi_admin na JOIN admin a ON a.id_admin=na.f_id_penerima WHERE na.f_id_penerima=$id_penerima;");
    }
    public function getNotifikasiBelumDibuka($id_penerima=null)
    {
        return $this->db->query("SELECT * FROM notifikasi_admin na JOIN admin a ON a.id_admin=na.f_id_penerima WHERE na.f_id_penerima=$id_penerima AND dibuka='0';");
    }
    public function countBelumDibaca($id_penerima=null)
    {
        return $this->db->query("SELECT * FROM notifikasi_admin WHERE f_id_penerima=$id_penerima AND dibuka='0'");
    }
    public function updateNotif($id_notif=null){
        if($id_notif != null){
            $update = $this->db->query("UPDATE notifikasi_admin SET dibuka='1' WHERE id_notif=$id_notif");
        }
    }
}
$Notifikasi = new Notifikasi();

?>