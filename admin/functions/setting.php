<?php 
require_once '../config.php';

class Setting{
    private $db;
    public function __construct()
    {
        $this->db = connectDatabase();

        $this->tutupPeriode();

    }

    public function tutupPeriode() {
        // Ambil waktu sekarang
        $waktu_sekarang = time(); // Gunakan fungsi time() atau sumber waktu lain yang sesuai dengan kebutuhan Anda
            // Ambil periode yang sedang dibuka
        $getPeriodeAktif = $this->db->query("SELECT * FROM periode WHERE status='buka'")->fetch_assoc();
        if ($getPeriodeAktif) {
            // Konversi batas buka dari string ke timestamp
            $batas_buka_timestamp = strtotime($getPeriodeAktif['batas_koor']);
            // Periksa apakah batas buka telah berlalu
            if ($batas_buka_timestamp < $waktu_sekarang) {
                // Jika batas buka telah berlalu, ubah status periode menjadi 'tutup'
                $this->db->query("UPDATE periode SET status='tutup' WHERE id_periode='" . $getPeriodeAktif['id_periode'] . "'");
            }
        }
    }
    

    public function getPeriode($id_periode=null){
        return $this->db->query("SELECT * FROM periode WHERE id_periode=$id_periode");
    }
    public function getAllPeriode(){
        return $this->db->query("SELECT * FROM periode");
    }
    public function getPeriodeActive($id_periode=null){
        return $this->db->query("SELECT * FROM periode WHERE id_periode='$id_periode'")->fetch_assoc();
    }
    public function getRayon(){
        return $this->db->query("SELECT * FROM rayon WHERE nama_rayon!='umum'");
    }
    public function addRayon($data=null){
        if($data == null){
            return $_SESSION['error'] = 'Tidak ada data yang dikirim.';
        }else{
            $nama_rayon = $data['nama_rayon'];
            $insertRayon = $this->db->query("INSERT INTO rayon(id_rayon,nama_rayon)VALUES(null,'$nama_rayon')");
            
            if ($this->db->affected_rows > 0 && $insertRayon) {
                $selectIdRayon = $this->db->query("SELECT id_rayon FROM rayon WHERE nama_rayon='$nama_rayon'")->fetch_assoc();
                $level = $data['level'];
                $username = $data['username'];
                $password = $data['password'];
                $id_rayon = $selectIdRayon['id_rayon'];
                $password_hash = password_hash($password,PASSWORD_BCRYPT);
                $insertKoor = $this->db->query("INSERT INTO admin(id_admin,username,password,level,f_id_rayon)VALUES(null,'$username','$password_hash',$level,$id_rayon)");
                if($insertKoor && $this->db->affected_rows > 0){
                    $_SESSION['success'] = "Data rayon berhasil disimpan.";
                }else{
                    $this->db->query("DELETE FROM rayon WHERE id_rayon=$id_rayon");
                    $_SESSION['error'] = "Data rayon gagal disimpan.";
                    return $_SESSION['error'];
                }
                // return $_SESSION['success'];
            } else {
                $_SESSION['error'] = "Data rayon gagal disimpan.";
                return $_SESSION['error'];
            }
        }
    }
    public function editRayon($id_rayon=null,$nama=null){
        if($nama == null && $id_rayon == null){
            return $_SESSION['error'] = 'Tidak ada data yang dikirim.';
        }else{
            $id = $id_rayon;
            $nama_rayon = $nama;
            $update = $this->db->query("UPDATE rayon SET nama_rayon='$nama_rayon' WHERE id_rayon=$id");
            if ($this->db->affected_rows > 0) {
                $_SESSION['success'] = "Data rayon berhasil diedit.";
                return $_SESSION['success'];
            } else {
                $_SESSION['error'] = "Data rayon gagal diedit.";
                return $_SESSION['error'];
            }
        }
    }
    public function hapusRayon($id_rayon=null){
        if($id_rayon == null){
            return $_SESSION['error'] = 'Tidak ada data yang dikirim.';
        }else{
            $id = $id_rayon;
            $delete = $this->db->query("DELETE FROM rayon WHERE id_rayon=$id");
            if ($this->db->affected_rows > 0) {
                $_SESSION['success'] = "Data rayon berhasil dihapus.";
                return $_SESSION['success'];
            } else {
                $_SESSION['error'] = "Data rayon gagal dihapus.";
                return $_SESSION['error'];
            }
        }
    }
    public function addPeriode($data=null){
        if($data == null){
            return $_SESSION['error'] = 'Tidak ada data yang dikirim.';
        }else{
            $periode = $data['periode'];
            $cekPeriode = mysqli_num_rows($this->db->query("SELECT * FROM periode WHERE LOWER(nama_periode)='".strtolower($periode)."'"));

            if($cekPeriode > 0){
                $_SESSION['error'] = "Data periode sudah ada.";
            }else{
                
                $deskripsi = $data['deskripsi'];
                $kuota_sma = $data['kuota_sma'];
                $kuota_pt =$data['kuota_pt'];
                $status = $data['status'];
                $batas_koor = $data['batas_koor'];
                $batas_pelamar = $data['batas_pelamar'];

                // Close all existing periods
                $selectIdPeriode = $this->db->query("SELECT id_periode FROM periode WHERE status='buka'");
                if(mysqli_num_rows($selectIdPeriode) > 0){
                    $id_periode = mysqli_fetch_assoc($selectIdPeriode);
                    $closePeriode = $this->db->query("UPDATE periode SET status='tutup' 
                    WHERE id_periode='".$id_periode['id_periode']."'");
                    if (!$closePeriode || $this->db->affected_rows <= 0) {
                        return $_SESSION['error'] = "Gagal menutup periode sebelumnya.";
                    }

                    $insertPeriode = $this->db->query("INSERT INTO periode(id_periode,nama_periode,deskripsi,kuota_sma,kuota_pt,status,batas_koor,batas_pelamar)VALUES(0,'$periode','$deskripsi',$kuota_sma,$kuota_pt,'buka','$batas_koor','$batas_pelamar')");
                    if($insertPeriode && $this->db->affected_rows > 0){
                    return $_SESSION['success'] = "Data periode berhasil disimpan.";
                    } else {
                        return $_SESSION['error'] = "Data periode gagal disimpan.";
                    }
                }else{
                    $insertPeriode = $this->db->query("INSERT INTO periode(id_periode,nama_periode,deskripsi,kuota_sma,kuota_pt,status,batas_koor,batas_pelamar)VALUES(0,'$periode','$deskripsi',$kuota_sma,$kuota_pt,'buka','$batas_koor','$batas_pelamar')");
                    if($insertPeriode && $this->db->affected_rows > 0){
                    return $_SESSION['success'] = "Data periode berhasil disimpan.";
                    } else {
                        return $_SESSION['error'] = "Data periode gagal disimpan.";
                    }
                }
            }
            
        }
    }
    public function editPeriode($data=null){
        
        if($data == null){
            return $_SESSION['error'] = 'Tidak ada data yang dikirim.';
        }else{            
            $id_periode = $data['id_periode'];
            $nama_periode = $data['nama_periode'];
            $deskripsi = $data['deskripsi'];
            $kuota_sma = $data['kuota_sma'];
            $kuota_pt =$data['kuota_pt'];
            $status = $data['status'];
            $batas_koor = $data['batas_koor'];
            $batas_pelamar = $data['batas_pelamar'];

            // Close all existing periods
            $selectIdPeriode = $this->db->query("SELECT id_periode FROM periode WHERE status='buka'");
            if(mysqli_num_rows($selectIdPeriode) > 0){
                $idPeriode = mysqli_fetch_assoc($selectIdPeriode);
                $closePeriode = $this->db->query("UPDATE periode SET status='tutup' WHERE id_periode='".$idPeriode['id_periode']."'");
                if ($closePeriode || $this->db->affected_rows > 0) {
                    $editPeriode = $this->db->query("UPDATE `periode` SET nama_periode='$nama_periode',deskripsi='$deskripsi',kuota_sma=$kuota_sma,kuota_pt=$kuota_pt,status='$status',batas_koor='$batas_koor',batas_pelamar='$batas_pelamar' WHERE id_periode=$id_periode");
                    if($editPeriode){
                        return $_SESSION['success'] = "Data periode berhasil diedit.";
                    } else {
                        return $_SESSION['error'] = "Data periode gagal diedit.";
                    }
                }else{
                    return $_SESSION['error'] = "Gagal menutup periode sebelumnya.";
                }

            }else{
                $editPeriode = $this->db->query("UPDATE `periode` SET nama_periode='$nama_periode',deskripsi='$deskripsi',kuota_sma=$kuota_sma,kuota_pt=$kuota_pt,status='$status',batas_koor='$batas_koor',batas_pelamar='$batas_pelamar' WHERE id_periode=$id_periode");
                if($editPeriode){
                return $_SESSION['success'] = "Data periode berhasil diedit.";
                } else {
                    return $_SESSION['error'] = "Data periode gagal diedit.";
                }
            }
            
            
        }
    }
    public function hapusPeriode($id_periode=null){
        if($id_periode == null){
            return $_SESSION['error'] = 'Tidak ada data yang dikirim.';
        }else{
            $id = $id_periode;
            $delete = $this->db->query("DELETE FROM periode WHERE id_periode=$id");
            if ($this->db->affected_rows > 0) {
                $_SESSION['success'] = "Data rayon berhasil dihapus.";
                return $_SESSION['success'];
            } else {
                $_SESSION['error'] = "Data rayon gagal dihapus.";
                return $_SESSION['error'];
            }
        }
    }

    public function getPengumuman(){
        return $this->db->query("SELECT * FROM pengumuman");
    }

    public function getPengumumanById($id=null){
        return $this->db->query("SELECT * FROM pengumuman WHERE id_pengumuman='$id'");
    }
    public function simpanPengumuman($data=null){
        if($data==null){
            return $_SESSION['error'] = "Tidak ada data yang dikirim.";
        }else{
            $judul = $data['judul'];
            $isi = $data['isi'];
            $tanggal_berakhir = $data['tanggal_berakhir'];
            $insetPengumuman = $this->db->query("INSERT INTO pengumuman(id_pengumuman,judul,isi_pengumuman,tanggal_posting,tanggal_berakhir)VALUES(0,'$judul','$isi',NOW(),'$tanggal_berakhir')");
            if($insetPengumuman && $this->db->affected_rows > 0){
                return $_SESSION['success'] = "Data berhasil ditambahkan.";
            }else{
                return $_SESSION['error'] = "Data gagal ditambahkan.";
            }
        }
    }
    public function editPengumuman($data=null){
        if($data==null){
            return $_SESSION['error'] = "Tidak ada data yang dikirim.";
        }else{
            $id_pengumuman = $data['id_pengumuman'];
            $judul = $data['judul'];
            $isi = $data['isi'];
            $tanggal_berakhir = $data['tanggal_berakhir'];
            $updatePengumuman = $this->db->query("UPDATE pengumuman SET judul='$judul',isi_pengumuman='$isi',tanggal_berakhir='$tanggal_berakhir' WHERE id_pengumuman=$id_pengumuman");
            if($updatePengumuman && $this->db->affected_rows > 0){
                return $_SESSION['success'] = "Data berhasil diedit.";
            }else{
                return $_SESSION['error'] = "Data gagal diedit.";
            }
        }
    }
    public function hapusPengumuman($id_pengumuman=null){
        if($id_pengumuman==null){
            return $_SESSION['error'] = "Tidak ada data yang dikirim.";
        }else{
            $deletePengumuman = $this->db->query("DELETE FROM pengumuman WHERE id_pengumuman=$id_pengumuman");
            if($deletePengumuman && $this->db->affected_rows > 0){
                return $_SESSION['success'] = "Data berhasil dihapus.";
            }else{
                return $_SESSION['error'] = "Data gagal dihapus.";
            }
        }
    }
}


$Setting = new Setting();



?>