-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Feb 2024 pada 23.03
-- Versi server: 10.4.25-MariaDB
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `comic_platform`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `gambar_komik`
--

CREATE TABLE `gambar_komik` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `volume_id` bigint(20) UNSIGNED NOT NULL,
  `komik_id` bigint(20) UNSIGNED NOT NULL,
  `judul_gambar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `gambar_komik`
--

INSERT INTO `gambar_komik` (`id`, `volume_id`, `komik_id`, `judul_gambar`, `created_at`, `updated_at`) VALUES
(253, 151, 99, 'uploads/gambarkomik/1708851121_naruto1.jpg', '2024-02-25 01:52:01', '2024-02-25 01:52:01'),
(254, 151, 99, 'uploads/gambarkomik/1708851121_naruto2.jpg', '2024-02-25 01:52:01', '2024-02-25 01:52:01'),
(255, 152, 99, 'uploads/gambarkomik/1708851910_naruto3.jpg', '2024-02-25 02:05:10', '2024-02-25 02:05:10'),
(256, 152, 99, 'uploads/gambarkomik/1708851910_naruto4.jpg', '2024-02-25 02:05:10', '2024-02-25 02:05:10'),
(257, 153, 99, 'uploads/gambarkomik/1708851928_naruto5.jpg', '2024-02-25 02:05:28', '2024-02-25 02:05:28'),
(258, 154, 99, 'uploads/gambarkomik/1708851942_naruto6.jpg', '2024-02-25 02:05:42', '2024-02-25 02:05:42'),
(259, 157, 99, 'uploads/gambarkomik/1708852086_naruto7.jpg', '2024-02-25 02:08:06', '2024-02-25 02:08:06'),
(260, 157, 99, 'uploads/gambarkomik/1708852086_naruto8.jpg', '2024-02-25 02:08:06', '2024-02-25 02:08:06'),
(264, 161, 103, 'uploads/gambarkomik/1708868108_l-death-note-navideno-3.jpg', '2024-02-25 06:35:08', '2024-02-25 06:35:08'),
(265, 161, 103, 'uploads/gambarkomik/1708868108_webflow-logo-icon-169218.png', '2024-02-25 06:35:08', '2024-02-25 06:35:08'),
(266, 162, 103, 'uploads/gambarkomik/1708868830_family-polaroid-photos-postcard.png', '2024-02-25 06:47:10', '2024-02-25 06:47:10'),
(267, 162, 103, 'uploads/gambarkomik/1708868830_1.PNG', '2024-02-25 06:47:10', '2024-02-25 06:47:10'),
(268, 163, 104, 'uploads/gambarkomik/1708897116_wordpress-blue-logosvg.png', '2024-02-25 14:38:36', '2024-02-25 14:38:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `komentars`
--

CREATE TABLE `komentars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `komik_id` bigint(20) UNSIGNED NOT NULL,
  `volume_id` bigint(20) UNSIGNED NOT NULL,
  `komentar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `komentars`
--

INSERT INTO `komentars` (`id`, `user_id`, `komik_id`, `volume_id`, `komentar`, `rating`, `created_at`, `updated_at`) VALUES
(91, 61, 99, 151, 'Saran saya tambahkan warna', 2, '2024-02-24 06:19:18', '2024-02-24 06:19:18'),
(94, 59, 99, 153, 'Saran saya tambahkan warna', 3, '2024-02-25 02:30:19', '2024-02-25 02:30:19'),
(98, 61, 99, 153, 'Kerennn jugaaa sihh', 4, '2024-02-25 06:57:48', '2024-02-25 06:57:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `komik`
--

CREATE TABLE `komik` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `judul_komik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_rilis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `genre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sinopsis` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover_komik` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `jumlah_pembaca` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `komik`
--

INSERT INTO `komik` (`id`, `user_id`, `judul_komik`, `tgl_rilis`, `genre`, `sinopsis`, `cover_komik`, `created_at`, `updated_at`, `jumlah_pembaca`) VALUES
(99, 62, 'Naruto Shippuden', '2020-08-19', 'Actions , Adventure & Fantasy', 'Komik ini bercerita tentang Naruto Uzumaki, seorang ninja remaja yang bercita-cita menjadi Hokage, pemimpin desa ninja terkuat. Dia diabaikan karena memiliki segel jinchuriki Kyuubi didalam tubuhnya. Bersama teman-temannya, Sasuke dan Sakura serta guru kakashi, Naruto menjalani petualangan ninja, menghadapi musuh-musuh, dan belajar tentang persahabatan.', 'uploads/coverkomik/1708867129_narutocoverjpg.jpg', '2024-02-24', '2024-02-25 06:57:34', 3),
(103, 62, 'Death Note', '2021-09-18', 'Mystery & Thriller', 'Bercerita tentang Light Yagami, seorang remaja jenius yang menemukan buku catatan misterius yang disebut \"Death Note\", yang dimiliki oleh shinigami (dewa kematian) bernama Ryuk, dan memberikan penggunanya kemampuan supranatural untuk membunuh siapapun ketika menulis namanya di buku tersebut.', 'uploads/coverkomik/1708868078_deathnotecoverjpg.jpg', '2024-02-25', '2024-02-25 06:49:17', 1),
(104, 60, 'Naruto The Movie', '2022-08-19', 'Actions , Adventure & Fantasy', 'testststststststst', 'uploads/coverkomik/1708897101_cover-narutomoviejpg.jpg', '2024-02-25', '2024-02-25 14:38:21', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penyimpanan_komik`
--

