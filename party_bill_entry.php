



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Party Bill</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="https://ankitroadcarrier.in/arc_logo.jpg" rel="icon">
  <link href="https://ankitroadcarrier.in/arc_logo.jpg" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <script src="assets/vendor/fontawesome/fontawesome.js"></script>
  <!-- SweetAlert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    max-width: 1100px;
    margin: 0 auto;
    padding: 20px;
    background-color: #ECF2FF;
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
.custom-checkbox {
    width: 20px; 
    height: 20px;
}

    
    </style>

</head>

<body>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// error_reporting(0);

session_start();
include("include/connection.php");
include('pages/fetch_data.php');
include('pages/party_bill_functions.php');

if (!isset($_SESSION["admin_id"])) {
    header("location:index.php");
    exit();
}

// Function to generate a unique bill number
function generateBillNumber($conn) {
    // Get the current session (e.g., 23-24)
    $current_session = date('y') . '-' . (date('y') + 1);

    // Retrieve the maximum bill number for the current session from the database
    $query = "SELECT MAX(bill_number) AS max_bill_no FROM party_bill WHERE bill_number LIKE 'ARC/$current_session/%'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $max_bill_no = $row['max_bill_no'];

    // If no bill number exists in the current session, start from 1
    if ($max_bill_no === null) {
        return "ARC/$current_session/0001";
    }

    // Extract the last four digits of the maximum bill number
    $last_four_digits = substr($max_bill_no, -4);

    // Increment the last four digits by 1 to get the next bill number
    $next_bill_number = str_pad(($last_four_digits + 1), 4, '0', STR_PAD_LEFT);

    // Return the unique bill number in the desired format
    return "ARC/$current_session/$next_bill_number";
}


$bill_number = generateBillNumber($conn);


// Function to calculate total bill amount based on selected LR IDs
function calculateBillAmount($conn, $lrIds) {
    $totalAmount = 0;
    
    // Iterate through each selected LR ID
    foreach ($lrIds as $lrId) {
        // Query the freight amount for the LR ID from the trip_entry table
        $sql = "SELECT bill_freight FROM trip_entry WHERE trip_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $lrId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // If a record is found, add the freight amount to the total amount
        if ($row = $result->fetch_assoc()) {
            $totalAmount += $row['bill_freight'];
        }
        
        $stmt->close();
    }
    
    return $totalAmount;
}

function insertPartyBill($conn, $party_bill_no, $partyName, $billAmount, $attachment, $party_bill_date) {
    // Check if attachment was provided
    if (!empty($attachment['name'])) {
        // Define the target directory for uploads
        $targetDir = "uploads/";

        // Generate a unique file name for the uploaded attachment
        $targetFile = $targetDir . uniqid() . '_' . basename($attachment['name']);

        // Move the uploaded attachment to the target directory
        if (move_uploaded_file($attachment['tmp_name'], $targetFile)) {
            // Prepare the SQL statement
            $sql = "INSERT INTO party_bill (bill_number, party_id, bill_amount, attachment, bill_date) VALUES (?, ?, ?, ?, ?)";
            
            // Prepare and bind parameters
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sidss", $party_bill_no, $partyName, $billAmount, $targetFile, $party_bill_date);
        } else {
            // If moving the file fails, return false
            return false;
        }
    } else {
        // If no attachment provided, insert NULL for the attachment column
        // Prepare the SQL statement without the attachment parameter
        $sql = "INSERT INTO party_bill (bill_number, party_id, bill_amount, bill_date) VALUES (?, ?, ?, ?)";
        
        // Prepare and bind parameters without the attachment parameter
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sids", $party_bill_no, $partyName, $billAmount, $party_bill_date);
    }

    // Execute the statement
    if ($stmt->execute()) {
        // Return the ID of the inserted record
        return $stmt->insert_id;
    } else {
        // If insertion fails, return false
        return false;
    }
}




