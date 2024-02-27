<?php
// Include your database connection file
include 'include/connection.php';

// Perform a database query to fetch consignor names
$query = "SELECT DISTINCT Consignee_name FROM consignee_Details";
$result = mysqli_query($conn, $query);

$consigneeNames = array();
while ($row = mysqli_fetch_assoc($result)) {
    $consigneeNames[] = array(
        // 'id' => $row['Consignee_id'],
        'name' => $row['Consignee_name']
    );
}

// Return the consignor names in JSON format
echo json_encode($consigneeNames);
?>
