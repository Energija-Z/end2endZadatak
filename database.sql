-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2026 at 10:43 PM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `department` varchar(50) CHARACTER SET cp1250 COLLATE cp1250_croatian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department`) VALUES
(1, 'Istraživanje i razvoj'),
(2, 'Prodaja'),
(3, 'Marketing'),
(4, 'Zakonska služba'),
(5, 'Sistemska podrška'),
(6, 'Nabava'),
(7, 'Kadrovska služba'),
(8, 'Uprava'),
(9, 'Relacije s javnošću');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `ID` int(11) NOT NULL,
  `Name` varchar(20) CHARACTER SET cp1250 COLLATE cp1250_croatian_ci NOT NULL,
  `Surname` varchar(20) CHARACTER SET cp1250 COLLATE cp1250_croatian_ci NOT NULL,
  `DateOfBirth` date DEFAULT NULL,
  `DateOfEmployment` date NOT NULL,
  `PositionID` int(11) NOT NULL,
  `DepartmentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`ID`, `Name`, `Surname`, `DateOfBirth`, `DateOfEmployment`, `PositionID`, `DepartmentID`) VALUES
(1, 'Mia', 'Negic', '2001-02-06', '2025-07-06', 5, 4),
(2, 'Dora', 'Zaga', '1991-12-06', '2010-06-12', 3, 2),
(3, 'Ante', 'Jura', '1980-01-05', '2006-04-08', 6, 1),
(4, 'Bogo', 'Mišić', '1991-09-25', '2016-03-14', 3, 8),
(5, 'Andro', 'Omniš', '1972-11-23', '2024-10-06', 5, 6),
(6, 'Maja', 'Sova', '1997-12-14', '2014-11-01', 2, 1),
(7, 'Lovro', 'Ugrest', '1979-02-26', '2015-06-09', 2, 8),
(8, 'Pavao', 'Zenka', '1992-10-24', '2017-01-25', 4, 6),
(9, 'Mia', 'Orna', '2002-04-17', '2020-01-07', 5, 3),
(10, 'Branko', 'Kušak', '2000-05-05', '2023-04-01', 4, 2),
(11, 'Tin', 'Ujnič', '1986-08-30', '2020-01-10', 6, 4),
(12, 'Ana', 'Đukov', '1965-03-30', '2009-07-12', 7, 7),
(14, 'Andreja', 'Nezgova', '1999-07-11', '2024-02-22', 3, 3),
(15, 'Mia', 'Šusković', '1989-11-16', '2017-02-26', 2, 2),
(16, 'Joško', 'Haža', '1998-06-04', '2015-11-02', 2, 7);

-- --------------------------------------------------------

--
-- Table structure for table `onboarding`
--

CREATE TABLE `onboarding` (
  `id` int(11) NOT NULL,
  `task` text CHARACTER SET cp1250 COLLATE cp1250_croatian_ci NOT NULL,
  `description` text CHARACTER SET cp1250 COLLATE cp1250_croatian_ci DEFAULT NULL,
  `requirements` text CHARACTER SET cp1250 COLLATE cp1250_croatian_ci NOT NULL,
  `finished` int(1) NOT NULL,
  `taskID` int(11) DEFAULT NULL,
  `employeeID` int(11) NOT NULL,
  `dateOffset` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `onboarding`
--

INSERT INTO `onboarding` (`id`, `task`, `description`, `requirements`, `finished`, `taskID`, `employeeID`, `dateOffset`) VALUES
(1, 'onboarding', 'Zaposlenik se mora upoznati s radnim okruženjem (zaposlenici, struktura, radni procesi).', 'laptop', 1, NULL, 2, 4),
(2, 'učiti o programiranju', 'U ovom koraku, zaposlenik mora naučiti programirati u objektno orijentiranim jezicima Java, C# i Python.', 'knjiga C++', 0, 1, 2, 3),
(3, 'Napisati dokumentaciju', 'Zaposlenik treba napisati dokumentaciju o korištenju alata za prijavu vremena.', 'Pristup Word-u', 0, 1, 2, 7),
(6, 'Izraditi program', 'Zaposlenik mora napisati program u PHP-u', 'Pristup IDE-u', 0, 3, 2, 8),
(7, 'Vidjeti naokolo', 'Help me', '', 0, 2, 2, 3),
(9, 'Poslati email', 'Zaposlenik mora poslati email kao zahtjev za pristup sustavu.', 'računalo, email račun', 0, NULL, 3, 0),
(10, 'Istraživanje', 'Zaposlenik mora istražiti više kako serveri rade', '', 0, NULL, 4, 20),
(11, 'Dovrši zadatak', 'Dovrši zadatak za END2END', 'PHP, računalo, mozak', 1, 6, 2, 7);

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `ID` int(11) NOT NULL,
  `Position` varchar(50) CHARACTER SET cp1250 COLLATE cp1250_croatian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`ID`, `Position`) VALUES
(1, 'Softverski inženjer'),
(2, 'Regruter'),
(3, 'Seniorski konzultant u prodaji'),
(4, 'Pripravnik'),
(5, 'Sistemski administrator'),
(6, 'Odvjetnik'),
(7, 'Promoter društvenih mreža');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `DepartmentFKConstraint` (`DepartmentID`),
  ADD KEY `PositionFKConstraint` (`PositionID`);

--
-- Indexes for table `onboarding`
--
ALTER TABLE `onboarding`
  ADD PRIMARY KEY (`id`),
  ADD KEY `TaskFKConstraint` (`taskID`);
ALTER TABLE `onboarding` ADD FULLTEXT KEY `taskIndex` (`task`);
ALTER TABLE `onboarding` ADD FULLTEXT KEY `requirements` (`requirements`);
ALTER TABLE `onboarding` ADD FULLTEXT KEY `descriptionIndex` (`description`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `onboarding`
--
ALTER TABLE `onboarding`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `DepartmentFKConstraint` FOREIGN KEY (`DepartmentID`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `PositionFKConstraint` FOREIGN KEY (`PositionID`) REFERENCES `positions` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `onboarding`
--
ALTER TABLE `onboarding`
  ADD CONSTRAINT `TaskFKConstraint` FOREIGN KEY (`taskID`) REFERENCES `onboarding` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
