<?php 
require_once '../config.php';

class Pesan{
    private $db;
    public function __construct()
    {
        $this->db = connectDatabase();
    }

    public function kirimPesan($pesan = [])
    {
        if(empty($pesan)){
            return $_SESSION['error'] = "Tidak ada pesan yang akan dikirim";
        }else{
            $f_id_penerima = $pesan['f_id_penerima'];
            $f_id_pengirim = $pesan['f_id_pengirim'];
            $isi_pesan = $pesan['isi_pesan'];
            $insertMsg = $this->db->query("INSERT INTO pesan (id_pesan,f_id_pengirim,f_id_penerima,pesan,tanggal_kirim,dibuka)VALUES(0,$f_id_pengirim,$f_id_penerima,'$isi_pesan',NOW(),'0')");
            if($this->db->affected_rows > 0 && $insertMsg){
                return $_SESSION['success'] = "Pesan telah terkirim";
            }else{
                return $_SESSION['error'] = "Pesan tidak terkirim";
            }
        }
    }
}
$Pesan = new Pesan();

?>