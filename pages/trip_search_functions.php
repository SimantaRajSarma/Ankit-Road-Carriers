<?php
// Function to fetch trips by party ID and date range
function fetchTripsByPartyAndDate($conn, $partyID, $fromDate, $toDate) {
    $sql = "SELECT 
    trip_entry.*,
    vehicle.VehicleNo AS vehicle_no,
    vehicle.OwnerType AS vehicle_owner_type,
    driver.DriverName AS driver_name,
    party.party_name,
    products.product_name
FROM 
    trip_entry
JOIN 
    vehicle ON trip_entry.vehicle_id = vehicle.VehicleID
JOIN 
    driver ON trip_entry.driver_id = driver.DriverID
JOIN 
    party ON trip_entry.party_id = party.party_id
JOIN 
    products ON trip_entry.product_id = products.product_id WHERE trip_entry.party_id = ? AND lr_date BETWEEN ? AND ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $partyID, $fromDate, $toDate); // Changed to "sss" for three string parameters
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}


// Function to fetch trips by party ID
function fetchTripsByParty($conn, $partyID) {
    $sql = "SELECT 
    trip_entry.*,
    vehicle.VehicleNo AS vehicle_no,
    vehicle.OwnerType AS vehicle_owner_type,
    driver.DriverName AS driver_name,
    party.party_name,
    products.product_name
FROM 
    trip_entry
JOIN 
    vehicle ON trip_entry.vehicle_id = vehicle.VehicleID
JOIN 
    driver ON trip_entry.driver_id = driver.DriverID
JOIN 
    party ON trip_entry.party_id = party.party_id
JOIN 
    products ON trip_entry.product_id = products.product_id WHERE trip_entry.party_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $partyID);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

// Function to fetch trips by date range
function fetchTripsByDate($conn, $fromDate, $toDate) {
    $sql = "SELECT 
    trip_entry.*,
    vehicle.VehicleNo AS vehicle_no,
    vehicle.OwnerType AS vehicle_owner_type,
    driver.DriverName AS driver_name,
    party.party_name,
    products.product_name
FROM 
    trip_entry
JOIN 
    vehicle ON trip_entry.vehicle_id = vehicle.VehicleID
JOIN 
    driver ON trip_entry.driver_id = driver.DriverID
JOIN 
    party ON trip_entry.party_id = party.party_id
JOIN 
    products ON trip_entry.product_id = products.product_id WHERE lr_date BETWEEN ? AND ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $fromDate, $toDate);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}


// Function to fetch trips by vehicle number
function fetchTripsByVehicle($conn, $vehicleID) {
    $sql = "SELECT 
    trip_entry.*,
    vehicle.VehicleNo AS vehicle_no,
    vehicle.OwnerType AS vehicle_owner_type,
    driver.DriverName AS driver_name,
    party.party_name,
    products.product_name
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
WHERE 
    vehicle.VehicleID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $vehicleID);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

 
  // Function to fetch trips by vehicle and date
function fetchTripsByVehicleAndDate($conn, $vehicleID, $fromDate, $toDate) {
    $sql = "SELECT 
    trip_entry.*,
    vehicle.VehicleNo AS vehicle_no,
    vehicle.OwnerType AS vehicle_owner_type,
    driver.DriverName AS driver_name,
    party.party_name,
    products.product_name
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
WHERE 
    vehicle.VehicleNo = ? AND lr_date BETWEEN ? AND ? ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $vehicleID,$fromDate, $toDate);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}



// Function to fetch trips by vehicle number
function fetchTripsByLRNumber($conn, $lr_number) {
    $sql = "SELECT 
    trip_entry.*,
    vehicle.VehicleNo AS vehicle_no,
    vehicle.OwnerType AS vehicle_owner_type,
    driver.DriverName AS driver_name,
    party.party_name,
    products.product_name
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
WHERE 
    trip_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $lr_number);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

?>
