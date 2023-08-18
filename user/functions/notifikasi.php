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
        return $this->db->query("SELECT * FROM notifikasi_pelamar np JOIN login_pelamar lp ON lp.id_login=np.f_id_penerima WHERE np.f_id_penerima=$id_penerima;");
    }
    public function getNotifikasiBelumDibuka($id_penerima=null)
    {
        return $this->db->query("SELECT * FROM notifikasi_pelamar np JOIN login_pelamar lp ON lp.id_login=np.f_id_penerima WHERE np.f_id_penerima=$id_penerima ORDER BY np.id_notif DESC LIMIT 20;");
    }
    public function countBelumDibaca($id_penerima=null)
    {
        return $this->db->query("SELECT * FROM notifikasi_pelamar WHERE f_id_penerima=$id_penerima AND dibuka='0'");
    }
    public function updateNotif($id_notif=null){
        if($id_notif != null){
            $update = $this->db->query("UPDATE notifikasi_pelamar SET dibuka='1' WHERE id_notif=$id_notif");
        }
    }
}
$Notifikasi = new Notifikasi();

?>