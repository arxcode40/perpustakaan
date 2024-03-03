-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 01, 2024 at 02:38 PM
-- Server version: 8.0.36
-- PHP Version: 8.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_perpustakaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_anggota`
--

CREATE TABLE `tbl_anggota` (
  `kode_anggota` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_telepon` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_pengguna` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_anggota` enum('Administrator','Anggota') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_anggota` enum('Terdaftar','Terverifikasi') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_pinjam` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_anggota`
--

INSERT INTO `tbl_anggota` (`kode_anggota`, `nama_lengkap`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `nomor_telepon`, `kode_pengguna`, `jenis_anggota`, `status_anggota`, `jumlah_pinjam`) VALUES
('A0001', 'Arya Putra Sadewa', 'Laki-laki', 'Jakarta', '2005-11-24', 'Legok, Kab. Tangerang.', '0895339792382', 'P0001', 'Administrator', 'Terverifikasi', 0),
('A0002', 'Arya Putra Sadewa', 'Laki-laki', 'Jakarta', '2005-11-24', 'Legok, Kab. Tangerang.', '0895339792382', 'P0002', 'Anggota', 'Terverifikasi', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_buku`
--

CREATE TABLE `tbl_buku` (
  `kode_buku` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_koleksi` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pengarang` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `penerbit` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_terbit` year NOT NULL,
  `cetakan` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `edisi` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_buku` enum('Tersedia','Dipinjam','Tidak Tersedia') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_buku`
--

INSERT INTO `tbl_buku` (`kode_buku`, `judul`, `jenis_koleksi`, `pengarang`, `penerbit`, `tahun_terbit`, `cetakan`, `edisi`, `status_buku`) VALUES
('B0001', 'Tentang Kamu', 'Novel', 'Tere Liye', 'Republika', '2016', 'Pertama', 'Pertama', 'Tersedia'),
('B0002', 'Negeri Para Bedebah', 'Novel', 'Tere Liye', 'Gramedia Pustaka Utama', '2012', 'Pertama', 'Pertama', 'Tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_peminjaman`
--

CREATE TABLE `tbl_peminjaman` (
  `kode_transaksi` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_anggota` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `kode_buku` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_peminjaman` enum('Tertunda','Terverifikasi') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_transaksi` enum('Dipinjam','Dikembalikan') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_pengguna` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_peminjaman`
--

INSERT INTO `tbl_peminjaman` (`kode_transaksi`, `kode_anggota`, `tanggal_pinjam`, `tanggal_kembali`, `kode_buku`, `status_peminjaman`, `status_transaksi`, `kode_pengguna`) VALUES
('T0001', 'A0002', '2024-03-01', '2024-03-01', 'B0001', 'Terverifikasi', 'Dikembalikan', 'P0002'),
('T0002', 'A0002', '2024-03-01', '2024-03-01', 'B0002', 'Terverifikasi', 'Dikembalikan', 'P0002');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengaturan`
--

CREATE TABLE `tbl_pengaturan` (
  `id_pengaturan` tinyint NOT NULL,
  `nama_aplikasi` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_telepon` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `denda_telat` int NOT NULL,
  `denda_rusak` int NOT NULL,
  `denda_hilang` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_pengaturan`
--

INSERT INTO `tbl_pengaturan` (`id_pengaturan`, `nama_aplikasi`, `alamat`, `nomor_telepon`, `email`, `denda_telat`, `denda_rusak`, `denda_hilang`) VALUES
(1, 'Perpustakaan', 'Legok, Kab. Tangerang.', '081234567890', 'perpustakaan@gmail.com', 2000, 10000, 20000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengembalian`
--

CREATE TABLE `tbl_pengembalian` (
  `kode_transaksi` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_anggota` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_pengembalian` date NOT NULL,
  `kode_buku` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `denda` int NOT NULL,
  `keterangan` enum('Baik','Rusak','Hilang') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_pengembalian` enum('Tertunda','Terverifikasi') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_pengguna` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_pengembalian`
--

INSERT INTO `tbl_pengembalian` (`kode_transaksi`, `kode_anggota`, `tanggal_pengembalian`, `kode_buku`, `denda`, `keterangan`, `status_pengembalian`, `kode_pengguna`) VALUES
('T0001', 'A0002', '2024-03-01', 'B0001', 0, 'Baik', 'Terverifikasi', 'P0002'),
('T0002', 'A0002', '2024-03-01', 'B0002', 0, 'Baik', 'Terverifikasi', 'P0002');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengguna`
--

CREATE TABLE `tbl_pengguna` (
  `kode_pengguna` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_pengguna` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kata_sandi` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hak_akses` enum('admin','user') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_pengguna` enum('Administrator','Anggota') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_pengguna`
--

INSERT INTO `tbl_pengguna` (`kode_pengguna`, `nama_pengguna`, `kata_sandi`, `hak_akses`, `status_pengguna`) VALUES
('P0001', 'admin', 'admin', 'admin', 'Administrator'),
('P0002', 'user', 'user', 'user', 'Anggota');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_anggota`
--
ALTER TABLE `tbl_anggota`
  ADD PRIMARY KEY (`kode_anggota`),
  ADD KEY `kode_pengguna` (`kode_pengguna`);

--
-- Indexes for table `tbl_buku`
--
ALTER TABLE `tbl_buku`
  ADD PRIMARY KEY (`kode_buku`);

--
-- Indexes for table `tbl_peminjaman`
--
ALTER TABLE `tbl_peminjaman`
  ADD PRIMARY KEY (`kode_transaksi`) USING BTREE,
  ADD KEY `kode_anggota` (`kode_anggota`),
  ADD KEY `kode_buku` (`kode_buku`),
  ADD KEY `kode_pengguna` (`kode_pengguna`);

--
-- Indexes for table `tbl_pengaturan`
--
ALTER TABLE `tbl_pengaturan`
  ADD PRIMARY KEY (`id_pengaturan`);

--
-- Indexes for table `tbl_pengembalian`
--
ALTER TABLE `tbl_pengembalian`
  ADD PRIMARY KEY (`kode_transaksi`) USING BTREE,
  ADD KEY `kode_anggota` (`kode_anggota`),
  ADD KEY `kode_buku` (`kode_buku`),
  ADD KEY `kode_pengguna` (`kode_pengguna`);

--
-- Indexes for table `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  ADD PRIMARY KEY (`kode_pengguna`),
  ADD UNIQUE KEY `nama_pengguna` (`nama_pengguna`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_pengaturan`
--
ALTER TABLE `tbl_pengaturan`
  MODIFY `id_pengaturan` tinyint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_anggota`
--
ALTER TABLE `tbl_anggota`
  ADD CONSTRAINT `tbl_anggota_ibfk_1` FOREIGN KEY (`kode_pengguna`) REFERENCES `tbl_pengguna` (`kode_pengguna`);

--
-- Constraints for table `tbl_peminjaman`
--
ALTER TABLE `tbl_peminjaman`
  ADD CONSTRAINT `tbl_peminjaman_ibfk_1` FOREIGN KEY (`kode_anggota`) REFERENCES `tbl_anggota` (`kode_anggota`),
  ADD CONSTRAINT `tbl_peminjaman_ibfk_2` FOREIGN KEY (`kode_buku`) REFERENCES `tbl_buku` (`kode_buku`),
  ADD CONSTRAINT `tbl_peminjaman_ibfk_3` FOREIGN KEY (`kode_pengguna`) REFERENCES `tbl_pengguna` (`kode_pengguna`);

--
-- Constraints for table `tbl_pengembalian`
--
ALTER TABLE `tbl_pengembalian`
  ADD CONSTRAINT `tbl_pengembalian_ibfk_1` FOREIGN KEY (`kode_anggota`) REFERENCES `tbl_anggota` (`kode_anggota`),
  ADD CONSTRAINT `tbl_pengembalian_ibfk_2` FOREIGN KEY (`kode_buku`) REFERENCES `tbl_buku` (`kode_buku`),
  ADD CONSTRAINT `tbl_pengembalian_ibfk_3` FOREIGN KEY (`kode_pengguna`) REFERENCES `tbl_pengguna` (`kode_pengguna`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
