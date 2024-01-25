-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2023 at 06:47 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hrm_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `createdAt` bigint(20) UNSIGNED NOT NULL,
  `updatedAt` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `createdAt`, `updatedAt`) VALUES
('b14db87d-1def-4bf1-b55b-7ec5a1f85ce6', 'Pusat', 1703783247, 1703783247);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` char(36) NOT NULL,
  `branchId` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `createdAt` bigint(20) UNSIGNED NOT NULL,
  `updatedAt` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `branchId`, `name`, `createdAt`, `updatedAt`) VALUES
('b14db87d-1def-4bf1-b55b-7ec5a1f85ce6', 'b14db87d-1def-4bf1-b55b-7ec5a1f85ce6', 'Keuangan', 1703847009, 1703847009);

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` char(36) NOT NULL,
  `departmentId` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `createdAt` bigint(20) UNSIGNED NOT NULL,
  `updatedAt` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `departmentId`, `name`, `createdAt`, `updatedAt`) VALUES
('b14db87d-1def-4bf1-b55b-7ec5a1f85ce6', 'b14db87d-1def-4bf1-b55b-7ec5a1f85ce6', 'Manajer', 1703847440, 1703847440);

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL COMMENT '1 = Wajib; 0 = Tidak Wajib',
  `createdAt` bigint(20) UNSIGNED NOT NULL,
  `updatedAt` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `name`, `status`, `createdAt`, `updatedAt`) VALUES
('b14db87d-1def-4bf1-b55b-7ec5a1f85ce6', 'Foto', 1, 1703870673, 1703870684),
('b8df9bf4-7366-4f76-b74f-d08ff2a33332', 'Akta Keluarga', 0, 1703870594, 1703870594);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` char(36) NOT NULL,
  `registrationNumber` varchar(255) NOT NULL,
  `designationId` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `dateOfBirth` bigint(20) UNSIGNED NOT NULL,
  `gender` enum('Pria','Wanita') NOT NULL,
  `address` text NOT NULL,
  `dateOfJoin` bigint(20) UNSIGNED NOT NULL,
  `bankAccountHolderName` varchar(255) NOT NULL,
  `bankAccountNumber` varchar(255) NOT NULL,
  `bankName` varchar(255) NOT NULL,
  `createdAt` bigint(20) UNSIGNED NOT NULL,
  `updatedAt` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `registrationNumber`, `designationId`, `name`, `phone`, `email`, `dateOfBirth`, `gender`, `address`, `dateOfJoin`, `bankAccountHolderName`, `bankAccountNumber`, `bankName`, `createdAt`, `updatedAt`) VALUES
('b14db87d-1def-4bf1-b55b-7ec5a1f85ce5', '2k1n1m3', 'b14db87d-1def-4bf1-b55b-7ec5a1f85ce6', 'Andi', '0849284123', 'muhrama082ss@gmail.com', 134214, 'Pria', 'asdasd', 123123, 'asdasd', 'asdas', 'asdasd', 1703952716, 1703952716),
('b14db87d-1def-4bf1-b55b-7ec5a1f85ce6', '2k1n1m', 'b14db87d-1def-4bf1-b55b-7ec5a1f85ce6', 'Andi', '0849284', 'muhrama082@gmail.com', 134214, 'Pria', 'asdasd', 123123, 'asdasd', 'asdas', 'asdasd', 1703952716, 1703952716);

-- --------------------------------------------------------

--
-- Table structure for table `employee_documents`
--

CREATE TABLE `employee_documents` (
  `id` char(36) NOT NULL,
  `employeeId` char(36) NOT NULL,
  `documentId` char(36) NOT NULL,
  `file` varchar(255) NOT NULL,
  `createdAt` bigint(20) UNSIGNED NOT NULL,
  `updatedAt` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` char(36) NOT NULL,
  `designationId` char(36) NOT NULL,
  `employeeId` char(36) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` bigint(20) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `createdAt` bigint(20) UNSIGNED NOT NULL,
  `updatedAt` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resignations`
--

