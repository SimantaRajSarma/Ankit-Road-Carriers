<?php
include("include/connection.php");

if (isset($_GET['client_id'])) {
    $DriverID= $_GET['client_id'];

    $delete_sql = "DELETE from party where party_id = '$DriverID'";
    $delete_query = mysqli_query($conn, $delete_sql);

    if ($delete_query) {
        echo '<script>alert("Client deleted successfully!"); window.location.href = "manage_client.php";</script>';
    } else {
        echo '<script>alert("Error deleting product."); window.location.href = "manage_driver.php";</script>';
    }
}
?>
