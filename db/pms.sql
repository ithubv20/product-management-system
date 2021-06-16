-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 16, 2021 at 05:54 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pms`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categories`
--

DROP TABLE IF EXISTS `tbl_categories`;
CREATE TABLE IF NOT EXISTS `tbl_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_description` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_categories`
--

INSERT INTO `tbl_categories` (`id`, `category_description`) VALUES
(1, 'Components'),
(2, 'Chairs'),
(3, 'Living room furniture');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_currency`
--

DROP TABLE IF EXISTS `tbl_currency`;
CREATE TABLE IF NOT EXISTS `tbl_currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cur_abbreviation` varchar(50) NOT NULL,
  `cur_description` varchar(120) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_currency`
--

INSERT INTO `tbl_currency` (`id`, `cur_abbreviation`, `cur_description`) VALUES
(1, 'MK', 'Malawi Kwacha'),
(2, 'USD', 'United States dollar');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_general_settings`
--

DROP TABLE IF EXISTS `tbl_general_settings`;
CREATE TABLE IF NOT EXISTS `tbl_general_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `preferred_currency` int(11) NOT NULL,
  `delivery_time` int(11) NOT NULL,
  `lead_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_general_settings`
--

INSERT INTO `tbl_general_settings` (`id`, `preferred_currency`, `delivery_time`, `lead_time`) VALUES
(1, 1, 14, 14);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_items`
--

DROP TABLE IF EXISTS `tbl_items`;
CREATE TABLE IF NOT EXISTS `tbl_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(150) NOT NULL,
  `variant_code` varchar(150) NOT NULL,
  `category` int(11) NOT NULL DEFAULT '0',
  `item_materials` varchar(150) NOT NULL,
  `item_operations` varchar(150) NOT NULL,
  `item_resources` varchar(150) NOT NULL,
  `default_sales_price` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_items`
--

