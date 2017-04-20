-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 19, 2017 at 10:23 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `product`
--

-- --------------------------------------------------------

--
-- Table structure for table `Product`
--

CREATE TABLE `Product` (
  `Category_ID` varchar(25) NOT NULL,
  `product_Id` varchar(25) NOT NULL,
  `product_Count` int(25) NOT NULL,
  `product_Desc` varchar(100) NOT NULL,
  `product_Name` varchar(50) NOT NULL,
  `product_Price` double NOT NULL,
  `product_Image` varchar(50) NOT NULL,
  `product_Band` varchar(30) NOT NULL,
  `is_Active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Product`
--

INSERT INTO `Product` (`Category_ID`, `product_Id`, `product_Count`, `product_Desc`, `product_Name`, `product_Price`, `product_Image`, `product_Band`, `is_Active`) VALUES
('cat_12', 'pro_1', 5, 'hp series 1220', 'hp laptop', 25000, 'http://api.pro-z.in/uploads/1492619676.png', 'hp', 0),
('cat_12', 'pro_1', 5, 'hp series 1220', 'hp laptop', 25000, 'http://api.pro-z.in/uploads/1492620433.png', 'hp', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Product`
--
ALTER TABLE `Product`
  ADD KEY `Category_ID` (`Category_ID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Product`
--
ALTER TABLE `Product`
  ADD CONSTRAINT `Product_ibfk_1` FOREIGN KEY (`Category_ID`) REFERENCES `category_list` (`category_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
