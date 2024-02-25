<?php
include("include/connection.php");

if (isset($_GET['product_id'])) {
    $product_id= $_GET['product_id'];

    $delete_sql = "DELETE from products where product_id = '$product_id'";
    $delete_query = mysqli_query($conn, $delete_sql);

    if ($delete_query) {
        echo '<script>alert("Product deleted successfully!"); window.location.href = "manage_product.php";</script>';
    } else {
        echo '<script>alert("Error deleting product."); window.location.href = "manage_product.php";</script>';
    }
}
?>
