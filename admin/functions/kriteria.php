<?php 

require_once '../config.php';
class Kriteria{
    private $db;

    public function __construct()
    {
        $this->db = connectDatabase();
        $this->addKriteria();
    }

    public function getKriteria(){
        return $this->db->query("SELECT * FROM kriteria");
    }

    public function addKriteria(){
        $data_kriteria = [
            ["K1","Status jemaat",0.2,"CF",3],
            ["K2","Keaktifan kegiatan bergereja",0.15,"CF",3],
            ["K3","Status keluarga",0.15,"CF",3],
            ["K4","Pendapatan orang tua",0.2,"CF",5],
            ["K5","Jumlah tanggungan orang tua",0.2,"CF",5],
            ["K6","Raport pendidikan / Kartu Hasil Studi (KHS)",0.05,"SF",5],
            ["K7","Semester",0.05,"SF",3]
        ];
       
        foreach ($data_kriteria as $key => $kriteria) {
            $cekKriteria = $this->db->query("SELECT * FROM kriteria WHERE LOWER(nama_kriteria) = '".strtolower($kriteria[1])."' OR id_kriteria != '$kriteria[0]'");
            if(mysqli_num_rows($cekKriteria) < 1){
                $this->db->query(
                    "INSERT INTO kriteria(id_kriteria,nama_kriteria,bobot_kriteria,faktor,profile_target) 
                    VALUES ('$kriteria[0]','$kriteria[1]',$kriteria[2],'$kriteria[3]',$kriteria[4])");
            }
        }
    }

}

$dataKriteria = new Kriteria();

?>