-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 26, 2019 at 09:35 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `description` text COLLATE utf8_polish_ci NOT NULL,
  `owner` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `name`, `description`, `owner`) VALUES
(3, 'Blog testowy', 'uspendisse magna nisl, eleifend id interdum vel, interdum ut nibh. Pellentesque porta blandit urna, nec luctus libero consectetur eu. Mauris placerat porttitor risus ac ultrices. Aliquam ex metus, semper quis ultrices pretium, tincidunt ut massa. Donec orci ligula, fringilla quis diam ac, scelerisque aliquam ligula. Curabitur mattis dignissim mi, a aliquam elit tristique vel. Suspendisse potenti. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam feugiat viverra tellus, quis ultricies quam viverra ac. Ut suscipit velit eu hendrerit interdum. Nulla ac odio condimentum, aliquam lectus id, commodo felis. Mauris eu suscipit nibh. Duis id enim et eros consectetur porttitor luctus quis tortor. Aliquam dui nibh, sodales at nibh ut, pellentesque consectetur metus. Phasellus sodales, neque a tristique varius, arcu dui suscipit nulla, nec tincidunt sapien leo vel dui.', 12);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `author` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `type` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `content` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `entry_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `author`, `type`, `content`, `entry_id`) VALUES
(5, 'havier pena', 'neutralny', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 3),
(6, 'Miguel Rodriguez ', 'negatywny', 'Vivamus consequat urna quis tellus consectetur consectetur. Maecenas lobortis urna eu venenatis pulvinar.', 3),
(7, 'Gepetto', 'pozytywny', ' Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;', 4);

-- --------------------------------------------------------

--
-- Table structure for table `entries`
--

CREATE TABLE `entries` (
  `id` int(11) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `content` text COLLATE utf8_polish_ci NOT NULL,
  `blog_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `entries`
--

INSERT INTO `entries` (`id`, `create_date`, `title`, `content`, `blog_id`) VALUES
(3, '2019-02-26 20:27:24', 'wpis powitalny', 'Mauris dictum sem sit amet turpis condimentum, et ornare sapien porttitor. Mauris sapien augue, luctus id elit at, tempus bibendum libero. Phasellus porttitor aliquam ex, ac imperdiet justo ultrices quis. Nullam id ornare odio. Donec eu metus vel risus iaculis ullamcorper sit amet a libero.', 3),
(4, '2019-02-26 20:30:42', 'Drugi wpis', 'Cras scelerisque purus lorem, in rhoncus est suscipit et. Interdum et malesuada fames ac ante ipsum primis in faucibus. Etiam elementum vulputate nibh, sed venenatis elit dictum porttitor. Duis a scelerisque orci, ut tristique enim. Morbi sit amet neque condimentum sem gravida pharetra. Curabitur ut fermentum neque.', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nick` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `age` int(11) NOT NULL,
  `email` varchar(30) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nick`, `password`, `name`, `age`, `email`) VALUES
(1, 'admin', '$2y$10$MKQAN.l6Yj7hvkIrKz7yg.wgKeIAiF4pKus5ux/MMThREUx8qSiNC', 'Kamil Skomro', 21, 'kamilskomro@example.com'),
(12, 'bloger', '$2y$10$MNNjg6.r9F6j7cvh/YwSiO50f6vcMCimDkMnFCPPm0kvAOxlHQABW', 'Jakub Klawiter', 30, 'klawi@example.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique` (`name`),
  ADD KEY `owner` (`owner`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entry_id` (`entry_id`);

--
-- Indexes for table `entries`
--
ALTER TABLE `entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_id` (`blog_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nick` (`nick`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `entries`
--
ALTER TABLE `entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_to_user` FOREIGN KEY (`owner`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `commets_to_entry` FOREIGN KEY (`entry_id`) REFERENCES `entries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `entries`
--
ALTER TABLE `entries`
  ADD CONSTRAINT `entries_to_blog` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
