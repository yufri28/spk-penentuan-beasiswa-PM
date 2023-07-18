-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Jul 2023 pada 18.40
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
(14, 'admin', '$2y$10$C5PQf4i.pS0mBB3DsYauIe8D5je7gJn8g40u7V1Gb4F9dCY9Lbzba', 0, 1),
(16, 'rosa', '$2y$10$jfAccKdRT4ksAUkWA474iOteTquzp7T5HaHdQPnnC3K1KTG61hnJK', 1, 24);

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

--
-- Dumping data untuk tabel `data_pelamar`
--

INSERT INTO `data_pelamar` (`id_pelamar`, `nama`, `foto`, `sekolah`, `jurusan`, `no_hp`, `kartu_keluarga`, `s_beasiswa_lain`, `raport_khs`, `f_id_rayon`, `f_id_login`) VALUES
(24, 'Rosaliani Kaseh', 'DFD UJIAN.png', 'UNDANA', 'Ilkom', '12345678', 'Diagram konteksrevisi ibu adri 1.png', 'DFD UJIAN.png', 'Diagram konteksrevisi ibu adri 1_1.png', 24, 9),
(25, 'simon', 'DFD UJIAN_1.png', 'UNDANA', 'ilkom', '12345', 'Diagram konteksrevisi ibu adri 1_2.png', 'DFD UJIAN_1.png', 'ERD UJIAN P.png', 24, 10),
(26, 'petrus', 'DFD UJIAN_2.png', 'SMA 6 Kupang', 'IPA', '123', 'DFD UJIAN_2.png', 'DFD UJIAN_3.png', 'Diagram konteksrevisi ibu adri 1_3.png', 24, 11);

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

--
-- Dumping data untuk tabel `hasil_akhir`
--

INSERT INTO `hasil_akhir` (`id_hasil`, `f_id_pelamar`, `f_id_periode`, `nilai_rank`, `jenjang`) VALUES
(16, 25, 8, '3.3571429337774', 'pt'),
(17, 26, 8, '3.3571429337774', 'sma');

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

--
-- Dumping data untuk tabel `login_pelamar`
--

INSERT INTO `login_pelamar` (`id_login`, `username`, `password`, `jenjang`) VALUES
(9, 'rosaliani', '$2y$10$cyQ5zE.uik.0m6Gkto/ujehwoctW8.B0VRfy05BCTAHSRnvIihNPa', 'pt'),
(10, 'simon', '$2y$10$bvo66evfQq4uC7pwW4j00uKDh6eqoucTRHGUdrHiS0XCzcMSRi/Yq', 'pt'),
(11, 'petrus', '$2y$10$6oYpmb3dxEPl5HurdzLmquvc0xku0pW/QfF52ORPndy9Xd3Wne.ry', 'sma');

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

--
-- Dumping data untuk tabel `notifikasi_admin`
--

INSERT INTO `notifikasi_admin` (`id_notif`, `f_id_penerima`, `f_id_pengirim`, `isi_notif`, `tanggal`, `dibuka`, `jenis_notif`) VALUES
(75, 16, 9, 'Rosaliani Kaseh melakukan pengajuan beasiswa.', '2023-07-18 12:00:42', '1', 'pengajuan'),
(76, 16, 10, 'simon melakukan pengajuan beasiswa.', '2023-07-18 12:06:18', '0', 'pengajuan'),
(77, 16, 10, 'simon melakukan pengajuan beasiswa.', '2023-07-18 12:10:04', '0', 'pengajuan'),
(78, 16, 9, 'Rosaliani Kaseh melakukan pengajuan beasiswa.', '2023-07-18 12:10:27', '0', 'pengajuan'),
(79, 16, 11, 'petrus melakukan pengajuan beasiswa.', '2023-07-18 12:27:39', '0', 'pengajuan');

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

--
-- Dumping data untuk tabel `notifikasi_pelamar`
--

INSERT INTO `notifikasi_pelamar` (`id_notif`, `f_id_pengirim`, `f_id_penerima`, `isi_notifikasi`, `tanggal`, `dibuka`) VALUES
(27, 16, 9, 'Data anda telah diverifikasi.', '2023-07-18 12:03:18', '1'),
(28, 16, 10, 'Data anda telah diverifikasi.', '2023-07-18 12:06:38', '0'),
(29, 16, 9, 'Data anda telah diverifikasi.', '2023-07-18 12:10:48', '1'),
(30, 16, 10, 'Data anda telah diverifikasi.', '2023-07-18 12:10:53', '0'),
(31, 16, 11, 'Data anda telah diverifikasi.', '2023-07-18 12:30:21', '0');

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

--
-- Dumping data untuk tabel `pdt`
--

