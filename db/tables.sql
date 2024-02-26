
CREATE TABLE `sys_moss` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `edate` date DEFAULT NULL,
  `address1` varchar(50) NOT NULL,
  `address2` varchar(50) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `gst_number` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
);

CREATE TABLE `driver` (
  `DriverID` int(11) PRIMARY KEY AUTO_INCREMENT,
  `DriverName` varchar(100) DEFAULT NULL,
  `MobileNo` varchar(15) DEFAULT NULL,
  `LicenseNo` varchar(50) DEFAULT NULL
);

CREATE TABLE `party` (
  `party_id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `party_name` varchar(100) NOT NULL,
  `party_type` enum('Customer','Supplier','Other'),
  `contact_name` varchar(100) DEFAULT NULL,
  `gstin` varchar(100) DEFAULT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
);


CREATE TABLE `products` (
  `product_id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `product_name` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `unit` varchar(20) DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `opening_quantity` decimal(10,2) DEFAULT NULL,
  `remarks` text DEFAULT NULL
);

CREATE TABLE `vehicle` (
  `VehicleID` int(11) PRIMARY KEY AUTO_INCREMENT,
  `VehicleNo` varchar(50) NOT NULL,
  `VehicleOwner` varchar(100) DEFAULT NULL,
  `mobile_no` varchar(20) DEFAULT NULL,
  `VehicleType` varchar(100) DEFAULT NULL,
  `OwnerType` varchar(500) DEFAULT NULL,
  `VehicleModelType` varchar(100) DEFAULT NULL
);



CREATE TABLE `Consignee_Details` (
  `Consignee_id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `Consignee_name` varchar(100) DEFAULT NULL,
  `Consignee_mobile` varchar(20) DEFAULT NULL,
  `Consignee_email` varchar(255) DEFAULT NULL,
  `Consignee_gstin` varchar(255) DEFAULT NULL,
  `Consignee_address` varchar(255) DEFAULT NULL,
  `Delivery_address` varchar(255) DEFAULT NULL
);


CREATE TABLE `Consignor_Details` (
  `Consignor_id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `Consignor_name` varchar(100) DEFAULT NULL,
  `Consignor_mobile` varchar(20) DEFAULT NULL,
  `Consignor_email` varchar(255) DEFAULT NULL,
  `Consignor_gstin` varchar(255) DEFAULT NULL,
  `Consignor_address` varchar(255) DEFAULT NULL
);


CREATE TABLE `trip_entry` (
  `trip_id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `vehicle_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `party_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `lr_no` varchar(50) NOT NULL,
  `lr_date` date DEFAULT NULL,
  `lr_type` enum('Single','Multiple') DEFAULT NULL,
  `invoice_no` varchar(20) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `bill_mode` enum('TO BE BILLED','TO PAY','PAID') DEFAULT NULL,
  `against_trip_id` int(11) DEFAULT NULL,
  `loading_wt` decimal(10,2) DEFAULT NULL,
  `unload_wt` decimal(10,2) DEFAULT NULL,
  `e_way_bill_no` int(11) DEFAULT NULL,
  `e_way_bill_date` date DEFAULT NULL,
  `party_rate` decimal(10,2) DEFAULT NULL,
  `trptr_rate` decimal(10,2) DEFAULT NULL,
  `rate_type` enum('Weight','Trip','Capacity') DEFAULT NULL,
  `bill_no` varchar(50) DEFAULT NULL,
  `bill_freight` decimal(10,2) DEFAULT NULL,
  `vehicle_freight` decimal(10,2) DEFAULT NULL,
  `diesel_charges` decimal(10,2) DEFAULT NULL,
  `pump_cash` decimal(10,2) DEFAULT NULL,
  `cash_in_hand` decimal(10,2) DEFAULT NULL,
  `rtgs_charge` decimal(10,2) DEFAULT NULL,
  `unloading_charges` decimal(10,2) DEFAULT NULL,
  `labour_charges` decimal(10,2) DEFAULT NULL,
  `commission` decimal(10,2) DEFAULT NULL,
  `Consignor_id` int(11) DEFAULT NULL,
  `Consignee_id` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`VehicleID`) ON DELETE CASCADE,
  FOREIGN KEY (`driver_id`) REFERENCES `driver` (`DriverID`) ON DELETE CASCADE,
  FOREIGN KEY (`party_id`) REFERENCES `party` (`party_id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  FOREIGN KEY (`Consignor_id`) REFERENCES `Consignor_Details` (`Consignor_id`) ON DELETE SET NULL,
  FOREIGN KEY (`Consignee_id`) REFERENCES `Consignee_Details` (`Consignee_id`) ON DELETE SET NULL
);

CREATE TABLE `party_bill` (
    `bill_id` INT AUTO_INCREMENT PRIMARY KEY,
    `bill_number` VARCHAR(50) NOT NULL,
    `party_id` INT NOT NULL,
    `bill_amount` DECIMAL(10, 2) DEFAULT NULL,
    `bill_date` DATE NOT NULL,
    FOREIGN KEY (`party_id`) REFERENCES `party` (`party_id`) ON DELETE CASCADE,
);

CREATE TABLE `party_bill_lr` (
    `bill_lr_id` INT AUTO_INCREMENT PRIMARY KEY,
    `bill_id` INT NOT NULL,
    `lr_id` INT NOT NULL,
    FOREIGN KEY (`bill_id`) REFERENCES `party_bill` (`bill_id`) ON DELETE CASCADE,
    FOREIGN KEY (`lr_id`) REFERENCES `trip_entry` (`trip_id`) ON DELETE CASCADE
);

