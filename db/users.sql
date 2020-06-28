-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 28, 2020 at 10:03 AM
-- Server version: 5.7.29-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `users`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `full_name` text NOT NULL,
  `pno` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(500) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `full_name`, `pno`, `email`, `password`, `date`) VALUES
(4, 'Asw lop', '', 'admin@example.com', '$2y$12$HP9yMU7ND.83aak5UmmDM.xXm24RuxXcq8cEfhPgCS5C2yoA8jM0q', '2018-08-07 01:23:11');

-- --------------------------------------------------------

--
-- Table structure for table `Agustyamuni`
--

CREATE TABLE `Agustyamuni` (
  `vill_name` text NOT NULL,
  `tot_person` text NOT NULL,
  `uq_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Agustyamuni`
--

INSERT INTO `Agustyamuni` (`vill_name`, `tot_person`, `uq_id`) VALUES
('ja  it   a', '0', 10),
('subh', '0', 12),
('gfegdf', '0', 13),
('Example', '0', 14);

-- --------------------------------------------------------

--
-- Table structure for table `blocks`
--

CREATE TABLE `blocks` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blocks`
--

INSERT INTO `blocks` (`id`, `name`) VALUES
(1, 'Agustyamuni'),
(2, 'Jakholi'),
(3, 'Ukhimath');

-- --------------------------------------------------------

--
-- Table structure for table `Jakholi`
--

CREATE TABLE `Jakholi` (
  `vill_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tot_person` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `uq_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Jakholi data';

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `uq_id` int(255) NOT NULL,
  `username` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `block` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `count` int(255) NOT NULL DEFAULT '0',
  `password_hash` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `salt` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `uq_key` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='login details';

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`uq_id`, `username`, `full_name`, `block`, `count`, `password_hash`, `salt`, `uq_key`) VALUES
(1, '9348472296', 'Gray Stout', 'Agustyamuni', 0, 'CPF11SCE5GS', 'CAF48SVL9TI', 'NJY34WAC8UK'),
(2, '5611428808', 'Craig Perry', 'Ukhimath', 0, 'ZJH09NNK6KI', 'JKK04ARR2RC', 'IUI15CIZ1YU'),
(3, '4869760093', 'Eve Lane', 'Jakholi', 1, 'RNW80KLY2XU', 'OWB11SES5ZJ', 'VAW40QZH5GT'),
(4, '6527587602', 'Hannah Pope', 'Agustyamuni', 1, 'KUV86TEC0NV', 'GZH38ZMG9CS', 'SME47KSS4VM'),
(5, '3508341619', 'Eliana Casey', 'Ukhimath', 1, 'HHJ80YRU9CC', 'HSH28QBD0JR', 'OLD23UCT2GI'),
(6, '8036202456', 'Nola Barker', 'Agustyamuni', 0, 'JCC49ANK6KW', 'HMZ51WJS8NB', 'UHV90NRO3XZ'),
(7, '6996580294', 'Rosalyn Hernandez', 'Jakholi', 1, 'RTD49DZY6SU', 'UNA28RFI8HZ', 'ETC54ICG4BZ'),
(8, '6656636547', 'Zorita Lancaster', 'Jakholi', 1, 'YLX04EUT4DD', 'YGV08BEK6OQ', 'GGR76PKU9XA'),
(9, '2106425466', 'Walter Michael', 'Ukhimath', 1, 'BGV78YQZ9GA', 'LIE20PJJ2QI', 'WOU31SRU2PG'),
(10, '9212285855', 'Nehru Schmidt', 'Ukhimath', 0, 'AKQ51GMY2SL', 'GLM09KIB7UO', 'XXN39AEP9PE'),
(11, '3625949211', 'Clementine White', 'Ukhimath', 1, 'TPG64DLH3HR', 'INQ64SXC4XF', 'EWF07LZZ6TI'),
(12, '8258341294', 'Baker Johns', 'Ukhimath', 0, 'ADC39VTN5JZ', 'ZLR53FYA8JS', 'WPS97KVV8UT'),
(13, '2476786192', 'Amy Sloan', 'Ukhimath', 0, 'BQA71VZM6MZ', 'YVP68STB8BX', 'FFY03AWQ6UC'),
(14, '1970636666', 'Reed Solomon', 'Ukhimath', 0, 'JLQ50UON9OK', 'ZLJ80JXG1YF', 'TMY50TAJ8WO'),
(15, '7888136750', 'Colette Turner', 'Agustyamuni', 0, 'BTF27QFG9WW', 'WBZ26JGG5RL', 'ZHE50KQU3HF'),
(16, '9331091561', 'Gannon Rich', 'Ukhimath', 0, 'DGE47UXN2RE', 'RZV77MWP8CD', 'TME69EBB1EF'),
(17, '4651422157', 'Gavin Mckay', 'Agustyamuni', 1, 'EML02KUV1IF', 'MXA76EUX9IC', 'EKE71REY5QU'),
(18, '1996314840', 'Minerva Little', 'Jakholi', 0, 'FCB27JLQ3KZ', 'FWJ25MAU3HM', 'CKS59HNH8RF'),
(19, '1061397060', 'Rae Mejia', 'Agustyamuni', 0, 'CGN07YBI9EV', 'IYO54BUG3IU', 'AMW99EAI3DX'),
(20, '4074608271', 'Kitra Ashley', 'Jakholi', 1, 'VBA09OWK0SV', 'PYZ70IBD8VO', 'QYW22RAJ4DY'),
(21, '3782041774', 'Erin Bennett', 'Jakholi', 0, 'WMD78AXY1WE', 'HKU79IWR9GV', 'CIN87XVJ8HA'),
(22, '4300010200', 'Audrey Cantu', 'Ukhimath', 0, 'IYS95NRS4NB', 'AVZ92TYV3VG', 'DCS62MPU5SS'),
(23, '7364502852', 'Rebekah Barnett', 'Agustyamuni', 1, 'URS83TPH4UN', 'KWI02NRZ6KF', 'VQQ70QXM9VT'),
(24, '3370504110', 'Neville Duffy', 'Agustyamuni', 1, 'SCK21DTQ9SS', 'GRX16ONB2KY', 'IZN36YUR5UJ'),
(25, '9071682129', 'Kameko Marshall', 'Ukhimath', 1, 'NHM32SET3UD', 'FGU08DUI3HR', 'CTF86GMA1TS');

-- --------------------------------------------------------

--
-- Table structure for table `Ukhimath`
--

CREATE TABLE `Ukhimath` (
  `vill_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tot_person` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `uq_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Ukhimath data';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Agustyamuni`
--
ALTER TABLE `Agustyamuni`
  ADD KEY `uq_id` (`uq_id`);

--
-- Indexes for table `blocks`
--
ALTER TABLE `blocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Jakholi`
--
ALTER TABLE `Jakholi`
  ADD KEY `uq_id` (`uq_id`) USING BTREE;

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`uq_id`),
  ADD UNIQUE KEY `uq_id` (`username`(255));

--
-- Indexes for table `Ukhimath`
--
ALTER TABLE `Ukhimath`
  ADD KEY `uq_id` (`uq_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `blocks`
--
ALTER TABLE `blocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `uq_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Jakholi`
--
ALTER TABLE `Jakholi`
  ADD CONSTRAINT `Jakholi_ibfk_1` FOREIGN KEY (`uq_id`) REFERENCES `login` (`uq_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Ukhimath`
--
ALTER TABLE `Ukhimath`
  ADD CONSTRAINT `Ukhimath_ibfk_1` FOREIGN KEY (`uq_id`) REFERENCES `login` (`uq_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