CREATE TABLE `penyimpanan_komik` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `komik_id` bigint(20) UNSIGNED NOT NULL,
  `volume_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `penyimpanan_komik`
--

INSERT INTO `penyimpanan_komik` (`id`, `user_id`, `komik_id`, `volume_id`, `created_at`, `updated_at`) VALUES
(117, 59, 99, 151, '2024-02-25 14:59:37', '2024-02-25 14:59:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_lahir` date NOT NULL,
  `level` enum('user','admin','author') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `gender` enum('laki-laki','perempuan') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `tgl_lahir`, `level`, `gender`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(54, 'Super admin', 'Admin', 'admin@gmail.com', '$2y$12$nCCcw9em8dBlEQFST3Hdi.4Z34dJUYTe6NBsawCmjvg5MDER03BUm', '2001-09-12', 'admin', 'laki-laki', NULL, NULL, '2024-02-11 05:01:33', '2024-02-11 05:01:33'),
(59, 'M Rofiq fadilah', 'Rofiqazk', 'mrofiqfadil@gmail.com', '$2y$12$pOwHpEqSlYaGBxggD/WQi.nhhHSR7Y7pMYBp2OE.YhEQXBd3Vimta', '2007-07-16', 'user', 'laki-laki', NULL, NULL, '2024-02-24 06:10:04', '2024-02-25 01:44:00'),
(60, 'Jauza Alya Nabilah', 'Jauza Alya', 'jauza@gmail.com', '$2y$12$t1o5Q.DoSA/SvyoclBVhcOly9rg1VPIk.Z/4YspNuWGD0BmQBxp.C', '2007-08-17', 'author', 'perempuan', NULL, NULL, '2024-02-24 06:11:11', '2024-02-24 06:11:11'),
(61, 'Devin Valentino', 'Devin', 'devin33@gmail.com', '$2y$12$PpyH0cpyCHQNU28cCQfpyeEn4y00semeglkUsVek95DoVVNuRAn1S', '2004-08-17', 'user', 'laki-laki', NULL, NULL, '2024-02-25 01:43:03', '2024-02-25 01:43:03'),
(62, 'M Hadrilianur', 'hadrilly2', 'hadril@gmail.com', '$2y$12$H2gt.MLEQRf640s/pHcwPurESQ6FyATTNdST2vsjJR5qNLFn6Yd3q', '2007-08-19', 'author', 'laki-laki', NULL, NULL, '2024-02-25 01:49:11', '2024-02-25 01:49:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `volume`
--

CREATE TABLE `volume` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `komik_id` bigint(20) UNSIGNED NOT NULL,
  `judul_volume` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_halaman` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `volume`
--

INSERT INTO `volume` (`id`, `komik_id`, `judul_volume`, `jumlah_halaman`, `created_at`, `updated_at`) VALUES
(151, 99, '1', '2', '2024-02-24', '2024-02-25 01:52:01'),
(152, 99, '2', '2', '2024-02-24', '2024-02-24 06:17:25'),
(153, 99, '3', '1', '2024-02-25', '2024-02-24 19:37:24'),
(154, 99, '4', '1', '2024-02-25', '2024-02-24 19:38:05'),
(157, 99, '5', '2', '2024-02-25', '2024-02-25 02:08:06'),
(161, 103, '1', '2', '2024-02-25', '2024-02-25 06:35:08'),
(162, 103, '2', '2', '2024-02-25', '2024-02-25 06:47:10'),
(163, 104, '1', '1', '2024-02-25', '2024-02-25 14:38:36');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `gambar_komik`
--
ALTER TABLE `gambar_komik`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gambar_komik_volume_id_foreign` (`volume_id`),
  ADD KEY `gambar_komik_komik_id_foreign` (`komik_id`);

--
-- Indeks untuk tabel `komentars`
--
ALTER TABLE `komentars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `komentars_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `komik`
--
ALTER TABLE `komik`
  ADD PRIMARY KEY (`id`),
  ADD KEY `komik_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `penyimpanan_komik`
--
ALTER TABLE `penyimpanan_komik`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penyimpanan_komik_user_id_foreign` (`user_id`),
  ADD KEY `penyimpanan_komik_komik_id_foreign` (`komik_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `volume`
--
ALTER TABLE `volume`
  ADD PRIMARY KEY (`id`),
  ADD KEY `volume_komik_id_foreign` (`komik_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `gambar_komik`
--
ALTER TABLE `gambar_komik`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=269;

--
-- AUTO_INCREMENT untuk tabel `komentars`
--
ALTER TABLE `komentars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT untuk tabel `komik`
--
ALTER TABLE `komik`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT untuk tabel `penyimpanan_komik`
--
ALTER TABLE `penyimpanan_komik`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT untuk tabel `volume`
--
ALTER TABLE `volume`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `gambar_komik`
--
ALTER TABLE `gambar_komik`
  ADD CONSTRAINT `gambar_komik_komik_id_foreign` FOREIGN KEY (`komik_id`) REFERENCES `komik` (`id`),
  ADD CONSTRAINT `gambar_komik_volume_id_foreign` FOREIGN KEY (`volume_id`) REFERENCES `volume` (`id`);

--
-- Ketidakleluasaan untuk tabel `komentars`
--
ALTER TABLE `komentars`
  ADD CONSTRAINT `komentars_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `komik`
--
ALTER TABLE `komik`
  ADD CONSTRAINT `komik_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `penyimpanan_komik`
--
ALTER TABLE `penyimpanan_komik`
  ADD CONSTRAINT `penyimpanan_komik_komik_id_foreign` FOREIGN KEY (`komik_id`) REFERENCES `komik` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `penyimpanan_komik_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `volume`
--
ALTER TABLE `volume`
  ADD CONSTRAINT `volume_komik_id_foreign` FOREIGN KEY (`komik_id`) REFERENCES `komik` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