INSERT INTO `tbl_items` (`id`, `item_name`, `variant_code`, `category`, `item_materials`, `item_operations`, `item_resources`, `default_sales_price`, `date_created`) VALUES
(1, 'Coffe Table', 'CF-T', 3, 'a:2:{i:0;s:1:\"2\";i:1;s:1:\"3\";}', 'a:3:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";}', 'a:1:{i:0;s:1:\"1\";}', 10000, '2021-06-16 11:26:31'),
(2, 'TV Stand', 'TV-S', 3, 'a:3:{i:0;s:1:\"1\";i:1;s:1:\"3\";i:2;s:1:\"4\";}', 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"3\";}', 'a:1:{i:0;s:1:\"2\";}', 20000, '2021-06-16 11:31:46'),
(3, 'L-shape sofa set', 'L-SF', 3, 'a:2:{i:0;s:1:\"3\";i:1;s:1:\"4\";}', 'a:3:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";}', 'a:1:{i:0;s:1:\"1\";}', 50000, '2021-06-16 15:30:45');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_materials`
--

DROP TABLE IF EXISTS `tbl_materials`;
CREATE TABLE IF NOT EXISTS `tbl_materials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `material_name` varchar(150) NOT NULL,
  `material_code` varchar(150) NOT NULL,
  `category` int(11) NOT NULL,
  `in_stock` int(10) NOT NULL,
  `default_supplier` int(11) NOT NULL,
  `purchase_price` float NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_materials`
--

INSERT INTO `tbl_materials` (`id`, `material_name`, `material_code`, `category`, `in_stock`, `default_supplier`, `purchase_price`, `date_created`) VALUES
(1, 'Paint(black)', 'P-BL', 1, 2, 1, 500, '2021-06-02 08:31:39'),
(2, 'Paint(brown)', 'P-BR', 1, 20, 1, 350, '2021-06-02 08:31:39'),
(3, 'wood', 'WD', 1, 6, 2, 400, '2021-06-02 08:33:14'),
(4, 'Drawer Knobs', 'D-KN', 3, 7, 2, 600, '2021-06-02 09:39:51'),
(5, 'paint(red)', 'P_RD', 1, 3, 1, 400, '2021-06-02 09:46:38');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_operations`
--

DROP TABLE IF EXISTS `tbl_operations`;
CREATE TABLE IF NOT EXISTS `tbl_operations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `operation_description` varchar(150) NOT NULL,
  `time_taken` int(10) NOT NULL,
  `operation_time_unit` varchar(150) NOT NULL DEFAULT 'hrs',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_operations`
--

INSERT INTO `tbl_operations` (`id`, `operation_description`, `time_taken`, `operation_time_unit`) VALUES
(1, 'cutting', 2, 'hrs'),
(2, 'gluing', 1, 'hrs'),
(3, 'assembly', 2, 'hrs');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_resources`
--

DROP TABLE IF EXISTS `tbl_resources`;
CREATE TABLE IF NOT EXISTS `tbl_resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_description` varchar(150) NOT NULL,
  `resource_amount_per_hour` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_resources`
--

INSERT INTO `tbl_resources` (`id`, `resource_description`, `resource_amount_per_hour`) VALUES
(1, 'John', 1500),
(2, 'IT Department', 3000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sales_orders`
--

DROP TABLE IF EXISTS `tbl_sales_orders`;
CREATE TABLE IF NOT EXISTS `tbl_sales_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_number` varchar(150) NOT NULL,
  `item` int(11) NOT NULL,
  `order_quantity` int(10) NOT NULL,
  `customer_name` varchar(150) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `delivery_deadline` varchar(150) NOT NULL,
  `order_status` int(11) NOT NULL DEFAULT '0',
  `make_status` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_sales_orders`
--

INSERT INTO `tbl_sales_orders` (`id`, `order_number`, `item`, `order_quantity`, `customer_name`, `total_amount`, `delivery_deadline`, `order_status`, `make_status`) VALUES
(1, 'J-001', 2, 2, 'James Banda', 40000, '2021-06-23', 1, 0),
(2, 'JC-2001', 3, 1, 'Jackson Banda', 50000, '2021-06-24', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stock`
--

DROP TABLE IF EXISTS `tbl_stock`;
CREATE TABLE IF NOT EXISTS `tbl_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` int(11) NOT NULL,
  `item_category` int(11) NOT NULL,
  `item_supplier` int(11) NOT NULL,
  `in_stock` int(11) NOT NULL,
  `expected_items` int(10) NOT NULL DEFAULT '0',
  `expected_date` date DEFAULT NULL,
  `committed` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `item_name` (`item_name`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_stock`
--

INSERT INTO `tbl_stock` (`id`, `item_name`, `item_category`, `item_supplier`, `in_stock`, `expected_items`, `expected_date`, `committed`) VALUES
(1, 1, 3, 1, 3, 0, '2021-06-13', 3),
(2, 2, 3, 1, 4, 0, '2021-06-15', 1),
(3, 3, 3, 1, 0, 0, NULL, 2),
(4, 4, 3, 1, 2, 0, NULL, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stock_material`
--

DROP TABLE IF EXISTS `tbl_stock_material`;
CREATE TABLE IF NOT EXISTS `tbl_stock_material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `material_name` int(11) NOT NULL,
  `material_category` int(11) NOT NULL,
  `material_supplier` int(11) NOT NULL,
  `in_stock` int(11) NOT NULL,
  `m_expected_items` int(10) NOT NULL,
  `m_expected_date` date DEFAULT NULL,
  `committed` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `item_name` (`material_name`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_stock_material`
--

INSERT INTO `tbl_stock_material` (`id`, `material_name`, `material_category`, `material_supplier`, `in_stock`, `m_expected_items`, `m_expected_date`, `committed`) VALUES
(1, 1, 1, 1, 3, 0, NULL, 4),
(2, 2, 1, 1, 4, 0, NULL, 5),
(3, 3, 1, 2, 0, 0, '2021-06-17', 2),
(4, 4, 3, 2, 0, 0, '2021-06-23', 8),
(5, 5, 1, 1, 10, 0, NULL, 12);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_suppliers`
--

DROP TABLE IF EXISTS `tbl_suppliers`;
CREATE TABLE IF NOT EXISTS `tbl_suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_suppliers`
--

INSERT INTO `tbl_suppliers` (`id`, `supplier_name`) VALUES
(1, 'Airspace'),
(2, 'AtoZ furnitures'),
(3, 'trusted suppliers group');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tax_rates`
--

DROP TABLE IF EXISTS `tbl_tax_rates`;
CREATE TABLE IF NOT EXISTS `tbl_tax_rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_rate` varchar(100) NOT NULL,
  `tax_description` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_tax_rates`
--

INSERT INTO `tbl_tax_rates` (`id`, `tax_rate`, `tax_description`) VALUES
(1, '20%', 'VAT');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_unit_of_measure`
--

DROP TABLE IF EXISTS `tbl_unit_of_measure`;
CREATE TABLE IF NOT EXISTS `tbl_unit_of_measure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit` varchar(50) NOT NULL,
  `unit_description` varchar(140) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_unit_of_measure`
--

INSERT INTO `tbl_unit_of_measure` (`id`, `unit`, `unit_description`) VALUES
(1, 'kg', 'kilogram'),
(2, 'cm', 'centimeter');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(150) NOT NULL,
  `user_name` varchar(120) NOT NULL,
  `user_password` varchar(250) NOT NULL,
  `email` varchar(120) NOT NULL,
  `role` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  KEY `role` (`role`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `user_name`, `user_password`, `email`, `role`, `date_created`) VALUES
(1, 'James Spader', 'James', 'b4cc344d25a2efe540adbf2678e2304c', 'james@gmail.com', 1, '2021-05-25 14:14:29'),
(2, 'Peter Banda', 'Peter', '51dc30ddc473d43a6011e9ebba6ca770', 'peter@gmail.com', 2, '2021-05-25 14:16:27'),
(3, 'Maxwel Banda', 'Maxwel', '03a05087682fd6aca81fea62b8dc5c61', 'maxwel@gmail.com', 1, '2021-06-01 15:49:43');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE IF NOT EXISTS `user_roles` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_role` varchar(120) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`user_id`, `user_role`, `date_created`) VALUES
(1, 'admin', '2021-05-13 14:16:02'),
(2, 'warehouse manager', '2021-05-13 14:16:02');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
