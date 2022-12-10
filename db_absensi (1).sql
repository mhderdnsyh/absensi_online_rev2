-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Des 2022 pada 23.44
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_absensi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `idAbsen` varchar(30) NOT NULL,
  `namaGtk` varchar(125) NOT NULL,
  `kodeGtk` varchar(125) NOT NULL,
  `tglAbsen` varchar(125) NOT NULL,
  `jamMasuk` varchar(13) NOT NULL,
  `jamPulang` varchar(13) NOT NULL,
  `statusGtk` int(1) NOT NULL,
  `keteranganAbsen` varchar(100) NOT NULL,
  `mapsAbsen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `absensi`
--

INSERT INTO `absensi` (`idAbsen`, `namaGtk`, `kodeGtk`, `tglAbsen`, `jamMasuk`, `jamPulang`, `statusGtk`, `keteranganAbsen`, `mapsAbsen`) VALUES
('absen_639508ca50a85', 'ismi', '1212121', 'Sabtu, 10 Desember 2022', '23:31:38', '', 2, 'Bekerja Di Kantor', 'No Location');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaturan`
--

CREATE TABLE `pengaturan` (
  `statusSetting` int(1) NOT NULL,
  `namaInstansi` varchar(255) NOT NULL,
  `jumbotronLeadSet` varchar(125) NOT NULL,
  `namaAppAbsensi` varchar(20) NOT NULL DEFAULT 'Absensi online',
  `logoInstansi` varchar(255) NOT NULL,
  `timezone` varchar(35) NOT NULL,
  `absenMulai` varchar(13) NOT NULL,
  `absenMulaiTo` varchar(13) NOT NULL,
  `absenPulang` varchar(13) NOT NULL,
  `mapsUse` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengaturan`
--

INSERT INTO `pengaturan` (`statusSetting`, `namaInstansi`, `jumbotronLeadSet`, `namaAppAbsensi`, `logoInstansi`, `timezone`, `absenMulai`, `absenMulaiTo`, `absenPulang`, `mapsUse`) VALUES
(1, 'Absensi SD Negeri 37 Kota Pekanbaru', 'Jangan Lupa Sholat!', 'Absensi Online', 'default-logo.png', 'Asia/Jakarta', '06:00:00', '11:00:00', '16:00:00', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `idGtk` int(11) NOT NULL,
  `namaLengkap` varchar(125) NOT NULL,
  `username` varchar(125) NOT NULL,
  `password` varchar(256) NOT NULL,
  `roleId` int(1) NOT NULL,
  `umur` int(11) NOT NULL,
  `image` varchar(125) NOT NULL,
  `kodeGtk` varchar(125) NOT NULL,
  `instansi` varchar(125) NOT NULL,
  `jabatan` varchar(125) NOT NULL,
  `nipGtk` varchar(255) NOT NULL,
  `tglLahir` varchar(25) NOT NULL,
  `tempatLahir` varchar(25) NOT NULL,
  `jenisKelamin` varchar(25) NOT NULL,
  `bagianShift` int(11) NOT NULL,
  `isActive` int(1) NOT NULL,
  `lastLogin` int(11) NOT NULL,
  `dateCreated` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`idGtk`, `namaLengkap`, `username`, `password`, `roleId`, `umur`, `image`, `kodeGtk`, `instansi`, `jabatan`, `nipGtk`, `tglLahir`, `tempatLahir`, `jenisKelamin`, `bagianShift`, `isActive`, `lastLogin`, `dateCreated`) VALUES
(12, 'Admin', 'admin', '12345678', 1, 18, 'default.png', '293571010111', 'Absensi SD Negeri 37 Kota Pekanbaru', 'Test', 'Tidak Ada', '2020-09-08', 'Test', 'Laki - Laki', 1, 1, 1625718271, 1584698797),
(13, 'ismi', 'ismi', '12345678', 2, 20, 'default.png', '1212121', 'Absensi SD Negeri 37 Kota Pekanbaru', 'Guru', '12121122', '2002-09-08', 'Pekanbaru', 'Perempuan', 1, 1, 0, 0),
(43, 'admin', 'admin', '12345678', 1, 20, 'default', '787878', 'Absensi SD Negeri 37 Kota Pekanbaru', 'operator', '09090', '2020-09-08', 'Pekanbaru', 'Laki-laki', 1, 2, 0, 0),
(44, 'operator', 'operator', '12345678', 3, 20, 'default', '787879', 'Absensi SD Negeri 37 Kota Pekanbaru', 'operator', '09099', '2020-09-08', 'Pekanbaru', 'Laki-laki', 1, 1, 1670632979, 1584698799);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`idAbsen`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`idGtk`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `idGtk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
