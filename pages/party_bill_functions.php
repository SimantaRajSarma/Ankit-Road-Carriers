<?php
    // Function to fetch trips by party name
function fetchTripsByPartyName($conn, $partyName) {
    $sql = "SELECT 
    trip_entry.*,
    vehicle.VehicleNo AS vehicle_no,
    vehicle.OwnerType AS vehicle_owner_type,
    driver.DriverName AS driver_name,
    party.party_name,
    products.product_name,
    consignor_Details.Consignor_name AS consignor_name,
    consignor_Details.Consignor_mobile AS consignor_mobile,
    consignee_Details.Consignee_name AS consignee_name,
    consignee_Details.Consignee_mobile AS consignee_mobile
FROM 
    trip_entry
JOIN 
    vehicle ON trip_entry.vehicle_id = vehicle.VehicleID
JOIN 
    driver ON trip_entry.driver_id = driver.DriverID
JOIN 
    party ON trip_entry.party_id = party.party_id
JOIN 
    products ON trip_entry.product_id = products.product_id
LEFT JOIN 
    consignor_Details ON trip_entry.Consignor_id = consignor_Details.Consignor_id
LEFT JOIN 
    consignee_Details ON trip_entry.Consignee_id = consignee_Details.Consignee_id
LEFT JOIN
    party_bill_lr ON trip_entry.trip_id = party_bill_lr.lr_id
WHERE 
    party_bill_lr.lr_id IS NULL AND party.party_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $partyName);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

