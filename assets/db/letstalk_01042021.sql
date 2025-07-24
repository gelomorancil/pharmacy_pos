-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 04, 2021 at 04:53 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `letstalk`
--

-- --------------------------------------------------------

--
-- Table structure for table `barangay`
--

CREATE TABLE `barangay` (
  `ID` int(11) NOT NULL,
  `name` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `city_municipality`
--

CREATE TABLE `city_municipality` (
  `ID` int(11) NOT NULL,
  `name` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `company_profile`
--

CREATE TABLE `company_profile` (
  `ID` int(11) NOT NULL,
  `company_name` varchar(225) DEFAULT NULL,
  `company_owner` varchar(225) DEFAULT NULL,
  `company_contact_no` varchar(225) DEFAULT NULL,
  `company_email` varchar(225) DEFAULT NULL,
  `company_blk_door` varchar(225) DEFAULT NULL,
  `company_street` varchar(225) DEFAULT NULL,
  `barangay_id` int(11) DEFAULT NULL,
  `city_municipality_id` int(11) DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `ID` int(11) NOT NULL,
  `name` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`ID`, `name`) VALUES
(1, 'Let\'s talk online tutor service'),
(2, 'Let\'s talk information Technology Solutions');

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

CREATE TABLE `designation` (
  `ID` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `job description` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `designation`
--

INSERT INTO `designation` (`ID`, `name`, `job description`) VALUES
(1, 'admin', NULL),
(2, 'employee', NULL),
(3, 'accounting', NULL),
(4, 'guard', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orderhead`
--

CREATE TABLE `orderhead` (
  `ID` int(11) NOT NULL,
  `order_no` int(11) DEFAULT NULL,
  `user_account_id` int(11) DEFAULT NULL,
  `is_order_cancelled` tinyint(1) DEFAULT NULL,
  `is_food_reserved` tinyint(1) DEFAULT 0,
  `food_pickup` datetime DEFAULT NULL,
  `datetime_created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orderline`
--

CREATE TABLE `orderline` (
  `ID` int(11) NOT NULL,
  `order_no` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_unit` int(11) DEFAULT NULL,
  `product_category_id` int(11) DEFAULT NULL,
  `product_price` double DEFAULT NULL,
  `total_amount` double DEFAULT NULL,
  `datetime_created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ID` int(11) NOT NULL,
  `product_name` varchar(225) DEFAULT NULL,
  `product_unit` int(11) DEFAULT NULL,
  `product_category` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `totat_stock` varchar(225) DEFAULT NULL,
  `datetime_created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `ID` int(11) NOT NULL,
  `product_category_name` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_unit`
--

CREATE TABLE `product_unit` (
  `ID` int(11) NOT NULL,
  `unit_name` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

CREATE TABLE `province` (
  `ID` int(11) NOT NULL,
  `name` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `ID` int(11) NOT NULL,
  `Product_id` int(11) DEFAULT NULL,
  `Qty` int(11) DEFAULT NULL,
  `supplier_price` double DEFAULT NULL,
  `date_purchase` date DEFAULT NULL,
  `datetime_created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `time_sheet`
--

CREATE TABLE `time_sheet` (
  `ID` int(11) NOT NULL,
  `user_account_id` int(11) DEFAULT NULL,
  `datetime_record` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `ID` int(11) NOT NULL,
  `auth_token` varchar(225) DEFAULT NULL,
  `employee_no` varchar(225) NOT NULL,
  `username` varchar(225) DEFAULT NULL,
  `password` varchar(225) DEFAULT NULL,
  `first_name` varchar(225) DEFAULT NULL,
  `middle_name` varchar(225) DEFAULT NULL,
  `last_name` varchar(225) DEFAULT NULL,
  `gender` varchar(225) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `contact_number` varchar(225) DEFAULT NULL,
  `contact_person` varchar(225) DEFAULT NULL,
  `security_pin` int(4) DEFAULT NULL,
  `blk_door` varchar(225) DEFAULT NULL,
  `street` varchar(225) DEFAULT NULL,
  `barangay_id` int(11) DEFAULT NULL,
  `city_municipality_id` int(11) DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  `company_profile_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `designation_id` int(11) DEFAULT NULL,
  `disable` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_permission`
--

CREATE TABLE `user_permission` (
  `ID` int(11) NOT NULL,
  `user_account_id` int(11) DEFAULT NULL,
  `user_permission_name` varchar(225) DEFAULT NULL,
  `user_permission_description` varchar(225) DEFAULT NULL,
  `allow_add` tinyint(1) DEFAULT NULL,
  `allow_edit` tinyint(1) DEFAULT NULL,
  `allow_delete` tinyint(1) DEFAULT NULL,
  `allow_print` tinyint(1) DEFAULT NULL,
  `allow_export` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barangay`
--
ALTER TABLE `barangay`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `city_municipality`
--
ALTER TABLE `city_municipality`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `company_profile`
--
ALTER TABLE `company_profile`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `designation`
--
ALTER TABLE `designation`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `orderhead`
--
ALTER TABLE `orderhead`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `orderline`
--
ALTER TABLE `orderline`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `product_unit`
--
ALTER TABLE `product_unit`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `time_sheet`
--
ALTER TABLE `time_sheet`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_account_id` (`user_account_id`);

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `designation_id` (`designation_id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `province_id` (`province_id`),
  ADD KEY `company_profile_id` (`company_profile_id`),
  ADD KEY `city_municipality_id` (`city_municipality_id`),
  ADD KEY `barangay_id` (`barangay_id`);

--
-- Indexes for table `user_permission`
--
ALTER TABLE `user_permission`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_account_id` (`user_account_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barangay`
--
ALTER TABLE `barangay`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `city_municipality`
--
ALTER TABLE `city_municipality`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_profile`
--
ALTER TABLE `company_profile`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `designation`
--
ALTER TABLE `designation`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orderhead`
--
ALTER TABLE `orderhead`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orderline`
--
ALTER TABLE `orderline`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_unit`
--
ALTER TABLE `product_unit`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `province`
--
ALTER TABLE `province`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `time_sheet`
--
ALTER TABLE `time_sheet`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_account`
--
ALTER TABLE `user_account`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_permission`
--
ALTER TABLE `user_permission`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `time_sheet`
--
ALTER TABLE `time_sheet`
  ADD CONSTRAINT `time_sheet_ibfk_1` FOREIGN KEY (`user_account_id`) REFERENCES `user_account` (`ID`);

--
-- Constraints for table `user_account`
--
ALTER TABLE `user_account`
  ADD CONSTRAINT `user_account_ibfk_1` FOREIGN KEY (`province_id`) REFERENCES `province` (`ID`),
  ADD CONSTRAINT `user_account_ibfk_2` FOREIGN KEY (`city_municipality_id`) REFERENCES `city_municipality` (`ID`),
  ADD CONSTRAINT `user_account_ibfk_3` FOREIGN KEY (`department_id`) REFERENCES `department` (`ID`),
  ADD CONSTRAINT `user_account_ibfk_4` FOREIGN KEY (`barangay_id`) REFERENCES `barangay` (`ID`),
  ADD CONSTRAINT `user_account_ibfk_5` FOREIGN KEY (`company_profile_id`) REFERENCES `company_profile` (`ID`),
  ADD CONSTRAINT `user_account_ibfk_6` FOREIGN KEY (`designation_id`) REFERENCES `designation` (`ID`);

--
-- Constraints for table `user_permission`
--
ALTER TABLE `user_permission`
  ADD CONSTRAINT `user_permission_ibfk_1` FOREIGN KEY (`user_account_id`) REFERENCES `user_account` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
