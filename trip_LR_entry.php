<?php
date_default_timezone_set('Asia/Kolkata');

error_reporting(0);
require_once('include/connection.php');
include('pages/fetch_data.php');

    // Generate LR number
  $lr_number = generateLRNumber();
  
 // Function to store trip data into the trip_entry table
function storeTripData($conn, $data) {
    
    $sql = "INSERT INTO trip_entry (vehicle_id, driver_id, party_id, product_id, lr_no, lr_date, lr_type, challan_no, source, destination, bill_mode, against_trip_id, loading_wt, unload_wt, party_rate, trptr_rate, rate_type, bill_no, statement_no, bill_freight, vehicle_freight, consignor_name, consignor_mobile, consignor_gstin, consignor_email, consignor_address, consignee_name, consignee_mobile, consignee_gstin, consignee_email, consignee_address, delivery_address, remarks) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiisssssssiddddsssddssssssssssss", $data['vehicle_id'], $data['driver_id'], $data['party_id'], $data['product_id'], $data['lr_no'], $data['lr_date'], $data['lr_type'], $data['challan_no'], $data['source'], $data['destination'], $data['bill_mode'], $data['against_trip_id'], $data['loading_wt'], $data['unload_wt'], $data['party_rate'], $data['trptr_rate'], $data['rate_type'], $data['bill_no'], $data['statement_no'], $data['bill_freight'], $data['vehicle_freight'], $data['consignor_name'], $data['consignor_mobile'], $data['consignor_gstin'], $data['consignor_email'], $data['consignor_address'], $data['consignee_name'], $data['consignee_mobile'], $data['consignee_gstin'], $data['consignee_email'], $data['consignee_address'], $data['delivery_address'], $data['remarks']);
    $stmt->execute();

    // Check if the query was successful
    if ($stmt->affected_rows > 0) {
        return "Data inserted successfully!";
    } else {
        return "Error: " . $conn->error;
    }

    // Close the statement
    $stmt->close();
}


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $data = array(
        'vehicle_id' => $_POST['vehicle_no'],
        'driver_id' => $_POST['driver_name'],
        'party_id' => $_POST['party_name'],
        'product_id' => $_POST['product_name'],
        'lr_no' => $_POST['lr_number'],
        'lr_date' => $_POST['lr_date'],
        'lr_type' => $_POST['lr_type'],
        'challan_no' => $_POST['challan_no'],
        'source' => $_POST['source'],
        'destination' => $_POST['destination'],
        'bill_mode' => $_POST['bill_mode'],
        'against_trip_id' => $_POST['against_trip_id'],
        'loading_wt' => $_POST['loading_wt'],
        'unload_wt' => $_POST['unload_wt'],
        'party_rate' => $_POST['party_rate'],
        'trptr_rate' => $_POST['transporter_rate'],
        'rate_type' => $_POST['party_rate_type'],
        'bill_no' => $_POST['bill_no'],
        'statement_no' => $_POST['statement_no'],
        'bill_freight' => $_POST['bill_freight'],
        'vehicle_freight' => $_POST['vehicle_freight'],
        'consignor_name' => $_POST['consignor_name'],
        'consignor_mobile' => $_POST['consignor_mobile'],
        'consignor_gstin' => $_POST['consignor_gstin'],
        'consignor_email' => $_POST['consignor_email'],
        'consignor_address' => $_POST['consignor_address'],
        'consignee_name' => $_POST['consignee_name'],
        'consignee_mobile' => $_POST['consignee_mobile'],
        'consignee_gstin' => $_POST['consignee_gstin'],
        'consignee_email' => $_POST['consignee_email'],
        'consignee_address' => $_POST['consignee_address'],
        'delivery_address' => $_POST['delivery_address'],
        'remarks' => $_POST['remarks']
    );
    

    // Call the function to store the trip data
    $result = storeTripData($conn, $data);
    
    echo "<script>alert('$result');</script>";

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


