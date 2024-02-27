<?php
// Include your database connection file
include 'include/connection.php';

if(isset($_POST['consignee_name'])) {
    $consigneeName = $_POST['consignee_name'];
    
    // Perform a database query to fetch consignor details based on ID
    $query = "SELECT * FROM consignee_Details WHERE Consignee_name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $consigneeName);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Fetch the details
    $consigneeDetails = $result->fetch_assoc();

    // Return the details in JSON format
    echo json_encode($consigneeDetails);
}
?>
