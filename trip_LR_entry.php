<?php
date_default_timezone_set('Asia/Kolkata');

error_reporting(E_ALL);
ini_set('display_errors', 1);
// error_reporting(0);
session_start();
include("include/connection.php");

if (!isset($_SESSION["admin_id"])) {
    header("location:index.php");
    exit();
}
include('pages/fetch_data.php');


// Function to generate a unique LR number
function generateLRNumber($conn) {
    // Get the current session (e.g., 23-24)
    $current_session = date('y') . '-' . (date('y') + 1);

    // Retrieve the maximum LR number for the current session from the database
    $query = "SELECT MAX(lr_no) AS max_lr FROM trip_entry WHERE lr_no LIKE 'ARC/$current_session/%'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $max_lr = $row['max_lr'];

    // If no LR number exists in the current session, start from 1
    if ($max_lr === null) {
        return "ARC/$current_session/0001";
    }

    // Extract the last four digits of the maximum LR number
    $last_four_digits = substr($max_lr, -4);

    // Increment the last four digits by 1 to get the next LR number
    $next_lr_number = str_pad(($last_four_digits + 1), 4, '0', STR_PAD_LEFT);

    // Return the unique LR number in the desired format
    return "ARC/$current_session/$next_lr_number";
}


$lr_number = generateLRNumber($conn);
  
// Function to store Consignor data
function storeConsignorData($conn, $data) {
    $sql = "INSERT INTO consignor_Details (Consignor_name, Consignor_mobile, Consignor_gstin, Consignor_email, Consignor_address) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $data['consignor_name'], $data['consignor_mobile'], $data['consignor_gstin'], $data['consignor_email'], $data['consignor_address']);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Return the auto-generated ID of the inserted record
        return $stmt->insert_id;
    } else {
        return null;
    }
}

// Function to store Consignee data
function storeConsigneeData($conn, $data) {
    $sql = "INSERT INTO consignee_Details (Consignee_name, Consignee_mobile, Consignee_gstin, Consignee_email, Consignee_address) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $data['consignee_name'], $data['consignee_mobile'], $data['consignee_gstin'], $data['consignee_email'], $data['consignee_address']);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Return the auto-generated ID of the inserted record
        return $stmt->insert_id;
    } else {
        return null;
    }
}

// Function to store trip data into the trip_entry table
function storeTripData($conn, $data) {
    $sql = "INSERT INTO trip_entry (vehicle_id, driver_id, party_id, product_id, lr_no, lr_date, lr_type, invoice_no, source, destination, bill_mode, against_trip_id, loading_wt, unload_wt, e_way_bill_no, e_way_bill_date, party_rate, trptr_rate, rate_type, bill_no, bill_freight, vehicle_freight, diesel_charges, pump_cash, cash_in_hand, rtgs_charge, unloading_charges, labour_charges, commission, advance_amount, Consignor_id, Consignee_id, remarks) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiisssssssiddisssssddddddddddiis", $data['vehicle_id'], $data['driver_id'], $data['party_id'], $data['product_id'], $data['lr_no'], $data['lr_date'], $data['lr_type'], $data['invoice_no'], $data['source'], $data['destination'], $data['bill_mode'], $data['against_trip_id'], $data['loading_wt'], $data['unload_wt'], $data['e_way_bill_no'], $data['e_way_bill_date'], $data['party_rate'], $data['trptr_rate'], $data['rate_type'], $data['bill_no'], $data['bill_freight'], $data['vehicle_freight'], $data['diesel_charges'], $data['pump_cash'], $data['cash_in_hand'], $data['rtgs_charge'], $data['unloading_charges'], $data['labour_charges'], $data['commission'],$data['advance_amount'], $data['Consignor_id'], $data['Consignee_id'], $data['remarks']);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        return "Data inserted successfully!";
    } else {
        return "Error: " . $conn->error;
    }

    $stmt->close();
}


