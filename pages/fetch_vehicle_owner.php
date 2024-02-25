<?php
// Include your database connection file
include_once('../include/connection.php');

function fetchVehicleOwnerByNumber($conn, $vehicle_id) {
    // Prepare and execute a query to fetch the owner of the vehicle with the given ID
    $stmt = $conn->prepare("SELECT VehicleOwner FROM vehicle WHERE VehicleID = ?");
    $stmt->bind_param("i", $vehicle_id);
    $stmt->execute();
    $stmt->bind_result($owner);
    $stmt->fetch();
    $stmt->close();

    return $owner;
}

if (isset($_POST['vehicle_number'])) {
    $vehicle_number = $_POST['vehicle_number'];
    $owner = fetchVehicleOwnerByNumber($conn, $vehicle_number);
    echo json_encode(['owner' => $owner]);
}
?>
