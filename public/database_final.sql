-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 21, 2024 at 06:04 PM
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
-- Database: `e-commerce_2`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `categories_type_id` int NOT NULL,
  `users_id` int NOT NULL,
  `quantity` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Men', '2024-02-14 16:26:23', '2024-02-14 17:04:10'),
(2, 'Women', '2024-02-14 16:26:27', '2024-02-14 16:26:27'),
(3, 'Kids', '2024-02-14 16:26:31', '2024-02-14 16:26:31'),
(4, 'Home Living', '2024-02-14 16:26:40', '2024-02-14 16:26:40'),
(5, 'Beauty', '2024-02-14 16:26:48', '2024-02-14 16:26:48');

-- --------------------------------------------------------

--
-- Table structure for table `categories_heading`
--

CREATE TABLE `categories_heading` (
  `id` int NOT NULL,
  `categories_id` int NOT NULL COMMENT '1 for mens, 2 for womens, 3 for kids, 4 for living, 5 for beauty',
  `name` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories_heading`
--

INSERT INTO `categories_heading` (`id`, `categories_id`, `name`, `created_at`, `updated_at`) VALUES
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
  `categories_heading_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories_type`
--

INSERT INTO `categories_type` (`id`, `categories_heading_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'T-Shirts', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(2, 1, 'Casual Shirts', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(3, 1, 'Formal Shirts', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(4, 1, 'Sweatshirts', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(5, 1, 'Sweaters', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(6, 1, 'Jackets', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(7, 1, 'Blazers & Coats', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(8, 1, 'Suits', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(9, 1, 'Rain Jackets', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(10, 2, 'Kurtas & Kurta Sets', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(11, 2, 'Sherwanis', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(12, 2, 'Nehru Jackets', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(13, 2, 'Dhotis', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(14, 3, 'Jeans', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(15, 3, 'Casual Trousers', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(16, 3, 'Formal Trousers', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(17, 3, 'Shorts', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(18, 3, 'Track Pants & Joggers', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(19, 4, 'Briefs & Trunks', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(20, 4, 'Boxers', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(21, 4, 'Vests', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(22, 4, 'Sleepwear & Loungewear', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(23, 4, 'Thermals', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(24, 6, 'Casual Shoes', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(25, 6, 'Sports Shoes', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(26, 6, 'Formal Shoes', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(27, 6, 'Sneakers', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(28, 6, 'Sandals & Floaters', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(29, 6, 'Flip Flops', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(30, 6, 'Socks', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(31, 10, 'Sports Shoes', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(32, 10, 'Sports Sandals', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(33, 10, 'Active T-Shirts', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(34, 10, 'Track Pants & Shorts', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(35, 10, 'Tracksuits', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(36, 10, 'Jackets & Sweatshirts', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(37, 10, 'Sports Accessories', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(38, 10, 'Swimwear', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(39, 11, 'Smart Wearables', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(40, 11, 'Fitness Gadgets', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(41, 11, 'Headphones', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(42, 11, 'Speakers', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(43, 12, 'Wallets', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(44, 12, 'Belts', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(45, 12, 'Perfumes & Body Mists', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(46, 12, 'Trimmers', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(47, 12, 'Deodorants', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(48, 12, 'Ties, Cufflinks & Pocket Squares', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(49, 12, 'Accessory Gift Sets', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(50, 12, 'Caps & Hats', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(51, 12, 'Mufflers, Scarves & Gloves', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(52, 12, 'Phone Cases', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(53, 12, 'Rings & Wristwear', '2024-02-06 18:45:14', '2024-02-06 18:45:14'),
(54, 12, 'Helmets', '2024-02-06 18:45:14', '2024-02-06 18:45:14');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `cart_id` int NOT NULL,
  `total_amount` int NOT NULL,
  `order_date` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `categories_type_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` varchar(8) COLLATE utf8mb4_general_ci NOT NULL,
  `discount` varchar(8) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `categories_type_id`, `quantity`, `price`, `discount`, `created_at`, `updated_at`) VALUES
(1, 'qwe', 'qweqeqqweqeqqweqeqqweqeqqweqeqqweqeqqweqeqqweqeqqweqeqqweqeqqweqeqqweqeqqweqeqqweqeqqweqeq', 2, 5, '10', '0', '2024-02-20 15:55:10', '2024-02-20 15:55:10'),
(3, 'oiuouoiuo weryt', 'adsdadsdadsdadsdadsdadsdadsdadsdadsdadsdadsdadsdadsdadsdadsdadsdadsdadsdadsdadsdadsdadsdadsdadsdadsdadsdadsdadsdadsdadsdadsdadsdadsdadsd', 4, 50, '50', '0', '2024-02-21 09:40:10', '2024-02-21 09:40:10');

-- --------------------------------------------------------

--
-- Table structure for table `products_image`
--

CREATE TABLE `products_image` (
  `id` int NOT NULL,
  `name` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `products_id` int NOT NULL,
  `path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products_image`
--

INSERT INTO `products_image` (`id`, `name`, `products_id`, `path`, `created_at`, `updated_at`) VALUES
(1, 'Screenshot from 2023-09-11 14-58-14.png', 1, 'Screenshot_from_2023-09-11_14-58-14.png', '2024-02-20 15:55:10', '2024-02-20 15:55:10'),
(7, 'Screenshot from 2023-10-03 18-43-46.png', 3, 'Screenshot_from_2023-10-03_18-43-46.png', '2024-02-21 09:40:10', '2024-02-21 09:40:10'),
(8, 'Screenshot from 2023-09-28 16-53-23.png', 3, 'Screenshot_from_2023-09-28_16-53-23.png', '2024-02-21 09:40:10', '2024-02-21 09:40:10'),
(9, 'Screenshot from 2023-09-11 14-58-14.png', 3, 'Screenshot_from_2023-09-11_14-58-14.png', '2024-02-21 09:40:10', '2024-02-21 09:40:10'),
(10, 'Screenshot from 2023-09-11 14-54-27.png', 3, 'Screenshot_from_2023-09-11_14-54-27.png', '2024-02-21 09:40:10', '2024-02-21 09:40:10'),
(11, 'Screenshot from 2023-09-11 14-54-26.png', 3, 'Screenshot_from_2023-09-11_14-54-26.png', '2024-02-21 09:40:10', '2024-02-21 09:40:10');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int NOT NULL,
  `name` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '2024-02-14 17:43:08', '2024-02-14 17:43:08'),
(2, 'User', '2024-02-14 17:43:08', '2024-02-16 11:33:19');

-- --------------------------------------------------------

--
-- Table structure for table `shipment_address`
--

CREATE TABLE `shipment_address` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `users_id` int NOT NULL,
  `address` text NOT NULL,
  `city` varchar(30) NOT NULL,
  `state` varchar(30) NOT NULL,
  `country` varchar(25) NOT NULL,
  `pin_code` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `first_name` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `role_id` int NOT NULL DEFAULT '2',
  `reset_link_token` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reset_token_exp` datetime DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `role_id`, `reset_link_token`, `reset_token_exp`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Sukhpreet', 'Singh', 'Sukhpreet9', 'ssingh77022@gmail.com', 2, 'NULL', NULL, '$2y$10$bGnAyeHAdVZ9oEVTBeVzDedv1WUbSJFwoqybRISvyxq.KptBQAQCy', '2024-02-01 09:47:43', '2024-02-16 19:12:26'),
(2, 'Sukhpreet', 'Singh', 'Sukhpreet99', 'ssingh77021@gmail.com', 1, 'NULL', NULL, '$2y$10$bGnAyeHAdVZ9oEVTBeVzDedv1WUbSJFwoqybRISvyxq.KptBQAQCy', '2024-02-01 09:47:43', '2024-02-16 18:47:12');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `categories_type_id` (`categories_type_id`),
  ADD KEY `users_id` (`users_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories_heading`
--
ALTER TABLE `categories_heading`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clothes_category_id` (`categories_id`);

--
-- Indexes for table `categories_type`
--
ALTER TABLE `categories_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_heading_id` (`categories_heading_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_id` (`cart_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_type_id` (`categories_type_id`) USING BTREE;

--
-- Indexes for table `products_image`
--
ALTER TABLE `products_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_id` (`products_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipment_address`
--
ALTER TABLE `shipment_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `users_id` (`users_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products_image`
--
ALTER TABLE `products_image`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `shipment_address`
--
ALTER TABLE `shipment_address`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_order_table_categories_type_id` FOREIGN KEY (`categories_type_id`) REFERENCES `categories_type` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_order_table_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_order_table_users_id` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `categories_heading`
--
ALTER TABLE `categories_heading`
  ADD CONSTRAINT `categories_heading_ibfk_1` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `fk_clothes_category` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `categories_type`
--
ALTER TABLE `categories_type`
  ADD CONSTRAINT `categories_type_ibfk_1` FOREIGN KEY (`categories_heading_id`) REFERENCES `categories_heading` (`id`),
  ADD CONSTRAINT `fk_category_heading` FOREIGN KEY (`categories_heading_id`) REFERENCES `categories_heading` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_cart_id` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_categories_type` FOREIGN KEY (`categories_type_id`) REFERENCES `categories_type` (`id`);

--
-- Constraints for table `products_image`
--
ALTER TABLE `products_image`
  ADD CONSTRAINT `fk_product_id` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `shipment_address`
--
ALTER TABLE `shipment_address`
  ADD CONSTRAINT `fk_users_id` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `fk_wishlist_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_wishlist_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;