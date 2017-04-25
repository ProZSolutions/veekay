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
-- Table structure for table `Customer`
--

CREATE TABLE `Customer` (
  `cust_ID` varchar(25) NOT NULL,
  `cust_Name` varchar(25) NOT NULL,
  `cust_Door_No` varchar(25) NOT NULL,
  `cust_Street_Name` varchar(25) NOT NULL,
  `cust_town` varchar(25) NOT NULL,
  `cust_country` varchar(25) NOT NULL,
  `cust_postcode` varchar(25) NOT NULL,
  `cust_band` varchar(25) NOT NULL,
  `cust_img` varchar(100) NOT NULL,
  `cust_mail` varchar(25) NOT NULL,
  `cust_no` varchar(25) NOT NULL,
  `cust_AltNo` varchar(25) NOT NULL,
  `is_Active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Customer`
--

INSERT INTO `Customer` (`cust_ID`, `cust_Name`, `cust_Door_No`, `cust_Street_Name`, `cust_town`, `cust_country`, `cust_postcode`, `cust_band`, `cust_img`, `cust_mail`, `cust_no`, `cust_AltNo`, `is_Active`) VALUES
('cust_4', 'demo_persons', '345/11A', 'Nehru street', 'namakkal', 'india', '635980', 'gold', '', 'demo@gmail.com', '0865321470', '123456789', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Customer`
--
ALTER TABLE `Customer`
  ADD PRIMARY KEY (`cust_ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
