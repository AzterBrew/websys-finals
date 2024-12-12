-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2024 at 02:34 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `websys_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

CREATE TABLE `administrators` (
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `admin_firstname` varchar(255) NOT NULL,
  `admin_surname` varchar(100) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `admin_pass` varchar(25) NOT NULL,
  `admin_contact` varchar(20) NOT NULL,
  `admin_status` varchar(100) NOT NULL,
  `admin_priv` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administrators`
--

INSERT INTO `administrators` (`admin_id`, `admin_firstname`, `admin_surname`, `admin_email`, `admin_pass`, `admin_contact`, `admin_status`, `admin_priv`) VALUES
(1, 'Eloisa', 'Sumbad', 'ems@gmail.com', '123', '09223010281', 'Active', 'Authorized');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  `admin_creator` bigint(20) UNSIGNED NOT NULL,
  `record_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_desc` varchar(255) NOT NULL,
  `item_img` longblob NOT NULL,
  `cat_id` bigint(11) UNSIGNED NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `admin_creator` bigint(20) UNSIGNED NOT NULL,
  `date_created` date NOT NULL,
  `record_status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `quantity_ordered` int(11) NOT NULL,
  `quantity_received` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `order_status` varchar(50) NOT NULL,
  `admin_order` bigint(20) UNSIGNED NOT NULL,
  `order_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(100) NOT NULL,
  `supplier_location` varchar(100) NOT NULL,
  `supplier_contact` varchar(20) NOT NULL,
  `supplier_email` varchar(100) NOT NULL,
  `admin_creator` bigint(20) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `record_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `userlogin_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `logindate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`userlogin_id`, `admin_id`, `logindate`) VALUES
(1, 1, '2024-12-11 16:40:24'),
(2, 1, '2024-12-11 16:40:41'),
(3, 1, '2024-12-11 16:41:12'),
(4, 1, '2024-12-11 20:15:58'),
(5, 1, '2024-12-11 21:26:36'),
(6, 1, '2024-12-11 21:28:24'),
(7, 1, '2024-12-11 21:45:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `adminID` (`admin_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`),
  ADD UNIQUE KEY `catID` (`cat_id`),
  ADD KEY `fk_admincat` (`admin_creator`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD UNIQUE KEY `item_id` (`item_id`),
  ADD KEY `fk_catid` (`cat_id`),
  ADD KEY `fk_adminid_item` (`admin_creator`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_adminorder` (`admin_order`),
  ADD KEY `fk_itemorder` (`item_id`),
  ADD KEY `fk_supporder` (`supplier_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_id`),
  ADD KEY `fk_adminsup` (`admin_creator`);

--
-- Indexes for table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`userlogin_id`),
  ADD KEY `fk_adminlogin` (`admin_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrators`
--
ALTER TABLE `administrators`
  MODIFY `admin_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `fk_admincat` FOREIGN KEY (`admin_creator`) REFERENCES `administrators` (`admin_id`) ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `fk_adminitem` FOREIGN KEY (`admin_creator`) REFERENCES `administrators` (`admin_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_itemcat` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`cat_id`) ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_adminorder` FOREIGN KEY (`admin_order`) REFERENCES `administrators` (`admin_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_itemorder` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_supporder` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`) ON UPDATE CASCADE;

--
-- Constraints for table `supplier`
--
ALTER TABLE `supplier`
  ADD CONSTRAINT `fk_adminsup` FOREIGN KEY (`admin_creator`) REFERENCES `administrators` (`admin_id`) ON UPDATE CASCADE;

--
-- Constraints for table `user_login`
--
ALTER TABLE `user_login`
  ADD CONSTRAINT `fk_adminlogin` FOREIGN KEY (`admin_id`) REFERENCES `administrators` (`admin_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