// Function to fetch trips by party name and date range
function fetchTripsByPartyNameAndDate($conn, $partyName, $startDate, $endDate) {
    $sql = "SELECT 
    trip_entry.*,
    vehicle.VehicleNo AS vehicle_no,
    vehicle.OwnerType AS vehicle_owner_type,
    driver.DriverName AS driver_name,
    party.party_name,
    products.product_name,
    consignor_Details.Consignor_name AS consignor_name,
    consignor_Details.Consignor_mobile AS consignor_mobile,
    consignee_Details.Consignee_name AS consignee_name,
    consignee_Details.Consignee_mobile AS consignee_mobile
FROM 
    trip_entry
JOIN 
    vehicle ON trip_entry.vehicle_id = vehicle.VehicleID
JOIN 
    driver ON trip_entry.driver_id = driver.DriverID
JOIN 
    party ON trip_entry.party_id = party.party_id
JOIN 
    products ON trip_entry.product_id = products.product_id
LEFT JOIN 
    consignor_Details ON trip_entry.Consignor_id = consignor_Details.Consignor_id
LEFT JOIN 
    consignee_Details ON trip_entry.Consignee_id = consignee_Details.Consignee_id
LEFT JOIN
    party_bill_lr ON trip_entry.trip_id = party_bill_lr.lr_id
WHERE 
    party_bill_lr.lr_id IS NULL AND party.party_id = ? AND lr_date BETWEEN ? AND ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $partyName, $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

// Function to fetch trips by vehicle number
function fetchTripsByVehicle($conn, $vehicleNumber) {
    $sql = "SELECT 
    trip_entry.*,
    vehicle.VehicleNo AS vehicle_no,
    vehicle.OwnerType AS vehicle_owner_type,
    driver.DriverName AS driver_name,
    party.party_name,
    products.product_name,
    consignor_Details.Consignor_name AS consignor_name,
    consignor_Details.Consignor_mobile AS consignor_mobile,
    consignee_Details.Consignee_name AS consignee_name,
    consignee_Details.Consignee_mobile AS consignee_mobile
FROM 
    trip_entry
JOIN 
    vehicle ON trip_entry.vehicle_id = vehicle.VehicleID
JOIN 
    driver ON trip_entry.driver_id = driver.DriverID
JOIN 
    party ON trip_entry.party_id = party.party_id
JOIN 
    products ON trip_entry.product_id = products.product_id
LEFT JOIN 
    consignor_Details ON trip_entry.Consignor_id = consignor_Details.Consignor_id
LEFT JOIN 
    consignee_Details ON trip_entry.Consignee_id = consignee_Details.Consignee_id
LEFT JOIN
    party_bill_lr ON trip_entry.trip_id = party_bill_lr.lr_id
WHERE 
    party_bill_lr.lr_id IS NULL AND vehicle.VehicleID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $vehicleNumber);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

// Function to fetch trips by start and end date
function fetchTripsByDate($conn, $startDate, $endDate) {
    $sql = "SELECT 
    trip_entry.*,
    vehicle.VehicleNo AS vehicle_no,
    vehicle.OwnerType AS vehicle_owner_type,
    driver.DriverName AS driver_name,
    party.party_name,
    products.product_name,
    consignor_Details.Consignor_name AS consignor_name,
    consignor_Details.Consignor_mobile AS consignor_mobile,
    consignee_Details.Consignee_name AS consignee_name,
    consignee_Details.Consignee_mobile AS consignee_mobile
FROM 
    trip_entry
JOIN 
    vehicle ON trip_entry.vehicle_id = vehicle.VehicleID
JOIN 
    driver ON trip_entry.driver_id = driver.DriverID
JOIN 
    party ON trip_entry.party_id = party.party_id
JOIN 
    products ON trip_entry.product_id = products.product_id
LEFT JOIN 
    consignor_Details ON trip_entry.Consignor_id = consignor_Details.Consignor_id
LEFT JOIN 
    consignee_Details ON trip_entry.Consignee_id = consignee_Details.Consignee_id
LEFT JOIN
    party_bill_lr ON trip_entry.trip_id = party_bill_lr.lr_id
WHERE 
    party_bill_lr.lr_id IS NULL AND lr_date BETWEEN ? AND ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

// Function to fetch trips by party name and vehicle number
function fetchTripsByPartyNameAndVehicle($conn, $partyName, $vehicleNumber) {
    $sql = "SELECT 
    trip_entry.*,
    vehicle.VehicleNo AS vehicle_no,
    vehicle.OwnerType AS vehicle_owner_type,
    driver.DriverName AS driver_name,
    party.party_name,
    products.product_name,
    consignor_Details.Consignor_name AS consignor_name,
    consignor_Details.Consignor_mobile AS consignor_mobile,
    consignee_Details.Consignee_name AS consignee_name,
    consignee_Details.Consignee_mobile AS consignee_mobile
FROM 
    trip_entry
JOIN 
    vehicle ON trip_entry.vehicle_id = vehicle.VehicleID
JOIN 
    driver ON trip_entry.driver_id = driver.DriverID
JOIN 
    party ON trip_entry.party_id = party.party_id
JOIN 
    products ON trip_entry.product_id = products.product_id
LEFT JOIN 
    consignor_Details ON trip_entry.Consignor_id = consignor_Details.Consignor_id
LEFT JOIN 
    consignee_Details ON trip_entry.Consignee_id = consignee_Details.Consignee_id
LEFT JOIN
    party_bill_lr ON trip_entry.trip_id = party_bill_lr.lr_id
WHERE 
    party_bill_lr.lr_id IS NULL AND party.party_id = ? AND vehicle.VehicleID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $partyName, $vehicleNumber);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

// Function to fetch trips by party name, vehicle number, and date range
function fetchTripsByPartyNameVehicleAndDate($conn, $partyName, $vehicleNumber, $startDate, $endDate) {
    $sql = "SELECT 
    trip_entry.*,
    vehicle.VehicleNo AS vehicle_no,
    vehicle.OwnerType AS vehicle_owner_type,
    driver.DriverName AS driver_name,
    party.party_name,
    products.product_name,
    consignor_Details.Consignor_name AS consignor_name,
    consignor_Details.Consignor_mobile AS consignor_mobile,
    consignee_Details.Consignee_name AS consignee_name,
    consignee_Details.Consignee_mobile AS consignee_mobile
FROM 
    trip_entry
JOIN 
    vehicle ON trip_entry.vehicle_id = vehicle.VehicleID
JOIN 
    driver ON trip_entry.driver_id = driver.DriverID
JOIN 
    party ON trip_entry.party_id = party.party_id
JOIN 
    products ON trip_entry.product_id = products.product_id
LEFT JOIN 
    consignor_Details ON trip_entry.Consignor_id = consignor_Details.Consignor_id
LEFT JOIN 
    consignee_Details ON trip_entry.Consignee_id = consignee_Details.Consignee_id
LEFT JOIN
    party_bill_lr ON trip_entry.trip_id = party_bill_lr.lr_id
WHERE 
    party_bill_lr.lr_id IS NULL AND party.party_id  = ? AND vehicle.VehicleID = ? AND lr_date BETWEEN ? AND ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $partyName, $vehicleNumber, $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

// Function to fetch trips by vehicle number and date range
function fetchTripsByVehicleAndDate($conn, $vehicleNumber, $startDate, $endDate) {
    $sql = "SELECT 
    trip_entry.*,
    vehicle.VehicleNo AS vehicle_no,
    vehicle.OwnerType AS vehicle_owner_type,
    driver.DriverName AS driver_name,
    party.party_name,
    products.product_name,
    consignor_Details.Consignor_name AS consignor_name,
    consignor_Details.Consignor_mobile AS consignor_mobile,
    consignee_Details.Consignee_name AS consignee_name,
    consignee_Details.Consignee_mobile AS consignee_mobile
FROM 
    trip_entry
JOIN 
    vehicle ON trip_entry.vehicle_id = vehicle.VehicleID
JOIN 
    driver ON trip_entry.driver_id = driver.DriverID
JOIN 
    party ON trip_entry.party_id = party.party_id
JOIN 
    products ON trip_entry.product_id = products.product_id
LEFT JOIN 
    consignor_Details ON trip_entry.Consignor_id = consignor_Details.Consignor_id
LEFT JOIN 
    consignee_Details ON trip_entry.Consignee_id = consignee_Details.Consignee_id
LEFT JOIN
    party_bill_lr ON trip_entry.trip_id = party_bill_lr.lr_id
WHERE 
    party_bill_lr.lr_id IS NULL AND vehicle.VehicleID = ? AND lr_date BETWEEN ? AND ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $vehicleNumber, $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

?>