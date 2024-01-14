<?php
require_once 'config.php';
$sql = "SELECT * FROM admin WHERE level=0";
$res = $koneksi->query($sql);
if($res->num_rows < 1){
    $password_hash = password_hash("admin",PASSWORD_BCRYPT);
    $sql1 = "INSERT INTO rayon (id_rayon,nama_rayon)VALUES(1,'umum')";
    $result1 = $koneksi->query($sql1);
    if($result1){
        $sql2 = "INSERT INTO admin (id_admin,username,password,level,f_id_rayon) VALUES (null,'admin','$password_hash',0,1)";
        $result2 = $koneksi->query($sql2);
    }
}
$sql_pelamar = "SELECT * FROM login_pelamar WHERE id_login=1";
$res_pelamar = $koneksi->query($sql_pelamar);
if($res_pelamar->num_rows < 1){
    $password_hash = password_hash("umum",PASSWORD_BCRYPT);
    $sql2 = "INSERT INTO login_pelamar (id_login,username,password,jenjang) VALUES (1,'umum','$password_hash',NULL)";
    $result2 = $koneksi->query($sql2);
}
// Mengambil URL yang dikirimkan melalui aturan rewriting
$url = isset($_GET['url']) ? $_GET['url'] : '';

// Mengonversi URL menjadi array dengan memisahkan setiap segment
$urlSegments = explode('/', rtrim($url, '/'));

/// Menentukan halaman yang akan ditampilkan berdasarkan URL
if (empty($urlSegments[0])) {
    // Jika URL kosong, tampilkan halaman beranda
    require_once 'home.php';
} elseif ($urlSegments[0] === 'admin') {
    // Jika URL dimulai dengan "admin", arahkan ke halaman admin
    if (isset($urlSegments[1])) {
        $adminPage = 'admin/' . $urlSegments[1] . '.php';
        if (file_exists($adminPage)) {
            require_once $adminPage;
        } else {
            header("Location: ../404.php");
            exit;
        }
    } else {
        header("Location: ../404.php");
        exit;
    }
} elseif ($urlSegments[0] === 'user') {
    // Jika URL dimulai dengan "user", arahkan ke halaman pengguna biasa
    if (isset($urlSegments[1])) {
        $userPage = 'user/' . $urlSegments[1] . '.php';
        if (file_exists($userPage)) {
            require_once $userPage;
        } else {
            header("Location: ../404.php");
            exit;
        }
    } else {
        header("Location: ../404.php");
        exit;
    }
} else {
    // Jika URL tidak cocok dengan kondisi di atas, tampilkan halaman 404
    header("Location: 404.php");
    exit;
}