</style>
  </head>
  <body>
    <?php include('include/header.php');  ?>

    <main id="main" class="main">
      <section class="section">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
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
                <div class="col-md-3 col-sm-12">
                    <label for="vehicle_no" class="form-label fw-bold">Vehicle No :</label>
                 <select name="vehicle_no" class="form-select" id="vehicle_no" required>
                    <option selected disabled>Select vehicle...</option>
                    <?php 
                    $vehicle_list = fetchVehicles($conn);
                        foreach ($vehicle_list as $vehicle): ?>
                        <option value="<?= $vehicle['id']; ?>"><?= $vehicle['number']; ?></option>
                    <?php endforeach; ?>
                </select>
                </div>

                <div class="col-md-3 col-sm-12">
                  <label for="lr_date" class="form-label fw-bold">LR Date :</label>
                  <input
                      type="date"
                      name="lr_date"
                      class="form-control"
                      value="<?php echo date('Y-m-d'); ?>"
                      required
                  />
              </div>
             

            <div class="col-md-3 col-sm-12">
    <label for="lr_type" class="form-label fw-bold">LR Type:</label>
    <select id="lr_type" name="lr_type" class="form-select fw-semibold">
        
        <option value="Single">Single</option>
        <!-- <option value="Multiple">Multiple</option> -->
       
    </select>
</div>


<div class="col-md-3 col-sm-12">
                <label for="against_trip_id" class="form-label fw-bold">Agnst Trip ID :</label>
                <input
                    type="number"
                    name="against_trip_id"
                    class="form-control"
                    value=""
                    readonly
                />
            </div>

    
<div class="col-md-3 col-sm-12">
                <label for="lr_number" class="form-label fw-bold">LR No :</label>
                <input
                type="number"
                    name="lr_number"
                    class="form-control"
                    value="<?= $lr_number; ?>"
                    readonly
                />
            </div>

            
            <div class="col-md-3 col-sm-12">
                <label for="challan_no" class="form-label fw-bold">Chln No :</label>
                <input
                type="number"
                    name="challan_no"
                    class="form-control"
                    placeholder="challan number..."
                />
            </div>


                    
            <div class="col-md-3 col-sm-12">
    <label for="loading_wt" class="form-label fw-bold">Loading Wt (MT) :</label>
    <input
        type="number"
        id="loading_wt"
        name="loading_wt"
        class="form-control"
        value=""
        placeholder="Loading weight"
    />
</div>


                        
<div class="col-md-3 col-sm-12">
    <label for="unload_wt" class="form-label fw-bold">Unload Wt (MT) :</label>
    <input
        type="number"
        id="unload_wt"
        name="unload_wt"
        class="form-control"
        value=""
        placeholder="Unload weight"
    />
</div>



            <div class="col-md-3 col-sm-12">
                <label for="product_name" class="form-label fw-bold">Product Name :</label>
                <select name="product_name" class="form-select" required>
                    <option selected disabled>Select product...</option>
                    <?php 
                    $product_list = fetchProducts($conn);
                        foreach ($product_list as $product): ?>
                        <option value="<?= $product['id']; ?>"><?= $product['name']; ?></option>
                    <?php endforeach; ?>
               </select>
            </div>

            
            <div class="col-md-3 col-sm-12">
    <label for="party_rate" class="form-label fw-bold">Party Rate :</label>
    <input
        type="number"
        id="party_rate"
        name="party_rate"
        class="form-control"
        value=""
        placeholder="Party Rate..."
    />
</div>
    
<div class="col-md-3 col-sm-12">
    <label for="transporter_rate" class="form-label fw-bold">Trptr Rate :</label>
    <input
        type="number"
        id="transporter_rate"
        name="transporter_rate"
        class="form-control"
        value=""
        placeholder="Transporter Rate..."
    />
</div>

            <div class="col-md-3 col-sm-12">
    <label for="source" class="form-label fw-bold">Source:</label>
    <input type="text" name="source" class="form-control" placeholder="Enter Source...">
