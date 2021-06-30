-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 30, 2021 at 12:28 AM
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
-- Table structure for table `tbl_buy_materials`
--

DROP TABLE IF EXISTS `tbl_buy_materials`;
CREATE TABLE IF NOT EXISTS `tbl_buy_materials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `material_id` int(11) NOT NULL,
  `buy_quantity` int(11) NOT NULL,
  `arrival_date` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_buy_materials`
--

INSERT INTO `tbl_buy_materials` (`id`, `material_id`, `buy_quantity`, `arrival_date`, `status`) VALUES
(1, 1, 45, '2021-07-04', 1),
(2, 1, 10, '2021-06-27', 0),
(3, 4, 4, '2021-07-11', 0),
(4, 3, 2, '2021-07-13', 1),
(5, 3, 3, '2021-07-13', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categories`
--

DROP TABLE IF EXISTS `tbl_categories`;
CREATE TABLE IF NOT EXISTS `tbl_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_description` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_categories`
--

INSERT INTO `tbl_categories` (`id`, `category_description`) VALUES
(1, 'Components'),
(2, 'Chairs'),
(3, 'Living room furniture'),
(6, 'Tables');

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
-- Table structure for table `tbl_customer`
--

DROP TABLE IF EXISTS `tbl_customer`;
CREATE TABLE IF NOT EXISTS `tbl_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cus_name` varchar(150) NOT NULL,
  `cus_email` varchar(255) NOT NULL,
  `phone_number` int(11) DEFAULT NULL,
  `admin_comment` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_customer`
--

INSERT INTO `tbl_customer` (`id`, `cus_name`, `cus_email`, `phone_number`, `admin_comment`, `date_created`) VALUES
(1, 'James spader', 'james@gmail.com', 998678876, 'a good customer', '2021-06-19 13:01:15');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_general_settings`
--

DROP TABLE IF EXISTS `tbl_general_settings`;
CREATE TABLE IF NOT EXISTS `tbl_general_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `preferred_currency` int(11) NOT NULL,
  `delivery_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_general_settings`
--

INSERT INTO `tbl_general_settings` (`id`, `preferred_currency`, `delivery_time`) VALUES
(1, 1, 14);

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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_items`
--

INSERT INTO `tbl_items` (`id`, `item_name`, `variant_code`, `category`, `item_materials`, `item_operations`, `item_resources`, `default_sales_price`, `date_created`) VALUES
(1, 'Coffe Table', 'CF-T', 3, 'a:2:{i:0;s:1:\"2\";i:1;s:1:\"3\";}', 'a:3:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";}', 'a:1:{i:0;s:1:\"1\";}', 10000, '2021-06-16 11:26:31'),
(2, 'TV Stand', 'TV-S', 3, 'a:3:{i:0;s:1:\"1\";i:1;s:1:\"3\";i:2;s:1:\"4\";}', 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"3\";}', 'a:1:{i:0;s:1:\"2\";}', 20000, '2021-06-16 11:31:46'),
(3, 'L-shape sofa set', 'L-SF', 3, 'a:2:{i:0;s:1:\"3\";i:1;s:1:\"4\";}', 'a:3:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";}', 'a:1:{i:0;s:1:\"1\";}', 50000, '2021-06-16 15:30:45'),
(4, 'Dinning Table Small', 'DT-S', 6, 'a:2:{i:0;s:1:\"2\";i:1;s:1:\"3\";}', 'a:3:{i:0;s:1:\"1\";i:1;s:1:\"3\";i:2;s:1:\"4\";}', 'a:1:{i:0;s:1:\"3\";}', 20000, '2021-06-29 13:33:42'),
(5, 'TV Stand small', 'TV-S', 3, 'a:3:{i:0;s:1:\"1\";i:1;s:1:\"3\";i:2;s:1:\"4\";}', 'a:3:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";}', 'a:1:{i:0;s:1:\"2\";}', 40000, '2021-06-29 16:21:47'),
(6, 'King Size Bed', 'KS-B', 1, 'a:3:{i:0;s:1:\"1\";i:1;s:1:\"3\";i:2;s:1:\"4\";}', 'a:4:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";i:3;s:1:\"4\";}', 'a:1:{i:0;s:1:\"3\";}', 100000, '2021-06-29 16:23:36'),
(7, 'King Size Bed', 'KS-B', 1, 'a:3:{i:0;s:1:\"1\";i:1;s:1:\"3\";i:2;s:1:\"4\";}', 'a:4:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";i:3;s:1:\"4\";}', 'a:1:{i:0;s:1:\"3\";}', 100000, '2021-06-29 16:23:56'),
(8, 'BIN', 'BN-1', 1, 'a:1:{i:0;s:1:\"3\";}', 'a:3:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";}', 'a:1:{i:0;s:1:\"3\";}', 50000, '2021-06-29 16:37:17'),
(9, 'Wide Drawers', 'WD-1', 3, 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"3\";}', 'a:3:{i:0;s:1:\"1\";i:1;s:1:\"3\";i:2;s:1:\"4\";}', 'a:1:{i:0;s:1:\"2\";}', 20000, '2021-06-29 16:39:48');

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
  `default_supplier` int(11) NOT NULL,
  `purchase_price` float NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_materials`
--

INSERT INTO `tbl_materials` (`id`, `material_name`, `material_code`, `category`, `default_supplier`, `purchase_price`, `date_created`) VALUES
(1, 'Paint(black)', 'P-BL', 1, 1, 500, '2021-06-02 08:31:39'),
(2, 'Paint(brown)', 'P-BR', 1, 1, 350, '2021-06-02 08:31:39'),
(3, 'wood', 'WD', 1, 2, 400, '2021-06-02 08:33:14'),
(4, 'Drawer Knobs', 'D-KN', 3, 2, 600, '2021-06-02 09:39:51'),
(5, 'paint(red)', 'P_RD', 1, 1, 400, '2021-06-02 09:46:38');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_operations`
--

DROP TABLE IF EXISTS `tbl_operations`;
CREATE TABLE IF NOT EXISTS `tbl_operations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `operation_description` varchar(150) NOT NULL,
  `time_taken` int(10) NOT NULL,
  `operation_time_unit` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_operations`
--

INSERT INTO `tbl_operations` (`id`, `operation_description`, `time_taken`, `operation_time_unit`) VALUES
(1, 'cutting', 2, 1),
(2, 'gluing', 1, 1),
(3, 'assembly', 2, 1),
(4, 'painting', 1, 1);

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_resources`
--

INSERT INTO `tbl_resources` (`id`, `resource_description`, `resource_amount_per_hour`) VALUES
(1, 'John', 1500),
(2, 'IT Department', 3000),
(3, 'James', 2000);

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
  `delivery_deadline` date DEFAULT NULL,
  `order_status` int(11) NOT NULL DEFAULT '0',
  `make_status` int(10) NOT NULL DEFAULT '0',
  `order_priority` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_sales_orders`
--

INSERT INTO `tbl_sales_orders` (`id`, `order_number`, `item`, `order_quantity`, `customer_name`, `total_amount`, `delivery_deadline`, `order_status`, `make_status`, `order_priority`) VALUES
(1, 'J-001', 2, 2, 'James Banda', 40000, '2021-06-28', 2, 3, 0),
(2, 'JC-2001', 3, 1, 'Jackson Banda', 50000, '2021-06-26', 2, 2, 0),
(4, 'LN-001', 2, 2, 'Lines Phiri', 40000, '2021-06-28', 2, 3, 0),
(5, 'S-001', 1, 2, 'Saul Gama', 20000, '2021-07-11', 2, 2, 0),
(6, 'J-001', 1, 1, 'Joyce Banda', 10000, '2021-07-01', 1, 0, 0),
(7, 'IP-001', 2, 1, 'Ines Phiri', 20000, '2021-07-11', 2, 0, 0),
(8, 'SG-001', 4, 2, 'Saul Gama', 8000, '2021-07-11', 1, 0, 0),
(9, 'BN_001', 8, 1, 'Jackson Banda', 5000, '2021-07-11', 2, 0, 0),
(10, 'BN_001', 8, 1, 'James spader', 5000, '2021-07-11', 2, 2, 0),
(11, 'JC-2001', 8, 1, 'James spader', 5000, '2021-06-30', 2, 3, 0),
(12, 'PMS-984617907', 7, 1, 'James spader', 100000, '2021-07-11', 0, 0, 0),
(13, 'PMS-252850060', 3, 1, 'Lines Phiri', 50000, '2021-07-11', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stock`
--

DROP TABLE IF EXISTS `tbl_stock`;
CREATE TABLE IF NOT EXISTS `tbl_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` int(11) NOT NULL,
  `item_category` int(11) NOT NULL,
  `in_stock` int(11) NOT NULL,
  `expected_items` int(10) NOT NULL DEFAULT '0',
  `expected_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_name` (`item_name`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_stock`
--

INSERT INTO `tbl_stock` (`id`, `item_name`, `item_category`, `in_stock`, `expected_items`, `expected_date`) VALUES
(1, 1, 3, 6, 0, '2021-06-13'),
(2, 2, 3, 0, 0, '2021-06-15'),
(3, 3, 3, 0, 0, NULL),
(5, 8, 1, 7, 0, NULL),
(6, 9, 3, 3, 0, NULL);

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
  `m_expected_date` varchar(150) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `item_name` (`material_name`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_stock_material`
--

INSERT INTO `tbl_stock_material` (`id`, `material_name`, `material_category`, `material_supplier`, `in_stock`, `m_expected_items`, `m_expected_date`) VALUES
(1, 1, 1, 1, 1, 0, '0'),
(2, 2, 1, 1, 2, 0, '0'),
(3, 3, 1, 2, 4, 0, '0'),
(4, 4, 3, 2, 3, 0, '0'),
(5, 5, 1, 1, 10, 0, '0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_suppliers`
--

DROP TABLE IF EXISTS `tbl_suppliers`;
CREATE TABLE IF NOT EXISTS `tbl_suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(150) NOT NULL,
  `supplier_phone` int(11) DEFAULT NULL,
  `supplier_email` varchar(255) DEFAULT NULL,
  `admin_comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_suppliers`
--

INSERT INTO `tbl_suppliers` (`id`, `supplier_name`, `supplier_phone`, `supplier_email`, `admin_comment`) VALUES
(1, 'Airspace', NULL, 'airspace@gmail.com', 'late delivery'),
(2, 'AtoZ furnitures', NULL, 'atoz@yahoo.com', 'supply in time'),
(4, 'jack banda', NULL, 'jack@gmail.com', 'a good supplier');

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_tax_rates`
--

INSERT INTO `tbl_tax_rates` (`id`, `tax_rate`, `tax_description`) VALUES
(1, '20', 'VAT');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_time_descriptors`
--

DROP TABLE IF EXISTS `tbl_time_descriptors`;
CREATE TABLE IF NOT EXISTS `tbl_time_descriptors` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `time_descriptor` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_time_descriptors`
--

INSERT INTO `tbl_time_descriptors` (`id`, `time_descriptor`) VALUES
(1, 'hrs'),
(2, 'min'),
(3, 'sec');

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_unit_of_measure`
--

INSERT INTO `tbl_unit_of_measure` (`id`, `unit`, `unit_description`) VALUES
(1, 'kg', 'kilogram'),
(3, 'cm', 'centimeter');

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
  `user_status` int(11) NOT NULL DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  KEY `role` (`role`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `user_name`, `user_password`, `email`, `role`, `user_status`, `date_created`) VALUES
(1, 'James Spader', 'James', 'b4cc344d25a2efe540adbf2678e2304c', 'james@gmail.com', 1, 0, '2021-05-25 14:14:29'),
(2, 'Peter Banda', 'Peter', '51dc30ddc473d43a6011e9ebba6ca770', 'peter@gmail.com', 1, 1, '2021-05-25 14:16:27'),
(3, 'Maxwel Banda', 'Maxwel', '03a05087682fd6aca81fea62b8dc5c61', 'maxwel@gmail.com', 1, 0, '2021-06-01 15:49:43'),
(4, 'Edward Phiri', 'Edward', 'a53f3929621dba1306f8a61588f52f55', 'edward@gmail.com', 2, 0, '2021-06-28 18:51:14');

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
