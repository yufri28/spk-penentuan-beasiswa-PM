-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Jan 2024 pada 05.57
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spk_beasiswa_pm`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifikasi_admin`
--

CREATE TABLE `notifikasi_admin` (
  `id_notif` int(11) NOT NULL,
  `f_id_penerima` int(11) NOT NULL,
  `f_id_pengirim` int(11) NOT NULL,
  `isi_notif` text NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `dibuka` enum('0','1') NOT NULL,
  `jenis_notif` enum('data-diri','pengajuan','simpan-hasil-seleksi') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `notifikasi_admin`
--

INSERT INTO `notifikasi_admin` (`id_notif`, `f_id_penerima`, `f_id_pengirim`, `isi_notif`, `tanggal`, `dibuka`, `jenis_notif`) VALUES
(120, 17, 16, 'Yufridon C. Luttu32 melakukan pengajuan beasiswa.', '2024-01-13 15:50:34', '1', 'pengajuan'),
(121, 17, 1, 'Hasil seleksi beasiswa Tahun 2024 Periode 2, jenjang Perguruan Tinggi telah disimpan oleh badan diakonat!', '2024-01-14 04:51:18', '1', 'simpan-hasil-seleksi'),
(122, 19, 1, 'Hasil seleksi beasiswa Tahun 2024 Periode 2, jenjang Perguruan Tinggi telah disimpan oleh badan diakonat!', '2024-01-14 04:51:18', '1', 'simpan-hasil-seleksi'),
(123, 20, 1, 'Hasil seleksi beasiswa Tahun 2024 Periode 2, jenjang Perguruan Tinggi telah disimpan oleh badan diakonat!', '2024-01-14 04:51:18', '0', 'simpan-hasil-seleksi'),
(124, 21, 1, 'Hasil seleksi beasiswa Tahun 2024 Periode 2, jenjang Perguruan Tinggi telah disimpan oleh badan diakonat!', '2024-01-14 04:51:18', '0', 'simpan-hasil-seleksi'),
(125, 22, 1, 'Hasil seleksi beasiswa Tahun 2024 Periode 2, jenjang Perguruan Tinggi telah disimpan oleh badan diakonat!', '2024-01-14 04:51:18', '0', 'simpan-hasil-seleksi'),
(126, 23, 1, 'Hasil seleksi beasiswa Tahun 2024 Periode 2, jenjang Perguruan Tinggi telah disimpan oleh badan diakonat!', '2024-01-14 04:51:18', '0', 'simpan-hasil-seleksi'),
(127, 24, 1, 'Hasil seleksi beasiswa Tahun 2024 Periode 2, jenjang Perguruan Tinggi telah disimpan oleh badan diakonat!', '2024-01-14 04:51:18', '0', 'simpan-hasil-seleksi'),
(128, 25, 1, 'Hasil seleksi beasiswa Tahun 2024 Periode 2, jenjang Perguruan Tinggi telah disimpan oleh badan diakonat!', '2024-01-14 04:51:18', '0', 'simpan-hasil-seleksi'),
(129, 26, 1, 'Hasil seleksi beasiswa Tahun 2024 Periode 2, jenjang Perguruan Tinggi telah disimpan oleh badan diakonat!', '2024-01-14 04:51:18', '0', 'simpan-hasil-seleksi'),
(130, 27, 1, 'Hasil seleksi beasiswa Tahun 2024 Periode 2, jenjang Perguruan Tinggi telah disimpan oleh badan diakonat!', '2024-01-14 04:51:18', '0', 'simpan-hasil-seleksi'),
(131, 17, 17, 'Yufridon C. Luttu3 melakukan pengajuan beasiswa.', '2024-01-14 04:55:26', '1', 'pengajuan'),
(132, 17, 1, 'Hasil seleksi beasiswa Tahun 2024 Periode 2, jenjang SMA telah disimpan oleh badan diakonat!', '2024-01-14 04:56:25', '1', 'simpan-hasil-seleksi'),
(133, 19, 1, 'Hasil seleksi beasiswa Tahun 2024 Periode 2, jenjang SMA telah disimpan oleh badan diakonat!', '2024-01-14 04:56:25', '0', 'simpan-hasil-seleksi'),
(134, 20, 1, 'Hasil seleksi beasiswa Tahun 2024 Periode 2, jenjang SMA telah disimpan oleh badan diakonat!', '2024-01-14 04:56:25', '0', 'simpan-hasil-seleksi'),
(135, 21, 1, 'Hasil seleksi beasiswa Tahun 2024 Periode 2, jenjang SMA telah disimpan oleh badan diakonat!', '2024-01-14 04:56:25', '0', 'simpan-hasil-seleksi'),
(136, 22, 1, 'Hasil seleksi beasiswa Tahun 2024 Periode 2, jenjang SMA telah disimpan oleh badan diakonat!', '2024-01-14 04:56:25', '0', 'simpan-hasil-seleksi'),
(137, 23, 1, 'Hasil seleksi beasiswa Tahun 2024 Periode 2, jenjang SMA telah disimpan oleh badan diakonat!', '2024-01-14 04:56:25', '0', 'simpan-hasil-seleksi'),
(138, 24, 1, 'Hasil seleksi beasiswa Tahun 2024 Periode 2, jenjang SMA telah disimpan oleh badan diakonat!', '2024-01-14 04:56:25', '0', 'simpan-hasil-seleksi'),
(139, 25, 1, 'Hasil seleksi beasiswa Tahun 2024 Periode 2, jenjang SMA telah disimpan oleh badan diakonat!', '2024-01-14 04:56:25', '0', 'simpan-hasil-seleksi'),
(140, 26, 1, 'Hasil seleksi beasiswa Tahun 2024 Periode 2, jenjang SMA telah disimpan oleh badan diakonat!', '2024-01-14 04:56:25', '0', 'simpan-hasil-seleksi'),
(141, 27, 1, 'Hasil seleksi beasiswa Tahun 2024 Periode 2, jenjang SMA telah disimpan oleh badan diakonat!', '2024-01-14 04:56:25', '0', 'simpan-hasil-seleksi');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `notifikasi_admin`
--
ALTER TABLE `notifikasi_admin`
  ADD PRIMARY KEY (`id_notif`),
  ADD KEY `f_id_penerima` (`f_id_penerima`),
  ADD KEY `f_id_pengirim` (`f_id_pengirim`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `notifikasi_admin`
--
ALTER TABLE `notifikasi_admin`
  MODIFY `id_notif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `notifikasi_admin`
--
ALTER TABLE `notifikasi_admin`
  ADD CONSTRAINT `notifikasi_admin_ibfk_1` FOREIGN KEY (`f_id_pengirim`) REFERENCES `login_pelamar` (`id_login`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notifikasi_admin_ibfk_2` FOREIGN KEY (`f_id_penerima`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