// Function to insert data into party_bill_lr table
function insertPartyBillLR($conn, $billId, $lrIds) {
    $sql = "INSERT INTO party_bill_lr (bill_id, lr_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    foreach ($lrIds as $lrId) {
        $stmt->bind_param("ii", $billId, $lrId);
        $stmt->execute();
    }
    $stmt->close();
}


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {

$partyName = isset($_POST['party_name']) ? $_POST['party_name'] : '';
$vehicleNumber = isset($_POST['vehicle_number']) ? $_POST['vehicle_number'] : '';
$startDate = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$endDate = isset($_POST['end_date']) ? $_POST['end_date'] : '';

// Store search criteria in session variables
$_SESSION['search_criteria'] = [
    'partyName' => $partyName

];

    // Conditions
if (!empty($partyName) && empty($vehicleNumber) && empty($startDate) && empty($endDate)) {
    // Search by Party Name Only
    $result = fetchTripsByPartyName($conn, $partyName);
} elseif (empty($partyName) && !empty($vehicleNumber) && empty($startDate) && empty($endDate)) {
    // Search by Vehicle Number Only
    $result = fetchTripsByVehicle($conn, $vehicleNumber);
} elseif (empty($partyName) && empty($vehicleNumber) && !empty($startDate) && !empty($endDate)) {
    // Search by Start Date and End Date Only
    $result = fetchTripsByDate($conn, $startDate, $endDate);
} elseif (!empty($partyName) && !empty($vehicleNumber) && empty($startDate) && empty($endDate)) {
    // Search by Party Name and Vehicle Number
    $result = fetchTripsByPartyNameAndVehicle($conn, $partyName, $vehicleNumber);
} elseif (!empty($partyName) && empty($vehicleNumber) && !empty($startDate) && empty($endDate)) {
    // Search by Party Name and Start Date
    echo "<script>alert('Please provide additional search criteria.')</script>";
} elseif (!empty($partyName) && empty($vehicleNumber) && empty($startDate) && !empty($endDate)) {
    // Search by Party Name and End Date
    echo "<script>alert('Please provide additional search criteria.')</script>";
} elseif (empty($partyName) && !empty($vehicleNumber) && !empty($startDate) && empty($endDate)) {
    // Search by Vehicle Number and Start Date
    echo "<script>alert('Please provide additional search criteria.')</script>";
} elseif (empty($partyName) && !empty($vehicleNumber) && empty($startDate) && !empty($endDate)) {
    // Search by Vehicle Number and End Date
    echo "<script>alert('Please provide additional search criteria.')</script>";
} elseif (!empty($partyName) && empty($vehicleNumber) && !empty($startDate) && !empty($endDate)) {
    // Search by Start Date, End Date, and Party Name
    $result = fetchTripsByPartyNameAndDate($conn, $partyName, $startDate, $endDate);
} elseif (empty($partyName) && !empty($vehicleNumber) && !empty($startDate) && !empty($endDate)) {
    // Search by Start Date, End Date, and Vehicle Number
    $result = fetchTripsByVehicleAndDate($conn, $vehicleNumber, $startDate, $endDate);
} elseif (!empty($partyName) && !empty($vehicleNumber) && !empty($startDate) && empty($endDate)) {
    // Search by Party Name, Vehicle Number, and Start Date
    $result = fetchTripsByPartyNameAndVehicle($conn, $partyName, $vehicleNumber);
} elseif (!empty($partyName) && !empty($vehicleNumber) && empty($startDate) && !empty($endDate)) {
    // Search by Party Name, Vehicle Number, and End Date
    $result = fetchTripsByPartyNameAndVehicle($conn, $partyName, $vehicleNumber);
} elseif (!empty($partyName) && !empty($vehicleNumber) && !empty($startDate) && !empty($endDate)) {
    // Search by Party Name, Vehicle Number, Start Date, and End Date
    $result = fetchTripsByPartyNameVehicleAndDate($conn, $partyName, $vehicleNumber, $startDate, $endDate);
} else {
    echo "<script>alert('Please provide at least one valid search criteria.')</script>";
}
  
}
 

// Function to update bill mode for LR IDs only when it changes
function updateBillMode($billMode, $lrIds, $conn) {
    foreach ($lrIds as $lrId) {
        // Retrieve the current bill mode for the LR ID from the database
        $sql = "SELECT bill_mode FROM trip_entry WHERE trip_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $lrId);
        $stmt->execute();
        $stmt->bind_result($currentBillMode);
        $stmt->fetch();
        $stmt->close();

        // Check if the new bill mode is different from the current one
        if ($currentBillMode !== $billMode) {
            // Update the bill mode in the database
            $sql = "UPDATE trip_entry SET bill_mode = ? WHERE trip_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $billMode, $lrId);
            $stmt->execute();
            $stmt->close();
        }
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['generate_bill'])) {

            // Retrieve form data
        $searchCriteria = $_SESSION['search_criteria'] ?? [];

       // Access individual search criteria
    $partyName = isset($searchCriteria['partyName']) ? $searchCriteria['partyName'] : '';
    $party_bill_no = isset($_POST['party_bill_no']) ? $_POST['party_bill_no'] : '';
    $party_bill_date = isset($_POST['party_bill_date']) ? $_POST['party_bill_date'] : '';
    $bill_mode = isset($_POST['bill_mode']) ? $_POST['bill_mode'] : '';
    $attachment = isset($_FILES['attachment']) ? $_FILES['attachment'] : '';
    $lrIds = isset($_POST['selectedLRs']) ? $_POST['selectedLRs'] : [];


      // Calculate total bill amount
    $billAmount = calculateBillAmount($conn, $lrIds);

    // Insert data into party_bill table
    $insertedBillId = insertPartyBill($conn, $party_bill_no, $partyName, $billAmount, $attachment ,$party_bill_date);
    

    // Check if insertion into party_bill table was successful
    if ($insertedBillId) {
        // Insert data into party_bill_lr table
        insertPartyBillLR($conn, $insertedBillId, $lrIds);
        updateBillMode($bill_mode, $lrIds, $conn);

        // Redirect to a success page or display a success message
        echo "<script>
    setTimeout(function() {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Bill generated successfully!',
            showConfirmButton: false,
            timer: 2000  // Adjust the timer as needed (in milliseconds)
        }).then(function() {
            window.location.href = 'party_bill_entry.php';
        });
    }, 3); // 3 milliseconds delay
