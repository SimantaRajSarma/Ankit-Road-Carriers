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
    $stmt->bind_param("sss", $partyID, $fromDate, $toDate); // Changed to "sss" for three string parameters
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
    $stmt->bind_param("s", $partyID);
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


// Fetch Parties with IDs
function fetchParty($conn) {
    $party_data = [];
    $sql = "SELECT party_id, party_name FROM party";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $party_data[] = array(
                'id' => $row["party_id"], 
                'name' => $row["party_name"]
            );
        }
    } else {
        $party_data[] = array(
            'id' => null, 
            'name' => "No parties found"
        );
    }
    return $party_data;
  }
?>
