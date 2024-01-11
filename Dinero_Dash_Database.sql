-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2024 at 08:05 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dinerodash`
--

-- --------------------------------------------------------

--
-- Table structure for table `budget`
--

CREATE TABLE `budget` (
  `UserID` int(11) DEFAULT NULL,
  `bug_amount` int(11) DEFAULT NULL,
  `prod_title` varchar(255) DEFAULT NULL,
  `exp_amount` int(11) DEFAULT NULL,
  `Phone` varchar(15) DEFAULT NULL,
  `Date_Added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `budget`
--

INSERT INTO `budget` (`UserID`, `bug_amount`, `prod_title`, `exp_amount`, `Phone`, `Date_Added`) VALUES
(5, 62000, NULL, NULL, NULL, '2024-01-10 18:47:13'),
(5, NULL, 'eggs', 3000, NULL, '2024-01-10 18:47:27'),
(5, NULL, 'contribution', 3044, NULL, '2024-01-10 18:47:47'),
(5, NULL, 'bike', 4900, NULL, '2024-01-10 18:48:14'),
(5, NULL, 'food', 3600, NULL, '2024-01-10 18:48:28');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `ExpenseID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `ExpenseName` varchar(255) DEFAULT NULL,
  `Amount` decimal(10,2) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `DateAdded` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`ExpenseID`, `UserID`, `ExpenseName`, `Amount`, `Description`, `DateAdded`) VALUES
(4, 5, 'amata', 2000.00, 'for kidds', '2024-01-10 18:39:15'),
(5, 5, 'eggs', 400.00, 'baby mama', '2024-01-10 18:39:32'),
(6, 5, 'airtime', 400.00, 'mission package', '2024-01-10 18:39:52'),
(7, 5, 'chips', 600.00, 'zo kurugendo', '2024-01-10 18:40:13'),
(8, 5, 'Kawasaki Motor', 3000.00, 'dream bike', '2024-01-10 18:40:30'),
(9, 5, 'tatra', 50.00, 'for imergence cases', '2024-01-10 18:41:09'),
(10, 5, 'insurerance', 240.00, 'life maintanance', '2024-01-10 18:41:43'),
(11, 5, 'contibution', 340.00, 'compony membership (TechSielo ltd) ', '2024-01-10 18:43:09'),
(12, 5, 'contibution', 340.00, 'compony membership (TechSielo ltd) ', '2024-01-10 18:43:27');

-- --------------------------------------------------------

--
-- Table structure for table `income`
--

CREATE TABLE `income` (
  `IncomeID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Category` varchar(255) DEFAULT NULL,
  `Amount` decimal(10,2) DEFAULT NULL,
  `Currency` varchar(3) DEFAULT NULL,
  `Frequency` varchar(20) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `DateAdded` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `income`
--

INSERT INTO `income` (`IncomeID`, `UserID`, `Category`, `Amount`, `Currency`, `Frequency`, `Description`, `DateAdded`) VALUES
(5, 4, 'Gift', 2000.00, 'RWF', 'monthly', 'kkkkk', '2024-01-06 08:21:29'),
(6, 5, 'Salary', 2000.00, 'RWF', 'monthly', 'testing notification', '2024-01-10 06:31:37'),
(7, 5, 'Salary', 3000.00, 'RWF', 'monthly', 'test 2', '2024-01-10 06:34:47'),
(8, 5, 'Salary', 3000.00, 'RWF', 'monthly', 'test 2', '2024-01-10 06:35:59'),
(9, 5, 'Salary', 2000.00, 'USD', 'hourly', 'income amt', '2024-01-10 06:44:04'),
(10, 5, 'Others', 5000.00, 'RWF', 'monthly', 'now check', '2024-01-10 06:53:52'),
(11, 5, 'Gift', 3000.00, 'USD', 'weekly', 'from my kid sis', '2024-01-10 11:52:00');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `UserID`, `category`, `message`, `timestamp`) VALUES
(15, 5, 'financial-alert1', 'Your current income amount is: 15000.00', '2024-01-10 06:53:52'),
(16, 5, 'financial-alert', 'Your budget has been exceeded.', '2024-01-10 06:54:50'),
(17, 5, 'profile_update', 'Your profile has been successfully updated.', '2024-01-10 06:56:35'),
(18, 5, 'financial-alert1', 'Your current income amount is: 18000.00', '2024-01-10 11:52:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `SecondName` varchar(50) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Phone` varchar(15) DEFAULT NULL,
  `PasswordHash` varchar(255) DEFAULT NULL,
  `RegistrationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `ProfileImage` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `FirstName`, `SecondName`, `Email`, `Phone`, `PasswordHash`, `RegistrationDate`, `ProfileImage`) VALUES
(4, 'am BILLY ', 'me', 'me@gmail.com', '07888888', '$2y$10$XANX40gq6u3c9Na6PbJYIuPtCAwMqMdXP0f64XajnMdcl6Y1wiyoW', '2024-01-06 08:15:46', NULL),
(5, 'OG nex', 'NELSON', 'user@gmail.com', '07917957711', '$2y$10$6hOyAdzmnKW3rRvV8lho7uZz5Dljm96nhaMeojU8aBBm.D55s7EA.', '2024-01-07 08:31:20', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`ExpenseID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`IncomeID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `ExpenseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `income`
--
ALTER TABLE `income`
  MODIFY `IncomeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `income`
--
ALTER TABLE `income`
  ADD CONSTRAINT `income_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
