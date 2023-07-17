-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Jul 2023 pada 16.02
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
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` int(1) NOT NULL,
  `f_id_rayon` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `level`, `f_id_rayon`) VALUES
(14, 'admin', '$2y$10$C5PQf4i.pS0mBB3DsYauIe8D5je7gJn8g40u7V1Gb4F9dCY9Lbzba', 0, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_pelamar`
--

CREATE TABLE `data_pelamar` (
  `id_pelamar` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `sekolah` varchar(100) NOT NULL,
  `jurusan` varchar(50) NOT NULL,
  `no_hp` varchar(12) NOT NULL,
  `kartu_keluarga` varchar(255) DEFAULT NULL,
  `s_beasiswa_lain` varchar(255) DEFAULT NULL,
  `raport_khs` varchar(255) DEFAULT NULL,
  `f_id_rayon` int(11) NOT NULL,
  `f_id_login` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_akhir`
--

CREATE TABLE `hasil_akhir` (
  `id_hasil` int(11) NOT NULL,
  `f_id_pelamar` int(11) NOT NULL,
  `f_id_periode` int(11) NOT NULL,
  `nilai_rank` decimal(15,13) NOT NULL,
  `jenjang` enum('sma','pt') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `info`
--

CREATE TABLE `info` (
  `id_info` int(11) NOT NULL,
  `f_id_periode` int(11) NOT NULL,
  `kuota` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` varchar(2) NOT NULL,
  `nama_kriteria` varchar(255) NOT NULL,
  `bobot_kriteria` float NOT NULL,
  `faktor` varchar(50) NOT NULL,
  `profile_target` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `nama_kriteria`, `bobot_kriteria`, `faktor`, `profile_target`) VALUES
