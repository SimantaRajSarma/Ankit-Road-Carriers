<?php


  // Function to fetch vehicle numbers and IDs from the database
function fetchVehicles($conn) {
    $sql = "SELECT VehicleID, VehicleNo FROM vehicle";
    $result = $conn->query($sql);
    $vehicles = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $vehicles[] = array(
                'id' => $row["VehicleID"],
                'number' => $row["VehicleNo"]
            );
        }
    } else {
        $vehicles[] = array(
            'id' => null,
            'number' => "No vehicles found"
        );
    }

    return $vehicles;
}

// Function to fetch LR numbers from the database
function fetchLRNumbers($conn) {
    // Fetch LR numbers from the database
    $query = "SELECT trip_id AS id, lr_no AS name FROM trip_entry";
    $result = mysqli_query($conn, $query);

    // Check if query was successful
    if ($result) {
        // Fetch LR numbers into an array
        $lr_numbers = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $lr_numbers;
    } else {
        // Return an empty array if query fails
        return array();
    }
}



// Function to fetch driver IDs and names from the database
function fetchDriverData($conn) {
    $sql = "SELECT DriverID, DriverName, MobileNo FROM driver";
    $result = $conn->query($sql);
    $driver_data = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $driver_data[] = array(
                'id' => $row["DriverID"],
                'name' => $row["DriverName"],
                'phone' => $row["MobileNo"]
            );
        }
    } else {
        $driver_data[] = array(
            'id' => null,
            'name' => "No drivers found",
            'phone' => ''
        );
    }

    return $driver_data;
}


    
// Fetch Products with IDs
function fetchProducts($conn) {
    $products = [];
    $sql = "SELECT product_id, product_name FROM products";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $products[] = array(
                'id' => $row["product_id"],
                'name' => $row["product_name"]
            );
        }
    } else {
        $products[] = array(
            'id' => null,
            'name' => "No products found"
        );
    }
    return $products;
}

// Fetch Parties with IDs
function fetchPartyData($conn) {
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