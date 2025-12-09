-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2025 at 03:44 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lms_nolasco`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(22, '2025-12-09-010900', 'App\\Database\\Migrations\\CreateUsersTable', 'default', 'App', 1765246258, 1),
(23, '2025-12-09-010901', 'App\\Database\\Migrations\\CreateCoursesTable', 'default', 'App', 1765246258, 1),
(24, '2025-12-09-010901', 'App\\Database\\Migrations\\CreateEnrollmentsTable', 'default', 'App', 1765246258, 1),
(25, '2025-12-09-010901', 'App\\Database\\Migrations\\CreateLessonsTable', 'default', 'App', 1765246258, 1),
(26, '2025-12-09-010901', 'App\\Database\\Migrations\\CreateQuizzesTable', 'default', 'App', 1765246258, 1),
(27, '2025-12-09-010901', 'App\\Database\\Migrations\\CreateSubmissionsTable', 'default', 'App', 1765246258, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','instructor','admin') NOT NULL DEFAULT 'student',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@example.com', '$2y$10$OwtkWp9HBH/JTD2fAbC6BOu/LnN5zPROCN/rcW7A9U/8j9ha5sIK6', 'admin', '2025-12-09 02:12:49', '2025-12-09 02:12:49'),
(2, 'Instructor User', 'instructor@example.com', '$2y$10$tZlmHJ7jUlJjo92gd0ptNuVzIxuOJPoVNjucncuJQ7v/o.sePbSeO', 'instructor', '2025-12-09 02:12:49', '2025-12-09 02:12:49'),
(3, 'Student User', 'student@example.com', '$2y$10$xoyXM0WYRZzogaG/b.YA4.nqLegO8jWsJ6BByVQy5f9ZkfCsvkSGK', 'student', '2025-12-09 02:12:49', '2025-12-09 02:12:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
