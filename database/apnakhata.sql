-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2024 at 08:11 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apnakhata`
--

-- --------------------------------------------------------

--
-- Table structure for table `manual_money`
--

CREATE TABLE `manual_money` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `source` text NOT NULL,
  `amount` int(11) NOT NULL,
  `soft_delete` int(11) NOT NULL DEFAULT 0,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `monthly_balance`
--

CREATE TABLE `monthly_balance` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `month` int(2) NOT NULL,
  `year` int(4) NOT NULL,
  `balance` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `monthly_money`
--

CREATE TABLE `monthly_money` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `source` text NOT NULL,
  `amount` int(11) NOT NULL,
  `soft_delete` int(11) NOT NULL DEFAULT 0,
  `datetime` date NOT NULL,
  `next_add_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `spanding`
--

CREATE TABLE `spanding` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `purpose` text NOT NULL,
  `price` int(11) NOT NULL,
  `date` date NOT NULL,
  `soft_delete` int(11) NOT NULL DEFAULT 0,
  `date_time` datetime NOT NULL DEFAULT current_timestamp(),
  `category` enum('Food','Transport','Entertainment','Utilities','Rent','Loans','Other') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `total`
--

CREATE TABLE `total` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(55) NOT NULL,
  `password` varchar(255) NOT NULL,
  `login_token` varchar(255) NOT NULL,
  `timedate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_balance`
--

CREATE TABLE `user_balance` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `balance` int(11) NOT NULL DEFAULT 0,
  `current_balance` int(11) NOT NULL,
  `update_date` date NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `manual_money`
--
ALTER TABLE `manual_money`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monthly_balance`
--
ALTER TABLE `monthly_balance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monthly_money`
--
ALTER TABLE `monthly_money`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spanding`
--
ALTER TABLE `spanding`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `total`
--
ALTER TABLE `total`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_balance`
--
ALTER TABLE `user_balance`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `manual_money`
--
ALTER TABLE `manual_money`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `monthly_balance`
--
ALTER TABLE `monthly_balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `monthly_money`
--
ALTER TABLE `monthly_money`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spanding`
--
ALTER TABLE `spanding`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `total`
--
ALTER TABLE `total`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_balance`
--
ALTER TABLE `user_balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