CREATE TABLE `resignations` (
  `id` char(36) NOT NULL,
  `employeeId` char(36) NOT NULL,
  `noticeDate` bigint(20) UNSIGNED NOT NULL,
  `date` bigint(20) UNSIGNED NOT NULL COMMENT 'Tanggal Terakhir Bekerja',
  `reason` text NOT NULL,
  `createdAt` bigint(20) UNSIGNED NOT NULL,
  `updatedAt` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `terminations`
--

CREATE TABLE `terminations` (
  `id` char(36) NOT NULL,
  `employeeId` char(36) NOT NULL,
  `terminationTypeId` char(36) NOT NULL,
  `noticeDate` bigint(20) UNSIGNED NOT NULL,
  `date` bigint(20) UNSIGNED NOT NULL COMMENT 'Tanggal Penghentian',
  `description` text NOT NULL,
  `createdAt` bigint(20) UNSIGNED NOT NULL,
  `updatedAt` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `termination_types`
--

CREATE TABLE `termination_types` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `createdAt` bigint(20) UNSIGNED NOT NULL,
  `updatedAt` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `id` char(36) NOT NULL,
  `employeeId` char(36) NOT NULL,
  `designationId` char(36) NOT NULL,
  `date` bigint(20) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `createdAt` bigint(20) UNSIGNED NOT NULL,
  `updatedAt` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` char(36) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` enum('Pemilik','Pengelola','Karyawan') NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL COMMENT '0 = Tidak Aktif; 1 = Aktif',
  `createdAt` bigint(20) UNSIGNED NOT NULL,
  `updatedAt` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `role`, `status`, `createdAt`, `updatedAt`) VALUES
('26c1fa9b-701c-4208-998e-023d2774d8c3', 'pemilik@gmail.com', '$2y$10$FOnVq.E6nFqiay5JeqGitOIGB2XoOIdmbOtG5MUEi8ryMNbm.pgky', 'Nama Pemilik', 'Pemilik', 1, 1703611152, 1703611152);

-- --------------------------------------------------------

--
-- Table structure for table `user_tokens`
--

CREATE TABLE `user_tokens` (
  `userId` char(36) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expiredAt` bigint(20) UNSIGNED NOT NULL,
  `createdAt` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_tokens`
--

INSERT INTO `user_tokens` (`userId`, `token`, `expiredAt`, `createdAt`) VALUES
('26c1fa9b-701c-4208-998e-023d2774d8c3', '0a01de35c1b61e644579f3a965d1611b', 1703802700, 1703781100),
('26c1fa9b-701c-4208-998e-023d2774d8c3', '2cb452768bcfda4af9064ca22e7eeeeb', 1703981863, 1703960263),
('26c1fa9b-701c-4208-998e-023d2774d8c3', '53df161b9d3cd9edb456a7be6ea370d9', 1704061354, 1704039754),
('26c1fa9b-701c-4208-998e-023d2774d8c3', '7441606ef42246a8dd604a8281facb93', 1703632757, 1703611157),
('26c1fa9b-701c-4208-998e-023d2774d8c3', 'b9baffc9f9feaaec5d80922611db8904', 1703890814, 1703869214),
('26c1fa9b-701c-4208-998e-023d2774d8c3', 'd50c536043ac882f8ee295a5040fcd76', 1703971379, 1703949779),
('26c1fa9b-701c-4208-998e-023d2774d8c3', 'd6daf02549321a76c895a096945086b8', 1703868481, 1703846881);

-- --------------------------------------------------------

--
-- Table structure for table `work_histories`
--

CREATE TABLE `work_histories` (
  `id` char(36) NOT NULL,
  `employeeId` char(36) NOT NULL,
  `dateOfJoin` bigint(20) UNSIGNED NOT NULL,
  `dateOfOut` bigint(20) UNSIGNED NOT NULL,
  `reasonOfOut` text NOT NULL,
  `createdAt` bigint(20) UNSIGNED NOT NULL,
  `updatedAt` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branchId` (`branchId`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departmentId` (`departmentId`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `registration_number` (`registrationNumber`),
  ADD KEY `designationId` (`designationId`);

--
-- Indexes for table `employee_documents`
--
ALTER TABLE `employee_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documentId` (`documentId`),
  ADD KEY `employeeId` (`employeeId`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `designationId` (`designationId`),
  ADD KEY `employeeId` (`employeeId`);

--
-- Indexes for table `resignations`
--
ALTER TABLE `resignations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employeeId` (`employeeId`);

--
-- Indexes for table `terminations`
--
ALTER TABLE `terminations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employeeId` (`employeeId`);

--
-- Indexes for table `termination_types`
--
ALTER TABLE `termination_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `designationId` (`designationId`),
  ADD KEY `employeeId` (`employeeId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `is_active` (`status`),
  ADD KEY `role` (`role`);

--
-- Indexes for table `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `user_id` (`userId`);

--
-- Indexes for table `work_histories`
--
ALTER TABLE `work_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employeeId` (`employeeId`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_ibfk_1` FOREIGN KEY (`branchId`) REFERENCES `branches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `designations`
--
ALTER TABLE `designations`
  ADD CONSTRAINT `designations_ibfk_1` FOREIGN KEY (`departmentId`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`designationId`) REFERENCES `designations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee_documents`
--
ALTER TABLE `employee_documents`
  ADD CONSTRAINT `employee_documents_ibfk_1` FOREIGN KEY (`documentId`) REFERENCES `documents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_documents_ibfk_2` FOREIGN KEY (`employeeId`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `promotions`
--
ALTER TABLE `promotions`
  ADD CONSTRAINT `promotions_ibfk_1` FOREIGN KEY (`designationId`) REFERENCES `designations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `promotions_ibfk_2` FOREIGN KEY (`employeeId`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `resignations`
--
ALTER TABLE `resignations`
  ADD CONSTRAINT `resignations_ibfk_1` FOREIGN KEY (`employeeId`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `terminations`
--
ALTER TABLE `terminations`
  ADD CONSTRAINT `terminations_ibfk_1` FOREIGN KEY (`employeeId`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transfers`
--
ALTER TABLE `transfers`
  ADD CONSTRAINT `transfers_ibfk_1` FOREIGN KEY (`designationId`) REFERENCES `designations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transfers_ibfk_2` FOREIGN KEY (`employeeId`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD CONSTRAINT `user_tokens_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `work_histories`
--
ALTER TABLE `work_histories`
  ADD CONSTRAINT `work_histories_ibfk_1` FOREIGN KEY (`employeeId`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
