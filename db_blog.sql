-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Apr 2026 pada 17.25
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_blog`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `artikel`
--

CREATE TABLE `artikel` (
  `id` int(11) NOT NULL,
  `id_penulis` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `hari_tanggal` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `artikel`
--

INSERT INTO `artikel` (`id`, `id_penulis`, `id_kategori`, `judul`, `isi`, `gambar`, `hari_tanggal`) VALUES
(1, 4, 9, 'Morph Sucker', 'Depok', '1777347075_pngfind.com-persona-5-png-309258.png', 'Selasa, 28 April 2026 | 10:31'),
(2, 5, 8, '1000 Spot Jogging di Depok', 'Daerah pondok cina, UI banyak dah pokoknya', '1777347202_b5409352b266cf91f9aaf46dfc8c7b91.jpg', 'Selasa, 28 April 2026 | 10:33'),
(3, 6, 10, 'Sepeda 200 KM dalam seminggu vs. GYM 7 kali seminggu ', 'Edan', '1777349186_images.jpg', 'Selasa, 28 April 2026 | 11:02'),
(4, 4, 11, 'Pengaruh Filsafat Stoikisme untuk Mahasiswa Semester Akhir', 'Begitulah', '1777364331_Aristotle_Altemps_Inv8575.jpg', 'Selasa, 28 April 2026 | 15:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_artikel`
--

CREATE TABLE `kategori_artikel` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kategori_artikel`
--

INSERT INTO `kategori_artikel` (`id`, `nama_kategori`, `keterangan`) VALUES
(8, 'Artikel', 'Artikel'),
(9, 'Buku', 'Book'),
(10, 'Study Case', 'Studi Kasus'),
(11, 'Jurnal', 'Journal');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penulis`
--

CREATE TABLE `penulis` (
  `id` int(11) NOT NULL,
  `nama_depan` varchar(100) NOT NULL,
  `nama_belakang` varchar(100) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `penulis`
--

INSERT INTO `penulis` (`id`, `nama_depan`, `nama_belakang`, `user_name`, `password`, `foto`) VALUES
(4, 'Raditya', 'Bintang Maulana', 'RadityaBM', '$2y$10$ZSkQfHjdcy/IcHE/tPy3RuJZFYJOgzu2c1umUwO3rWwJT5h/nVwRG', '1777082855_☆.jpeg'),
(5, 'Fasha', 'Maliqh', 'rrae budak bageur', '$2y$10$9G8AmONeDgjOasTDWHR2cO4nKXwAgDAvjaXNzkdRzMxyYT8AP12RS', '1777082939_Screenshot_2025-03-29_181339.png'),
(6, 'Belva', 'Karla', 'givenchy', '$2y$10$YY8pcs8cNuyp2jV1BC9qqOjVYqWODxDpp2qOA.9ti8ppZ/LaL2lAq', '1777348816_WhatsApp Image 2026-04-28 at 10.59.48 AM.jpeg'),
(10, 'Raditya', 'Bintang Maulana', 'rdtty_bm', '$2y$10$fKy58mNJdU5DXGfp6OQMduaha6mhwf/QL0dqEMlVsUznTMGwSgSTK', '1777364253_IMG_20260407_233523_240.png');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_artikel_penulis` (`id_penulis`),
  ADD KEY `fk_artikel_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `kategori_artikel`
--
ALTER TABLE `kategori_artikel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_nama_kategori` (`nama_kategori`);

--
-- Indeks untuk tabel `penulis`
--
ALTER TABLE `penulis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_user_name` (`user_name`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `kategori_artikel`
--
ALTER TABLE `kategori_artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `penulis`
--
ALTER TABLE `penulis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `artikel`
--
ALTER TABLE `artikel`
  ADD CONSTRAINT `fk_artikel_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_artikel` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_artikel_penulis` FOREIGN KEY (`id_penulis`) REFERENCES `penulis` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
