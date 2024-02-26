<?php
error_reporting(0);
session_start();
include("include/connection.php");

if (!isset($_SESSION["admin_id"])) {
    header("location:login.php");
    exit();
}   require_once('include/connection.php');

    // SQL query to retrieve all data from the vehicle table
    $sql = "SELECT * FROM party";

    // Execute the query
    $result = $conn->query($sql);

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Manage Clients</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/logo1.png" rel="icon">
  <link href="assets/img/logo1.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
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
  <h1>Manage Clients</h1>
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
          <!-- Table with stripped rows -->
           <div class="table-responsive">
          <table class="table datatable">
            <thead>
              <tr>
              <th scope="col">#</th>
                <th scope="col">Client Name</th>
                <th scope="col">Type</th>
                <th scope="col">Mobile No</th>
                <th scope="col">GSTIN</th>
                <th scope="col">Address</th>
            
                <th width="15%">Action</th>
              </tr>
            </thead>
            <tbody>
            <?php $rank=1; 
            while($row=mysqli_fetch_assoc($result)) {
                ?>
              <tr>
              <td><b><?php echo $rank?></b></td>
                <td><?php echo $row['party_name'];?></td>
                <td><?php echo $row['party_type'];?>&nbsp;</td>
                <td><?php echo $row['contact_phone'];?></td>
                <td><?php echo $row['gstin'];?></td>
                <td><?php echo $row['address'];?></td>
            
                <td><button class="btn btn-danger btn-sm" onclick="deleteConfirm('delete_client.php?client_id=<?php echo $row['party_id']; ?>')">
                <i class="fa-solid fa-trash"></i>
                    </button></td>
             
            </tr>
           
                <?php $rank++; }?>
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
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
   <script src="assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>


  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>