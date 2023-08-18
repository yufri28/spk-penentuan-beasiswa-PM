<?php 

require '../vendor/autoload.php';
require './functions/laporan.php';

use Spipu\Html2Pdf\Html2Pdf;

if(isset($_GET['order_jenjang'])){
    $data = $Laporan->cetakByJenjang(htmlspecialchars($_GET['order_jenjang']));
}elseif(isset($_GET['order_periode'])){
    $data = $Laporan->cetakByPeriode(htmlspecialchars($_GET['order_periode']));
}elseif(isset($_GET['order_rayon'])){
    $data = $Laporan->cetakByRayon(htmlspecialchars($_GET['order_rayon']));
}else{
    $data = $Laporan->cetakAll();
}


// Buat judul halaman
$judul_halaman = '<h1 style="text-align: center;">Daftar Penerima Beasiswa</h1>';

// Buat tabel data dengan gaya CSS
$table = '<table align="center" style="width: 100%; border-collapse: collapse;">
            <tr style="background-color: #f2f2f2; text-align: center;">
                <th style="padding: 10px; border: 1px solid #ddd;">Nama</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Sekolah / PT</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Jurusan</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Rayon</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Periode</th>
            </tr>';

foreach ($data as $row) {
    $table .= '<tr>
                <td style="padding: 15px; border: 1px solid #ddd;">' . $row['nama'] . '</td>
                <td style="padding: 15px; border: 1px solid #ddd;">' . $row['sekolah'] . '</td>
                <td style="padding: 15px; border: 1px solid #ddd;">' . $row['jurusan'] . '</td>
                <td style="padding: 15px; border: 1px solid #ddd;">' . $row['nama_rayon'] . '</td>
                <td style="padding: 15px; border: 1px solid #ddd;">' . $row['nama_periode'] . '</td>
            </tr>';
}

$table .= '</table>';

// Gabungkan judul dan tabel
$content = '<div style="margin-top: 50px;">' . $judul_halaman . $table . '</div>';

// Buat objek HTML2PDF
$html2pdf = new Html2Pdf();

// Cetak HTML ke PDF
$html2pdf->writeHTML($content);

// Simpan PDF ke file atau keluarkan ke browser
$html2pdf->output('Daftar_Penerima_Beasiswa.pdf');

?>