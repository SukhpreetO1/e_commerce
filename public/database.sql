-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 06, 2024 at 06:58 PM
-- Server version: 8.0.36-0ubuntu0.20.04.1
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e-commerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories_heading`
--

CREATE TABLE `categories_heading` (
  `id` int NOT NULL,
  `clothes_category_id` int NOT NULL COMMENT '1 for mens, 2 for womens, 3 for kids, 4 for living, 5 for beauty',
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories_heading`
--

INSERT INTO `categories_heading` (`id`, `clothes_category_id`, `name`, `created_at`, `updated_at`) VALUES
(3, 1, 'Topwear', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(4, 1, 'Indians & Festive Wear', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(7, 1, 'Bottomwear', '2024-02-06 18:48:18', '2024-02-06 18:48:18'),
(8, 1, 'Innerwear & sleepwear', '2024-02-06 18:48:18', '2024-02-06 18:48:18'),
(9, 1, 'Plus Size', '2024-02-06 18:48:18', '2024-02-06 18:48:18'),
(10, 1, 'Footwear', '2024-02-06 18:48:18', '2024-02-06 18:48:18'),
(11, 1, 'Personal Care & Grooming', '2024-02-06 18:48:18', '2024-02-06 18:48:18'),
(12, 1, 'Sunglasses & Frames', '2024-02-06 18:48:18', '2024-02-06 18:48:18'),
(13, 1, 'Watches', '2024-02-06 18:48:18', '2024-02-06 18:48:18'),
(14, 1, 'Sports & Active Wear', '2024-02-06 18:48:18', '2024-02-06 18:48:18'),
(15, 1, 'Gadgets', '2024-02-06 18:48:18', '2024-02-06 18:48:18'),
(16, 1, 'Fashion Accessories', '2024-02-06 18:48:18', '2024-02-06 18:48:18'),
(17, 1, 'Bags & Backpacks', '2024-02-06 18:48:18', '2024-02-06 18:48:18'),
(18, 1, 'Luggages & Trolleys', '2024-02-06 18:48:18', '2024-02-06 18:48:18');

-- --------------------------------------------------------

--
-- Table structure for table `categories_type`
--

CREATE TABLE `categories_type` (
  `id` int NOT NULL,
  `category_heading_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clothes_categories`
--

CREATE TABLE `clothes_categories` (
  `id` int NOT NULL,
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clothes_categories`
--

INSERT INTO `clothes_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Men', '2024-02-06 18:43:30', '2024-02-06 18:43:30'),
(2, 'Women', '2024-02-06 18:43:30', '2024-02-06 18:43:30'),
(3, 'Kids', '2024-02-06 18:43:46', '2024-02-06 18:43:46'),
(4, 'Home & Living', '2024-02-06 18:44:09', '2024-02-06 18:44:09'),
(5, 'Beauty', '2024-02-06 18:44:29', '2024-02-06 18:44:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `first_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_admin` int NOT NULL DEFAULT '2' COMMENT '1 for admin and 2 for users',
  `reset_link_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reset_token_exp` datetime DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `is_admin`, `reset_link_token`, `reset_token_exp`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Sukhpreet', 'Singh', 'Sukhpreet9', 'ssingh77022@gmail.com', 2, 'NULL', NULL, '$2y$10$bGnAyeHAdVZ9oEVTBeVzDedv1WUbSJFwoqybRISvyxq.KptBQAQCy', '2024-02-01 09:47:43', '2024-02-06 12:43:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories_heading`
--
ALTER TABLE `categories_heading`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clothes_category_id` (`clothes_category_id`);

--
-- Indexes for table `categories_type`
--
ALTER TABLE `categories_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_heading_id` (`category_heading_id`);

--
-- Indexes for table `clothes_categories`
--
ALTER TABLE `clothes_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories_heading`
--
ALTER TABLE `categories_heading`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `categories_type`
--
ALTER TABLE `categories_type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clothes_categories`
--
ALTER TABLE `clothes_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories_heading`
--
ALTER TABLE `categories_heading`
  ADD CONSTRAINT `categories_heading_ibfk_1` FOREIGN KEY (`clothes_category_id`) REFERENCES `clothes_categories` (`id`);

--
-- Constraints for table `categories_type`
--
ALTER TABLE `categories_type`
  ADD CONSTRAINT `categories_type_ibfk_1` FOREIGN KEY (`category_heading_id`) REFERENCES `categories_heading` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;