INSERT INTO `pdt` (`id_pdt`, `f_id_kriteria`, `f_id_sub_kriteria`, `f_id_pelamar`, `f_id_periode`) VALUES
(248, 'K1', 1, 24, 8),
(249, 'K2', 5, 24, 8),
(250, 'K3', 9, 24, 8),
(251, 'K4', 11, 24, 8),
(252, 'K5', 18, 24, 8),
(253, 'K6', 22, 24, 8),
(254, 'K7', 26, 24, 8),
(255, 'K1', 1, 25, 8),
(256, 'K2', 4, 25, 8),
(257, 'K3', 7, 25, 8),
(258, 'K4', 10, 25, 8),
(259, 'K5', 15, 25, 8),
(260, 'K6', 20, 25, 8),
(261, 'K7', 25, 25, 8),
(262, 'K1', 1, 26, 8),
(263, 'K2', 4, 26, 8),
(264, 'K3', 7, 26, 8),
(265, 'K4', 10, 26, 8),
(266, 'K5', 15, 26, 8),
(267, 'K6', 20, 26, 8),
(268, 'K7', 25, 26, 8);

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

--
-- Dumping data untuk tabel `pelamar_kriteria`
--

INSERT INTO `pelamar_kriteria` (`id_pelamar_kriteria`, `f_id_kriteria`, `f_id_sub_kriteria`, `f_id_pelamar`) VALUES
(92, 'K1', 1, 24),
(93, 'K2', 5, 24),
(94, 'K3', 9, 24),
(95, 'K4', 11, 24),
(96, 'K5', 18, 24),
(97, 'K6', 22, 24),
(98, 'K7', 26, 24),
(99, 'K1', 1, 25),
(100, 'K2', 4, 25),
(101, 'K3', 7, 25),
(102, 'K4', 10, 25),
(103, 'K5', 15, 25),
(104, 'K6', 20, 25),
(105, 'K7', 25, 25),
(106, 'K1', 1, 26),
(107, 'K2', 4, 26),
(108, 'K3', 7, 26),
(109, 'K4', 10, 26),
(110, 'K5', 15, 26),
(111, 'K6', 20, 26),
(112, 'K7', 25, 26);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id_pengumuman` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi_pengumuman` text NOT NULL,
  `tanggal_posting` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengumuman`
--

INSERT INTO `pengumuman` (`id_pengumuman`, `judul`, `isi_pengumuman`, `tanggal_posting`) VALUES
(1, 'Daftar ulang siswa / mahasiswa yang lulus seleksi penerimaan beasiswa Tahun 2023 Periode 1', 'Bagi siswa / mahasiswa yang lulus seleksi penerimaan beasiswa Tahun 2023 Periode 1, Silahkan membawa berkas ke sekretariat gereja.', '2023-07-18 16:02:32');

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
(8, '20232', 'Tahun 2023 periode 2', 1, 1, 'tutup'),
(9, '20241', 'Tahun 2024 Periode 1', 2, 1, 'buka');

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

--
-- Dumping data untuk tabel `pesan`
--

INSERT INTO `pesan` (`id_pesan`, `f_id_pengirim`, `f_id_penerima`, `pesan`, `tanggal_kirim`, `dibuka`) VALUES
(8, 16, 9, 'khs salah', '2023-07-18 12:02:02', '1');

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
(24, 'Rayon I');

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
-- Dumping data untuk tabel `verifikasi`
--

INSERT INTO `verifikasi` (`id_verifikasi`, `f_id_pelamar`, `f_id_periode`, `status`) VALUES
(38, 25, 8, '1'),
(39, 24, 8, '1'),
(40, 26, 8, '1');

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
-- Indeks untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id_pengumuman`);

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
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `data_pelamar`
--
ALTER TABLE `data_pelamar`
  MODIFY `id_pelamar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `hasil_akhir`
--
ALTER TABLE `hasil_akhir`
  MODIFY `id_hasil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `login_pelamar`
--
ALTER TABLE `login_pelamar`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `notifikasi_admin`
--
ALTER TABLE `notifikasi_admin`
  MODIFY `id_notif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT untuk tabel `notifikasi_pelamar`
--
ALTER TABLE `notifikasi_pelamar`
  MODIFY `id_notif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `pdt`
--
ALTER TABLE `pdt`
  MODIFY `id_pdt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=276;

--
-- AUTO_INCREMENT untuk tabel `pelamar_kriteria`
--
ALTER TABLE `pelamar_kriteria`
  MODIFY `id_pelamar_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id_pengumuman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `periode`
--
ALTER TABLE `periode`
  MODIFY `id_periode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `pesan`
--
ALTER TABLE `pesan`
  MODIFY `id_pesan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `rayon`
--
ALTER TABLE `rayon`
  MODIFY `id_rayon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id_sub_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `verifikasi`
--
ALTER TABLE `verifikasi`
  MODIFY `id_verifikasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

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
