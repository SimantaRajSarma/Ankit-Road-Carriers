<?php

function generateLRNumber() {
    // Generate a random number between 1 and 999999
    $random_number = mt_rand(1, 999999);
    // Pad the number with leading zeros to ensure it's at least 6 digits long
    $padded_number = str_pad($random_number, 6, '0', STR_PAD_LEFT);
    return $padded_number;
}


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


// Function to fetch driver IDs and names from the database
function fetchDriverData($conn) {
    $sql = "SELECT DriverID, DriverName FROM driver";
    $result = $conn->query($sql);
    $driver_data = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $driver_data[] = array(
                'id' => $row["DriverID"],
                'name' => $row["DriverName"]
            );
        }
    } else {
        $driver_data[] = array(
            'id' => null,
            'name' => "No drivers found"
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