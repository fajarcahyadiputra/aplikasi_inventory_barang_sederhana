-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 31 Okt 2020 pada 06.05
-- Versi server: 10.4.14-MariaDB
-- Versi PHP: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `free_stokbarang`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_barang`
--

CREATE TABLE `tb_barang` (
  `id` bigint(20) NOT NULL,
  `id_user` bigint(20) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `stok` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `tanggal_buat` datetime NOT NULL,
  `terakhir_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_barang`
--

INSERT INTO `tb_barang` (`id`, `id_user`, `nama_barang`, `stok`, `keterangan`, `tanggal_buat`, `terakhir_update`) VALUES
(1, 1, 'sabun', 2, 'sabun ok', '2020-10-04 07:41:59', '2020-10-11 01:42:03'),
(19, 1, 'kacamata', 30, 'okok', '2020-10-11 01:56:58', '2020-10-11 01:56:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_barangkeluar`
--

CREATE TABLE `tb_barangkeluar` (
  `id` bigint(20) NOT NULL,
  `id_barang` bigint(20) NOT NULL,
  `id_user` bigint(20) NOT NULL,
  `jumblah` decimal(10,0) NOT NULL,
  `tanggal_keluar` datetime NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_barangkeluar`
--

INSERT INTO `tb_barangkeluar` (`id`, `id_barang`, `id_user`, `jumblah`, `tanggal_keluar`, `keterangan`) VALUES
(1, 1, 1, '20', '2020-10-04 07:42:36', 'di bawa orang'),
(5, 1, 1, '10', '2020-10-11 01:59:38', 'ok');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_users`
--

CREATE TABLE `tb_users` (
  `id` bigint(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `level` enum('admin','sub_admin') NOT NULL,
  `status_aktif` enum('ya','tidak') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_users`
--

INSERT INTO `tb_users` (`id`, `nama`, `username`, `password`, `level`, `status_aktif`) VALUES
(1, 'admin', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin', 'ya');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_barangkeluar`
--
ALTER TABLE `tb_barangkeluar`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_barang`
--
ALTER TABLE `tb_barang`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `tb_barangkeluar`
--
ALTER TABLE `tb_barangkeluar`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
