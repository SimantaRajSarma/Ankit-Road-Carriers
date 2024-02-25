<?php
include("include/connection.php");

if (isset($_GET['vehicle_id'])) {
    $vehicle_id= $_GET['vehicle_id'];

    $delete_sql = "DELETE from vehicle where VehicleID = '$vehicle_id'";
    $delete_query = mysqli_query($conn, $delete_sql);

    if ($delete_query) {
        echo '<script>alert("Vehicle deleted successfully!"); window.location.href = "manage_vehicle.php";</script>';
    } else {
        echo '<script>alert("Error deleting product."); window.location.href = "manage_vehicle.php";</script>';
    }
}
?>
