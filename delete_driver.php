<?php
include("include/connection.php");

if (isset($_GET['DriverID'])) {
    $DriverID= $_GET['DriverID'];

    $delete_sql = "DELETE from driver where DriverID = '$DriverID'";
    $delete_query = mysqli_query($conn, $delete_sql);

    if ($delete_query) {
        echo '<script>alert("Driver deleted successfully!"); window.location.href = "manage_driver.php";</script>';
    } else {
        echo '<script>alert("Error deleting product."); window.location.href = "manage_driver.php";</script>';
    }
}
?>
