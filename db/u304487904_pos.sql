-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 24, 2025 at 05:58 AM
-- Server version: 10.11.10-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u304487904_pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inventory`
--

CREATE TABLE `tbl_inventory` (
  `id` int(11) NOT NULL,
  `item_profile_id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `date_in` datetime DEFAULT NULL,
  `recieved_by` varchar(50) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_inventory`
--

INSERT INTO `tbl_inventory` (`id`, `item_profile_id`, `supplier_id`, `quantity`, `date_in`, `recieved_by`, `date_created`, `deleted`) VALUES
(1, 1, 1, 50, '2024-10-10 00:00:00', 'ACCOUNT, TEST', '2024-10-10 20:12:55', 0),
(2, 3, 1, 30, '2024-10-19 00:00:00', 'ACCOUNT, TEST', '2024-10-10 20:13:16', 0),
(3, 2, 2, 10, '2024-10-10 00:00:00', 'ACCOUNT, TEST', '2024-10-10 20:45:27', 0),
(4, 2, 2, 15, '2024-10-10 00:00:00', 'ACCOUNT, TEST', '2024-10-10 20:46:20', 0),
(5, 1, 1, 5, '2024-10-10 00:00:00', 'ACCOUNT, TEST', '2024-10-10 20:47:25', 0),
(6, 4, 2, 13, '2024-10-10 00:00:00', 'ACCOUNT, TEST', '2024-10-10 21:03:29', 0),
(7, 4, 2, 6, '2024-10-10 00:00:00', 'ACCOUNT, TEST', '2024-10-10 21:04:06', 0),
(8, 4, 1, 3, '2024-10-10 00:00:00', 'ACCOUNT, TEST', '2024-10-10 21:04:25', 0),
(9, 3, 2, 4, '2024-10-10 00:00:00', 'ACCOUNT, TEST', '2024-10-10 21:04:39', 0),
(10, 1, 1, 4, '2024-10-10 00:00:00', 'ACCOUNT, TEST', '2024-10-10 21:05:00', 0),
(11, 4, 2, 13, '2024-10-10 00:00:00', 'ACCOUNT, TEST', '2024-10-10 21:53:35', 0),
(12, 4, 2, 2, '2024-10-10 00:00:00', 'ACCOUNT, TEST', '2024-10-10 21:53:45', 0),
(13, 1, 1, 5, '2024-10-10 00:00:00', 'ACCOUNT, TEST', '2024-10-10 22:00:08', 0),
(14, 1, 1, 12, '2024-10-14 00:00:00', 'ACCOUNT, TEST', '2024-10-14 21:56:19', 0),
(15, 1, 2, 12, '2024-10-14 00:00:00', 'ACCOUNT, TEST', '2024-10-14 21:56:42', 0),
(16, 1, 1, 1, '2024-10-14 00:00:00', 'ACCOUNT, TEST', '2024-10-14 22:12:33', 0),
(17, 1, 2, 2, '2024-10-14 00:00:00', 'ACCOUNT, TEST', '2024-10-14 22:17:24', 0),
(18, 1, 1, 20000, '2025-07-31 00:00:00', 'ACCOUNT, TEST', '2025-07-12 13:36:49', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_items`
--

