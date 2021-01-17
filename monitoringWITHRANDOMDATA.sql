-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2021 at 06:54 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `monitoring`
--

-- --------------------------------------------------------

--
-- Table structure for table `barangay`
--

CREATE TABLE `barangay` (
  `bid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `brgyname` varchar(120) NOT NULL,
  `streetname` varchar(120) NOT NULL,
  `referral` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barangay`
--

INSERT INTO `barangay` (`bid`, `uid`, `brgyname`, `streetname`, `referral`) VALUES
(1, 3, 'Barangay Padre Zamora', 'Padre Zamora Street', 'f4b81'),
(2, 30, 'Barangay Padre Burgos', 'Padre Burgos Street', 'e5e67'),
(3, 33, 'Barangay Padre Burgos', 'Padre Burgos Street', '8824d');

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `referral` varchar(6) NOT NULL,
  `daterecorded` datetime DEFAULT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `gender` tinytext NOT NULL,
  `contactno` varchar(12) NOT NULL,
  `address` varchar(80) NOT NULL,
  `archive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`pid`, `uid`, `referral`, `daterecorded`, `firstname`, `middlename`, `lastname`, `email`, `gender`, `contactno`, `address`, `archive`) VALUES
(1, 4, 'f4b81', NULL, 'Ken', 'Dall', 'Dave', 'kendall@mail.com', 'Male', '1234567890', 'Zamora Street', 0),
(2, 4, 'f4b81', NULL, 'asd', 'asd', 'asd', 'asd@mail.com', 'Male', '123213123', 'asdasdasd', 0),
(3, 4, 'f4b81', NULL, 'dfgdfg', 'dfgdfg', 'dfgdfg', 'dfgdfg@mail.com', 'Male', '1236767676', 'asdasdhghhfhfg', 0),
(4, 4, 'f4b81', NULL, 'yuiyuiyui', 'yuiyui', 'yuiyui', 'iuyiu@mail.com', 'Female', '7646546456', 'asdjutyutyut', 0),
(5, 3, 'f4b81', NULL, 'hhghgh', 'yuiyui', 'sdasdasd', 'gfgdfg@mail.com', 'Female', '12356788', 'MNMBNBMN', 0),
(6, 4, 'f4b81', NULL, 'HGHGH', 'YUYUHGHG', 'PLPIJSND', 'jhkljhl@mail.com', 'Male', '0964454545', 'nmjlukHHHH', 1),
(7, 4, 'f4b81', NULL, 'asdsad', 'nbmbnm', 'bnmbnmbnm', 'bnmbnm@mail.com', 'Male', 'yuiyuoiuyopo', 'rtyrtyrtyrty', 0),
(10, 33, '8824d', '2021-01-16 05:18:10', 'Juan', 'Enrique', 'Colenza', '', 'Male', '09219706979', '41-A Street', 0),
(11, 34, '8824d', '2021-01-16 05:22:20', 'Juan', 'Dela', 'Cruz', '', 'Male', '12345678901', '51-Bruh Street', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pwd_reset`
--

CREATE TABLE `pwd_reset` (
  `email` varchar(50) NOT NULL,
  `token` varchar(40) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pwd_reset`
--

INSERT INTO `pwd_reset` (`email`, `token`, `created_at`) VALUES
('hoyeko9991@aranelab.com', '7040af2ad107ab908af1fc92077d89ab', '2020-12-23 09:42:18'),
('hoyeko9991@aranelab.com', 'dfc70a13d213397984b1bada4f0900dc', '2020-12-23 10:03:14'),
('hoyeko9991@aranelab.com', '941aad592ae4b75459f3b99ba0fe0d44', '2020-12-23 10:05:07');

-- --------------------------------------------------------

--
-- Table structure for table `record`
--

CREATE TABLE `record` (
  `rid` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `daterecorded` datetime NOT NULL,
  `temp` decimal(4,2) NOT NULL,
  `reason` varchar(120) NOT NULL,
  `status` varchar(10) NOT NULL,
  `pointoforigin` varchar(180) NOT NULL,
  `addressto` varchar(180) NOT NULL,
  `archive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `record`
--

INSERT INTO `record` (`rid`, `uid`, `pid`, `daterecorded`, `temp`, `reason`, `status`, `pointoforigin`, `addressto`, `archive`) VALUES
(4, 4, 1, '2020-12-01 02:41:57', '0.00', 'Came home from work, essential worker.', 'APOR', '', '', 0),
(5, 3, 1, '2020-12-11 11:02:46', '0.00', 'Came home from work, essential worker.', 'APOR', '', '', 0),
(6, 4, 2, '2020-12-14 05:26:55', '0.00', 'Came from Pangasinan', 'PUM', '', '', 0),
(7, 4, 7, '2020-12-14 05:27:07', '0.00', 'Came from Bengue', 'PUM', '', '', 0),
(8, 4, 3, '2020-12-14 05:27:54', '0.00', 'Came from Nueva Ecija', 'PUM', '', '', 0),
(9, 4, 4, '2020-12-14 05:28:41', '0.00', 'Has signs and symptoms.', 'PUI', '', '', 0),
(10, 4, 5, '2020-12-14 05:29:11', '0.00', 'Came from Heavily infected area.', 'PUM', '', '', 0),
(11, 4, 1, '2020-12-15 01:03:54', '0.00', 'Home from work', 'APOR', '', '', 0),
(12, 4, 6, '2020-12-15 01:04:50', '0.00', 'Work from City Hall', 'APOR', '', '', 0),
(13, 4, 6, '2020-12-15 11:03:15', '0.00', 'Essential Worker, came home from work early', 'APOR', '', '', 0),
(14, 3, 1, '2020-12-16 10:16:04', '0.00', 'Came home to get phone.', 'APOR', '', '', 0),
(15, 3, 1, '2020-12-17 10:04:32', '0.00', 'Came home for work.', 'APOR', '', '', 0),
(17, 3, 6, '2020-12-17 10:06:24', '0.00', 'Employee From City hall', 'APOR', '', '', 0),
(18, 3, 1, '2020-12-21 10:28:45', '0.00', 'Came home from work', 'APOR', '', '', 0),
(19, 3, 6, '2020-12-22 07:50:21', '0.00', 'Work from City Hall', 'APOR', '', '', 0),
(20, 3, 1, '2020-12-24 11:15:01', '0.00', 'From Work', 'APOR', '', '', 0),
(21, 3, 2, '2021-01-05 09:14:25', '0.00', 'Working now', 'APOR', '', '', 0),
(28, 33, 11, '2021-01-16 06:11:16', '36.00', 'Visit', 'APOR', 'City Hall', 'Street Name', 0),
(29, 33, 10, '2021-01-16 06:14:45', '37.00', 'Came Home from City', 'LSI', 'Laoag City', 'Home Street', 0),
(30, 33, 10, '2021-01-16 10:15:12', '36.70', 'APOR', 'APOR', 'Baguio General Hospital', 'Friend\'s House', 0),
(31, 35, 11, '2021-01-17 01:48:57', '37.00', 'Another Visit, normal temperature.', 'APOR', 'SM City Baguio.', '43-A Padre Burgos Street.', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `uid` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(70) NOT NULL,
  `token` varchar(70) DEFAULT NULL,
  `status` varchar(3) DEFAULT NULL,
  `type` varchar(3) NOT NULL,
  `referral` varchar(6) NOT NULL,
  `promote` int(2) NOT NULL,
  `authorize` int(2) NOT NULL,
  `profilepic` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uid`, `firstname`, `middlename`, `lastname`, `email`, `password`, `token`, `status`, `type`, `referral`, `promote`, `authorize`, `profilepic`) VALUES
(3, 'Kendall Dave', 'Rimando', 'Balas', 'ken@mail.com', '$2y$10$x7.a7DVEcBnjPPEnXCQUU.ZjBquD2Ba1vM41sfeF/E4SvhDcmj1OO', NULL, '1', '1', 'f4b81', 1, 0, 0x2e2e2f2e2e2f6173736574732f696d672f6d652e6a706567),
(4, 'Joe', 'Ma', 'Ma', 'joe@mail.com', '$2y$10$emjKOXAOvQ2G9vOMLn4FRe6wogXLZ0icrCy.5B7iBXyDNTkZBplXa', NULL, '1', '2', 'f4b81', 0, 0, 0x2e2e2f2e2e2f6173736574732f696d672f627275682e6a7067),
(26, 'Ken', 'Dall', 'Dave', 'nofapa9570@1heizi.com', '$2y$10$FxbKucx6VM1q5lhkWI1M5eOLuTJHP/rC4bV0QR9X6WHyvzBOoD9ES', '61b90d702d461b3c3f54bcc4aff54aaf', '1', '2', 'f4b81', 0, 0, NULL),
(27, 'Dall', 'Ken', 'Evad', 'gopey92370@94jo.com', '$2y$10$MaFOK1.ufMKlg0FdDflcCuxrQ5lt01/wSTydOAvuZCvnXq/3cDWbq', '6e4ec7735aae3679d370b18b67c36333', '1', '4', 'f4b81', 0, 0, NULL),
(29, 'Man', 'Man', 'Man', 'hoyeko9991@aranelab.com', '$2y$10$jkViyyf2LtrE5n3THpAbVOlpDGmOqggqiwkrHlG7eMb2OMXNHzhpK', '1535caae66f45517e3fefd4be85bf582', '1', '3', 'f4b81', 0, 0, NULL),
(30, 'Juan', 'De', 'La Cruz', 'repamaf107@j24blog.com', '$2y$10$Ql7Q1QUj7PiR4o1RX7F1zeOqZLjYN/lKd2s6md3.AsJsFAFVucNdG', '9a56c7d725d5c53b5fb0053a8e24a794', '1', '1', 'e5e67', 1, 0, NULL),
(32, 'Ken', 'Ken', 'ken', 'vimixe6687@aranelab.com', '$2y$10$oaMp0f8nq5Agoz61I2z5yu4OQdCOvdfAAEhrs/3g5174eV6XVtwbu', 'e3422e10ddfd56ec6c2c23ca3577244a', '1', '1', '42fec', 1, 0, NULL),
(33, 'Kendall', 'Rimando', 'Balas', 'kanipe1465@majorsww.com', '$2y$10$TWcrOvKMIVT.AN89CUpE7ev.G30HVyPXNd//nCwKVxTx0IgVRu4QC', 'cc1b02afc17da388099b32f90724be16', '1', '1', '8824d', 1, 0, NULL),
(34, 'David', 'Rimando', 'Rimando', 'faxah81830@majorsww.com', '$2y$10$qiQ0DK/MkY.GvNRhI1fvFumgP9Sa19DER30kEnk.ojxqSWGNFRKvu', '501a4ee6eb266eb63551580da414b3fd', '1', '2', '8824d', 0, 0, 0x2e2e2f2e2e2f6173736574732f696d672f42616c617320526563656970742e6a7067),
(35, 'Joe', 'Mha', 'Mar', 'yeric13919@vss6.com', '$2y$10$QlIwMv9WXVeFMURHKDOdYej1g2U8JhP.Hny7muaJoNcaJ3Mj9lAX.', 'eb87d7645d6797653bff1026fb8a29d4', '1', '2', '8824d', 0, 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barangay`
--
ALTER TABLE `barangay`
  ADD PRIMARY KEY (`bid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`pid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `pwd_reset`
--
ALTER TABLE `pwd_reset`
  ADD UNIQUE KEY `time` (`created_at`);

--
-- Indexes for table `record`
--
ALTER TABLE `record`
  ADD PRIMARY KEY (`rid`),
  ADD KEY `PersonFK` (`pid`),
  ADD KEY `UserFK` (`uid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barangay`
--
ALTER TABLE `barangay`
  MODIFY `bid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `record`
--
ALTER TABLE `record`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barangay`
--
ALTER TABLE `barangay`
  ADD CONSTRAINT `uid` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`);

--
-- Constraints for table `person`
--
ALTER TABLE `person`
  ADD CONSTRAINT `person_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`);

--
-- Constraints for table `record`
--
ALTER TABLE `record`
  ADD CONSTRAINT `PersonFK` FOREIGN KEY (`pid`) REFERENCES `person` (`pid`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `UserFK` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE SET NULL ON UPDATE SET NULL;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `pwd_reset_DeleteRow` ON SCHEDULE EVERY '1 0' DAY_HOUR STARTS '2020-12-23 19:27:47' ON COMPLETION NOT PRESERVE ENABLE DO TRUNCATE pwd_reset$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
