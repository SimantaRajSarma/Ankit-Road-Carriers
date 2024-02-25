<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
date_default_timezone_set('Asia/Kolkata');
error_reporting(0);
require_once('include/connection.php');
include('pages/trip_search_functions.php');


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $partyID = isset($_POST['party_id']) ? $_POST['party_id'] : 'none';
  $fromDate = $_POST['fdate'];
  $toDate = $_POST['tdate'];

  if ($partyID != 'none' && !empty($fromDate) && !empty($toDate)) {
      $result = fetchTripsByPartyAndDate($conn, $partyID, $fromDate, $toDate);
  }
  
  elseif ($partyID != 'none' && empty($fromDate) && empty($toDate)) {
      $result = fetchTripsByParty($conn, $partyID);
  }
 
  elseif ($partyID == 'none' && !empty($fromDate) && !empty($toDate)) {
      $result = fetchTripsByDate($conn, $fromDate, $toDate);
  }
 
  else {
      echo "<script>alert('Please select at least one search criteria.');</script>";
  }

}


    // SQL query to retrieve all data from the vehicle table
    $sql = "SELECT 
    trip_entry.trip_id,
    trip_entry.lr_no,
    trip_entry.lr_date,
    trip_entry.source,
    trip_entry.destination,
    trip_entry.bill_mode,
    trip_entry.loading_wt,
    trip_entry.unload_wt,
    trip_entry.party_rate,
    trip_entry.trptr_rate,
    vehicle.VehicleNo AS vehicle_no,
    vehicle.OwnerType AS vehicle_owner_type,
    driver.DriverName AS driver_name,
    party.party_name,
    products.product_name
FROM 
    trip_entry
JOIN 
    vehicle ON trip_entry.vehicle_id = vehicle.VehicleID
JOIN 
    driver ON trip_entry.driver_id = driver.DriverID
JOIN 
    party ON trip_entry.party_id = party.party_id
JOIN 
    products ON trip_entry.product_id = products.product_id";

    // Execute the query
    $result = $conn->query($sql);

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Trip List</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="https://ankitroadcarrier.in/logon33.jpg" rel="icon">
  <link href="https://ankitroadcarrier.in/logon33.jpg" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <script src="assets/vendor/fontawesome/fontawesome.js"></script>
  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Mar 09 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
    <style>
        @media (max-width: 767px) {
            .table-responsive {
                overflow-x: auto;
            }
        }
        
        .pagination {
    margin-top: 20px;
    text-align: center;
}

.pagination ul {
    display: inline-block;
    padding: 0;
    margin: 0;
}

.pagination li {
    display: inline;
    margin: 0 5px;
}

.pagination a {
    color: #333;
    display: inline-block;
    padding: 5px 10px;
    text-decoration: none;
    border-radius: 3px;
    transition: background-color 0.3s;
}

.pagination a:hover {
    background-color: #e0e0e0;
}

.pagination .active {
    background-color: #333;
    color: #fff;
}

@media (max-width: 768px) {
    .pagination li {
        margin: 0 3px;
    }
}

@media (max-width: 576px) {
    .pagination li {
        margin: 0 2px;
    }
}

   #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .colorful-spinner {
            border-top-color: #FF5C58;
            border-left-color: #FFE066;
            border-right-color: #59C9A5;
            border-bottom-color: #256EFF;
        }

    .report{
        border-radius:5px;
        font-weight:bold;
    }

    /* CSS for the search form */
.search-form {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 20px;
}

label {
    font-weight: bold;
}

.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

.form-select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