CREATE TABLE `tbl_items` (
  `id` int(11) NOT NULL,
  `item_name` varchar(50) NOT NULL DEFAULT '0',
  `item_code` varchar(50) NOT NULL DEFAULT '0',
  `short_name` varchar(50) NOT NULL DEFAULT '0',
  `description` varchar(50) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_items`
--

INSERT INTO `tbl_items` (`id`, `item_name`, `item_code`, `short_name`, `description`, `active`) VALUES
(1, 'FIRST ITEM', '111', 'ITEM 1', 'FIRST ITEM 1 DESCRIPTION', 1),
(2, 'SECOND ITEM', '222', 'ITEM 2', 'SECOND ITEM 2 DESCRIPTION', 1),
(3, 'THIRD ITEM', '333', 'ITEM 3', 'THIRD ITEM DESCRIPTION', 1),
(4, 'FOURTH ITEM', '444', 'ITEM 4', 'FOURTH ITEM DESCRIPTION', 1),
(5, 'IN-ACTIVE ITEM', 'IAI1', 'IN-ACTIVE', 'IN-ACTIVE ITEM DESCRIPTION', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_item_profile`
--

CREATE TABLE `tbl_item_profile` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `unit_price` double DEFAULT NULL,
  `threshold` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_item_profile`
--

INSERT INTO `tbl_item_profile` (`id`, `item_id`, `unit_id`, `unit_price`, `threshold`) VALUES
(1, 1, 1, 350.75, 15),
(2, 2, 5, 50.45, 20),
(3, 3, 6, 8.15, 50),
(4, 4, 3, 15.25, 35);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_modules`
--

CREATE TABLE `tbl_modules` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_modules`
--

INSERT INTO `tbl_modules` (`ID`, `Name`) VALUES
(1, 'Dashboard'),
(2, 'Customer'),
(3, 'Create Order'),
(4, 'Management'),
(5, 'Payment');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment_child`
--

CREATE TABLE `tbl_payment_child` (
  `id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `item_profile_id` int(11) NOT NULL,
  `unit_price` double NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `discount` double NOT NULL DEFAULT 0,
  `total_price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_payment_child`
--

INSERT INTO `tbl_payment_child` (`id`, `payment_id`, `item_profile_id`, `unit_price`, `quantity`, `discount`, `total_price`) VALUES
(1, 1, 1, 350.75, 2, 50, 651.5),
(2, 1, 2, 50.45, 13, 0, 655.85),
(3, 1, 3, 8.15, 24, 0, 195.6),
(4, 2, 0, 8.15, 2, 0, 16.3),
(5, 2, 0, 50.45, 5, 0, 252.25),
(6, 3, 0, 8.15, 3, 0, 24.45),
(7, 4, 0, 350.75, 25, 0, 8768.75),
(8, 5, 1, 350.75, 13, 100, 4459.75),
(9, 6, 4, 15.25, 5, 0, 76.25),
(10, 7, 0, 50.45, 2, 0, 100.9),
(11, 7, 0, 15.25, 5, 0, 76.25),
(12, 8, 0, 8.15, 2, 0, 16.3),
(13, 8, 0, 350.75, 50, 0, 17537.5),
(14, 9, 1, 350.75, 1, 23, 327.75),
(15, 10, 0, 350.75, 2, 0, 701.5),
(16, 11, 1, 350.75, 1, 0, 350.75),
(17, 12, 0, 350.75, 2, 0, 701.5),
(18, 13, 0, 50.45, 2, 0, 100.9),
(19, 14, 1, 350.75, 2, 0, 701.5),
(20, 14, 4, 15.25, 1, 0, 15.25),
(21, 15, 1, 350.75, 100, 5000, 30075),
(22, 17, 1, 350.75, 4, 0, 1403),
(23, 18, 1, 350.75, 2, 0, 701.5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment_parent`
--

CREATE TABLE `tbl_payment_parent` (
  `id` int(11) NOT NULL,
  `sub_total` double NOT NULL,
  `discount_amount` double NOT NULL,
  `total_amount` double NOT NULL,
  `discount_type` varchar(50) DEFAULT NULL,
  `payment_type` varchar(50) NOT NULL,
  `amount_rendered` double NOT NULL,
  `reference_number` varchar(50) NOT NULL DEFAULT '',
  `control_number` varchar(50) NOT NULL DEFAULT '',
  `remarks` varchar(50) DEFAULT NULL,
  `recieved_by` varchar(50) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `voided` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_payment_parent`
--

INSERT INTO `tbl_payment_parent` (`id`, `sub_total`, `discount_amount`, `total_amount`, `discount_type`, `payment_type`, `amount_rendered`, `reference_number`, `control_number`, `remarks`, `recieved_by`, `date_created`, `voided`) VALUES
(1, 1552.95, 50, 1502.95, 'PWD', 'CASH', 1505, '', '000001', 'Yes', '26', '2024-10-19 15:29:30', 0),
(2, 268.55, 0, 268.55, 'NO DISCOUNT', 'CASH', 500, '', '000002', '', '26', '2024-10-21 01:44:38', 0),
(3, 24.45, 0, 24.45, 'NO DISCOUNT', 'ONLINE', 200, '231312', '000003', '', '26', '2024-10-21 01:46:16', 0),
(4, 8768.75, 0, 8768.75, 'NO DISCOUNT', 'CASH', 10000, '', '000004', '', '26', '2024-11-03 13:45:34', 1),
(5, 4559.75, 100, 4459.75, 'SENIOR', 'CASH', 4500, '', '000005', '', '26', '2024-11-04 13:17:03', 0),
(6, 76.25, 0, 76.25, 'NO DISCOUNT', 'CASH', 100, '', '000006', '', '26', '2024-11-04 13:17:31', 0),
(7, 177.15, 0, 177.15, 'SENIOR', 'CASH', 200, '', '000007', '', '26', '2024-11-05 05:23:48', 0),
(8, 17553.8, 0, 17553.8, 'NO DISCOUNT', 'CASH', 18000, '', '000008', 'sample remarks', '26', '2024-12-04 03:13:45', 0),
(9, 350.75, 23, 327.75, 'NO DISCOUNT', 'CASH', 500, '', '000009', '', '26', '2025-02-01 11:04:13', 0),
(10, 701.5, 0, 701.5, 'NO DISCOUNT', 'CASH', 1000, '', '000010', '', '26', '2025-02-01 11:04:50', 0),
(11, 350.75, 0, 350.75, 'NO DISCOUNT', 'CASH', 500, '', '000011', '', '26', '2025-02-02 10:52:00', 0),
(12, 701.5, 0, 701.5, 'NO DISCOUNT', 'CASH', 1000, '', '000012', '', '26', '2025-02-02 10:52:27', 0),
(13, 100.9, 0, 100.9, 'NO DISCOUNT', 'CASH', 600, '', '000013', '', '26', '2025-02-02 11:04:33', 0),
(14, 716.75, 0, 716.75, 'NO DISCOUNT', 'CASH', 1000, '', '000014', '', '26', '2025-02-04 13:35:03', 0),
(15, 35075, 5000, 30075, 'PWD', 'CASH', 117000, '', '000015', 'peimentel', '26', '2025-07-12 05:34:45', 0),
(16, 0, 0, 0, 'NO DISCOUNT', 'CASH', 10, '', '000016', '', '26', '2025-07-12 05:35:41', 0),
(17, 1403, 0, 1403, 'SENIOR', 'CASH', 1500, '', '000017', 'senior ni ha', '26', '2025-07-23 02:25:07', 0),
(18, 701.5, 0, 701.5, 'NO DISCOUNT', 'CASH', 1000, '', '000018', '', '26', '2025-07-23 02:33:22', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_proof`
--

CREATE TABLE `tbl_proof` (
  `id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL DEFAULT 0,
  `payment_proof` varchar(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_proof`
--

INSERT INTO `tbl_proof` (`id`, `payment_id`, `payment_proof`) VALUES
(1, 3, 'assets/uploaded/proofs/Acer_Wallpaper_01_3840x2400.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier`
--

CREATE TABLE `tbl_supplier` (
  `id` int(11) NOT NULL,
  `supplier_name` varchar(100) DEFAULT '0',
  `address` varchar(255) DEFAULT '0',
  `contact_number_1` varchar(50) DEFAULT '0',
  `contact_number_2` varchar(50) DEFAULT '0',
  `email` varchar(50) DEFAULT '0',
  `contact_person` varchar(50) DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_supplier`
--

INSERT INTO `tbl_supplier` (`id`, `supplier_name`, `address`, `contact_number_1`, `contact_number_2`, `email`, `contact_person`, `active`) VALUES
(1, 'SUPPLIER TEST 1', 'SUPPLIER TEST 1 ADDRESS', '123456789', '987654321', 'asdfas@sdfbsdfgb.com', 'SUPPLIER TEST 1 CONTACT PERSON', 1),
(2, 'SUPPLIER TEST 2', 'SUPPLIER TEST 2 ADDRESS', '987654321', '123456789', 'suppliertest2@gmail.com', 'SUPPLIER TEST 2 CONTACT PERSON', 1),
(3, 'IN-ACTIVE SUPPLIER TEST', 'IN-ACTIVE SUPPLIER TEST ADDRESS', '741852963', '369258147', 'asdfas@sdfbsdfgb.com', 'IN-ACTIVE SUPPLIER TEST CONTACT PERSON', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_unit`
--

CREATE TABLE `tbl_unit` (
  `id` int(11) NOT NULL,
  `unit_of_measure` varchar(50) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_unit`
--

INSERT INTO `tbl_unit` (`id`, `unit_of_measure`) VALUES
(1, 'kg'),
(3, 'cm'),
(5, 'yard'),
(6, 'mm'),
(8, 'mg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `ID` int(11) NOT NULL,
  `FName` varchar(255) NOT NULL,
  `LName` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Locker` varchar(255) NOT NULL,
  `U_ID` varchar(255) NOT NULL,
  `Role_ID` int(11) NOT NULL,
  `Role` varchar(255) NOT NULL,
  `Pass_change` int(11) NOT NULL,
  `Active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`ID`, `FName`, `LName`, `Username`, `Password`, `Locker`, `U_ID`, `Role_ID`, `Role`, `Pass_change`, `Active`) VALUES
(17, 'Super', 'Admin', 'superadmin', 'a91430953c0a1bcfb3f59af9c98e348db119fed6', '!it#tze()6QDZ<UGI#W$%<uo\\Cn1I@HRHbYx!1H<Si$6azws.@', '720910dacbdce4695a27a3cbbc85b5f9bd1975b8:bbf461b5e7223da33a1ae3433b2b1548fc8d7cf0:2a6da1c5e31c5da22a56070d310b10d0c79ce5d71', 1, 'Admin', 1, 1),
(26, 'TEST', 'ACCOUNT', 'testaccount', '86116ac1bc4642df1c6f23bc8717d52c431f6288', 'X3ia>Oiug9e^Jwl%1K&%LDhBwc58Y9KT<LL5)Buo^eAny0750m', '6d5374d115250056c92e8df44c6b3c2e46b7c938:29b226ba89b58bc8cb6f8c2b8b08cf23d538f61e:bd9fa30d9b09a20522b64c4d5e9c3eeb65605d901', 1, 'Admin', 1, 1),
(27, 'testing12345', 'testing123', 'testing123', '207fc077bf38c11c9122030d98dc014250e453a3', '^l10IG8wB0I^MDN1?M&vzOQn!lBUem2Zz<$EPpfr))h#x*a4T$', '0cc71f5fdbfa09aeac0795b6505bf2a36eea8f3b:5a7c6770ed23645a24e9e12a8829496691efbaaa:98361f657678842d9e0438ecbf1e8f40002198de1', 2, 'Cashier', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_role`
--

CREATE TABLE `tbl_user_role` (
  `id` int(11) NOT NULL,
  `user_role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_user_role`
--

INSERT INTO `tbl_user_role` (`id`, `user_role`) VALUES
(1, 'Admin'),
(2, 'Cashier'),
(3, 'Staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_inventory`
--
ALTER TABLE `tbl_inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_profile_id` (`item_profile_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `tbl_items`
--
ALTER TABLE `tbl_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_item_profile`
--
ALTER TABLE `tbl_item_profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unit_id` (`unit_id`,`item_id`) USING BTREE;

--
-- Indexes for table `tbl_modules`
--
ALTER TABLE `tbl_modules`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_payment_child`
--
ALTER TABLE `tbl_payment_child`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Foreign Key` (`payment_id`,`item_profile_id`) USING BTREE;

--
-- Indexes for table `tbl_payment_parent`
--
ALTER TABLE `tbl_payment_parent`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_proof`
--
ALTER TABLE `tbl_proof`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_id` (`payment_id`);

--
-- Indexes for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_unit`
--
ALTER TABLE `tbl_unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_user_role`
--
ALTER TABLE `tbl_user_role`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_inventory`
--
ALTER TABLE `tbl_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_items`
--
ALTER TABLE `tbl_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_item_profile`
--
ALTER TABLE `tbl_item_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_modules`
--
ALTER TABLE `tbl_modules`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_payment_child`
--
ALTER TABLE `tbl_payment_child`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbl_payment_parent`
--
ALTER TABLE `tbl_payment_parent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_proof`
--
ALTER TABLE `tbl_proof`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_unit`
--
ALTER TABLE `tbl_unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tbl_user_role`
--
ALTER TABLE `tbl_user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
