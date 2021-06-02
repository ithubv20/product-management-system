-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 02, 2021 at 04:05 PM
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
  `default_sales_price` int(11) NOT NULL,
  `cost` float NOT NULL,
  `prod_time` varchar(150) NOT NULL,
  `category` int(11) NOT NULL DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_items`
--

INSERT INTO `tbl_items` (`id`, `item_name`, `variant_code`, `default_sales_price`, `cost`, `prod_time`, `category`, `date_created`) VALUES
(1, 'Coffee Table', 'CT-CO', 50000, 30000, '9hr', 3, '2021-06-02 07:34:42'),
(2, 'Dinning Table', 'DN-TB', 40000, 20000, '20hr', 3, '2021-06-02 07:34:42'),
(3, 'Drawers', 'DR', 3000, 1850, '2hr', 3, '2021-06-02 13:00:31'),
(4, 'L-shape sofa set', 'L-SF', 200000, 41000, '30hr', 3, '2021-06-02 13:09:28');

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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_operations`
--

INSERT INTO `tbl_operations` (`id`, `operation_description`) VALUES
(1, 'Cutting '),
(2, 'Gluing'),
(3, 'Assembly');

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
(1, 'John', 10000),
(2, 'IT Department', 100000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sales_orders`
--

DROP TABLE IF EXISTS `tbl_sales_orders`;
CREATE TABLE IF NOT EXISTS `tbl_sales_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_number` varchar(150) NOT NULL,
  `customer_name` varchar(150) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `delivery_deadline` varchar(150) NOT NULL,
  `sales_item` int(11) NOT NULL,
  `ingredients` int(11) NOT NULL,
  `production` int(11) NOT NULL,
  `delivery_status` int(11) NOT NULL,
  `date_ordered` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stock`
--

DROP TABLE IF EXISTS `tbl_stock`;
CREATE TABLE IF NOT EXISTS `tbl_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` int(11) NOT NULL,
  `stock_value` int(11) NOT NULL,
  `in_stock` int(11) NOT NULL,
  `expected` int(11) NOT NULL,
  `committed` int(11) NOT NULL,
  `missing` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
