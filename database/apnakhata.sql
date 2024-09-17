-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2024 at 02:37 PM
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

--
-- Dumping data for table `manual_money`
--

INSERT INTO `manual_money` (`id`, `user_id`, `source`, `amount`, `soft_delete`, `datetime`) VALUES
(3, 7, 'stock', 2000, 0, '2024-09-16 18:06:43');

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
  `datetime` datetime NOT NULL,
  `next_add_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `monthly_money`
--

INSERT INTO `monthly_money` (`id`, `user_id`, `source`, `amount`, `soft_delete`, `datetime`, `next_add_date`) VALUES
(13, 7, 'salary', 12000, 0, '2024-09-16 00:00:00', '2024-10-16'),
(14, 7, 'youtube', 6000, 0, '2024-09-16 00:00:00', '2024-10-16');

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
  `date_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `spanding`
--

INSERT INTO `spanding` (`id`, `user_id`, `purpose`, `price`, `date`, `soft_delete`, `date_time`) VALUES
(1, 7, 'bus', 24, '2024-09-16', 0, '2024-09-16 10:32:35'),
(2, 7, 'food', 100, '2024-09-16', 0, '2024-09-16 12:02:27'),
(3, 7, 'bus', 24, '2024-09-15', 0, '2024-09-16 12:07:19'),
(4, 7, 'food', 200, '2024-09-15', 0, '2024-09-16 12:07:30'),
(5, 7, 'bus', 100, '2024-09-14', 0, '2024-09-16 12:38:25'),
(6, 7, 'food', 487, '2024-09-06', 0, '2024-09-16 13:18:38'),
(7, 7, 'food', 120, '2024-09-01', 0, '2024-09-16 16:11:52');

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

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `login_token`, `timedate`) VALUES
(7, 'Arpan', 'arpan76@gmail.com', '$2y$10$SNPnfvCTwtAK/EgmOvvYsOLOWNNpiS4jqPZiOOucskWHqKSlGo1FC', '$2y$10$9uYg4XTal0gcQlrHTVUA/eD.ZzMhuqd.kyzp6AFa1fldtHtFu6Ja.', '2024-09-12 15:59:57');

-- --------------------------------------------------------

--
-- Table structure for table `user_balance`
--

CREATE TABLE `user_balance` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `balance` int(11) NOT NULL DEFAULT 0,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_balance`
--

INSERT INTO `user_balance` (`id`, `user_id`, `balance`, `datetime`) VALUES
(3, 7, 20000, '2024-09-16 17:58:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `manual_money`
--
ALTER TABLE `manual_money`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `monthly_money`
--
ALTER TABLE `monthly_money`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `spanding`
--
ALTER TABLE `spanding`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_balance`
--
ALTER TABLE `user_balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