</script>";
        
    } else {
        // Handle insertion failure
        echo "<script>alert('Failed to generate bill. Please try again.');</script>";
    }

    // Clear the session variables after generating the bill
    unset($_SESSION['search_criteria']);
}
 ?>
    
     <div id="preloader">
        <div class="spinner-border colorful-spinner" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

<?php
include('include/header.php');

?>

<main id="main" class="main">

<div class="pagetitle">
  <h1>Party Bill</h1>
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
       
         <form method="post" action="" class="search-form">
    <h5 class="text-left fw-bold">Search By :-</h5><br>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="party_name">Party Name:</label>
                <select name="party_name" class="form-select" id="party_name">
                    <option selected disabled>Select Party...</option>
                    <?php 
                    $party_list = fetchPartyData($conn);
                        foreach ($party_list as $party): ?>
                        <option value="<?= $party['id']; ?>"><?= $party['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="vehicle_number">Vehicle No. :</label>
                <select name="vehicle_number" class="form-select" id="vehicle_number">
                    <option selected disabled>Select vehicle...</option>
                    <?php 
                    $vehicle_list = fetchVehicles($conn);
                        foreach ($vehicle_list as $vehicle): ?>
                        <option value="<?= $vehicle['id']; ?>"><?= $vehicle['number']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="fdate">From:</label>
                <input type="date" class="form-control" id="fdate" name="fdate" value="<?php echo date('Y-m-d'); ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="tdate">To:</label>
                <input type="date" class="form-control" id="tdate" name="tdate" value="<?php echo date('Y-m-d'); ?>">
            </div>
        </div>
    </div>
        <div class="row">
        <div class="col-md-12 pt-3 text-center">
            <button type="submit" name="search" class="btn btn-lg btn-primary fw-semibold"><i class="fa-solid fa-magnifying-glass"></i>&nbsp;&nbsp;Search</button>
        </div>
    </div>
</form>

 <br>
          <!-- Table with stripped rows -->
          <div class="table-responsive">
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
          <!-- <hr> -->
    <table class="table datatable table-hover">
        <thead>
            <tr>
            <th scope="col" class="px-5"></th>
                <!-- <th scope="col" class="px-5">#</th> -->
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
                <th scope="col" class="px-5">Consignor Name</th>
                <th scope="col" class="px-5">Consignor Mobile</th>
                <th scope="col" class="px-5">Consignee Name</th>
                <th scope="col" class="px-5">Consignor Mobile</th>
                <th scope="col" class="px-5" >Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
// Check if $result is defined and not empty
if (isset($result) && $result->num_rows > 0) { ?>
    <!-- // $rowCount = 0; -->
    <div class="row">
         <div class="col-md-2">
            <div class="form-group">
                <label for="party_bill_no">Bill No:</label>
                <input type="text" class="form-control fw-bold" id="party_bill_no" name="party_bill_no" value="<?= $bill_number; ?>" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="party_bill_date">Bill Date:</label>
                <input type="text" class="form-control fw-bold" id="party_bill_date" name="party_bill_date" value="<?php echo date('Y-m-d'); ?>" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="party_bill_date">Bill Mode:</label>
                <select id="bill_mode" name="bill_mode" class="form-select fw-bold" required>
                    <option value="TO BE BILLED">TO BE BILLED</option>
                    <option value="TO PAY">TO PAY</option>
                    <option value="PAID">PAID</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="attachment">Add attachment:</label>
                <input type="file" class="form-control" id="attachment" name="attachment" accept="image/*, application/pdf">
            </div>
        </div>
    </div>
    <hr>
   <?php
    while ($row = $result->fetch_assoc()) {
        // $rowCount++;
?>
        <tr>
                <td class="px-5">
                    <input type="checkbox" class="custom-checkbox" name="selectedLRs[]" value="<?php echo $row['trip_id']; ?>">
                </td>
            <!-- <td class="px-5"><?php echo $rowCount; ?></td> -->
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
            <td class="px-5"><?php echo $row['consignor_name']; ?></td>
            <td class="px-5"><?php echo $row['consignor_mobile']; ?></td>
            <td class="px-5"><?php echo $row['consignee_name']; ?></td>
            <td class="px-5"><?php echo $row['consignor_mobile']; ?></td>
            <td class="px-5">
                <button class="btn btn-danger">
                    <i class="fa-solid fa-lock ms-auto"></i>
                </button>
            </td>
        </tr>
<?php 
    }
} else {
    // Handle case where $result is empty or not defined
    echo "<tr><td colspan='21'>No records found</td></tr>";
}
?>

        </tbody>
    </table>
</div>

<br>
<!-- End Table with stripped rows -->
<div class="text-center">
        <button type="submit" name="generate_bill" class="btn btn-lg btn-primary"><i class="fa-solid fa-circle-plus"></i>&nbsp;Generate Bill</button>
    </form>
</div>
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

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>