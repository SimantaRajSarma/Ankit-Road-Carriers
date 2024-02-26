
CREATE TABLE `bills` (
  `bill_id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `trip_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `bill_date` date NOT NULL
);

CREATE TABLE `Consignee_Details` (
  `Consignee_id` int(11),
  `Consignee_name` varchar(100) DEFAULT NULL,
  `Consignee_mobile` varchar(20) DEFAULT NULL,
  `Consignee_email` varchar(255) DEFAULT NULL,
  `Consignee_gstin` varchar(255) DEFAULT NULL,
  `Consignee_address` varchar(255) DEFAULT NULL,
  `Delivery_address` varchar(255) DEFAULT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table `Consignor_Details`
--

CREATE TABLE `Consignor_Details` (
  `Consignor_id` int(11) NOT NULL,
  `Consignor_name` varchar(100) DEFAULT NULL,
  `Consignor_mobile` varchar(20) DEFAULT NULL,
  `Consignor_email` varchar(255) DEFAULT NULL,
  `Consignor_gstin` varchar(255) DEFAULT NULL,
  `Consignor_address` varchar(255) DEFAULT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE `driver` (
  `DriverID` int(11) NOT NULL,
  `DriverName` varchar(100) NOT NULL,
  `MobileNo` varchar(15) DEFAULT NULL,
  `LicenseNo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `driver`
--

INSERT INTO `driver` (`DriverID`, `DriverName`, `MobileNo`, `LicenseNo`) VALUES
(3, 'Simanta', '8011678422', '');

-- --------------------------------------------------------

--
-- Table structure for table `party`
--

CREATE TABLE `party` (
  `party_id` int(11) NOT NULL,
  `party_name` varchar(100) NOT NULL,
  `party_type` enum('Customer','Supplier','Other') NOT NULL,
  `contact_name` varchar(100) DEFAULT NULL,
  `gstin` varchar(100) DEFAULT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `party`
--

INSERT INTO `party` (`party_id`, `party_name`, `party_type`, `contact_name`, `gstin`, `contact_phone`, `address`) VALUES
(3, 'MAA Enterprice', 'Customer', NULL, ' 4frfrr44', '6002957819', 'Kamalpur, Kamrup Assam');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `unit` varchar(20) DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `opening_quantity` decimal(10,2) DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `date`, `product_name`, `unit`, `rate`, `opening_quantity`, `remarks`) VALUES
(4, '2024-02-25', 'Kraft Papper', 'MT', '1200.00', '10.00', 'No');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `sys_moss`
--

INSERT INTO `sys_moss` (`id`, `name`, `edate`, `address1`, `address2`, `phone`, `gst_number`, `username`, `password`, `last_update`) VALUES
('G1002', 'Infotech CEC', '2019-03-26', 'Guwahati', 'Guwahati', '6000786878', '3484949477 - 915202', 'test', '1234', '2024-02-20 18:42:45');

-- --------------------------------------------------------

--
-- Table structure for table `trip_entry`
--

CREATE TABLE `trip_entry` (
  `trip_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `party_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `lr_no` varchar(50) NOT NULL,
  `lr_date` date DEFAULT NULL,
  `lr_type` enum('Single','Multiple') DEFAULT NULL,
  `challan_no` varchar(20) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `bill_mode` enum('TO BE BILLED','TO PAY','PAID') DEFAULT NULL,
  `against_trip_id` int(11) DEFAULT NULL,
  `loading_wt` decimal(10,2) DEFAULT NULL,
  `unload_wt` decimal(10,2) DEFAULT NULL,
  `party_rate` decimal(10,2) DEFAULT NULL,
  `trptr_rate` decimal(10,2) DEFAULT NULL,
  `rate_type` enum('Weight','Trip','Capacity') DEFAULT NULL,
  `bill_no` varchar(50) DEFAULT NULL,
  `bill_freight` decimal(10,2) DEFAULT NULL,
  `vehicle_freight` decimal(10,2) DEFAULT NULL,
  `Consignor_id` int(11) DEFAULT NULL,
  `Consignee_id` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `VehicleID` int(11) NOT NULL,
  `VehicleNo` varchar(50) NOT NULL,
  `VehicleOwner` varchar(100) DEFAULT NULL,
  `mobile_no` varchar(20) DEFAULT NULL,
  `VehicleType` varchar(100) DEFAULT NULL,
  `OwnerType` varchar(500) DEFAULT NULL,
  `VehicleModelType` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`VehicleID`, `VehicleNo`, `VehicleOwner`, `mobile_no`, `VehicleType`, `OwnerType`, `VehicleModelType`) VALUES
(7, 'RJ23GB2953', 'Balbir Singh ', '8094093090', 'truck', 'OWN', '2 tire'),
(8, 'AS25AC7900', 'Manjul Anoawar', '9707196358', 'truck', 'OWN', '2 tire');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`bill_id`),
  ADD KEY `trip_id` (`trip_id`);

--
-- Indexes for table `Consignee_Details`
--
ALTER TABLE `Consignee_Details`
  ADD PRIMARY KEY (`Consignee_id`);

--
-- Indexes for table `Consignor_Details`
--
ALTER TABLE `Consignor_Details`
  ADD PRIMARY KEY (`Consignor_id`);

--
-- Indexes for table `driver`
--
ALTER TABLE `driver`
  ADD PRIMARY KEY (`DriverID`);

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
-- Indexes for table `sys_moss`
--
ALTER TABLE `sys_moss`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `trip_entry`
--
ALTER TABLE `trip_entry`
  ADD PRIMARY KEY (`trip_id`),
  ADD KEY `driver_id` (`driver_id`),
  ADD KEY `vehicle_id` (`vehicle_id`),
  ADD KEY `party_id` (`party_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`VehicleID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Consignee_Details`
--
ALTER TABLE `Consignee_Details`
  MODIFY `Consignee_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Consignor_Details`
--
ALTER TABLE `Consignor_Details`
  MODIFY `Consignor_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `driver`
--
ALTER TABLE `driver`
  MODIFY `DriverID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `party`
--
ALTER TABLE `party`
  MODIFY `party_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `trip_entry`
--
ALTER TABLE `trip_entry`
  MODIFY `trip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `VehicleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bills_ibfk_1` FOREIGN KEY (`trip_id`) REFERENCES `trip_entry` (`trip_id`);

--
-- Constraints for table `trip_entry`
--
ALTER TABLE `trip_entry`
  ADD CONSTRAINT `trip_entry_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `driver` (`DriverID`) ON DELETE CASCADE,
  ADD CONSTRAINT `trip_entry_ibfk_2` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`VehicleID`) ON DELETE CASCADE,
  ADD CONSTRAINT `trip_entry_ibfk_3` FOREIGN KEY (`party_id`) REFERENCES `party` (`party_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `trip_entry_ibfk_4` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
