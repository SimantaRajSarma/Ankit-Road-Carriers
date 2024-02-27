<?php
// Include your database connection file
include 'include/connection.php';

// Perform a database query to fetch consignor names
$query = "SELECT DISTINCT Consignor_name FROM consignor_Details";
$result = mysqli_query($conn, $query);

$consignorNames = array();
while ($row = mysqli_fetch_assoc($result)) {
    $consignorNames[] = array(
        // 'id' => $row['Consignor_id'],
        'name' => $row['Consignor_name']
    );
}

// Return the consignor names in JSON format
echo json_encode($consignorNames);
?>
