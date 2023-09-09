-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Sep 2023 pada 05.58
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
(17, 'user', '$2y$10$qOnv5laAF6QgDfqvh.eI7OxbyJUN0jF42pJSDj/UQFubFvYWKVc36', 1, 25),
(19, 'koor_rayon_2', '$2y$10$4vNaWf6eOo3Djix.hPa9.ernaksdBJGcA6HT7EpJTsgsDV/JBglbO', 1, 27),
(20, 'koor_rayon_3', '$2y$10$cBO.2Nd7SampvBk6xK6DQeYP/K8wbKiPANsoFbienugCnshKrP64.', 1, 28),
(21, 'koor_rayon_4', '$2y$10$qoQAs.hH/whzULafLeu0UOAsMsKf7/.ui/OEuDz6IQyJQP6ez6hFW', 1, 29),
(22, 'koor_rayon_5', '$2y$10$fwhc0686BUg3iVttJ62eEuM3zA8T9AVYn99f77Zr6JArP98yf7HHK', 1, 30),
(23, 'koor_rayon_6', '$2y$10$n3KNttHK8DjdL4gIaJ6K8umWejqXFksJiYXcoiEys2hidqtnL.iY.', 1, 31),
(24, 'koor_rayon_7', '$2y$10$srWKJ9ReQXMSXciPojsUi.m/RYF4/carAOLP/9IL5C0bhfpw.H1Dm', 1, 32),
(25, 'koor_rayon_8', '$2y$10$.KOX8U6JOncVeNOUYR.0r..NT15g/gGU8VpvZ4Yf0DhGddZvEMJ7G', 1, 33),
(26, 'koor_rayon_9', '$2y$10$zdS/I49JRuI9gMxNJPF6.OmsPt6qxSbIndmG/1XwsbvjkkmQd8oui', 1, 34),
(27, 'koor_rayon_10', '$2y$10$pVnDUK4MjO8htq72AedCp.e/vMbsSf5STkg/nbK8tRylqu5ijlb1q', 1, 35);

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
(32, 'Yufridon C. Luttu', 'Screenshot (6).png', 'UNDANA', 'Ilkom', '424234234234', 'Screenshot (6).png', 'Screenshot (8)_1.png', 'Screenshot (2).png', 25, 15),
(33, 'Yufridon C. Luttu32', 'Screenshot (2)_1.png', 'UNDANA', 'ILKOM', '43342323232', 'Screenshot (1)_4.png', 'Screenshot (3)_2.png', 'Screenshot (2)_1.png', 25, 16),
(34, 'Yufridon C. Luttu3', 'Screenshot (1).png', 'SMA 1', 'IPA', '343434433434', 'Screenshot (2)_2.png', 'Screenshot (7)_1.png', 'Screenshot (9)_1.png', 25, 17),
(35, 'Yufridon C. Luttu2', 'Screenshot (1)_1.png', 'Yufridon C. Luttu', 'Yufridon C. Luttu2', '55656565', 'Screenshot (7)_2.png', 'Screenshot (8)_2.png', 'Screenshot (6)_1.png', 25, 18),
(36, 'dadsadas', 'Screenshot (6)_1.png', 'dadsadas', 'UNDANA', '232323232323', 'Screenshot (6)_2.png', 'Screenshot (7)_3.png', 'Screenshot (3)_3.png', 28, 19),
(37, 'Yufridon C. Luttu', 'Screenshot (6)_2.png', 'Yufridon C. Luttu', 'Yufridon C. Luttu', '433433333333', 'Screenshot (7)_4.png', 'Screenshot (4).png', 'Screenshot (1)_5.png', 31, 20),
(38, 'Yufridon C. Luttu2', 'Screenshot (6)_3.png', 'Yufridon C. Luttu', 'Yufridon C. Luttu', '432535443554', 'Screenshot (8)_4.png', 'Screenshot (9)_3.png', 'Screenshot (6)_4.png', 32, 21);

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
(18, 34, 9, '2.3642857681428', 'sma'),
(19, 33, 9, '2.5571429154703', 'pt'),
(20, 33, 11, '2.5571429154703', 'pt'),
(21, 34, 11, '2.4285714839186', 'sma');

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
(15, 'yupi', '$2y$10$/IJ.V0GJGcU3dEUTZkvywe5quPOhhKl.thEP18XsSgC/OlkCRpjba', 'pt'),
(16, 'pengguna', '$2y$10$8FQp278deY.P4bF1QNIpF.F3yaYSoJl2Inr7jFhKqbaTMdUuvwksa', 'pt'),
(17, 'pengguna2', '$2y$10$gkhj1oUeZ88h0qwRv1jY0.PF2UO9VVBXB3XmgPDimhhPh3earsYU2', 'sma'),
(18, 'yufrid', '$2y$10$iUczbxYJ.5y86YgNYlCIo.Q/HnXfEopkN2b/rIL6nntI.hf0aNMwu', 'sma'),
(19, 'pengguna21', '$2y$10$Mxk9TAYYanI9VbVaykt4Qup115pEpp0lmsSKybrZP9k4k.o3osWtC', 'pt'),
(20, 'pengguna5', '$2y$10$1lrfkHV7WZrnSpS0CnKf/uGy3gh7bGr8yEcvmIvnVqPZfAX8MQtSG', 'pt'),
(21, 'pengguna0', '$2y$10$6UKG85y7.jCZuC.vjHA5TOk6N3rH9gcuhEyo38GxcZ5WYIriQAs1y', 'sma');

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
(87, 17, 15, 'Yufridon C. Luttu melakukan pengajuan beasiswa.', '2023-08-17 07:59:02', '0', 'pengajuan'),
(88, 17, 16, 'Yufridon C. Luttu32 melakukan pengajuan beasiswa.', '2023-08-17 08:06:29', '0', 'pengajuan'),
(89, 17, 17, 'Yufridon C. Luttu3 telah memperbaharui data dirinya.', '2023-08-18 14:17:38', '0', 'data-diri'),
(90, 17, 15, 'Yufridon C. Luttu telah memperbaharui data dirinya.', '2023-08-18 14:18:56', '0', 'data-diri'),
(91, 17, 17, 'Yufridon C. Luttu3 melakukan pengajuan beasiswa.', '2023-08-18 14:42:27', '0', 'pengajuan'),
(92, 17, 15, 'Yufridon C. Luttu melakukan pengajuan beasiswa.', '2023-08-18 15:02:44', '0', 'pengajuan'),
(93, 17, 15, 'Yufridon C. Luttu melakukan pengajuan beasiswa.', '2023-08-18 15:13:49', '0', 'pengajuan'),
(94, 17, 16, 'Yufridon C. Luttu32 melakukan pengajuan beasiswa.', '2023-08-18 15:14:14', '0', 'pengajuan'),
(95, 17, 17, 'Yufridon C. Luttu3 melakukan pengajuan beasiswa.', '2023-08-18 15:14:34', '0', 'pengajuan');

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
(33, 17, 17, 'Data anda telah diverifikasi.', '2023-08-18 14:44:53', '0'),
(34, 17, 15, 'Data anda telah diverifikasi.', '2023-08-18 14:45:03', '1'),
(35, 17, 16, 'Data anda telah diverifikasi.', '2023-08-18 14:45:13', '0'),
(36, 17, 15, 'Data anda telah diverifikasi.', '2023-08-18 15:23:09', '1'),
(37, 17, 16, 'Data anda telah diverifikasi.', '2023-08-18 15:23:14', '0'),
(38, 17, 17, 'Data anda telah diverifikasi.', '2023-08-18 15:23:19', '0'),
(39, 17, 15, 'Data anda telah diverifikasi.', '2023-08-18 15:34:29', '1'),
(40, 17, 17, 'Data anda telah diverifikasi.', '2023-08-18 15:34:44', '0'),
(41, 17, 16, 'Data anda telah diverifikasi.', '2023-08-18 15:34:49', '0');

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
(276, 'K1', 21, 34, 8),
(277, 'K2', 26, 34, 8),
(278, 'K1', 1, 34, 8),
(279, 'K2', 5, 34, 8),
(280, 'K3', 8, 34, 8),
(281, 'K4', 12, 34, 8),
(282, 'K5', 18, 34, 8),
(283, 'K6', 21, 34, 8),
(284, 'K7', 26, 34, 8),
(285, 'K1', 3, 32, 8),
(286, 'K2', 5, 32, 8),
(287, 'K3', 7, 32, 8),
(288, 'K4', 11, 32, 8),
(289, 'K5', 17, 32, 8),
(290, 'K6', 22, 32, 8),
(291, 'K7', 26, 32, 8),
(292, 'K1', 3, 33, 8),
(293, 'K2', 5, 33, 8),
(294, 'K3', 8, 33, 8),
(295, 'K4', 11, 33, 8),
(296, 'K5', 16, 33, 8),
(297, 'K6', 21, 33, 8),
(298, 'K7', 26, 33, 8),
(299, 'K1', 3, 32, 8),
(300, 'K2', 5, 32, 8),
(301, 'K3', 7, 32, 8),
(302, 'K4', 11, 32, 8),
(303, 'K5', 17, 32, 8),
(304, 'K6', 22, 32, 8),
(305, 'K7', 26, 32, 8),
(306, 'K1', 3, 33, 8),
(307, 'K2', 5, 33, 8),
(308, 'K3', 8, 33, 8),
(309, 'K4', 11, 33, 8),
(310, 'K5', 16, 33, 8),
(311, 'K6', 21, 33, 8),
(312, 'K7', 26, 33, 8),
(313, 'K1', 1, 34, 8),
(314, 'K2', 5, 34, 8),
(315, 'K3', 8, 34, 8),
(316, 'K4', 12, 34, 8),
(317, 'K5', 18, 34, 8),
(318, 'K6', 21, 34, 8),
(319, 'K7', 26, 34, 8),
(320, 'K1', 3, 32, 11),
(321, 'K2', 5, 32, 11),
(322, 'K3', 7, 32, 11),
(323, 'K4', 11, 32, 11),
(324, 'K5', 17, 32, 11),
(325, 'K6', 22, 32, 11),
(326, 'K7', 26, 32, 11),
(327, 'K1', 1, 34, 11),
(328, 'K2', 5, 34, 11),
(329, 'K3', 8, 34, 11),
(330, 'K4', 12, 34, 11),
(331, 'K5', 18, 34, 11),
(332, 'K6', 21, 34, 11),
(333, 'K7', 26, 34, 11),
(334, 'K1', 3, 33, 11),
(335, 'K2', 5, 33, 11),
(336, 'K3', 8, 33, 11),
(337, 'K4', 11, 33, 11),
(338, 'K5', 16, 33, 11),
(339, 'K6', 21, 33, 11),
(340, 'K7', 26, 33, 11);

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
(148, 'K1', 3, 32),
(149, 'K2', 5, 32),
(150, 'K3', 7, 32),
(151, 'K4', 11, 32),
(152, 'K5', 17, 32),
(153, 'K6', 22, 32),
(154, 'K7', 26, 32),
(155, 'K1', 3, 33),
(156, 'K2', 5, 33),
(157, 'K3', 8, 33),
(158, 'K4', 11, 33),
(159, 'K5', 16, 33),
(160, 'K6', 21, 33),
(161, 'K7', 26, 33),
(162, 'K1', 1, 34),
(163, 'K2', 5, 34),
(164, 'K3', 8, 34),
(165, 'K4', 12, 34),
(166, 'K5', 18, 34),
(167, 'K6', 21, 34),
(168, 'K7', 26, 34),
(169, 'K1', 3, 35),
(170, 'K2', 6, 35),
(171, 'K3', 8, 35),
(172, 'K4', 11, 35),
(173, 'K5', 17, 35),
(174, 'K6', 22, 35),
(175, 'K7', 26, 35),
(176, 'K1', 1, 36),
(177, 'K2', 5, 36),
(178, 'K3', 8, 36),
(179, 'K4', 11, 36),
(180, 'K5', 16, 36),
(181, 'K6', 21, 36),
(182, 'K7', 27, 36),
(183, 'K1', 2, 37),
(184, 'K2', 6, 37),
(185, 'K3', 8, 37),
(186, 'K4', 11, 37),
(187, 'K5', 17, 37),
(188, 'K6', 20, 37),
(189, 'K7', 26, 37),
(190, 'K1', 1, 38),
(191, 'K2', 5, 38),
(192, 'K3', 9, 38),
(193, 'K4', 10, 38),
(194, 'K5', 16, 38),
(196, 'K1', 1, 38),
(197, 'K2', 5, 38),
(198, 'K3', 9, 38),
(199, 'K4', 10, 38),
(200, 'K5', 16, 38),
(201, 'K6', 22, 38),
(202, 'K7', 26, 38);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id_pengumuman` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi_pengumuman` text NOT NULL,
  `tanggal_posting` timestamp NOT NULL DEFAULT current_timestamp(),
  `tanggal_berakhir` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengumuman`
--

INSERT INTO `pengumuman` (`id_pengumuman`, `judul`, `isi_pengumuman`, `tanggal_posting`, `tanggal_berakhir`) VALUES
(3, 'Daftar ulang mahasiswa/siswa yang lulus seleksi penerimaan beasiswa Tahun 2023 Periode 1', 'adsasasdasd', '2023-09-09 01:57:16', '2023-09-09 03:57:16'),
(4, 'Daftar ulang mahasiswa/siswa yang lulus seleksi penerimaan beasiswa Tahun 2023 Periode 1', 'dasdasdasdsadee212131212', '2023-09-09 02:01:25', '2023-09-09 02:25:00');

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
(9, '20241', 'Tahun 2024 Periode 1', 1, 1, 'tutup'),
(11, '20242', 'Tahun 2024 Periode 2', 1, 1, 'buka');

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
(25, 'Rayon I'),
(27, 'Rayon II'),
(28, 'Rayon III'),
(29, 'Rayon IV'),
(30, 'Rayon V'),
(31, 'Rayon VI'),
(32, 'Rayon VII'),
(33, 'Rayon VIII'),
(34, 'Rayon IX'),
(35, 'Rayon X');

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
(7, 'Yatim Piatu', 'K3', 3),
(8, 'Yatim atau Piatu', 'K3', 2),
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
(25, '3,4,5 / 1', 'K7', 3),
(26, '6,7,8 / 2', 'K7', 2),
(27, '9 - 14 / 3', 'K7', 1);

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
(49, 32, 9, '1'),
(50, 33, 9, '1'),
(51, 34, 9, '1'),
(53, 32, 11, '1'),
(54, 33, 11, '1'),
(55, 34, 11, '1');

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
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `data_pelamar`
--
ALTER TABLE `data_pelamar`
  MODIFY `id_pelamar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `hasil_akhir`
--
ALTER TABLE `hasil_akhir`
  MODIFY `id_hasil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `login_pelamar`
--
ALTER TABLE `login_pelamar`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `notifikasi_admin`
--
ALTER TABLE `notifikasi_admin`
  MODIFY `id_notif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT untuk tabel `notifikasi_pelamar`
--
ALTER TABLE `notifikasi_pelamar`
  MODIFY `id_notif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT untuk tabel `pdt`
--
ALTER TABLE `pdt`
  MODIFY `id_pdt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=341;

--
-- AUTO_INCREMENT untuk tabel `pelamar_kriteria`
--
ALTER TABLE `pelamar_kriteria`
  MODIFY `id_pelamar_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203;

--
-- AUTO_INCREMENT untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id_pengumuman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `periode`
--
ALTER TABLE `periode`
  MODIFY `id_periode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `pesan`
--
ALTER TABLE `pesan`
  MODIFY `id_pesan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `rayon`
--
ALTER TABLE `rayon`
  MODIFY `id_rayon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id_sub_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `verifikasi`
--
ALTER TABLE `verifikasi`
  MODIFY `id_verifikasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

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