// Function to fetch consignor ID based on consignor name
function fetchConsignorId($conn, $consignor_name) {
    $sql = "SELECT Consignor_id FROM consignor_Details WHERE Consignor_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $consignor_name);
    $stmt->execute();
    $stmt->bind_result($consignor_id);
    $stmt->fetch();
    $stmt->close();
    return $consignor_id ? $consignor_id : false;
}

// Function to fetch consignee ID based on consignee name
function fetchConsigneeId($conn, $consignee_name) {
    $sql = "SELECT Consignee_id FROM consignee_Details WHERE Consignee_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $consignee_name);
    $stmt->execute();
    $stmt->bind_result($consignee_id);
    $stmt->fetch();
    $stmt->close();
    return $consignee_id ? $consignee_id : false;
}



// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Retrieve and sanitize form data for Consignor
    $consignor_name = $_POST['consignor_name'];
    $consignee_name = $_POST['consignee_name'];
    
    // Check if consignor exists in the database
    $consignor_id = fetchConsignorId($conn, $consignor_name);
    
    // Check if consignee exists in the database
    $consignee_id = fetchConsigneeId($conn, $consignee_name);
    
    // If consignor does not exist, store consignor data
    if (!$consignor_id) {
        $consignor_data = array(
            'consignor_name' => $consignor_name,
            'consignor_mobile' => $_POST['consignor_mobile'],
            'consignor_gstin' => $_POST['consignor_gstin'],
            'consignor_email' => $_POST['consignor_email'],
            'consignor_address' => $_POST['consignor_address']
        );
        $consignor_id = storeConsignorData($conn, $consignor_data);
    }
    
    // If consignee does not exist, store consignee data
    if (!$consignee_id) {
        $consignee_data = array(
            'consignee_name' => $consignee_name,
            'consignee_mobile' => $_POST['consignee_mobile'],
            'consignee_gstin' => $_POST['consignee_gstin'],
            'consignee_email' => $_POST['consignee_email'],
            'consignee_address' => $_POST['consignee_address']
        );
        $consignee_id = storeConsigneeData($conn, $consignee_data);
    }

    // Construct $trip_data array with Consignor and Consignee IDs
    $trip_data = array(
        'vehicle_id' => $_POST['vehicle_no'],
        'driver_id' => $_POST['driver_name'],
        'party_id' => $_POST['party_name'],
        'product_id' => $_POST['product_name'],
        'lr_no' => $_POST['lr_number'],
        'lr_date' => $_POST['lr_date'],
        'lr_type' => $_POST['lr_type'],
        'invoice_no' => $_POST['invoice_no'],
        'source' => $_POST['source'],
        'destination' => $_POST['destination'],
        'bill_mode' => $_POST['bill_mode'],
        'against_trip_id' => $_POST['against_trip_id'],
        'loading_wt' => $_POST['loading_wt'],
        'unload_wt' => $_POST['unload_wt'],
        'e_way_bill_no' => $_POST['e_way_bill_no'],
        'e_way_bill_date' => $_POST['e_way_bill_date'],
        'party_rate' => $_POST['party_rate'],
        'trptr_rate' => $_POST['transporter_rate'],
        'rate_type' => $_POST['party_rate_type'],
        'bill_freight' => $_POST['bill_freight'],
        'vehicle_freight' => $_POST['vehicle_freight'],
        'diesel_charges' => $_POST['diesel_charges'],
        'pump_cash' => $_POST['pump_cash'],
        'cash_in_hand' => $_POST['cash_in_hand'],
        'rtgs_charge' => $_POST['rtgs_charge'],
        'unloading_charges' => $_POST['unloading_charges'],
        'labour_charges' => $_POST['labour_charges'],
        'commission' => $_POST['commission'],
        'advance_amount' => $_POST['advance_amount'],
        'Consignor_id' => $consignor_id,
        'Consignee_id' => $consignee_id,
        'remarks' => $_POST['remarks']
    );

    // Call the function to store the trip data
    $result = storeTripData($conn, $trip_data);
    
    // Echo JavaScript code with setTimeout function and redirect
