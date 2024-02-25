CREATE TABLE `driver` (
  `DriverID` INT(11) PRIMARY KEY AUTO_INCREMENT,
  `DriverName` VARCHAR(100) NOT NULL,
  `PhotoPath` VARCHAR(255) DEFAULT NULL,
  `PermanentAddress` VARCHAR(255) DEFAULT NULL,
  `TemporaryAddress` VARCHAR(255) DEFAULT NULL,
  `MobileNo` VARCHAR(15) DEFAULT NULL,
  `GuarantorName` VARCHAR(100) DEFAULT NULL,
  `GuarantorMobileNo` VARCHAR(15) DEFAULT NULL,
  `LicenseNo` VARCHAR(50) DEFAULT NULL,
  `LicenseIssueDate` DATE DEFAULT NULL,
  `LicenseExpiryDate` DATE DEFAULT NULL,
  `HAZExpiryDate` DATE DEFAULT NULL,
  `HAZLicenseNo` VARCHAR(50) DEFAULT NULL,
  `OpBalance` INT(11) DEFAULT NULL
);

CREATE TABLE `driverbankdetails` (
  `BankDetailID` INT(11)  PRIMARY KEY AUTO_INCREMENT,
  `DriverID` INT(11) DEFAULT NULL,
  `BankName` VARCHAR(100) DEFAULT NULL,
  `AccountNo` VARCHAR(50) DEFAULT NULL,
  `BranchName` VARCHAR(100) DEFAULT NULL,
  `IFSCCode` VARCHAR(20) DEFAULT NULL,
  FOREIGN KEY (`DriverID`) REFERENCES `driver` (`DriverID`) ON DELETE CASCADE
);

CREATE TABLE `driverdocuments` (
  `DocumentID` INT(11) PRIMARY KEY AUTO_INCREMENT,
  `DriverID` INT(11) DEFAULT NULL,
  `DocumentType` VARCHAR(50) DEFAULT NULL,
  `DocumentName` VARCHAR(100) DEFAULT NULL,
  `Remarks` VARCHAR(255) DEFAULT NULL,
  `DocumentPath` VARCHAR(255) DEFAULT NULL,
  FOREIGN KEY (`DriverID`) REFERENCES `driver` (`DriverID`) ON DELETE CASCADE
);

CREATE TABLE `joiningdetails` (
  `JoiningDetailsID` INT(11) PRIMARY KEY AUTO_INCREMENT,
  `DriverID` INT(11) DEFAULT NULL,
  `JoiningDate` DATE DEFAULT NULL,
  `LeaveDate` DATE DEFAULT NULL,
  `TotalDate` INT(11) DEFAULT NULL,
  `VehicleNo` VARCHAR(50) DEFAULT NULL,
  `BasicSalary` INT(11) DEFAULT NULL,
  `SalaryType` VARCHAR(50) DEFAULT NULL,
  `Allowance` INT(11) DEFAULT NULL,
  `AllowanceType` VARCHAR(50) DEFAULT NULL,
  `Remarks` VARCHAR(255) DEFAULT NULL,
  `Status` VARCHAR(50) DEFAULT NULL,
  FOREIGN KEY (`DriverID`) REFERENCES `driver` (`DriverID`) ON DELETE CASCADE
);

CREATE TABLE `vehicle` (
  `VehicleID` INT(11) PRIMARY KEY  AUTO_INCREMENT,
  `VehicleNo` VARCHAR(50) NOT NULL,
  `VehicleOwner` VARCHAR(100) DEFAULT NULL,
  `Capacity` INT(11) DEFAULT NULL,
  `PANName` VARCHAR(100) DEFAULT NULL,
  `PANCardNo` VARCHAR(20) DEFAULT NULL,
  `TareWeight` FLOAT DEFAULT NULL,
  `VehicleType` VARCHAR(100) DEFAULT NULL,
  `OwnerType` VARCHAR(500) DEFAULT NULL,
  `VehicleModelType` VARCHAR(100) DEFAULT NULL
);

