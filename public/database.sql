-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 14, 2024 at 05:56 PM
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
(1, 1, 'Topwear', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(2, 1, 'Indians & Festive Wear', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(3, 1, 'Bottomwear', '2024-02-06 18:48:18', '2024-02-06 18:48:18'),
(4, 1, 'Innerwear & sleepwear', '2024-02-06 18:48:18', '2024-02-06 18:48:18'),
(5, 1, 'Plus Size', '2024-02-06 18:48:18', '2024-02-06 18:48:18'),
(6, 1, 'Footwear', '2024-02-06 18:48:18', '2024-02-06 18:48:18'),
(7, 1, 'Personal Care & Grooming', '2024-02-06 18:48:18', '2024-02-06 18:48:18'),
(8, 1, 'Sunglasses & Frames', '2024-02-06 18:48:18', '2024-02-06 18:48:18'),
(9, 1, 'Watches', '2024-02-06 18:48:18', '2024-02-06 18:48:18'),
(10, 1, 'Sports & Active Wear', '2024-02-06 18:48:18', '2024-02-06 18:48:18'),
(11, 1, 'Gadgets', '2024-02-06 18:48:18', '2024-02-06 18:48:18'),
(12, 1, 'Fashion Accessories', '2024-02-06 18:48:18', '2024-02-06 18:48:18'),
(13, 1, 'Bags & Backpacks', '2024-02-06 18:48:18', '2024-02-06 18:48:18'),
(14, 1, 'Luggages & Trolleys', '2024-02-06 18:48:18', '2024-02-06 18:48:18'),
(15, 2, 'Indian & Fusion Wear', '2024-02-12 09:58:36', '2024-02-12 09:58:36');

-- --------------------------------------------------------

--
-- Table structure for table `categories_type`
--

CREATE TABLE `categories_type` (
  `id` int NOT NULL,
  `category_heading_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories_type`
--

INSERT INTO `categories_type` (`id`, `category_heading_id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'T-Shirts', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(2, 1, 'Casual Shirts', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(3, 1, 'Formal Shirts', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(4, 1, 'Sweatshirts', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(5, 1, 'Sweaters', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(6, 1, 'Jackets', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(7, 1, 'Blazers & Coats', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(8, 1, 'Suits', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(9, 1, 'Rain Jackets', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(10, 2, 'Kurtas & Kurta Sets', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(11, 2, 'Sherwanis', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(12, 2, 'Nehru Jackets', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(13, 2, 'Dhotis', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(14, 3, 'Jeans', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(15, 3, 'Casual Trousers', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(16, 3, 'Formal Trousers', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(17, 3, 'Shorts', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(18, 3, 'Track Pants & Joggers', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(19, 4, 'Briefs & Trunks', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(20, 4, 'Boxers', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(21, 4, 'Vests', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(22, 4, 'Sleepwear & Loungewear', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(23, 4, 'Thermals', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(24, 6, 'Casual Shoes', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(25, 6, 'Sports Shoes', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(26, 6, 'Formal Shoes', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(27, 6, 'Sneakers', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(28, 6, 'Sandals & Floaters', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(29, 6, 'Flip Flops', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(30, 6, 'Socks', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(31, 10, 'Sports Shoes', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(32, 10, 'Sports Sandals', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(33, 10, 'Active T-Shirts', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(34, 10, 'Track Pants & Shorts', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(35, 10, 'Tracksuits', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(36, 10, 'Jackets & Sweatshirts', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(37, 10, 'Sports Accessories', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(38, 10, 'Swimwear', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(39, 11, 'Smart Wearables', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(40, 11, 'Fitness Gadgets', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(41, 11, 'Headphones', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(42, 11, 'Speakers', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(43, 12, 'Wallets', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(44, 12, 'Belts', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(45, 12, 'Perfumes & Body Mists', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(46, 12, 'Trimmers', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(47, 12, 'Deodorants', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(48, 12, 'Ties, Cufflinks & Pocket Squares', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(49, 12, 'Accessory Gift Sets', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(50, 12, 'Caps & Hats', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(51, 12, 'Mufflers, Scarves & Gloves', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(52, 12, 'Phone Cases', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(53, 12, 'Rings & Wristwear', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(54, 12, 'Helmets', NULL, '2024-02-06 18:45:14', '2024-02-06 18:45:14');

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
(1, 'Men', '2024-02-14 16:26:23', '2024-02-14 17:04:10'),
(2, 'Women', '2024-02-14 16:26:27', '2024-02-14 16:26:27'),
(3, 'Kids', '2024-02-14 16:26:31', '2024-02-14 16:26:31'),
(4, 'Home Living', '2024-02-14 16:26:40', '2024-02-14 16:26:40'),
(5, 'Beauty', '2024-02-14 16:26:48', '2024-02-14 16:26:48');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int NOT NULL,
  `name` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '2024-02-14 17:43:08', '2024-02-14 17:43:08'),
(2, 'User', '2024-02-14 17:43:08', '2024-02-14 17:43:08');

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
  `role_id` int NOT NULL DEFAULT '2',
  `reset_link_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reset_token_exp` datetime DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `role_id`, `reset_link_token`, `reset_token_exp`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Sukhpreet', 'Singh', 'Sukhpreet9', 'ssingh77022@gmail.com', 2, 'NULL', NULL, '$2y$10$bGnAyeHAdVZ9oEVTBeVzDedv1WUbSJFwoqybRISvyxq.KptBQAQCy', '2024-02-01 09:47:43', '2024-02-06 12:43:37'),
(2, 'Sukhpreet', 'Singh', 'Sukhpreet99', 'ssingh77021@gmail.com', 1, 'NULL', NULL, '$2y$10$bGnAyeHAdVZ9oEVTBeVzDedv1WUbSJFwoqybRISvyxq.KptBQAQCy', '2024-02-01 09:47:43', '2024-02-06 12:43:37');

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
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories_heading`
--
ALTER TABLE `categories_heading`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `categories_type`
--
ALTER TABLE `categories_type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `clothes_categories`
--
ALTER TABLE `clothes_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories_heading`
--
ALTER TABLE `categories_heading`
  ADD CONSTRAINT `categories_heading_ibfk_1` FOREIGN KEY (`clothes_category_id`) REFERENCES `clothes_categories` (`id`),
  ADD CONSTRAINT `fk_clothes_category` FOREIGN KEY (`clothes_category_id`) REFERENCES `clothes_categories` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `categories_type`
--
ALTER TABLE `categories_type`
  ADD CONSTRAINT `categories_type_ibfk_1` FOREIGN KEY (`category_heading_id`) REFERENCES `categories_heading` (`id`),
  ADD CONSTRAINT `fk_category_heading` FOREIGN KEY (`category_heading_id`) REFERENCES `categories_heading` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;