echo "<script>
    setTimeout(function() {
        alert('$result');
        window.location.href = 'trip_Lr_entry.php';
    }, 3); // 3 milliseconds delay
</script>";

}
?>




<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>Trip - LR Entry</title>
    <!-- Google Fonts -->
    <script src="assets/vendor/fontawesome/fontawesome.js"></script>
    <link href="https://fonts.gstatic.com" rel="preconnect" />
    <link
      href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
      rel="stylesheet"
    />

    <!-- Vendor CSS Files -->
    <link
      href="assets/vendor/bootstrap/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="assets/vendor/bootstrap-icons/bootstrap-icons.css"
      rel="stylesheet"
    />
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet" />

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet" />


    <style>
.other_charges {
  background-color: #DAF5FF !important;
}

.other_charges:focus {
  background-color: #DAF5FF !important;
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
    <?php include('include/header.php');  ?>

    <main id="main" class="main">
      <section class="section">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body pb-3">
                <h5 class="card-title text-center pb-5">Trip / LR Entry</h5>
                <!-- <div class="alert alert-success alert-dismissible fade show" role="alert">
        Hello
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> -->
                <!-- Vertical Form -->
                <form
                  class="row g-3"
                  method="post"
                  enctype="multipart/form-data"
                  action=""

                >
                <div class="row">
                <div class="col-md-3 col-sm-12 pb-3">
                    <label for="vehicle_no" class="form-label fw-bold">Vehicle No :</label>
                 <select name="vehicle_no" class="form-select" id="vehicle_no" required>
                    <option selected disabled value="">Select vehicle...</option>
                    <?php 
                    $vehicle_list = fetchVehicles($conn);
                        foreach ($vehicle_list as $vehicle): ?>
                        <option value="<?= $vehicle['id']; ?>"><?= $vehicle['number']; ?></option>
                    <?php endforeach; ?>
                </select>
                </div>

                <div class="col-md-3 col-sm-12 pb-3">
                  <label for="lr_date" class="form-label fw-bold">LR Date :</label>
                  <input
                      type="date"
                      name="lr_date"
                      class="form-control"
                      value="<?php echo date('Y-m-d'); ?>"
                      required
                  />
              </div>
             

            <div class="col-md-3 col-sm-12 pb-3">
    <label for="lr_type" class="form-label fw-bold">LR Type:</label>
    <select id="lr_type" name="lr_type" class="form-select fw-semibold">
        
        <option value="Single">Single</option>
         <option value="Multiple">Multiple</option> 
       
    </select>
</div>


<div class="col-md-3 col-sm-12 pb-3">
                <label for="against_trip_id" class="form-label fw-bold">Agnst Trip ID :</label>
                <input
                    type="number"
                    name="against_trip_id"
                    class="form-control other_charges"
                    value=""
                    placeholder="trip id"
                    readonly
                />
            </div>

    
<div class="col-md-3 col-sm-12 pb-3">
                <label for="lr_number" class="form-label fw-bold">LR No :</label>
                <input
                type="text"
                    name="lr_number"
                    class="form-control other_charges"
                    value="<?= $lr_number; ?>"
                   readonly
                />
            </div>

            
            <div class="col-md-3 col-sm-12 pb-3">
                <label for="invoice_no" class="form-label fw-bold">Invoice No :</label>
                <input
                type="text"
                    name="invoice_no"
                    class="form-control"
                    placeholder="Enter Invoice No"
                    required
                />
            </div>

                    
            <div class="col-md-3 col-sm-12 pb-3">
    <label for="loading_wt" class="form-label fw-bold">Loading Wt (KG) :</label>
    <input
        type="number"
        id="loading_wt"
        name="loading_wt"
        class="form-control"
        value=""
        placeholder="Loading weight"
        step="0.001"
        required
         min="0"
    />
</div>


                        
<div class="col-md-3 col-sm-12 pb-3">
    <label for="unload_wt" class="form-label fw-bold">Unload Wt (KG) :</label>
    <input
        type="number"
        id="unload_wt"
        name="unload_wt"
        class="form-control"
        value=""
        placeholder="Unload weight"
        required
       step="0.001"
        min="0"
    />
</div>

<div class="col-md-6 col-sm-12 pb-3">
                <label for="e_way_bill_no" class="form-label fw-bold">E Way Bill No. :</label>
                <input
                type="number"
                    name="e_way_bill_no"
                    class="form-control"
                    value=""
                    placeholder="E Way bill number..."
                    min="0" required
                />
            </div>

            
            <div class="col-md-6 col-sm-12 pb-3">
                <label for="e_way_bill_date" class="form-label fw-bold">E Way Bill Date :</label>
                <input
                type="date"
                    name="e_way_bill_date" required
                    class="form-control"
                    value="<?php echo date('Y-m-d'); ?>"
                />
            </div>




            <div class="col-md-6 col-sm-12 pb-3">
                <label for="product_name" class="form-label fw-bold">Product Name :</label>
                <select name="product_name" class="form-select">
                    <option selected disabled>Select product...</option>
                    <?php 
                    $product_list = fetchProducts($conn);
                        foreach ($product_list as $product): ?>
                        <option value="<?= $product['id']; ?>"><?= $product['name']; ?></option>
                    <?php endforeach; ?>
               </select>
            </div>

            
            <div class="col-md-3 col-sm-12 pb-3">
    <label for="party_rate" class="form-label fw-bold">Party Rate :</label>
    <input
        type="number"
        id="party_rate"
        name="party_rate"
        class="form-control"
        value=""
        placeholder="Party Rate..."
        min="0"
        step="0.001"
    />
</div>
    
<div class="col-md-3 col-sm-12 pb-3">
    <label for="transporter_rate" class="form-label fw-bold">Trptr Rate :</label>
    <input
        type="number"
        id="transporter_rate"
        name="transporter_rate"
        class="form-control"
        value=""
        placeholder="Transporter Rate..."
        min="0"
        step="0.001"
    />
</div>

            <div class="col-md-3 col-sm-12 pb-3">
    <label for="source" class="form-label fw-bold">Source:</label>
    <input type="text" name="source" class="form-control" placeholder="Enter Source..." required>
</div>

<div class="col-md-3 col-sm-12 pb-3">
    <label for="destination" class="form-label fw-bold">Destination</label>
    <input type="text" name="destination" class="form-control" placeholder="Enter Destination..." required>
</div>


<div class="col-md-3 col-sm-12 pb-3">
    <label for="party_rate_type" class="form-label fw-bold">Party Rate Type:</label>
    <input
        type="text"
        name="party_rate_type"
        class="form-control fw-semibold"
        value="Weight"  
        readonly   
     />
</div>



<div class="col-md-3 col-sm-12 pb-3">
    <label for="transporter_rate_type" class="form-label fw-bold">Trptr Rate Type:</label>
    <input
        type="text"
        name="transporter_rate_type"
        class="form-control fw-semibold"
        value="Weight"
        readonly
    />
</div>



            <div class="col-md-6 col-sm-12 pb-3">
    <label for="bill_mode" class="form-label fw-bold">Bill Mode:</label>
    <select id="bill_mode" name="bill_mode" class="form-select" required>
        <option value="TO BE BILLED">TO BE BILLED</option>
        <option value="TO PAY">TO PAY</option>
        <option value="PAID">PAID</option>
        <!-- Add more options as needed -->
    </select>
</div>


   <div class="col-md-6 col-sm-12 pb-3">
    <label for="driver_name" class="form-label fw-bold">Driver Name :</label>
    <select name="driver_name" class="form-select" required>
        <option value="" selected disabled>Select driver...</option>
        <?php 
        $driver_data = fetchDriverData($conn);
        foreach ($driver_data as $driver): ?>
            <option value="<?= $driver['id']; ?>"><?= $driver['name']; ?>( <?= isset($driver['phone']) ? $driver['phone'] : ''; ?> )</option>
        <?php endforeach; ?>
    </select>
    
    
    
</div>



            <div class="col-md-6 col-sm-12 pb-3">
    <label for="party_name" class="form-label fw-bold">Party Name : (For Billing)</label>
    <select name="party_name" class="form-select" required>
        <option value="" selected disabled>Select party...</option>
        <?php 
        $party_data = fetchPartyData($conn);
        foreach ($party_data as $party): ?>
            <option value="<?= $party['id']; ?>"><?= $party['name']; ?></option>
        <?php endforeach; ?>
    </select>
</div>

            
            


            <div class="col-md-6 col-sm-12 pb-3">
                <label for="vehicle_owner" class="form-label fw-bold">Vehicle Owner :</label>
                <input
                type="text"
                    name="vehicle_owner"
                    class="form-control fw-semibold other_charges"
                    id="vehicle_owner"
                    
                />
            </div>
    
            <div class="col-md-6 col-sm-12 pb-3">
            <label for="bill_freight" class="form-label fw-bold">Bill Freight :</label>
                <input
                    style="background-color: #C3ACD0"
                    type="number"
                    id="bill_freight"
                    name="bill_freight"
                    class="form-control fw-medium"
                    value=""
                    readonly
                />
        </div>


             
        <div class="col-md-6 col-sm-12 pb-3">
    <label for="vehicle_freight" class="form-label fw-bold">Vehicle Freight :</label>
    <input
    style="background-color: #C3ACD0"
        type="number"
        id="vehicle_freight"
        name="vehicle_freight"
        class="form-control fw-medium"
        value=""
        readonly
    />
</div>

<!-- Other Charges -->
<div class="col-md-4 col-sm-12 pb-3">
            <label for="diesel_charges" class="form-label fw-bold">Diesel Charge :</label>
                <input
                    type="number"
                    id="diesel_charges"
                    name="diesel_charges"
                    class="form-control fw-medium other_charges"
                    value=""
                    min="0"
                    
                />
        </div>

        <div class="col-md-4 col-sm-12 pb-3">
            <label for="pump_cash" class="form-label fw-bold">Pump Cash :</label>
                <input
                    type="number"
                    id="pump_cash"
                    name="pump_cash"
                    class="form-control fw-medium other_charges"
                    value=""
                    min="0"
                    
                />
        </div>

        <div class="col-md-4 col-sm-12 pb-3">
            <label for="cash_in_hand" class="form-label fw-bold">Case in Hand :</label>
                <input
                    type="number"
                    id="cash_in_hand"
                    name="cash_in_hand"
                    class="form-control fw-medium other_charges"
                    value=""
                    min="0"
                    
                />
        </div>

        <div class="col-md-4 col-sm-12 pb-3">
            <label for="rtgs_charge" class="form-label fw-bold">RTGS Charge :</label>
                <input
                    type="number"
                    id="rtgs_charge"
                    name="rtgs_charge"
                    class="form-control fw-medium other_charges"
                    value=""
                    min="0"
                />
        </div>

        <div class="col-md-4 col-sm-12 pb-3">
            <label for="unloading_charges" class="form-label fw-bold">Unloading Charge :</label>
                <input
                    type="number"
                    id="unloading_charges"
                    name="unloading_charges"
                    class="form-control fw-medium other_charges"
                    value=""
                    min="0" 
                />
        </div>

        <div class="col-md-4 col-sm-12 pb-3">
            <label for="labour_charges" class="form-label fw-bold">Labour Charge :</label>
                <input
                    type="number"
                    id="labour_charges"
                    name="labour_charges"
                    class="form-control fw-medium other_charges"
                    value=""
                    min="0"
                />
        </div>
        <div class="col-md-4 col-sm-12 pb-3">
            <label for="commission" class="form-label fw-bold">Commission :</label>
                <input
                    type="number"
                    id="commission"
                    name="commission"
                    class="form-control fw-medium other_charges"
                    value=""
                    min="0"
                />
        </div>

            <div class="row pb-3">
            <div class="col-md-3 col-sm-12 pb-3">
                <label for="bill_balance_amount" class="form-label fw-bold">Balance Amount :</label>
                <input
                type="number"
                    name="bill_balance_amount"
                    class="form-control"
                    id="bill_balance_amount"
                    value=""
                    readonly
                    
                />
            </div>

            <div class="col-md-3 col-sm-12 pb-3">
                <label for="bill_total_advance" class="form-label fw-bold">Total Advance :</label>
                <input
                type="number"
                    name="bill_total_advance"
                    class="form-control"
                    value=""
                    readonly
                    
                />
            </div>



            <div class="col-md-3 col-sm-12 pb-3">
                <label for="statement_balance_amount" class="form-label fw-bold">Balance Anount :</label>
                <input
                type="number"
                    name="statement_balance_amount"
                    class="form-control"
                    id="statement_balance_amount"
                    value=""
                    readonly
                    
                />
            </div>



            <div class="col-md-3 col-sm-12 pb-3">
                <label for="statement_total_advance" class="form-label fw-bold">Total Advance :</label>
                <input
                type="number" id="advancefr"
                    name="advance_amount"
                    class="form-control"
                    value=""
                    readonly
                    
                />
            </div>
    </div>

            
            <h5 class="card-title text-center">Consignor Details</h5>

            <div class="col-md-3 col-sm-12 pb-3">
              <label for="consignor_select" class="form-label fw-bold form-label-sm">Select Consignor:</label>
              <select id="consignor_select" class="form-select form-control-sm">
                  <option value="">Select Consignor</option>
                  <!-- Consignor names will be dynamically populated here -->
              </select>
          </div>
            <div class="col-md-3 col-sm-12 pb-3">
                <label for="consignor_name" class="form-label fw-bold">Consignor Name :</label>
                <input
                type="text"
                    name="consignor_name"
                    class="form-control"
                    value="" 
                    required
                    placeholder="Enter Consignor Name..."
                    id="consignor_name"  
                />
            </div>



            <div class="col-md-3 col-sm-12 pb-3">
                <label for="consignor_mobile" class="form-label fw-bold">Mobile No :</label>
                <input
                type="number"
                    name="consignor_mobile"
                    class="form-control"
                    value="" required
                    placeholder="Consignor mobile no..."
                    id="consignor_mobile"
                />
            </div>



            
            <div class="col-md-3 col-sm-12 pb-3">
                <label for="consignor_gstin" class="form-label fw-bold">GSTIN NO :</label>
                <input
                type="text"
                    name="consignor_gstin"
                    class="form-control"
                    value="" required
                    placeholder="Enter GSTIN..."
                    id="consignor_gstin"
                />
            </div>


            <div class="col-md-3 col-sm-12 pb-3">
                <label for="consignor_email" class="form-label fw-bold">Email :</label>
                <input
                type="email"
                    name="consignor_email"
                    class="form-control"
                    value=""
                    placeholder="example@gmail.com"
                    id="consignor_email"
                />
            </div>



            <div class="col-12 pb-3">
    <label for="consignor_address" class="form-label fw-bold">Address:</label>
    <textarea id="consignor_address" name="consignor_address" class="form-control" placeholder="Enter Client Address" rows="3"></textarea>
</div>

<h5 class="card-title text-center">Consignee Details</h5>

        <div class="col-md-3 col-sm-12 pb-3">
              <label for="consignee_select" class="form-label fw-bold">Select Consignee:</label>
              <select id="consignee_select" class="form-select form-control-sm">
                  <option value="">Select Consignee</option>
                  <!-- Consignee names will be dynamically populated here -->
              </select>
          </div>
             <div class="col-md-3 col-sm-12 pb-3">
                <label for="consignee_name" class="form-label fw-bold">Consignee Name :</label>
                <input
                type="text"
                    name="consignee_name"
                    class="form-control"
                    value="" required
                    placeholder="Enter Consignee Name..."
                    id="consignee_name"
                />
            </div>



            <div class="col-md-3 col-sm-12 pb-3">
                <label for="consignee_mobile" class="form-label fw-bold">Mobile No :</label>
                <input
                type="number" required
                    name="consignee_mobile"
                    class="form-control"
                    value=""
                    placeholder="Consignee Mobile No..."
                    id="consignee_mobile"
                />
            </div>



            
            <div class="col-md-3 col-sm-12 pb-3">
                <label for="consignee_gstin" class="form-label fw-bold">GSTIN NO :</label>
                <input
                type="text"
                    name="consignee_gstin" 
                    required
                    class="form-control"
                    value=""
                    placeholder="GSTIN"
                    id="consignee_gstin"
                />
            </div>


            <div class="col-md-3 col-sm-12 pb-3">
                <label for="consignee_email" class="form-label fw-bold">Email :</label>
                <input
                type="email"
                    name="consignee_email"
                    class="form-control"
                    value=""
                    placeholder="example@gmail.com"  
                    id="consignee_email" 
                />
            </div>
            
            <div class="col-12 pb-3">
    <label for="consignee_address" class="form-label fw-bold">Address:</label>
    <textarea id="consignee_address" name="consignee_address" class="form-control" placeholder="Enter Client Address" rows="3"></textarea>
</div>

<div class="col-12 pb-3">
    <label for="remarks" class="form-label fw-bold">Remarks:</label>
    <textarea id="remarks" name="remarks" class="form-control" placeholder="Remarks..." rows="3"></textarea>
</div>

                </div>   
                  <div class="text-center m-1">
                  <br>
          
                    <button
                      type="submit"
                      name="submit"
                      class="btn btn-primary shadow"
                    >
                <i class="fa-solid fa-circle-plus"></i>&nbsp;Generate Bilty
                    </button>
                    <button type="reset" class="btn btn-lg btn-secondary">
                      Reset
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
    <!-- End #main -->

    <?php include('include/footer.php');  ?>
    <a
      href="#"
      class="back-to-top d-flex align-items-center justify-content-center"
      ><i class="bi bi-arrow-up-short"></i
    ></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>
    <!-- <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script> -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
    <script src="pages/validate.js"></script>
      <!-- AJax caller -->
    <script src="pages/caller.js"></script>
    <script>
// Function to calculate the sum of all input values
function calculateAdvanceFreight() {
    // Get the values from the input boxes
    var dieselCharges = parseFloat(document.getElementById("diesel_charges").value) || 0;
    var pumpCash = parseFloat(document.getElementById("pump_cash").value) || 0;
    var cashInHand = parseFloat(document.getElementById("cash_in_hand").value) || 0;
    var rtgsCharge = parseFloat(document.getElementById("rtgs_charge").value) || 0;
    var unloadingCharges = parseFloat(document.getElementById("unloading_charges").value) || 0;
    var labourCharges = parseFloat(document.getElementById("labour_charges").value) || 0;
    var commission = parseFloat(document.getElementById("commission").value) || 0;
    
    // Calculate the sum
    var advanceFreight = dieselCharges + pumpCash + cashInHand + rtgsCharge + unloadingCharges + labourCharges + commission;
    
    // Update the value of the advancefr input box
    document.getElementById("advancefr").value = advanceFreight.toFixed(2);
}

// Listen for changes in all input boxes
document.getElementById("diesel_charges").addEventListener("input", calculateAdvanceFreight);
document.getElementById("pump_cash").addEventListener("input", calculateAdvanceFreight);
document.getElementById("cash_in_hand").addEventListener("input", calculateAdvanceFreight);
document.getElementById("rtgs_charge").addEventListener("input", calculateAdvanceFreight);
document.getElementById("unloading_charges").addEventListener("input", calculateAdvanceFreight);
document.getElementById("labour_charges").addEventListener("input", calculateAdvanceFreight);
document.getElementById("commission").addEventListener("input", calculateAdvanceFreight);

// Initial calculation
calculateAdvanceFreight();
</script>

  </body>
</html>
