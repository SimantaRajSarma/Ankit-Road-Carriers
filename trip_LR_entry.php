<?php
error_reporting(0);
require_once('include/connection.php');

// Function to fetch vehicle numbers from the database
function fetchVehicleNumbers($conn) {
    $sql = "SELECT VehicleNo FROM vehicle";
    $result = $conn->query($sql);
    $vehicle_numbers = [];

    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {
            $vehicle_numbers[] = $row["VehicleNo"];
        }

    } else {
        $vehicle_numbers[] = "No vehicles found";
    }

    return $vehicle_numbers;
}

function generateLRNumber() {
  return mt_rand(1000, 100000);
}
$lr_number = generateLRNumber();


// Fetch Products
function fetchProductNames($conn) {
  $product_names = [];
  $sql = "SELECT product_name FROM products";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
          $product_names[] = $row["product_name"];
      }
  } else {
      $product_names[] = "No products found";
  }
  return $product_names;
}


// Main code to process form submission
if($_SERVER["REQUEST_METHOD"] == "POST") {


    header("Location: success.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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

    <script type="text/javascript" src="../lib/jquery.js"></script>
    <script type="text/javascript" src="../lib/main.js"></script>
  </head>
  <body>
    <?php include('include/header.php');  ?>

    <main id="main" class="main">
      <section class="section">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title text-center">Trip / LR Entry</h5>
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
                <div class="col-3">
                    <label for="vehicle_no" class="form-label fw-bold">Vehicle No :</label>
                    <select name="vehicle_no" class="form-select">
                        <option selected disabled>Select vehicle</option>
                        <?php 
                          $vehicle_numbers = fetchVehicleNumbers($conn);

                        foreach ($vehicle_numbers as $vehicle_number): ?>
                            <option value="<?php echo $vehicle_number; ?>"><?php echo $vehicle_number; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-3">
                  <label for="lr_date" class="form-label fw-bold">LR Date :</label>
                  <input
                      type="date"
                      name="lr_date"
                      class="form-control"
                      value="<?php echo date('Y-m-d'); ?>"
                      required
                  />
              </div>
             

            <div class="col-3">
    <label for="lr_type" class="form-label fw-bold">LR Type:</label>
    <select id="lr_type" name="lr_type" class="form-select" readonly>
        <option value="Single">Single</option>
        <option value="Multiple">Multiple</option>
       
    </select>
</div>


<div class="col-3">
                <label for="lr_number" class="form-label fw-bold">Agnst Trip ID :</label>
                <input
                    name="Agnst_Trip_ID"
                    class="form-control"
                    value=""
                    readonly
                />
            </div>





            
<div class="col-3">
                <label for="lr_number" class="form-label fw-bold">LR No :</label>
                <input
                type="number"
                    name="lr_number"
                    class="form-control"
                    value="<?= $lr_number; ?>"
                    readonly
                />
            </div>

            
            <div class="col-3">
                <label for="lr_number" class="form-label fw-bold">Chln No :</label>
                <input
                type="number"
                    name="Agnst_Trip_ID"
                    class="form-control"
                    value=""
                    
                />
            </div>


                    
            <div class="col-3">
                <label for="lr_number" class="form-label fw-bold">Loading Wt (MT) :</label>
                <input
                type="number"
                    name="Agnst_Trip_ID"
                    class="form-control"
                    value=""
                
                />
            </div>


                        
            <div class="col-3">
                <label for="lr_number" class="form-label fw-bold">Unload Wt (MT) :</label>
                <input
                type="number"
                    name="Agnst_Trip_ID"
                    class="form-control"
                    value=""
                    
                />
            </div>



            <div class="col-6">
                <label for="lr_number" class="form-label fw-bold">Product Name :</label>
                <input
                type="text"
                    name="product"
                    class="form-control"
                    value=""
                    
                />
            </div>


            



            
            <div class="col-3">
                <label for="lr_number" class="form-label fw-bold">Party Rate :</label>
                <input
                type="number"
                    name="product"
                    class="form-control"
                    value=""
                    
                />
            </div>


             
            <div class="col-3">
                <label for="lr_number" class="form-label fw-bold">Trptr Rate :</label>
                <input
                type="number"
                    name="product"
                    class="form-control"
                    value=""
                    
                />
            </div>

            <div class="col-3">
    <label for="from_state" class="form-label fw-bold">From State:</label>
    <select id="from_state" name="from_state" class="form-select">
        <option value="Andhra Pradesh">Andhra Pradesh</option>
        <option value="Arunachal Pradesh">Arunachal Pradesh</option>
        <option value="Assam">Assam</option>
        <option value="Bihar">Bihar</option>
        <option value="Chhattisgarh">Chhattisgarh</option>
        <option value="Goa">Goa</option>
        <option value="Gujarat">Gujarat</option>
        <option value="Haryana">Haryana</option>
        <option value="Himachal Pradesh">Himachal Pradesh</option>
        <option value="Jharkhand">Jharkhand</option>
        <option value="Karnataka">Karnataka</option>
        <option value="Kerala">Kerala</option>
        <option value="Madhya Pradesh">Madhya Pradesh</option>
        <option value="Maharashtra">Maharashtra</option>
        <option value="Manipur">Manipur</option>
        <option value="Meghalaya">Meghalaya</option>
        <option value="Mizoram">Mizoram</option>
        <option value="Nagaland">Nagaland</option>
        <option value="Odisha">Odisha</option>
        <option value="Punjab">Punjab</option>
        <option value="Rajasthan">Rajasthan</option>
        <option value="Sikkim">Sikkim</option>
        <option value="Tamil Nadu">Tamil Nadu</option>
        <option value="Telangana">Telangana</option>
        <option value="Tripura">Tripura</option>
        <option value="Uttar Pradesh">Uttar Pradesh</option>
        <option value="Uttarakhand">Uttarakhand</option>
        <option value="West Bengal">West Bengal</option>
        <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
        <option value="Chandigarh">Chandigarh</option>
        <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
        <option value="Delhi">Delhi</option>
        <option value="Lakshadweep">Lakshadweep</option>
        <option value="Puducherry">Puducherry</option>
    </select>
</div>

<div class="col-3">
    <label for="from_state" class="form-label fw-bold">To State:</label>
    <select id="from_state" name="from_state" class="form-select">
        <option value="Andhra Pradesh">Andhra Pradesh</option>
        <option value="Arunachal Pradesh">Arunachal Pradesh</option>
        <option value="Assam">Assam</option>
        <option value="Bihar">Bihar</option>
        <option value="Chhattisgarh">Chhattisgarh</option>
        <option value="Goa">Goa</option>
        <option value="Gujarat">Gujarat</option>
        <option value="Haryana">Haryana</option>
        <option value="Himachal Pradesh">Himachal Pradesh</option>
        <option value="Jharkhand">Jharkhand</option>
        <option value="Karnataka">Karnataka</option>
        <option value="Kerala">Kerala</option>
        <option value="Madhya Pradesh">Madhya Pradesh</option>
        <option value="Maharashtra">Maharashtra</option>
        <option value="Manipur">Manipur</option>
        <option value="Meghalaya">Meghalaya</option>
        <option value="Mizoram">Mizoram</option>
        <option value="Nagaland">Nagaland</option>
        <option value="Odisha">Odisha</option>
        <option value="Punjab">Punjab</option>
        <option value="Rajasthan">Rajasthan</option>
        <option value="Sikkim">Sikkim</option>
        <option value="Tamil Nadu">Tamil Nadu</option>
        <option value="Telangana">Telangana</option>
        <option value="Tripura">Tripura</option>
        <option value="Uttar Pradesh">Uttar Pradesh</option>
        <option value="Uttarakhand">Uttarakhand</option>
        <option value="West Bengal">West Bengal</option>
        <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
        <option value="Chandigarh">Chandigarh</option>
        <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
        <option value="Delhi">Delhi</option>
        <option value="Lakshadweep">Lakshadweep</option>
        <option value="Puducherry">Puducherry</option>
    </select>
</div>


<div class="col-3">
    <label for="rate_type" class="form-label fw-bold">Rate Type:</label>
    <select id="rate_type" name="rate_type" class="form-select">
        <option value="Type1">Weight</option>
        <option value="Type2">Trip</option>
        <option value="Type3">Capacity</option>
        <!-- Add more options as needed -->
    </select>
</div>



<div class="col-3">
    <label for="rate_type" class="form-label fw-bold">Rate Type:</label>
    <select id="rate_type" name="rate_type" class="form-select">
        <option value="Type1">Weight</option>
        <option value="Type2">Trip</option>
        <option value="Type3">Capacity</option>
        <!-- Add more options as needed -->
    </select>
</div>





            <div class="col-6">
    <label for="bill_mode" class="form-label fw-bold">Bill Mode:</label>
    <select id="bill_mode" name="bill_mode" class="form-select">
        <option value="TO BE BILLED">TO BE BILLED</option>
        <option value="TO PAY">TO PAY</option>
        <option value="PAID">PAID</option>
        <!-- Add more options as needed -->
    </select>
</div>


   
<div class="col-6">
                <label for="lr_number" class="form-label fw-bold">Driver Name :</label>
                <input
                type="text"
                    name="product"
                    class="form-control"
                    value=""
                    
                />
            </div>


            <div class="col-6">
                <label for="lr_number" class="form-label fw-bold">Party Name :</label>
                <input
                type="text"
                    name="product"
                    class="form-control"
                    value=""
                    
                />
            </div>


            <div class="col-6">
                <label for="lr_number" class="form-label fw-bold">Vehicle Owner :</label>
                <input
                type="text"
                    name="product"
                    class="form-control"
                    value=""
                    
                />
            </div>



            <div class="col-6">
                <label for="lr_number" class="form-label fw-bold">Bill No :</label>
                <input
                type="text"
                    name="product"
                    class="form-control"
                    value=""
                    
                />
            </div>


            <div class="col-6">
                <label for="lr_number" class="form-label fw-bold">Statement No :</label>
                <input
                type="text"
                    name="product"
                    class="form-control"
                    value=""
                    
                />
            </div>


            
            <div class="col-6">
                <label for="lr_number" class="form-label fw-bold">Bill Fright :</label>
                <input
                type="number"
                    name="product"
                    class="form-control"
                    value=""
                    readonly
                    
                />
            </div>

             
            <div class="col-6">
                <label for="lr_number" class="form-label fw-bold">Vehicle Fright :</label>
                <input
                type="number"
                    name="product"
                    class="form-control"
                    value=""
                    readonly
                    
                />
            </div>


            <div class="col-3">
                <label for="lr_number" class="form-label fw-bold">Balance Amount :</label>
                <input
                type="number"
                    name="product"
                    class="form-control"
                    value=""
                    readonly
                    
                />
            </div>

            <div class="col-3">
                <label for="lr_number" class="form-label fw-bold">Total Advance :</label>
                <input
                type="number"
                    name="product"
                    class="form-control"
                    value=""
                    readonly
                    
                />
            </div>



            <div class="col-3">
                <label for="lr_number" class="form-label fw-bold">Balance Anount :</label>
                <input
                type="number"
                    name="product"
                    class="form-control"
                    value=""
                    readonly
                    
                />
            </div>



            <div class="col-3">
                <label for="lr_number" class="form-label fw-bold">Total Advance :</label>
                <input
                type="number"
                    name="product"
                    class="form-control"
                    value=""
                    readonly
                    
                />
            </div>



            <hr>
            <h5 class="card-title text-center">Consignor Details</h5>


            <div class="col-3">
                <label for="lr_number" class="form-label fw-bold">Consignor Name :</label>
                <input
                type="number"
                    name="product"
                    class="form-control"
                    value=""
                  
                    
                />
            </div>



            <div class="col-3">
                <label for="lr_number" class="form-label fw-bold">Mobile No :</label>
                <input
                type="number"
                    name="product"
                    class="form-control"
                    value=""
                  
                    
                />
            </div>



            
            <div class="col-3">
                <label for="lr_number" class="form-label fw-bold">GSTIN NO :</label>
                <input
                type="text"
                    name="product"
                    class="form-control"
                    value=""
                  
                    
                />
            </div>


            <div class="col-3">
                <label for="lr_number" class="form-label fw-bold">Email :</label>
                <input
                type="email"
                    name="product"
                    class="form-control"
                    value=""
                  
                    
                />
            </div>



            <div class="col-12">
    <label for="client_address" class="form-label fw-bold">Address:</label>
    <textarea id="client_address" name="client_address" class="form-control" placeholder="Enter Client Address" rows="3"></textarea>
</div>

<h5 class="card-title text-center">Consignee / Buyer Details</h5>






<div class="col-3">
                <label for="lr_number" class="form-label fw-bold">Consignor Name :</label>
                <input
                type="number"
                    name="product"
                    class="form-control"
                    value=""
                  
                    
                />
            </div>



            <div class="col-3">
                <label for="lr_number" class="form-label fw-bold">Mobile No :</label>
                <input
                type="number"
                    name="product"
                    class="form-control"
                    value=""
                  
                    
                />
            </div>



            
            <div class="col-3">
                <label for="lr_number" class="form-label fw-bold">GSTIN NO :</label>
                <input
                type="text"
                    name="product"
                    class="form-control"
                    value=""
                  
                    
                />
            </div>


            <div class="col-3">
                <label for="lr_number" class="form-label fw-bold">Email :</label>
                <input
                type="email"
                    name="product"
                    class="form-control"
                    value=""
                  
                    
                />
            </div>


            
            <div class="col-6">
    <label for="client_address" class="form-label fw-bold">Address:</label>
    <textarea id="client_address" name="client_address" class="form-control" placeholder="Enter Client Address" rows="3"></textarea>
</div>



<div class="col-6">
    <label for="client_address" class="form-label fw-bold">Delivery Address:</label>
    <textarea id="client_address" name="client_address" class="form-control" placeholder="Enter Client Address" rows="3"></textarea>
</div>

                </div>
               
                 
        
               
 
                 
                 
                  <div class="text-center m-1">
                  <br>
          
                    <button
                      type="submit"
                      name="submit"
                      class="btn  btn-success "
                    >
                      Submit
                    </button>
                    <button type="reset" class="btn btn-secondary">
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


  </body>
</html>