('K1', 'Status jemaat', 0.2, 'CF', 3),
('K2', 'Keaktifan kegiatan bergereja', 0.15, 'CF', 3),
('K3', 'Status keluarga', 0.15, 'CF', 3),
('K4', 'Pendapatan orang tua', 0.2, 'CF', 5),
('K5', 'Jumlah tanggungan orang tua', 0.2, 'CF', 5),
('K6', 'IPK/Nilai Raport', 0.05, 'SF', 5),
('K7', 'Semester', 0.05, 'SF', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `login_pelamar`
--

CREATE TABLE `login_pelamar` (
  `id_login` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `jenjang` enum('sma','pt') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `jenis_notif` enum('data-diri','pengajuan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifikasi_pelamar`
--

CREATE TABLE `notifikasi_pelamar` (
  `id_notif` int(11) NOT NULL,
  `f_id_pengirim` int(11) NOT NULL,
  `f_id_penerima` int(11) NOT NULL,
  `isi_notifikasi` text NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `dibuka` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pdt`
--

CREATE TABLE `pdt` (
  `id_pdt` int(11) NOT NULL,
  `f_id_kriteria` varchar(2) NOT NULL,
  `f_id_sub_kriteria` int(11) NOT NULL,
  `f_id_pelamar` int(11) NOT NULL,
  `f_id_periode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelamar_kriteria`
--

CREATE TABLE `pelamar_kriteria` (
  `id_pelamar_kriteria` int(11) NOT NULL,
  `f_id_kriteria` varchar(2) NOT NULL,
  `f_id_sub_kriteria` int(11) NOT NULL,
  `f_id_pelamar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `periode`
--

CREATE TABLE `periode` (
  `id_periode` int(11) NOT NULL,
  `nama_periode` varchar(10) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `kuota_sma` int(11) NOT NULL,
  `kuota_pt` int(11) NOT NULL,
  `status` enum('buka','tutup') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `periode`
--

INSERT INTO `periode` (`id_periode`, `nama_periode`, `deskripsi`, `kuota_sma`, `kuota_pt`, `status`) VALUES
(1, '20235', 'Tahun 2023 periode 1', 50, 3, 'buka');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesan`
--

CREATE TABLE `pesan` (
  `id_pesan` int(11) NOT NULL,
  `f_id_pengirim` int(11) NOT NULL,
  `f_id_penerima` int(11) NOT NULL,
  `pesan` text NOT NULL,
  `tanggal_kirim` timestamp NOT NULL DEFAULT current_timestamp(),
  `dibuka` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rayon`
--

CREATE TABLE `rayon` (
  `id_rayon` int(11) NOT NULL,
  `nama_rayon` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `rayon`
--

INSERT INTO `rayon` (`id_rayon`, `nama_rayon`) VALUES
(1, 'umum'),
(6, 'Rayon I'),
(22, 'Rayon II');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sub_kriteria`
--

CREATE TABLE `sub_kriteria` (
  `id_sub_kriteria` int(11) NOT NULL,
  `nama_sub_kriteria` varchar(255) NOT NULL,
  `f_id_kriteria` varchar(2) NOT NULL,
  `bobot_sub_kriteria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `sub_kriteria`
--

INSERT INTO `sub_kriteria` (`id_sub_kriteria`, `nama_sub_kriteria`, `f_id_kriteria`, `bobot_sub_kriteria`) VALUES
(1, 'Terdaftar dalam database gereja >= 1 tahun', 'K1', 3),
(2, 'Terdaftar dalam database gereja < 1 tahun', 'K1', 2),
(3, 'Tidak terdaftar dalam database', 'K1', 1),
(4, 'Aktif sebagai badan pengurus', 'K2', 3),
(5, 'Aktif sebagai anggota', 'K2', 2),
(6, 'Tidak aktif', 'K2', 1),
(7, 'Yatim-Piatu', 'K3', 3),
(8, 'Yatim/Piatu', 'K3', 2),
(9, 'Lengkap', 'K3', 1),
(10, '< Rp1.000.000', 'K4', 5),
(11, 'Rp1.000.000 - < Rp1.500.000', 'K4', 4),
(12, 'Rp 1.500.000 - < Rp 2.000.000', 'K4', 3),
(13, 'Rp 2.000.000 - < Rp 3.000.000', 'K4', 2),
(14, '>= Rp 3.000.000', 'K4', 1),
(15, '>= 5 orang', 'K5', 5),
(16, '4 orang', 'K5', 4),
(17, '3 orang', 'K5', 3),
(18, '2 orang', 'K5', 2),
(19, '1 orang', 'K5', 1),
(20, '90,00 - 100 / 3,76 - 4,00', 'K6', 5),
(21, '81,00 - 89,99 / 3,51 - 3,75', 'K6', 4),
(22, '76,00 - 80,99 / 3,01 - 3,50', 'K6', 3),
(23, '65,01 - 75,99 / 2,51 - 3,00', 'K6', 2),
(24, '<= 65,00 / <= 2,50', 'K6', 1),
(25, '3,4,5 / 1 & 2', 'K7', 3),
(26, '6,7,8 / 3 & 4', 'K7', 2),
(27, '9 - 14 / 5 & 6', 'K7', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `verifikasi`
--

CREATE TABLE `verifikasi` (
  `id_verifikasi` int(11) NOT NULL,
  `f_id_pelamar` int(11) NOT NULL,
  `f_id_periode` int(11) NOT NULL,
  `status` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD KEY `f_id_rayon` (`f_id_rayon`);

--
-- Indeks untuk tabel `data_pelamar`
--
ALTER TABLE `data_pelamar`
  ADD PRIMARY KEY (`id_pelamar`),
  ADD UNIQUE KEY `f_id_login` (`f_id_login`),
  ADD KEY `id_loging` (`f_id_login`),
  ADD KEY `rayon` (`f_id_rayon`);

--
-- Indeks untuk tabel `hasil_akhir`
--
ALTER TABLE `hasil_akhir`
  ADD PRIMARY KEY (`id_hasil`),
  ADD KEY `f_id_pelamar` (`f_id_pelamar`),
  ADD KEY `f_id_periode` (`f_id_periode`);

--
-- Indeks untuk tabel `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`id_info`),
  ADD KEY `f_id_periode` (`f_id_periode`);

--
-- Indeks untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indeks untuk tabel `login_pelamar`
--
ALTER TABLE `login_pelamar`
  ADD PRIMARY KEY (`id_login`);

--
-- Indeks untuk tabel `notifikasi_admin`
--
ALTER TABLE `notifikasi_admin`
  ADD PRIMARY KEY (`id_notif`),
  ADD KEY `f_id_penerima` (`f_id_penerima`),
  ADD KEY `f_id_pengirim` (`f_id_pengirim`);

--
-- Indeks untuk tabel `notifikasi_pelamar`
--
ALTER TABLE `notifikasi_pelamar`
  ADD PRIMARY KEY (`id_notif`),
  ADD KEY `f_id_pengirim` (`f_id_pengirim`),
  ADD KEY `f_id_penerima` (`f_id_penerima`);

--
-- Indeks untuk tabel `pdt`
--
ALTER TABLE `pdt`
  ADD PRIMARY KEY (`id_pdt`),
  ADD KEY `f_id_kriteria` (`f_id_kriteria`),
  ADD KEY `f_id_sub_kriteria` (`f_id_sub_kriteria`),
  ADD KEY `f_id_pelamar` (`f_id_pelamar`),
  ADD KEY `f_id_periode` (`f_id_periode`);

--
-- Indeks untuk tabel `pelamar_kriteria`
--
ALTER TABLE `pelamar_kriteria`
  ADD PRIMARY KEY (`id_pelamar_kriteria`),
  ADD KEY `f_id_kriteria` (`f_id_kriteria`),
  ADD KEY `f_id_sub_kriteria` (`f_id_sub_kriteria`),
  ADD KEY `f_id_pelamar` (`f_id_pelamar`);

--
-- Indeks untuk tabel `periode`
--
ALTER TABLE `periode`
  ADD PRIMARY KEY (`id_periode`);

--
-- Indeks untuk tabel `pesan`
--
ALTER TABLE `pesan`
  ADD PRIMARY KEY (`id_pesan`),
  ADD KEY `f_id_pengirim` (`f_id_pengirim`),
  ADD KEY `f_id_penerima` (`f_id_penerima`);

--
-- Indeks untuk tabel `rayon`
--
ALTER TABLE `rayon`
  ADD PRIMARY KEY (`id_rayon`);

--
-- Indeks untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD PRIMARY KEY (`id_sub_kriteria`),
  ADD KEY `id_kritria` (`f_id_kriteria`);

--
-- Indeks untuk tabel `verifikasi`
--
ALTER TABLE `verifikasi`
  ADD PRIMARY KEY (`id_verifikasi`),
  ADD KEY `f_id_pelamar` (`f_id_pelamar`),
  ADD KEY `f_id_periode` (`f_id_periode`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `data_pelamar`
--
ALTER TABLE `data_pelamar`
  MODIFY `id_pelamar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `hasil_akhir`
--
ALTER TABLE `hasil_akhir`
  MODIFY `id_hasil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `info`
--
ALTER TABLE `info`
  MODIFY `id_info` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `login_pelamar`
--
ALTER TABLE `login_pelamar`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `notifikasi_admin`
--
ALTER TABLE `notifikasi_admin`
  MODIFY `id_notif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT untuk tabel `notifikasi_pelamar`
--
ALTER TABLE `notifikasi_pelamar`
  MODIFY `id_notif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `pdt`
--
ALTER TABLE `pdt`
  MODIFY `id_pdt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=234;

--
-- AUTO_INCREMENT untuk tabel `pelamar_kriteria`
--
ALTER TABLE `pelamar_kriteria`
  MODIFY `id_pelamar_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT untuk tabel `periode`
--
ALTER TABLE `periode`
  MODIFY `id_periode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pesan`
--
ALTER TABLE `pesan`
  MODIFY `id_pesan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `rayon`
--
ALTER TABLE `rayon`
  MODIFY `id_rayon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id_sub_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `verifikasi`
--
ALTER TABLE `verifikasi`
  MODIFY `id_verifikasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`f_id_rayon`) REFERENCES `rayon` (`id_rayon`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `data_pelamar`
--
ALTER TABLE `data_pelamar`
  ADD CONSTRAINT `data_pelamar_ibfk_1` FOREIGN KEY (`f_id_login`) REFERENCES `login_pelamar` (`id_login`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `data_pelamar_ibfk_2` FOREIGN KEY (`f_id_rayon`) REFERENCES `rayon` (`id_rayon`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `hasil_akhir`
--
ALTER TABLE `hasil_akhir`
  ADD CONSTRAINT `hasil_akhir_ibfk_1` FOREIGN KEY (`f_id_pelamar`) REFERENCES `data_pelamar` (`id_pelamar`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hasil_akhir_ibfk_2` FOREIGN KEY (`f_id_periode`) REFERENCES `periode` (`id_periode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `info`
--
ALTER TABLE `info`
  ADD CONSTRAINT `info_ibfk_1` FOREIGN KEY (`f_id_periode`) REFERENCES `periode` (`id_periode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `notifikasi_admin`
--
ALTER TABLE `notifikasi_admin`
  ADD CONSTRAINT `notifikasi_admin_ibfk_1` FOREIGN KEY (`f_id_pengirim`) REFERENCES `login_pelamar` (`id_login`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notifikasi_admin_ibfk_2` FOREIGN KEY (`f_id_penerima`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `notifikasi_pelamar`
--
ALTER TABLE `notifikasi_pelamar`
  ADD CONSTRAINT `notifikasi_pelamar_ibfk_1` FOREIGN KEY (`f_id_pengirim`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notifikasi_pelamar_ibfk_2` FOREIGN KEY (`f_id_penerima`) REFERENCES `login_pelamar` (`id_login`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pdt`
--
ALTER TABLE `pdt`
  ADD CONSTRAINT `pdt_ibfk_1` FOREIGN KEY (`f_id_pelamar`) REFERENCES `data_pelamar` (`id_pelamar`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pdt_ibfk_2` FOREIGN KEY (`f_id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pdt_ibfk_3` FOREIGN KEY (`f_id_sub_kriteria`) REFERENCES `sub_kriteria` (`id_sub_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pdt_ibfk_4` FOREIGN KEY (`f_id_periode`) REFERENCES `periode` (`id_periode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pelamar_kriteria`
--
ALTER TABLE `pelamar_kriteria`
  ADD CONSTRAINT `pelamar_kriteria_ibfk_1` FOREIGN KEY (`f_id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pelamar_kriteria_ibfk_2` FOREIGN KEY (`f_id_sub_kriteria`) REFERENCES `sub_kriteria` (`id_sub_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pelamar_kriteria_ibfk_3` FOREIGN KEY (`f_id_pelamar`) REFERENCES `data_pelamar` (`id_pelamar`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pesan`
--
ALTER TABLE `pesan`
  ADD CONSTRAINT `pesan_ibfk_1` FOREIGN KEY (`f_id_pengirim`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pesan_ibfk_2` FOREIGN KEY (`f_id_penerima`) REFERENCES `login_pelamar` (`id_login`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD CONSTRAINT `sub_kriteria_ibfk_1` FOREIGN KEY (`f_id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `verifikasi`
--
ALTER TABLE `verifikasi`
  ADD CONSTRAINT `verifikasi_ibfk_1` FOREIGN KEY (`f_id_pelamar`) REFERENCES `data_pelamar` (`id_pelamar`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `verifikasi_ibfk_2` FOREIGN KEY (`f_id_periode`) REFERENCES `periode` (`id_periode`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
