-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 01, 2015 at 03:35 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cvd`
--

-- --------------------------------------------------------

--
-- Table structure for table `Doctors`
--

CREATE TABLE IF NOT EXISTS `Doctors` (
`id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Doctors`
--

INSERT INTO `Doctors` (`id`, `username`, `password`, `firstname`, `lastname`) VALUES
(1, 'doctor', '123', 'Pushpa', 'Kumarapeli');

-- --------------------------------------------------------

--
-- Table structure for table `Health`
--

CREATE TABLE IF NOT EXISTS `Health` (
`id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `gender` varchar(45) DEFAULT NULL,
  `age` int(5) DEFAULT NULL,
  `ldl_c` double(11,2) DEFAULT NULL,
  `cholesterol` double(11,2) DEFAULT NULL,
  `hdl_c` double(11,2) DEFAULT NULL,
  `bp` varchar(100) DEFAULT NULL,
  `diabetes` tinyint(1) DEFAULT NULL,
  `smoker` tinyint(1) DEFAULT NULL,
  `total_point` int(11) DEFAULT NULL,
  `rec` text,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Health`
--

INSERT INTO `Health` (`id`, `patient_id`, `gender`, `age`, `ldl_c`, `cholesterol`, `hdl_c`, `bp`, `diabetes`, `smoker`, `total_point`, `rec`, `date`) VALUES
(1, 1, 'Male', 54, 190.00, 280.00, 60.00, '160/100', 1, 1, 11, NULL, '2015-01-20 18:49:20'),
(2, 1, 'Male', 54, 190.00, 280.00, 38.00, '160/100', 1, 1, 14, 'Not good at all! You need to exercise regularly and eat healthy otherwise youre gonna die soon.', '2015-01-21 02:00:48'),
(3, 1, 'Male', 54, 105.00, 168.00, 60.00, '147/100', 0, 1, 0, NULL, '2015-01-20 22:04:27'),
(4, 1, 'Male', 54, 162.00, 206.00, 49.00, '160/100', 1, 1, 9, NULL, '2015-01-20 22:05:49'),
(5, 1, 'Male', 54, 100.00, 175.00, 46.00, '120/80', 0, 1, 2, NULL, '2015-01-20 22:20:10'),
(6, 1, 'Male', 54, 157.00, 220.00, 35.00, '120/80', 0, 0, 1, 'Do more exercise do  you even lift bro?', '2015-01-22 16:25:49'),
(7, 1, 'Male', 54, 107.00, 165.00, 40.00, '122/80', 0, 1, 3, 'whatever', '2015-01-27 11:13:23'),
(8, 1, 'Male', 54, 105.00, 162.00, 36.00, '120/81', 1, 1, 5, NULL, '2015-01-27 11:33:51'),
(9, 1, 'Male', 54, 80.00, 150.00, 64.00, '100/75', 0, 0, -8, 'Very good. You''re the healthiest patient I''ve had so far!', '2015-02-17 13:47:56'),
(10, 3, 'Male', 22, 80.00, 150.00, 65.00, '100/70', 0, 0, -8, NULL, '2015-02-17 12:24:37'),
(11, 2, 'Female', 25, 140.00, 173.00, 58.00, '120/110', 0, 1, 2, 'Good', '2015-02-17 12:40:47');

-- --------------------------------------------------------

--
-- Table structure for table `Patients`
--

CREATE TABLE IF NOT EXISTS `Patients` (
`id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  `gender` varchar(10) NOT NULL,
  `dob` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Patients`
--

INSERT INTO `Patients` (`id`, `doctor_id`, `username`, `password`, `firstname`, `lastname`, `gender`, `dob`, `email`, `token`) VALUES
(1, 1, 'amir', '123', 'Amir', 'Azimi', 'Male', 1961, 'persian.loyal@yahoo.com', NULL),
(2, 1, 'zeeshan', '123', 'Zeeshan', 'Minhas', 'Female', 1990, 'persian.loyal@yahoo.com', NULL),
(3, 1, 'lennard', '123', 'Lennard', 'Graham', 'Male', 1993, 'persian.loyal@yahoo.com', NULL),
(4, 1, 'ali', '123', 'Ali', 'Shaikh', 'Male', 1990, 'persian.loyal@yahoo.com', NULL),
(5, 1, 'hamza', '123', 'Hamza', 'Ashraf', 'Male', 1990, 'persian.loyal@yahoo.com', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Doctors`
--
ALTER TABLE `Doctors`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username_UNIQUE` (`username`);

--
-- Indexes for table `Health`
--
ALTER TABLE `Health`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_Female_Patients1_idx` (`patient_id`);

--
-- Indexes for table `Patients`
--
ALTER TABLE `Patients`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username_UNIQUE` (`username`), ADD KEY `fk_Patients_Doctors_idx` (`doctor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Doctors`
--
ALTER TABLE `Doctors`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `Health`
--
ALTER TABLE `Health`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `Patients`
--
ALTER TABLE `Patients`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `Health`
--
ALTER TABLE `Health`
ADD CONSTRAINT `patient_health` FOREIGN KEY (`patient_id`) REFERENCES `Patients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Patients`
--
ALTER TABLE `Patients`
ADD CONSTRAINT `Patients_Doctors` FOREIGN KEY (`doctor_id`) REFERENCES `Doctors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
