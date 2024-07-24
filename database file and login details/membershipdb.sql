-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2024 at 09:49 AM
-- Server version: 5.6.21
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `membershipdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
`id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `postcode` varchar(20) NOT NULL,
  `occupation` varchar(255) NOT NULL,
  `membership_type` int(11) NOT NULL,
  `membership_number` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `photo` varchar(255) NOT NULL,
  `expiry_date` date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `fullname`, `dob`, `gender`, `contact_number`, `email`, `address`, `country`, `postcode`, `occupation`, `membership_type`, `membership_number`, `created_at`, `photo`, `expiry_date`) VALUES
(1, 'Vivian G. Delaney', '1995-11-10', 'Male', '609-560-2400', 'VivianGDelaney@teleworm.us', '1367 Moonlight Drive
Camden', 'USA', '4545', 'Staff assistant', 2, 'CA-923020', '2024-02-02 04:10:30', 'default.png', '2024-05-04'),
(4, 'Kim W. Keeling', '1990-12-12', 'Female', '765-884-1298', 'KimWKeeling@rhyta.com', '3687 Davisson Street
Fowler', 'USA', '4545', 'Aerospace engineer', 3, 'CA-610243', '2024-02-04 03:40:16', 'default.png', '2024-05-04'),
(5, 'Henriette Frappier', '1990-12-12', 'Female', '01.84.87.01.33', 'HenrietteFrappier@dayrep.com', '27, rue Marguerite
91170', 'Franch', '95880', 'Government accountant', 3, 'CA-373031', '2024-02-04 12:23:22', 'default.png', '2024-08-04');

-- --------------------------------------------------------

--
-- Table structure for table `membership_types`
--

CREATE TABLE IF NOT EXISTS `membership_types` (
`id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `membership_types`
--

INSERT INTO `membership_types` (`id`, `type`, `amount`) VALUES
(1, 'Basic', 8),
(2, 'Standard', 13),
(3, 'Gold', 19),
(4, 'Silver', 15),
(10, 'Premium', 28);

-- --------------------------------------------------------

--
-- Table structure for table `renew`
--

CREATE TABLE IF NOT EXISTS `renew` (
`id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `renew_date` date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `renew`
--

INSERT INTO `renew` (`id`, `member_id`, `total_amount`, `renew_date`) VALUES
(1, 1, '39.00', '2024-02-04'),
(16, 4, '57.00', '2024-02-04'),
(18, 5, '114.00', '2024-02-04');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
`id` int(11) NOT NULL,
  `system_name` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `currency` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `system_name`, `logo`, `currency`) VALUES
(1, 'MMS', 'uploads/logo.png', '$');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT 'uploads\users_photos\default.png',
  `registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `email`, `password`, `registration_date`, `updated_date`) VALUES
(1, 'admin', 'admin@mail.com', '21232f297a57a5a743894a0e4a801fc3', '2024-02-02 01:34:26', '2024-02-05 08:49:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `members`
--
ALTER TABLE `members`
 ADD PRIMARY KEY (`id`), ADD KEY `membership_type` (`membership_type`);

--
-- Indexes for table `membership_types`
--
ALTER TABLE `membership_types`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `renew`
--
ALTER TABLE `renew`
 ADD PRIMARY KEY (`id`), ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `membership_types`
--
ALTER TABLE `membership_types`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `renew`
--
ALTER TABLE `renew`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `members`
--
ALTER TABLE `members`
ADD CONSTRAINT `members_ibfk_1` FOREIGN KEY (`membership_type`) REFERENCES `membership_types` (`id`);

--
-- Constraints for table `renew`
--
ALTER TABLE `renew`
ADD CONSTRAINT `renew_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
