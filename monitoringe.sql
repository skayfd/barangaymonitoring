-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2021 at 05:02 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.3.26

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
  `brgyname` varchar(120) NOT NULL,
  `referral` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barangay`
--

INSERT INTO `barangay` (`bid`, `brgyname`, `referral`) VALUES
(1, 'Padre Zamora', '880d7'),
(2, 'Padre Burgos', '12312'),
(3, 'Camp Allen', '13212'),
(4, 'Ambiong', '67890');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `hid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `pid` int(11) DEFAULT NULL,
  `daterecorded` datetime NOT NULL,
  `action` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`hid`, `uid`, `pid`, `daterecorded`, `action`) VALUES
(92, 9, NULL, '2021-06-01 05:46:31', 'Added Ezmeralda Carmencita Tugonon into listed people.'),
(93, 9, NULL, '2021-06-01 05:55:22', 'Added Gael Cayden Balangao into listed people.'),
(94, 9, NULL, '2021-06-01 05:56:28', 'Added Carlomagno Kenneth Acevedo into listed people.'),
(95, 9, NULL, '2021-06-01 05:59:43', 'Added Clinton Montrell Masancay into listed people.'),
(96, 9, NULL, '2021-06-01 06:00:22', 'Added Lexi Roana Roxas into listed people.'),
(97, 9, NULL, '2021-06-01 06:02:33', 'Added Xenia Jayden Defensor into listed people.'),
(98, 8, NULL, '2021-06-22 06:15:20', 'Added Jerald Leannon into listed people.'),
(99, 8, NULL, '2021-06-22 06:16:07', 'Added Felicia Weimann into listed people.'),
(100, 8, NULL, '2021-06-22 06:17:42', 'Added Wiley Ward Lopez into listed people.'),
(101, 8, NULL, '2021-06-22 06:18:52', 'Added Roberto McGlynn II into listed people.'),
(102, 8, NULL, '2021-06-22 06:19:48', 'Added Micah Romaguera into listed people.'),
(103, 8, NULL, '2021-06-22 06:21:00', 'Added Kara Lang into listed people.'),
(104, 8, NULL, '2021-06-22 06:21:44', 'Added Corbin Rodriguez into listed people.'),
(105, 8, NULL, '2021-06-22 06:22:19', 'Added Jerrod  Cremin  into listed people.'),
(106, 8, NULL, '2021-06-22 06:24:56', 'Added Clara  Bogan  into listed people.'),
(107, 8, NULL, '2021-06-22 06:25:35', 'Added Phoebe  Amparo into listed people.'),
(108, 7, NULL, '2021-06-22 06:28:16', 'Added Laila  Rizal into listed people.'),
(109, 7, NULL, '2021-06-22 06:28:51', 'Added Milan Fadel into listed people.'),
(110, 7, NULL, '2021-06-22 06:30:11', 'Added Trystan  Beckel into listed people.'),
(111, 7, NULL, '2021-06-22 06:30:56', 'Added Mauricio Klocko into listed people.'),
(112, 7, NULL, '2021-06-22 06:32:04', 'Added Josephine Morar into listed people.'),
(113, 7, NULL, '2021-06-22 06:32:59', 'Added Nelson Bugayong into listed people.'),
(114, 7, NULL, '2021-06-22 06:33:29', 'Added Nadia Pasilan into listed people.'),
(115, 7, NULL, '2021-06-22 06:35:05', 'Added Lenore Padilla into listed people.'),
(116, 7, NULL, '2021-06-22 06:35:39', 'Added Keenan Padilla into listed people.'),
(117, 9, 31, '2021-06-03 07:01:53', 'Added record for Xenia Jayden Defensor in the system.'),
(118, 9, NULL, '2021-06-03 05:02:16', 'Time Out record of Xenia Jayden Defensor from records.'),
(119, 9, 30, '2021-06-03 07:08:34', 'Added record for Lexi Roana Roxas in the system.'),
(120, 9, 51, '2021-06-03 07:09:11', 'Added record for Keenan Padilla in the system.'),
(121, 9, NULL, '2021-06-03 05:09:30', 'Time Out record of Keenan Padilla from records.'),
(122, 9, NULL, '2021-06-03 05:09:38', 'Time Out record of Lexi Roana Roxas from records.'),
(123, 9, 38, '2021-06-22 07:31:04', 'Added record for Corbin Rodriguez in the system.'),
(124, 9, NULL, '2021-06-22 07:31:21', 'Time Out record of Corbin Rodriguez from records.'),
(125, 9, NULL, '2021-06-22 07:51:49', 'Added Alexis Roxas into listed people.');

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `referral` varchar(6) DEFAULT NULL,
  `daterecorded` datetime DEFAULT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) NOT NULL,
  `gender` tinytext NOT NULL,
  `contactno` varchar(12) NOT NULL,
  `address` varchar(80) NOT NULL,
  `archive` tinyint(1) NOT NULL,
  `personStatus` varchar(50) NOT NULL,
  `datequar` datetime DEFAULT NULL,
  `quarantinedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`pid`, `uid`, `referral`, `daterecorded`, `firstname`, `middlename`, `lastname`, `gender`, `contactno`, `address`, `archive`, `personStatus`, `datequar`, `quarantinedby`) VALUES
(26, 9, '13212', '2021-06-01 05:46:31', 'Ezmeralda Carmencita', '', 'Tugonon', 'Female', '09123456789', '#1 Camp Allen', 0, '0', NULL, NULL),
(27, 9, '13212', '2021-06-01 05:55:22', 'Gael Cayden', '', 'Balangao', 'Male', '09133456789', '#2 Camp Allen', 0, '0', NULL, NULL),
(28, 9, '13212', '2021-06-01 05:56:28', 'Carlomagno Kenneth', '', 'Acevedo', 'Male', '09143456789', '# 3 Camp Allen', 0, '0', NULL, NULL),
(29, 9, '13212', '2021-06-01 05:59:43', 'Clinton Montrell', '', 'Masancay', 'Male', '09153456789', '#4 Camp Allen', 0, '0', NULL, NULL),
(30, 9, '13212', '2021-06-01 06:00:22', 'Lexi Roana', '', 'Roxas', 'Female', '09163456789', '#5 Camp Allen', 0, 'PUI', '2021-06-03 05:09:56', 9),
(31, 9, '13212', '2021-06-01 06:02:33', 'Xenia Jayden', '', 'Defensor', 'Female', '09113456789', '#6 Camp Allen', 0, '0', NULL, NULL),
(32, 8, '12312', '2021-06-02 06:15:20', 'Jerald', '', 'Leannon', 'Male', '09035169153', '#1 Padre Burgos', 0, '0', NULL, NULL),
(33, 8, '12312', '2021-06-03 06:16:07', 'Felicia', '', 'Weimann', 'Female', '09193456780', '#2 Padre Burgos', 0, '0', NULL, NULL),
(34, 8, '12312', '2021-06-03 06:17:42', 'Wiley Ward', '', 'Lopez', 'Male', '09126556789', '#3 Padre Burgos', 0, '0', NULL, NULL),
(35, 8, '12312', '2021-06-03 06:18:52', 'Roberto', '', 'McGlynn', 'Male', '09126457687', '#4 Padre Burgos', 0, '0', NULL, NULL),
(36, 8, '12312', '2021-06-03 06:19:48', 'Micah', '', 'Romaguera', 'Male', '09833377703', '#5 Padre Burgos', 0, '0', NULL, NULL),
(37, 8, '12312', '2021-06-03 06:21:00', 'Kara', '', 'Lang', 'Female', '09155657312', '#6 Padre Burgos', 0, '0', NULL, NULL),
(38, 8, '12312', '2021-06-04 06:21:44', 'Corbin', '', 'Rodriguez', 'Male', '09156423719', '#7 Padre Burgos', 0, '0', NULL, NULL),
(39, 8, '12312', '2021-06-04 06:22:19', 'Jerrod', '', 'Cremin', 'Male', '09143236937', '#8 Padre Burgos', 0, '0', NULL, NULL),
(40, 8, '12312', '2021-06-04 06:24:56', 'Clara', '', 'Bogan', 'Female', '09132547764', '#9 Padre Burgos', 0, '0', NULL, NULL),
(41, 8, '12312', '2021-06-04 06:25:35', 'Phoebe', '', 'Amparo', 'Female', '09214353743', '#10 Padre Burgos', 0, '0', NULL, NULL),
(42, 7, '880d7', '2021-06-02 06:28:16', 'Laila', '', 'Rizal', 'Female', '09956558799', '#1 Padre Zamora', 0, '0', NULL, NULL),
(43, 7, '880d7', '2021-06-03 06:28:51', 'Milan', '', 'Fadel', 'Male', '09233256729', '#2 Padre Zamora', 0, '0', NULL, NULL),
(45, 7, '880d7', '2021-06-03 06:30:11', 'Trystan', '', 'Beckel', 'Male', '09223252727', '#3 Padre Zamora', 0, '0', NULL, NULL),
(46, 7, '880d7', '2021-06-04 06:30:56', 'Mauricio', '', 'Klocko', 'Male', '09323454708', '#4 Padre Zamora', 0, '0', NULL, NULL),
(47, 7, '880d7', '2021-06-06 06:32:04', 'Josephine', '', 'Morar', 'Female', '09333054750', '#5 Padre Zamora', 0, 'PUM', '2021-06-22 08:48:02', 9),
(48, 7, '880d7', '2021-06-07 06:32:59', 'Nelson', '', 'Bugayong', 'Male', '09624458768', '#6 Padre Zamora', 0, 'PUM', '2021-06-22 08:47:56', 9),
(49, 7, '880d7', '2021-06-09 06:33:29', 'Nadia', '', 'Pasilan', 'Female', '09013426181', '#7 Padre Zamora', 0, '0', NULL, NULL),
(50, 7, '880d7', '2021-06-10 06:35:05', 'Lenore', '', 'Padilla', 'Female', '09323412710', '#8 Padre Zamora', 0, '0', NULL, NULL),
(51, 7, '880d7', '2021-06-10 06:35:39', 'Keenan', '', 'Padilla', 'Male', '09623401729', '#9 Padre Zamora', 0, 'PUM', '2021-06-22 08:48:41', 9),
(52, 9, '13212', '2021-06-03 07:51:49', 'Alexis', '', 'Roxas', 'Female', '09133453980', '#5 Camp Allen', 0, 'PUM', '2021-06-22 07:51:49', 9);

-- --------------------------------------------------------

--
-- Table structure for table `pwd_reset`
--

CREATE TABLE `pwd_reset` (
  `email` varchar(50) NOT NULL,
  `token` varchar(40) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `record`
--

CREATE TABLE `record` (
  `rid` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `daterecorded` datetime NOT NULL,
  `timeout` datetime DEFAULT NULL,
  `temp` decimal(4,2) NOT NULL,
  `reason` varchar(120) NOT NULL,
  `status` varchar(10) NOT NULL,
  `pointoforigin` varchar(180) NOT NULL,
  `addressto` varchar(180) NOT NULL,
  `addressto2` varchar(180) DEFAULT NULL,
  `addressto3` varchar(180) DEFAULT NULL,
  `brgycert` blob DEFAULT NULL,
  `healthdeclaration` blob DEFAULT NULL,
  `medcert` blob DEFAULT NULL,
  `travelauth` blob DEFAULT NULL,
  `workingid` blob DEFAULT NULL,
  `archive` tinyint(1) NOT NULL,
  `healthStatus` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `record`
--

INSERT INTO `record` (`rid`, `uid`, `pid`, `daterecorded`, `timeout`, `temp`, `reason`, `status`, `pointoforigin`, `addressto`, `addressto2`, `addressto3`, `brgycert`, `healthdeclaration`, `medcert`, `travelauth`, `workingid`, `archive`, `healthStatus`) VALUES
(45, 9, 31, '2021-06-03 07:01:53', '2021-06-03 05:02:16', '34.50', 'Work', 'APOR', 'Camp Allen', 'Loakan', '', '', 0x2e2e2f2e2e2f6173736574732f696d672f6238383066613130353138656335313039336462382e706e67, 0x2e2e2f2e2e2f6173736574732f696d672f663539623265372e, 0x2e2e2f2e2e2f6173736574732f696d672f613534363033356463662e, 0x2e2e2f2e2e2f6173736574732f696d672f65656662636363636135663764653431302e, NULL, 0, NULL),
(46, 9, 30, '2021-06-03 07:08:34', '2021-06-03 05:09:38', '36.50', 'Work', 'APOR', 'Camp Allen', 'Loakan', '', '', 0x2e2e2f2e2e2f6173736574732f696d672f356132643431362e706e67, 0x2e2e2f2e2e2f6173736574732f696d672f636333636666333033643031333637363535363261332e, 0x2e2e2f2e2e2f6173736574732f696d672f3936646364393166356433336264372e, 0x2e2e2f2e2e2f6173736574732f696d672f626366396237373931373836393763343964356565393532652e, NULL, 0, NULL),
(47, 9, 51, '2021-06-03 07:09:11', '2021-06-03 05:09:30', '37.20', 'Work', 'APOR', 'Camp Allen', 'Loakan', '', '', 0x2e2e2f2e2e2f6173736574732f696d672f333739343534373663613261346438666235302e706e67, 0x2e2e2f2e2e2f6173736574732f696d672f3264636462396435623736343639302e, 0x2e2e2f2e2e2f6173736574732f696d672f6462653233666165626564373538353262376663393263662e, 0x2e2e2f2e2e2f6173736574732f696d672f37323461343462396237653765663337303135393439653333352e, NULL, 0, NULL),
(48, 9, 30, '2021-06-03 05:09:56', '2021-06-03 05:09:56', '0.00', 'Changed Status to PUI', ' ', ' ', ' ', ' ', ' ', NULL, NULL, NULL, NULL, NULL, 0, 'PUI'),
(49, 9, 38, '2021-06-02 11:31:03', '2021-06-03 00:00:00', '34.60', 'Work', 'APOR', 'Padre Burgos', 'Loakan', '', '', 0x2e2e2f2e2e2f6173736574732f696d672f343730363236316164642e706e67, 0x2e2e2f2e2e2f6173736574732f696d672f6131396337353837393865303664352e, 0x2e2e2f2e2e2f6173736574732f696d672f326263663438326565626462652e, 0x2e2e2f2e2e2f6173736574732f696d672f36323031306135626461363461343535623134353066613934312e, NULL, 0, NULL),
(50, 9, 48, '2021-06-22 08:47:56', '2021-06-22 08:47:56', '0.00', 'Changed Status to PUM', ' ', ' ', ' ', ' ', ' ', NULL, NULL, NULL, NULL, NULL, 0, 'PUM'),
(51, 9, 47, '2021-06-22 08:48:02', '2021-06-22 08:48:02', '0.00', 'Changed Status to PUM', ' ', ' ', ' ', ' ', ' ', NULL, NULL, NULL, NULL, NULL, 0, 'PUM'),
(52, 9, 51, '2021-06-22 08:48:41', '2021-06-22 08:48:41', '0.00', 'Changed Status to PUM', ' ', ' ', ' ', ' ', ' ', NULL, NULL, NULL, NULL, NULL, 0, 'PUM');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `uid` int(11) NOT NULL,
  `bid` int(11) NOT NULL,
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
  `profilepic` blob DEFAULT NULL,
  `barid` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uid`, `bid`, `firstname`, `middlename`, `lastname`, `email`, `password`, `token`, `status`, `type`, `referral`, `promote`, `authorize`, `profilepic`, `barid`) VALUES
