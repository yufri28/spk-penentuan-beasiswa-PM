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
$judul_halaman = '<h4 style="text-align: center;">Daftar Penerima Beasiswa</h4>';

// Buat tabel data dengan gaya CSS
$table = '<table align="center" style="width: 100%; border-collapse: collapse; text-wrap:wrap; font-size: 7px;">
            <tr style="background-color: #f2f2f2; text-align: center;">
                <th style="padding: 5px; border: 1px solid #ddd;">Nama</th>
                <th style="padding: 5px; border: 1px solid #ddd;">Nomor HP</th>
                <th style="padding: 5px; border: 1px solid #ddd;">Sekolah / PT</th>
                <th style="padding: 5px; border: 1px solid #ddd;">Jurusan</th>
                <th style="padding: 5px; border: 1px solid #ddd;">Status Jemaat</th>
                <th style="padding: 5px; border: 1px solid #ddd;">Keaktifan kegiatan bergereja</th>
                <th style="padding: 5px; border: 1px solid #ddd;">Status keluarga</th>
                <th style="padding: 5px;  border: 1px solid #ddd;">Pendapatan orang tua/wali (per bulan)</th>
                <th style="padding: 5px; border: 1px solid #ddd;">Jumlah tanggungan orang tua/wali
                </th>
                <th style="padding: 5px; border: 1px solid #ddd;">IPK/Nilai Raport</th>
                <th style="padding: 5px; border: 1px solid #ddd;">Semester</th>
                <th style="padding: 5px; border: 1px solid #ddd;">Rayon</th>
                <th style="padding: 5px; border: 1px solid #ddd;">Nilai</th>
                <th style="padding: 5px; border: 1px solid #ddd;">Periode</th>
            </tr>';

foreach ($data as $row) {
    $table .= '<tr>
                <td style="padding: 8px; border: 1px solid #ddd;">' . $row['nama'] . '</td>
                <td style="padding: 8px; border: 1px solid #ddd;">' . $row['no_hp'] . '</td>
                <td style="padding: 8px; border: 1px solid #ddd;">' . $row['sekolah'] . '</td>
                <td style="padding: 8px; border: 1px solid #ddd;">' . $row['jurusan'] . '</td>
                <td style="padding: 8px; border: 1px solid #ddd;">' . $row['C1'] . '</td>
                <td style="padding: 8px; border: 1px solid #ddd;">' . $row['C2'] . '</td>
                <td style="padding: 8px; border: 1px solid #ddd;">' . $row['C3'] . '</td>
                <td style="padding: 8px; border: 1px solid #ddd;">' . $row['pendapatan_ortu'] . '</td>
                <td style="padding: 8px; border: 1px solid #ddd;">' . $row['C5'] . '</td>
                <td style="padding: 8px; border: 1px solid #ddd;">' . $row['ipk'] . '</td>
                <td style="padding: 8px; border: 1px solid #ddd;">' . $row['C7'] . '</td>
                <td style="padding: 8px; border: 1px solid #ddd;">' . $row['nama_rayon'] . '</td>
                <td style="padding: 8px; border: 1px solid #ddd;">' . number_format($row['nilai_rank'], 2, '.', ''). '</td>
                <td style="padding: 8px; border: 1px solid #ddd;">' . $row['nama_periode'] . '</td>
            </tr>';
}

$table .= '</table>';

// Gabungkan judul dan tabel
$content = '<div style="margin-top: 50px;">' . $judul_halaman . $table . '</div>';

// Buat objek HTML2PDF
$html2pdf = new Html2Pdf('L', 'A4', 'en', false, 'UTF-8');
// Cetak HTML ke PDF
$html2pdf->writeHTML($content);

// Simpan PDF ke file atau keluarkan ke browser
$html2pdf->output('Daftar_Penerima_Beasiswa.pdf');

?>