.btn-primary {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn-primary:hover {
    background-color: #0056b3;
}

    
    </style>

</head>

<body>
    
     <div id="preloader">
        <div class="spinner-border colorful-spinner" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

<?php
include('include/header.php');

?>
<audio id="notificationSound">
    <source src="notification.wav" type="audio/mpeg">
   
</audio>

<main id="main" class="main">

<div class="pagetitle">
  <h1>Trip Lists</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
      <li class="breadcrumb-item">Tables</li>
      <li class="breadcrumb-item active">Data</li>
    </ol>
  </nav>
</div><!-- End Page Title -->
<script>
function deleteConfirm(obj){
    Swal.fire({
        icon: 'question',
        title: 'Are you Sure?',
        text: 'Are you sure to delete an item. Deletation may be affect on records.',
        showDenyButton: true,
        confirmButtonText: 'Close',
        denyButtonText: 'Delete',
    }).then((result) => {
        if (result.isDenied) {
            location.href = obj;
        }
    })
    
}
</script>
<section class="section">
  <div class="row">
    
    <div class="col-lg-12">

      <div class="card">
        
        <div class="card-body">
         <br>
         <div class="report">
         <form method="post" action="" class="search-form">
    <div class="row">
      <div class="col-md-4">
            <div class="form-group">
                <label for="courseSelect" >Select Party:</label>
                <select id="courseSelect" name="party_id" class="form-select">
                    <option value="none" selected disabled>Select a Party...</option>
                    <?php 
                    $party_data = fetchParty($conn);
                        foreach ($party_data as $party): ?>
                        <option value="<?= $party['id']; ?>"><?= $party['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="startDate">From:</label>
                <input type="date" class="form-control" id="startDate" name="fdate" value="<?php echo date('Y-m-d'); ?>">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="endDate">To:</label>
                <input type="date" id="endDate" class="form-control" name="tdate" value="<?php echo date('Y-m-d'); ?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-lg btn-primary"><i class="fa-solid fa-magnifying-glass"></i>&nbsp;&nbsp;Search</button>
        </div>
    </div>
</form>
 </div>
 <br>
          <!-- Table with stripped rows -->
<div class="table-responsive">
    <table class="table datatable table-hover">
        <thead>
            <tr>
                <th scope="col" class="px-5">#</th>
                <th scope="col" class="px-5">Vehicle No.</th>
                <th scope="col" class="px-5">LR No.</th>
                <th scope="col" class="px-5">LR Date</th>
                <th scope="col" class="px-5">Source</th>
                <th scope="col" class="px-5">Destination</th>
                <th scope="col" class="px-5">Bill Mode</th>
                <th scope="col" class="px-5">Loading Wt (MT)</th>
                <th scope="col" class="px-5">Unload Wt (MT)</th>
                <th scope="col" class="px-5">Party Rate</th>
                <th scope="col" class="px-5">Trptr Rate</th>
                <th scope="col" class="px-5">Vehicle Owner Type</th>
                <th scope="col" class="px-5">Driver Name</th>
                <th scope="col" class="px-5">Party Name</th>
                <th scope="col" class="px-5">Product Name</th>
                <th scope="col" class="px-5" >Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $rank = 1; 
            // Assuming $result contains the result of the SQL query
            while($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td class="px-5"><b><?php echo $rank; ?></b></td>
                    <td class="px-5"><?php echo $row['vehicle_no']; ?></td>
                    <td class="px-5"><?php echo $row['lr_no']; ?></td>
                    <td class="px-5"><?php echo $row['lr_date']; ?></td>
                    <td class="px-5"><?php echo $row['source']; ?></td>
                    <td class="px-5"><?php echo $row['destination']; ?></td>
                    <td class="px-5"><?php echo $row['bill_mode']; ?></td>
                    <td class="px-5"><?php echo $row['loading_wt']; ?></td>
                    <td class="px-5"><?php echo $row['unload_wt']; ?></td>
                    <td class="px-5"><?php echo $row['party_rate']; ?></td>
                    <td class="px-5"><?php echo $row['trptr_rate']; ?></td>
                    <td class="px-5"><?php echo $row['vehicle_owner_type']; ?></td>
                    <td class="px-5"><?php echo $row['driver_name']; ?></td>
                    <td class="px-5"><?php echo $row['party_name']; ?></td>
                    <td class="px-5"><?php echo $row['product_name']; ?></td>
                    <td>
                        <button class="btn btn-danger">
                            <i class="fa-solid fa-lock ms-auto"></i>
                        </button>
                    </td>
                </tr>
            <?php 
                $rank++; 
            } 
            ?>
        </tbody>
    </table>
</div>
<!-- End Table with stripped rows -->

        </div>
      </div>

    </div>
  </div>
</section>

</main><!-- End #main -->

<?php
include('include/footer.php');
?>
  

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<script>
        // Hide the preloader when the page is loaded
        window.addEventListener("load", function() {
            const preloader = document.getElementById("preloader");
            preloader.style.display = "none";
        });
    </script>
    
   
  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
   <script src="assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>

   <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->


  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>