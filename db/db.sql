-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2024 at 07:50 PM
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
-- Database: `logistics_software`
--

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE `driver` (
  `DriverID` int(11) NOT NULL,
  `DriverName` varchar(100) NOT NULL,
  `PhotoPath` varchar(255) DEFAULT NULL,
  `PermanentAddress` varchar(255) DEFAULT NULL,
  `TemporaryAddress` varchar(255) DEFAULT NULL,
  `MobileNo` varchar(15) DEFAULT NULL,
  `GuarantorName` varchar(100) DEFAULT NULL,
  `GuarantorMobileNo` varchar(15) DEFAULT NULL,
  `LicenseNo` varchar(50) DEFAULT NULL,
  `LicenseIssueDate` date DEFAULT NULL,
  `LicenseExpiryDate` date DEFAULT NULL,
  `HAZExpiryDate` date DEFAULT NULL,
  `HAZLicenseNo` varchar(50) DEFAULT NULL,
  `OpBalance` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `driverbankdetails`
--

CREATE TABLE `driverbankdetails` (
  `BankDetailID` int(11) NOT NULL,
  `DriverID` int(11) DEFAULT NULL,
  `BankName` varchar(100) DEFAULT NULL,
  `AccountNo` varchar(50) DEFAULT NULL,
  `BranchName` varchar(100) DEFAULT NULL,
  `IFSCCode` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `driverdocuments`
--

CREATE TABLE `driverdocuments` (
  `DocumentID` int(11) NOT NULL,
  `DriverID` int(11) DEFAULT NULL,
  `DocumentType` varchar(50) DEFAULT NULL,
  `DocumentName` varchar(100) DEFAULT NULL,
  `Remarks` varchar(255) DEFAULT NULL,
  `DocumentPath` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `joiningdetails`
--

CREATE TABLE `joiningdetails` (
  `JoiningDetailsID` int(11) NOT NULL,
  `DriverID` int(11) DEFAULT NULL,
  `JoiningDate` date DEFAULT NULL,
  `LeaveDate` date DEFAULT NULL,
  `TotalDate` int(11) DEFAULT NULL,
  `VehicleNo` varchar(50) DEFAULT NULL,
  `BasicSalary` int(11) DEFAULT NULL,
  `SalaryType` varchar(50) DEFAULT NULL,
  `Allowance` int(11) DEFAULT NULL,
  `AllowanceType` varchar(50) DEFAULT NULL,
  `Remarks` varchar(255) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `party`
--

CREATE TABLE `party` (
  `party_id` int(11) NOT NULL,
  `party_name` varchar(100) NOT NULL,
  `party_type` enum('Customer','Supplier','Other') NOT NULL,
  `contact_name` varchar(100) DEFAULT NULL,
  `contact_email` varchar(100) DEFAULT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `party`
--

INSERT INTO `party` (`party_id`, `party_name`, `party_type`, `contact_name`, `contact_email`, `contact_phone`, `address`) VALUES
(1, 'MAA Enterprice', 'Customer', NULL, 'test@gmail.com', '6002957819', 'VILL- DWIGUNPAR,P.O-BARDEKPAR,\r\nPIN-781382');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `product_group` varchar(50) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `unit` varchar(20) DEFAULT NULL,
  `cgst` decimal(5,2) DEFAULT NULL,
  `sgst` decimal(5,2) DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `opening_quantity` decimal(10,2) DEFAULT NULL,
  `hsn_sac_code` varchar(20) DEFAULT NULL,
  `godown` varchar(50) DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rto`
--

CREATE TABLE `rto` (
  `RTOID` int(11) NOT NULL,
  `VehicleID` int(11) NOT NULL,
  `TaxExpiry` date DEFAULT NULL,
  `FitnessNo` varchar(50) DEFAULT NULL,
  `FitnessExpiry` date DEFAULT NULL,
  `StatePermitNo` varchar(50) DEFAULT NULL,
  `StatePermitExpiry` date DEFAULT NULL,
  `PermittedState` varchar(100) DEFAULT NULL,
  `AIPPermit` varchar(50) DEFAULT NULL,
  `AIPPermitExpiry` date DEFAULT NULL,
  `InsurancePolicyNo` varchar(50) DEFAULT NULL,
  `InsuranceExpiry` date DEFAULT NULL,
  `ExplosiveLicNo` varchar(50) DEFAULT NULL,
  `ExplosiveExpiry` date DEFAULT NULL,
  `PUCNo` varchar(50) DEFAULT NULL,
  `PUCExpiry` date DEFAULT NULL,
  `CalibrationNo` varchar(50) DEFAULT NULL,
  `CalibrationExpiry` date DEFAULT NULL,
  `NumOfComp` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rto`
--

INSERT INTO `rto` (`RTOID`, `VehicleID`, `TaxExpiry`, `FitnessNo`, `FitnessExpiry`, `StatePermitNo`, `StatePermitExpiry`, `PermittedState`, `AIPPermit`, `AIPPermitExpiry`, `InsurancePolicyNo`, `InsuranceExpiry`, `ExplosiveLicNo`, `ExplosiveExpiry`, `PUCNo`, `PUCExpiry`, `CalibrationNo`, `CalibrationExpiry`, `NumOfComp`) VALUES
(1, 1, '0000-00-00', '', '0000-00-00', '', '0000-00-00', '', '', '0000-00-00', '', '0000-00-00', '', '0000-00-00', '', '0000-00-00', '', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sys_moss`
--

CREATE TABLE `sys_moss` (
  `id` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `edate` date NOT NULL,
  `address1` varchar(50) NOT NULL,
  `address2` varchar(50) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `gst_number` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `sys_moss`
--

INSERT INTO `sys_moss` (`id`, `name`, `edate`, `address1`, `address2`, `phone`, `gst_number`, `username`, `password`, `last_update`) VALUES
('G1002', 'Infotech CEC', '2019-03-26', 'Guwahati', 'Guwahati', '6000786878', '3484949477 - 915202', 'test', '1234', '2024-02-20 18:42:45');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `VehicleID` int(11) NOT NULL,
  `VehicleNo` varchar(50) NOT NULL,
  `VehicleOwner` varchar(100) DEFAULT NULL,
  `Capacity` int(11) DEFAULT NULL,
  `PANName` varchar(100) DEFAULT NULL,
  `PANCardNo` varchar(20) DEFAULT NULL,
  `TareWeight` float DEFAULT NULL,
  `VehicleType` varchar(100) DEFAULT NULL,
  `OwnerType` varchar(500) DEFAULT NULL,
  `VehicleModelType` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`VehicleID`, `VehicleNo`, `VehicleOwner`, `Capacity`, `PANName`, `PANCardNo`, `TareWeight`, `VehicleType`, `OwnerType`, `VehicleModelType`) VALUES
(1, 'AS25AC7900', 'Manjul Anoawar', 100, 'Manjul Anowar', 'DVGPB0305F', 0, 'truck', 'OWN', '2 tire');

-- --------------------------------------------------------

--
-- Table structure for table `vehicledocument`
--

CREATE TABLE `vehicledocument` (
  `DocumentID` int(11) NOT NULL,
  `VehicleID` int(11) DEFAULT NULL,
  `DocumentType` varchar(50) DEFAULT NULL,
  `DocumentName` varchar(100) DEFAULT NULL,
  `Remarks` varchar(255) DEFAULT NULL,
  `DocumentFile` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `driver`
--
ALTER TABLE `driver`
  ADD PRIMARY KEY (`DriverID`);

--
-- Indexes for table `driverbankdetails`
--
ALTER TABLE `driverbankdetails`
  ADD PRIMARY KEY (`BankDetailID`),
  ADD KEY `DriverID` (`DriverID`);

--
-- Indexes for table `driverdocuments`
--
ALTER TABLE `driverdocuments`
  ADD PRIMARY KEY (`DocumentID`),
  ADD KEY `DriverID` (`DriverID`);

--
-- Indexes for table `joiningdetails`
--
ALTER TABLE `joiningdetails`
  ADD PRIMARY KEY (`JoiningDetailsID`),
  ADD KEY `DriverID` (`DriverID`);

--
-- Indexes for table `party`
--
ALTER TABLE `party`
  ADD PRIMARY KEY (`party_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `rto`
--
ALTER TABLE `rto`
  ADD PRIMARY KEY (`RTOID`),
  ADD KEY `VehicleID` (`VehicleID`);

--
-- Indexes for table `sys_moss`
--
ALTER TABLE `sys_moss`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`VehicleID`);

--
-- Indexes for table `vehicledocument`
--
ALTER TABLE `vehicledocument`
  ADD PRIMARY KEY (`DocumentID`),
  ADD KEY `VehicleID` (`VehicleID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `driver`
--
ALTER TABLE `driver`
  MODIFY `DriverID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `driverbankdetails`
--
ALTER TABLE `driverbankdetails`
  MODIFY `BankDetailID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `driverdocuments`
--
ALTER TABLE `driverdocuments`
  MODIFY `DocumentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `joiningdetails`
--
ALTER TABLE `joiningdetails`
  MODIFY `JoiningDetailsID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `party`
--
ALTER TABLE `party`
  MODIFY `party_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rto`
--
ALTER TABLE `rto`
  MODIFY `RTOID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `VehicleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vehicledocument`
--
ALTER TABLE `vehicledocument`
  MODIFY `DocumentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `driverbankdetails`
--
ALTER TABLE `driverbankdetails`
  ADD CONSTRAINT `driverbankdetails_ibfk_1` FOREIGN KEY (`DriverID`) REFERENCES `driver` (`DriverID`) ON DELETE CASCADE;

--
-- Constraints for table `driverdocuments`
--
ALTER TABLE `driverdocuments`
  ADD CONSTRAINT `driverdocuments_ibfk_1` FOREIGN KEY (`DriverID`) REFERENCES `driver` (`DriverID`) ON DELETE CASCADE;

--
-- Constraints for table `joiningdetails`
--
ALTER TABLE `joiningdetails`
  ADD CONSTRAINT `joiningdetails_ibfk_1` FOREIGN KEY (`DriverID`) REFERENCES `driver` (`DriverID`) ON DELETE CASCADE;

--
-- Constraints for table `rto`
--
ALTER TABLE `rto`
  ADD CONSTRAINT `rto_ibfk_1` FOREIGN KEY (`VehicleID`) REFERENCES `vehicle` (`VehicleID`) ON DELETE CASCADE;

--
-- Constraints for table `vehicledocument`
--
ALTER TABLE `vehicledocument`
  ADD CONSTRAINT `vehicledocument_ibfk_1` FOREIGN KEY (`VehicleID`) REFERENCES `vehicle` (`VehicleID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
