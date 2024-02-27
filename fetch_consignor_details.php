<?php
// Include your database connection file
include 'include/connection.php';

if(isset($_POST['consignor_name'])) {
    $consignorName = $_POST['consignor_name'];
    
    // Perform a database query to fetch consignor details based on ID
    $query = "SELECT * FROM consignor_Details WHERE Consignor_name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $consignorName);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Fetch the details
    $consignorDetails = $result->fetch_assoc();

    // Return the details in JSON format
    echo json_encode($consignorDetails);
}
?>