</div>

<div class="col-md-3 col-sm-12">
    <label for="destination" class="form-label fw-bold">Destination</label>
    <input type="text" name="destination" class="form-control" placeholder="Enter Destination...">
</div>


<div class="col-md-3 col-sm-12">
    <label for="party_rate_type" class="form-label fw-bold">Party Rate Type:</label>
    <input
        type="text"
        name="party_rate_type"
        class="form-control fw-semibold"
        value="Weight"  
        readonly   
     />
</div>



<div class="col-md-3 col-sm-12">
    <label for="transporter_rate_type" class="form-label fw-bold">Trptr Rate Type:</label>
    <input
        type="text"
        name="transporter_rate_type"
        class="form-control fw-semibold"
        value="Weight"
        readonly
    />
</div>





            <div class="col-md-6 col-sm-12">
    <label for="bill_mode" class="form-label fw-bold">Bill Mode:</label>
    <select id="bill_mode" name="bill_mode" class="form-select">
        <option value="TO BE BILLED">TO BE BILLED</option>
        <option value="TO PAY">TO PAY</option>
        <option value="PAID">PAID</option>
        <!-- Add more options as needed -->
    </select>
</div>


   
            <div class="col-md-6 col-sm-12">
                <label for="driver_name" class="form-label fw-bold">Driver Name :</label>
                <select name="driver_name" class="form-select" required>
                    <option selected disabled>Select driver...</option>
                    <?php 
                    $driver_data = fetchDriverData($conn);
                        foreach ($driver_data as $driver): ?>
                        <option value="<?= $driver['id']; ?>"><?= $driver['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>


            <div class="col-md-6 col-sm-12">
                <label for="party_name" class="form-label fw-bold">Party Name :</label>
                <select name="party_name" class="form-select">
                    <option selected disabled>Select Party...</option>
                    <?php 
                    $party_data = fetchPartyData($conn);
                        foreach ($party_data as $party): ?>
                        <option value="<?= $party['id']; ?>"><?= $party['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>


            <div class="col-md-6 col-sm-12">
                <label for="vehicle_owner" class="form-label fw-bold">Vehicle Owner :</label>
                <input
                type="text"
                    name="vehicle_owner"
                    class="form-control fw-semibold"
                    id="vehicle_owner"
                    readonly
                />
            </div>



            <div class="col-md-6 col-sm-12">
                <label for="bill_no" class="form-label fw-bold">Bill No :</label>
                <input
                type="text"
                    name="bill_no"
                    class="form-control"
                    value=""
                    readonly
                    
                />
            </div>


            <div class="col-md-6 col-sm-12">
                <label for="statement_no" class="form-label fw-bold">Statement No :</label>
                <input
                type="text"
                    name="statement_no"
                    class="form-control"
                    value=""
                    readonly
                    
                />
            </div>


            
            <div class="col-md-6 col-sm-12">
            <label for="bill_freight" class="form-label fw-bold">Bill Freight :</label>
                <input
                    type="number"
                    id="bill_freight"
                    name="bill_freight"
                    class="form-control fw-medium"
                    value=""
                    readonly
                />
        </div>

             
        <div class="col-md-6 col-sm-12">
    <label for="vehicle_freight" class="form-label fw-bold">Vehicle Freight :</label>
    <input
        type="number"
        id="vehicle_freight"
        name="vehicle_freight"
        class="form-control fw-medium"
        value=""
        readonly
    />
</div>


            <div class="col-md-3 col-sm-12">
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

            <div class="col-md-3 col-sm-12">
                <label for="bill_total_advance" class="form-label fw-bold">Total Advance :</label>
                <input
                type="number"
                    name="bill_total_advance"
                    class="form-control"
                    value=""
                    readonly
                    
                />
            </div>



            <div class="col-md-3 col-sm-12">
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



            <div class="col-md-3 col-sm-12">
                <label for="statement_total_advance" class="form-label fw-bold">Total Advance :</label>
                <input
                type="number"
                    name="statement_total_advance"
                    class="form-control"
                    value=""
                    readonly
                    
                />
            </div>



            <hr>
            <h5 class="card-title text-center">Consignor Details</h5>


            <div class="col-md-3 col-sm-12">
                <label for="consignor_name" class="form-label fw-bold">Consignor Name :</label>
                <input
                type="text"
                    name="consignor_name"
                    class="form-control"
                    value=""
                    placeholder="Enter Consignor Name..."  
                />
            </div>



            <div class="col-md-3 col-sm-12">
                <label for="consignor_mobile" class="form-label fw-bold">Mobile No :</label>
                <input
                type="number"
                    name="consignor_mobile"
                    class="form-control"
                    value=""
                    placeholder="Consignor mobile no..."
                />
            </div>



            
            <div class="col-md-3 col-sm-12">
                <label for="consignor_gstin" class="form-label fw-bold">GSTIN NO :</label>
                <input
                type="text"
                    name="consignor_gstin"
                    class="form-control"
                    value=""
                    placeholder="Enter GSTIN..."
                />
            </div>


            <div class="col-md-3 col-sm-12">
                <label for="consignor_email" class="form-label fw-bold">Email :</label>
                <input
                type="email"
                    name="consignor_email"
                    class="form-control"
                    value=""
                    placeholder="example@gmail.com"
                />
            </div>



            <div class="col-12">
    <label for="consignor_address" class="form-label fw-bold">Address:</label>
    <textarea id="consignor_address" name="consignor_address" class="form-control" placeholder="Enter Client Address" rows="3"></textarea>
</div>

<h5 class="card-title text-center">Consignee / Buyer Details</h5>






<div class="col-md-3 col-sm-12">
                <label for="consignee_name" class="form-label fw-bold">Consignee Name :</label>
                <input
                type="text"
                    name="consignee_name"
                    class="form-control"
                    value=""
                    placeholder="Enter Consignee Name..."
                />
            </div>



            <div class="col-md-3 col-sm-12">
                <label for="consignee_mobile" class="form-label fw-bold">Mobile No :</label>
                <input
                type="number"
                    name="consignee_mobile"
                    class="form-control"
                    value=""
                    placeholder="Consignee Mobile No..."
                />
            </div>



            
            <div class="col-md-3 col-sm-12">
                <label for="consignee_gstin" class="form-label fw-bold">GSTIN NO :</label>
                <input
                type="text"
                    name="consignee_gstin"
                    class="form-control"
                    value=""
                    placeholder="GSTIN"
                />
            </div>


            <div class="col-md-3 col-sm-12">
                <label for="consignee_email" class="form-label fw-bold">Email :</label>
                <input
                type="email"
                    name="consignee_email"
                    class="form-control"
                    value=""
                    placeholder="example@gmail.com"   
                />
            </div>


            
            <div class="col-6">
    <label for="consignee_address" class="form-label fw-bold">Address:</label>
    <textarea id="consignee_address" name="consignee_address" class="form-control" placeholder="Enter Client Address" rows="3"></textarea>
</div>



<div class="col-6">
    <label for="delivery_address" class="form-label fw-bold">Delivery Address:</label>
    <textarea id="delivery_address" name="delivery_address" class="form-control" placeholder="Enter Delivery Address" rows="3"></textarea>
</div>

<div class="col-12">
    <label for="remarks" class="form-label fw-bold">Remarks:</label>
    <textarea id="remarks" name="remarks" class="form-control" placeholder="Remarks..." rows="3"></textarea>
</div>

                </div>
               
                 
        
               
 
                 
                 
                  <div class="text-center m-1">
                  <br>
          
                    <button
                      type="submit"
                      name="submit"
                      class="btn btn-lg btn-primary shadow"
                    >
                      Submit
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

      <!-- AJax caller -->
    <script src="pages/caller.js"></script>

  </body>
</html>
