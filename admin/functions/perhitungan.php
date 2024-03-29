<?php 

require_once '../config.php';

class Perhitungan{
    private $db;

    public function __construct()
    {
        $this->db = connectDatabase();
    }

    public function GapAlternatif($jenjang=null,$periode=null){
        return $this->db->query("SELECT
            dp.id_pelamar,
            dp.nama,
            dp.f_id_rayon,
            dp.f_id_login,
            dp.pendapatan_ortu,
            dp.ipk,
            dp.kartu_keluarga,
            dp.raport_khs,
            dp.kartu_pelajar,
            pdt.f_id_periode,
            r.nama_rayon,
            pdt.terima,
            MAX(CASE WHEN k.id_kriteria = 'K1' THEN sk.nama_sub_kriteria END) AS nama_C1,
            MAX(CASE WHEN k.id_kriteria = 'K2' THEN sk.nama_sub_kriteria END) AS nama_C2,
            MAX(CASE WHEN k.id_kriteria = 'K3' THEN sk.bobot_sub_kriteria END) AS nama_C3,
            MAX(CASE WHEN k.id_kriteria = 'K4' THEN sk.nama_sub_kriteria END) AS nama_C4,
            MAX(CASE WHEN k.id_kriteria = 'K5' THEN sk.nama_sub_kriteria END) AS nama_C5,
            MAX(CASE WHEN k.id_kriteria = 'K6' THEN sk.nama_sub_kriteria END) AS nama_C6,
            MAX(CASE WHEN k.id_kriteria = 'K7' THEN sk.nama_sub_kriteria END) AS nama_C7,
            MAX(CASE WHEN k.id_kriteria = 'K1' THEN k.profile_target END) AS pt_C1,
            MAX(CASE WHEN k.id_kriteria = 'K2' THEN k.profile_target END) AS pt_C2,
            MAX(CASE WHEN k.id_kriteria = 'K3' THEN k.profile_target END) AS pt_C3,
            MAX(CASE WHEN k.id_kriteria = 'K4' THEN k.profile_target END) AS pt_C4,
            MAX(CASE WHEN k.id_kriteria = 'K5' THEN k.profile_target END) AS pt_C5,
            MAX(CASE WHEN k.id_kriteria = 'K6' THEN k.profile_target END) AS pt_C6,
            MAX(CASE WHEN k.id_kriteria = 'K7' THEN k.profile_target END) AS pt_C7,
            MAX(CASE WHEN k.id_kriteria = 'K1' THEN k.bobot_kriteria END) AS bobotC1,
            MAX(CASE WHEN k.id_kriteria = 'K2' THEN k.bobot_kriteria END) AS bobotC2,
            MAX(CASE WHEN k.id_kriteria = 'K3' THEN k.bobot_kriteria END) AS bobotC3,
            MAX(CASE WHEN k.id_kriteria = 'K4' THEN k.bobot_kriteria END) AS bobotC4,
            MAX(CASE WHEN k.id_kriteria = 'K5' THEN k.bobot_kriteria END) AS bobotC5,
            MAX(CASE WHEN k.id_kriteria = 'K6' THEN k.bobot_kriteria END) AS bobotC6,
            MAX(CASE WHEN k.id_kriteria = 'K7' THEN k.bobot_kriteria END) AS bobotC7,
            (SELECT MAX(CASE WHEN k.id_kriteria = 'K1' THEN sk.bobot_sub_kriteria END)) AS bobot_C1,
            (SELECT MAX(CASE WHEN k.id_kriteria = 'K2' THEN sk.bobot_sub_kriteria END)) AS bobot_C2,
            (SELECT MAX(CASE WHEN k.id_kriteria = 'K3' THEN sk.bobot_sub_kriteria END)) AS bobot_C3,
            (SELECT MAX(CASE WHEN k.id_kriteria = 'K4' THEN sk.bobot_sub_kriteria END)) AS bobot_C4,
            (SELECT MAX(CASE WHEN k.id_kriteria = 'K5' THEN sk.bobot_sub_kriteria END)) AS bobot_C5,
            (SELECT MAX(CASE WHEN k.id_kriteria = 'K6' THEN sk.bobot_sub_kriteria END)) AS bobot_C6,
            (SELECT MAX(CASE WHEN k.id_kriteria = 'K7' THEN sk.bobot_sub_kriteria END)) AS bobot_C7,
            (SELECT
                CASE
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K1' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K1' THEN k.profile_target END) = 0 THEN 5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K1' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K1' THEN k.profile_target END) = 1 THEN 4.5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K1' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K1' THEN k.profile_target END) = -1 THEN 4
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K1' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K1' THEN k.profile_target END) = 2 THEN 3.5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K1' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K1' THEN k.profile_target END) = -2 THEN 3
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K1' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K1' THEN k.profile_target END) = 3 THEN 2.5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K1' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K1' THEN k.profile_target END) = -3 THEN 2
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K1' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K1' THEN k.profile_target END) = 4 THEN 1.5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K1' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K1' THEN k.profile_target END) = -4 THEN 1
                END
            ) AS bobot_gap_C1,
            (SELECT
                CASE
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K2' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K2' THEN k.profile_target END) = 0 THEN 5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K2' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K2' THEN k.profile_target END) = 1 THEN 4.5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K2' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K2' THEN k.profile_target END) = -1 THEN 4
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K2' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K2' THEN k.profile_target END) = 2 THEN 3.5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K2' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K2' THEN k.profile_target END) = -2 THEN 3
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K2' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K2' THEN k.profile_target END) = 3 THEN 2.5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K2' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K2' THEN k.profile_target END) = -3 THEN 2
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K2' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K2' THEN k.profile_target END) = 4 THEN 1.5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K2' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K2' THEN k.profile_target END) = -4 THEN 1
                END
            ) AS bobot_gap_C2,
            (SELECT
                CASE
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K3' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K2' THEN k.profile_target END) = 0 THEN 5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K3' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K2' THEN k.profile_target END) = 1 THEN 4.5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K3' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K3' THEN k.profile_target END) = -1 THEN 4
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K3' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K3' THEN k.profile_target END) = 2 THEN 3.5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K3' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K3' THEN k.profile_target END) = -2 THEN 3
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K3' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K3' THEN k.profile_target END) = 3 THEN 2.5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K3' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K3' THEN k.profile_target END) = -3 THEN 2
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K3' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K3' THEN k.profile_target END) = 4 THEN 1.5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K3' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K3' THEN k.profile_target END) = -4 THEN 1
                END
            ) AS bobot_gap_C3,
            
            (SELECT
                CASE
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K4' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K4' THEN k.profile_target END) = 0 THEN 5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K4' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K4' THEN k.profile_target END) = 1 THEN 4.5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K4' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K4' THEN k.profile_target END) = -1 THEN 4
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K4' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K4' THEN k.profile_target END) = 2 THEN 3.5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K4' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K4' THEN k.profile_target END) = -2 THEN 3
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K4' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K4' THEN k.profile_target END) = 3 THEN 2.5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K4' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K4' THEN k.profile_target END) = -3 THEN 2
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K4' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K4' THEN k.profile_target END) = 4 THEN 1.5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K4' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K4' THEN k.profile_target END) = -4 THEN 1
                END
            ) AS bobot_gap_C4,
            (SELECT
                CASE
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K5' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K5' THEN k.profile_target END) = 0 THEN 5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K5' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K5' THEN k.profile_target END) = 1 THEN 4.5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K5' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K5' THEN k.profile_target END) = -1 THEN 4
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K5' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K5' THEN k.profile_target END) = 2 THEN 3.5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K5' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K5' THEN k.profile_target END) = -2 THEN 3
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K5' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K5' THEN k.profile_target END) = 3 THEN 2.5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K5' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K5' THEN k.profile_target END) = -3 THEN 2
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K5' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K5' THEN k.profile_target END) = 4 THEN 1.5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K5' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K5' THEN k.profile_target END) = -4 THEN 1
                END
            ) AS bobot_gap_C5,
            (SELECT
                CASE
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K6' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K6' THEN k.profile_target END) = 0 THEN 5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K6' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K6' THEN k.profile_target END) = 1 THEN 4.5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K6' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K6' THEN k.profile_target END) = -1 THEN 4
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K6' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K6' THEN k.profile_target END) = 2 THEN 3.5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K6' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K6' THEN k.profile_target END) = -2 THEN 3
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K6' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K6' THEN k.profile_target END) = 3 THEN 2.5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K6' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K6' THEN k.profile_target END) = -3 THEN 2
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K6' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K6' THEN k.profile_target END) = 4 THEN 1.5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K6' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K6' THEN k.profile_target END) = -4 THEN 1
                END
            ) AS bobot_gap_C6,
            (SELECT
                CASE
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K7' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K7' THEN k.profile_target END) = 0 THEN 5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K7' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K7' THEN k.profile_target END) = 1 THEN 4.5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K7' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K7' THEN k.profile_target END) = -1 THEN 4
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K7' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K7' THEN k.profile_target END) = 2 THEN 3.5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K7' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K7' THEN k.profile_target END) = -2 THEN 3
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K7' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K7' THEN k.profile_target END) = 3 THEN 2.5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K7' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K7' THEN k.profile_target END) = -3 THEN 2
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K7' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K7' THEN k.profile_target END) = 4 THEN 1.5
                    WHEN MAX(CASE WHEN k.id_kriteria = 'K7' THEN sk.bobot_sub_kriteria END) - MAX(CASE WHEN k.id_kriteria = 'K7' THEN k.profile_target END) = -4 THEN 1
                END
            ) AS bobot_gap_C7
        
        FROM
            data_pelamar dp
            JOIN login_pelamar lp ON lp.id_login = dp.f_id_login
            JOIN pdt pdt ON dp.id_pelamar = pdt.f_id_pelamar
            JOIN sub_kriteria sk ON pdt.f_id_sub_kriteria = sk.id_sub_kriteria
            JOIN kriteria k ON pdt.f_id_kriteria = k.id_kriteria
            JOIN rayon r ON r.id_rayon = dp.f_id_rayon
        WHERE
            lp.jenjang = '$jenjang' 
        AND
            pdt.f_id_periode = '$periode'
        GROUP BY
            dp.id_pelamar, dp.nama, dp.f_id_rayon, dp.f_id_login;");
    }

    public function perengkingan($jenjang=null,$periode=null){
        $perhitungan = $this->GapAlternatif($jenjang,$periode);
        $ranking = array();
        
        foreach ($perhitungan as $key => $value) {
            $jumlahCF = $value['bobot_gap_C1'] + $value['bobot_gap_C2'] + $value['bobot_gap_C3'] + $value['bobot_gap_C4'] + $value['bobot_gap_C5'];
            $jumlahSF = $value['bobot_gap_C6'] + $value['bobot_gap_C7'];
            
            $NCF = $jumlahCF / 5;
            $NSF = $jumlahSF / 2;
            
            $NMA = ($value['bobotC1'] * $NCF) + ($value['bobotC2'] * $NCF) + ($value['bobotC3'] * $NCF) + ($value['bobotC4'] * $NCF) + ($value['bobotC5'] * $NCF);
            $NSA = ($value['bobotC6'] * $NSF) + ($value['bobotC7'] * $NSF);
            
            $nilaiAkhir = ((5 / 7) * $NCF) + ((2 / 7) * $NSF);
    
            $ranking[] = [
                'id_pelamar' => $value['id_pelamar'],
                'nama' => $value['nama'],
                'nama_rayon' => $value['nama_rayon'],
                'f_id_rayon' => $value['f_id_rayon'],
                'f_id_login' => $value['f_id_login'],
                'f_id_periode' => $value['f_id_periode'],
                'kriteriaSatu' => $value['nama_C1'], 
                'kriteriaDua' => $value['nama_C2'], 
                'kriteriaTiga' => $value['nama_C3'], 
                'pendapatan_ortu' => $value['pendapatan_ortu'], 
                'kriteriaLima' => $value['nama_C5'], 
                'ipk' => $value['ipk'], 
                'kriteriaTujuh' => $value['nama_C7'],
                'kartu_keluarga' => $value['kartu_keluarga'],
                'raport_khs' => $value['raport_khs'],
                'kartu_pelajar' => $value['kartu_pelajar'],
                'nilaiAkhir' => $nilaiAkhir,
                'terima' => $value['terima'],
            ];
        }
    
        // Lakukan perengkingan
        usort($ranking, array($this, 'compare'));
    
        return $ranking;
    } 
    
    function compare($a, $b) {
        if ($a['nilaiAkhir'] == $b['nilaiAkhir']) {
            return 0;
        }
        return ($a['nilaiAkhir'] > $b['nilaiAkhir']) ? -1 : 1;
    }


    public function simpanHasil($data=[]) {
        $str_jenjang = "";
        $data_koor = $this->db->query("SELECT * FROM admin WHERE username != 'admin' AND level!=0");
        $data_periode = $this->db->query("SELECT deskripsi FROM periode WHERE id_periode='".$_SESSION['id_periode']."'")->fetch_assoc();
        $str_notifikasi = "";
        
        if (empty($data)) {
            return $_SESSION['error'] = "Tidak ada data yang dikirim!";
        } else {
            foreach ($data as $key => $value) {
                $f_id_pelamar = $value['id_pelamar'];
                $f_id_periode = $value['f_id_periode'];
                $nilai_rank = $value['nilai_rank'];
                $jenjang = $value['jenjang'];
                $str_jenjang = $value['jenjang'] == 'sma' ?'SMA':"Perguruan Tinggi";
                
                // Periksa keberadaan data sebelum penyimpanan
                $checkQuery = $this->db->query("SELECT * FROM hasil_akhir WHERE f_id_pelamar = $f_id_pelamar AND f_id_periode = $f_id_periode");
                if ($checkQuery->num_rows > 0) {
                    return $_SESSION['error'] = "Data sudah disimpan sebelumnya!";
                } else {
                    // Simpan data jika belum ada
                    $insert = $this->db->query("INSERT INTO hasil_akhir (id_hasil, f_id_pelamar, f_id_periode, nilai_rank, jenjang) VALUES (0, $f_id_pelamar, $f_id_periode, $nilai_rank, '$jenjang')");
                    
                }
            }
            
            $data_koor = $this->db->query("SELECT * FROM admin WHERE username != 'admin' AND level!=0");
            if($this->db->affected_rows > 0 && $insert){
                $id_koor = 0;
                foreach ($data_koor as $key_koordinator => $koordinator) {
                    $id_koor = $koordinator['id_admin'];
                    $str_notifikasi = "Hasil seleksi beasiswa ".$data_periode['deskripsi'].", jenjang ".$str_jenjang." telah disimpan oleh badan diakonat!";
                    $this->db->query("INSERT INTO notifikasi_admin (id_notif,f_id_penerima,f_id_pengirim,isi_notif,tanggal,dibuka,jenis_notif) VALUES (0,'$id_koor','1','$str_notifikasi',NOW(),'0','simpan-hasil-seleksi')");
                }
    
               // Data yang ingin disimpan ke file JSON
                $data = array(
                    'id_periode' => $_SESSION['id_periode'],
                    'isi_pengumuman' => "Hasil Seleksi Penerima Beasiswa",
                    'tanggal' => date('Y-m-d H:i:s') // Menggunakan format date yang benar
                );

                // Konversi array menjadi format JSON
                $jsonData = json_encode($data);

                // Simpan data ke file JSON
                $namaFile = './data.json';
                file_put_contents($namaFile, $jsonData);
                // if (file_put_contents($namaFile, $jsonData)) {
                //     // echo "Data telah disimpan ke $namaFile";
                // } else {
                //     // echo "Gagal menyimpan data ke $namaFile";
                // }
                return $_SESSION['success'] = "Data berhasil disimpan!";
            }else{
                return $_SESSION['success'] = "Data gagal disimpan!";
            }
        }
    }    
    
    public function getHasilAkhir($f_id_periode=null,$jenjang=null){
        return $this->db->query("SELECT * FROM hasil_akhir WHERE f_id_periode=$f_id_periode AND jenjang='$jenjang'");
    }


    public function tolak($data)
    {
        if(!empty($data))
        {
            $id_pelamar = $data['id_pelamar'];
            $id_periode = $data['id_periode'];
            $queryTolak = $this->db->query("UPDATE pdt SET terima='0' WHERE f_id_pelamar='$id_pelamar' AND f_id_periode='$id_periode'");
            if($queryTolak){
                return $_SESSION['success'] = "Proses berhasil!";
            }else{
                return $_SESSION['success'] = "Proses gagal!";
            }
        }
    }
    // public function hapusHasil($data)
    // {
    //     if(!empty($data))
    //     {
    //         $id_pelamar = $data['id_pelamar'];
    //         $id_periode = $data['id_periode'];
    //         $queryDelete = $this->db->query("DELETE FROM pdt WHERE f_id_pelamar='$id_pelamar' AND f_id_periode='$id_periode'");
    //         if($queryDelete){
    //             return $_SESSION['success'] = "Data berhasil dihapus!";
    //         }else{
    //             return $_SESSION['success'] = "Data gagal dihapus!";
    //         }
    //     }
    // }
}

$Perhitungan = new Perhitungan();



?>