(7, 1, 'Osmanjep', '', 'Escobido', 'waweros753@d4wan.com', '$2y$10$GyM3CSCetCaA6bokgsx4i.53KvdgRgPl.1lETpIdvhvaP.0dT/Pxu', '100e72e9226e7b37f99f4544f2ba6c66', '1', '1', '880d7', 1, 0, NULL, 0x2e2e2f2e2e2f6173736574732f696d672f3834323863353631633663636338613330653663322e6a7067),
(8, 2, 'Faren Kersteen Kate', '', 'Manguiob', 'firikow953@gocasin.com', '$2y$10$wUNxHerP8omJN5R5OdZN7OMZ6krOTkZhEDUM.zvBFJe4.xyyLuiJK', 'a7da4ff8f121355faf4190ad83963ae8', '1', '1', '12312', 1, 0, NULL, 0x2e2e2f2e2e2f6173736574732f696d672f35626665386534396331623236303666313731312e6a7067),
(9, 3, 'John David', '', 'Villanueva', 'fodihi2052@gocasin.com', '$2y$10$zk0eIeGQbxUiFX6XvgClAucE1fBQWA1wQW4sVvjLox5CMGp2.aNdy', '2a4a56130f26539b5588468a385f7cf3', '1', '1', '13212', 1, 0, NULL, 0x2e2e2f2e2e2f6173736574732f696d672f643661356332612e6a7067);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barangay`
--
ALTER TABLE `barangay`
  ADD PRIMARY KEY (`bid`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`hid`),
  ADD KEY `foreign_uid` (`uid`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`pid`),
  ADD UNIQUE KEY `fName_lName_mName` (`firstname`,`lastname`,`middlename`),
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
  ADD PRIMARY KEY (`uid`),
  ADD KEY `bid` (`bid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barangay`
--
ALTER TABLE `barangay`
  MODIFY `bid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67891;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `hid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `record`
--
ALTER TABLE `record`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `foreign_uid` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`);

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

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `bid` FOREIGN KEY (`bid`) REFERENCES `barangay` (`bid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
