<?php

function generateLRNumber($conn) {
     // Generate a random 6-8 digit number
     $randomDigits = mt_rand(100000, 99999999);
     
     // Concatenate the parts to form the LR number
     $lrNumber = "{$randomDigits}";
    
    // Check if the LR number already exists in the database
    $sql = "SELECT trip_id, lr_no FROM trip_entry WHERE lr_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $lrNumber);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // If the LR number already exists, generate a new LR number
    if ($result->num_rows > 0) {
        generateLRNumber($conn); // Recursive call to generate a new LR number
    }
    
    return $lrNumber;
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