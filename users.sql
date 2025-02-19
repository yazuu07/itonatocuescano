-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2025 at 10:08 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `users`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin1`
--

CREATE TABLE `admin1` (
  `id` int(50) NOT NULL,
  `user` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `role` varchar(500) NOT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin1`
--

INSERT INTO `admin1` (`id`, `user`, `email`, `role`, `contact_number`, `password`) VALUES
(21, 'admin', 'admin@gmail.com', '', '1234567890', '$2y$10$/PHBt495U6bEJo8B9CvekO3RTcxk/yQjDhln96Z62xikJiV5/d8OC'),
(22, 'Nimrod', 'nimrod@gmail.com', '', '09158541683', '$2y$10$7M4EumNn.KkbknFh1qFLFePk6PeyYa5qHoghYqsAQSeI9ACERlCvu'),
(23, 'lledo', 'lledo@gmail.com', '', '123456789', '$2y$10$tBt4zTy7BnfI/ZRhIxbFQuGs5b1nORz7XQXZJOKtOAPPazeGhhVei'),
(25, 'sto.tomas', 'sto.tomas@gmail.com', '', '09158541683', '$2y$10$JZjeXMj1pM7ooOFtHaPP8e7sAyEP7aTVLabowRCQMOTvn3R8s1LMC'),
(28, 'totoy', 'msavvy7@gmail.com', '', '1234567890', '$2y$10$ynnPCep5pAVj.dXKZDqOVO/cJjjAVB25DUbffv6rnRFPa6bryoUZm'),
(29, 'Banas', 'bans@gmail.com', '', '1234567890', '$2y$10$JNSadZ1/dW3xHEyk5V0SI.rIkuUU.y5B05BYkwcK4.4UQ1Rh63FbO'),
(31, 'Gilda', 'gilda@gmail.com', '', '821362149213', '$2y$10$jRb9x1HqBI8AlJfb8gb3Y.a/E/y0L316SyMsKIEcyyxrIIsTouWxq');

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `id` int(11) NOT NULL,
  `user_id` int(50) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `location` enum('In','Out','Overtime','Undertime') NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `uploads`
--

INSERT INTO `uploads` (`id`, `user_id`, `image_path`, `location`, `uploaded_at`) VALUES
(3, 23, 'uploads/photo_67b448fdbe4d5.jpg', 'In', '2025-02-18 08:46:53'),
(4, 23, 'uploads/photo_67b4490782ab7.jpg', 'Undertime', '2025-02-18 08:47:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin1`
--
ALTER TABLE `admin1`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user` (`user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin1`
--
ALTER TABLE `admin1`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `uploads`
--
ALTER TABLE `uploads`
  ADD CONSTRAINT `uploads_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `admin1` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