CREATE TABLE `rto` (
  `RTOID` INT(11) PRIMARY KEY AUTO_INCREMENT,
  `VehicleID` INT(11) NOT NULL,
  `TaxExpiry` DATE DEFAULT NULL,
  `FitnessNo` VARCHAR(50) DEFAULT NULL,
  `FitnessExpiry` DATE DEFAULT NULL,
  `StatePermitNo` VARCHAR(50) DEFAULT NULL,
  `StatePermitExpiry` DATE DEFAULT NULL,
  `PermittedState` VARCHAR(100) DEFAULT NULL,
  `AIPPermit` VARCHAR(50) DEFAULT NULL,
  `AIPPermitExpiry` DATE DEFAULT NULL,
  `InsurancePolicyNo` VARCHAR(50) DEFAULT NULL,
  `InsuranceExpiry` DATE DEFAULT NULL,
  `ExplosiveLicNo` VARCHAR(50) DEFAULT NULL,
  `ExplosiveExpiry` DATE DEFAULT NULL,
  `PUCNo` VARCHAR(50) DEFAULT NULL,
  `PUCExpiry` DATE DEFAULT NULL,
  `CalibrationNo` VARCHAR(50) DEFAULT NULL,
  `CalibrationExpiry` DATE DEFAULT NULL,
  `NumOfComp` INT(11) DEFAULT NULL,
  FOREIGN KEY (`VehicleID`) REFERENCES `vehicle` (`VehicleID`) ON DELETE CASCADE
);


CREATE TABLE `vehicledocument` (
  `DocumentID` INT(11) PRIMARY KEY AUTO_INCREMENT,
  `VehicleID` INT(11) DEFAULT NULL,
  `DocumentType` VARCHAR(50) DEFAULT NULL,
  `DocumentName` VARCHAR(100) DEFAULT NULL,
  `Remarks` VARCHAR(255) DEFAULT NULL,
  `DocumentFile` VARCHAR(255) DEFAULT NULL,
  FOREIGN KEY (`VehicleID`) REFERENCES `vehicle` (`VehicleID`) ON DELETE CASCADE
);


CREATE TABLE `party` (
  `party_id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `party_name` varchar(100) NOT NULL,
  `party_type` enum('Customer','Supplier','Other') NOT NULL,
  `contact_name` varchar(100) DEFAULT NULL,
  `contact_email` varchar(100) DEFAULT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
);


CREATE TABLE `products` (
  `product_id` int(11) PRIMARY KEY AUTO_INCREMENT,
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
);

CREATE TABLE `sys_moss` (
  `id` varchar(10) PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `edate` date NOT NULL,
  `address1` varchar(50) NOT NULL,
  `address2` varchar(50) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `gst_number` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL UNIQUE,
  `password` varchar(100) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
);



CREATE TABLE `trip_entry` (
  `trip_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
  `vehicle_id` INT(11) NOT NULL,
  `driver_id` INT(11) NOT NULL,
  `party_id` INT(11) NOT NULL,
  `product_id` INT(11) NOT NULL,
  `lr_no` VARCHAR(50) NOT NULL,
  `lr_date` DATE DEFAULT NULL,
  `lr_type` enum('Single', 'Multiple'),
  `challan_no` VARCHAR(20) DEFAULT NULL,
  `source` VARCHAR(255) DEFAULT NULL,
  `destination` VARCHAR(255) DEFAULT NULL,
  `bill_mode` enum('TO BE BILLED', 'TO PAY', 'PAID'),
  `against_trip_id` INT(11) DEFAULT NULL,
  `loading_wt` DECIMAL(10,2) DEFAULT NULL,
  `unload_wt` DECIMAL(10,2) DEFAULT NULL,
  `party_rate` DECIMAL(10,2) DEFAULT NULL,
  `trptr_rate` DECIMAL(10,2) DEFAULT NULL,
  `rate_type` ENUM('Weight', 'Trip', 'Capacity'),
  `bill_no` VARCHAR(50) DEFAULT NULL,
  `statement_no` VARCHAR(50) DEFAULT NULL,
  `bill_freight` DECIMAL(10,2),
  `vehicle_freight` DECIMAL(10,2),
  `consignor_name` VARCHAR(100),
  `consignor_mobile` VARCHAR(20),
  `consignor_gstin` VARCHAR(20),
  `consignor_email` VARCHAR(100),
  `consignor_address` TEXT,
  `consignee_name` VARCHAR(100),
  `consignee_mobile` VARCHAR(20),
  `consignee_gstin` VARCHAR(20),
  `consignee_email` VARCHAR(100),
  `consignee_address` TEXT,
  `delivery_address` TEXT,
  `remarks` VARCHAR(255) DEFAULT NULL,
  FOREIGN KEY (`driver_id`) REFERENCES `driver` (`DriverID`) ON DELETE CASCADE,
  FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`VehicleID`) ON DELETE CASCADE,
  FOREIGN KEY (`party_id`) REFERENCES `party` (`party_id`) ON DELETE CASCADE
  FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE
);
