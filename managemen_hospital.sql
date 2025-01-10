-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 10 Jan 2025 pada 08.29
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `managemen_hospital`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `patient_name` varchar(255) NOT NULL,
  `doctor_name` varchar(255) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `status` enum('pending','completed','canceled') DEFAULT 'pending',
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `appointments`
--

INSERT INTO `appointments` (`id`, `patient_name`, `doctor_name`, `appointment_date`, `appointment_time`, `status`, `user_id`) VALUES
(6, 'Andi Setiawan', 'Dr. Andi Surya', '2025-01-08', '10:00:00', 'pending', 0),
(7, 'Rina Hartanti', 'Dr. Rina Santoso', '2025-01-09', '23:50:00', 'pending', 0),
(8, 'Budi Prasetyo', 'Dr. Budi Pranoto', '2025-01-07', '03:40:00', 'pending', 0),
(9, 'Siti Nurhaliza', 'Dr. Siti Lestari', '2025-01-06', '07:49:00', 'pending', 0),
(10, 'Arief Wijaya', 'Dr. Arief Wijaya', '2025-01-10', '21:52:00', 'pending', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `specialization` varchar(255) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `specialization`, `contact`, `email`, `address`, `created_at`) VALUES
(5, 'Dr. Andi Surya', 'Spesialis Jantung', '081234567890', 'andi.surya@gmail.com', 'Jl. Merdeka No. 5, Bandung', '2025-01-07 00:43:31'),
(6, 'Dr. Rina Santoso', 'Spesialis Anak', '081298765432', 'rina.santoso@yahoo.com', 'Jl. Mawar No. 12, Jakarta', '2025-01-07 00:44:03'),
(7, 'Dr. Budi Pranoto', 'Spesialis Bedah', '081345678912', 'budi.pranoto@gmail.com', 'Jl. Anggrek No. 8, Surabaya', '2025-01-07 00:44:34'),
(8, 'Dr. Siti Lestari', 'Spesialis Kandungan', '081987654321', 'siti.lestari@outlook.com', 'Jl. Kemuning No. 9, Medan', '2025-01-07 00:45:12'),
(9, 'Dr. Arief Wijaya', 'Spesialis Penyakit Dalam', '081456789123', 'arief.wijaya@gmail.com', 'Jl. Melati No. 3, Semarang', '2025-01-07 00:45:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `contact` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `patients`
--

INSERT INTO `patients` (`id`, `name`, `age`, `gender`, `contact`, `email`, `phone`, `address`, `created_at`) VALUES
(5, 'Andi Setiawan', 25, 'Male', 'WhatsApp', 'andi.setiawan@gmail.com', '081234567890', 'Jl. Merdeka No. 10, Bandung', '2025-01-07 00:38:32'),
(6, 'Rina Hartanti', 32, 'Female', 'Telegram', 'rina.hartanti@yahoo.com', '081298765432', 'Jl. Mawar No. 5, Jakarta', '2025-01-07 00:39:28'),
(7, 'Budi Prasetyo', 45, 'Male', 'WhatsApp, SMS', 'budi.pra@gmail.com', '081345678912', 'Jl. Anggrek No. 8, Surabaya', '2025-01-07 00:40:25'),
(8, 'Siti Nurhaliza', 29, 'Female', 'WhatsApp, Telepon', 'siti.nur@gmail.com', '081987654321', 'Jl. Kemuning No. 7, Medan', '2025-01-07 00:40:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(1, 'oozezeooo@gmail.com', '$2y$10$cyd1hOxtIzQ7LBP.te9bheuq3F3Q6mfl7ObhjzyT71qtJ/WRGPkce', '', '2025-01-05 22:20:26');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
