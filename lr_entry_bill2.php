<?php
error_reporting(0);

session_start();
include("include/connection.php");

if (!isset($_SESSION["admin_id"])) {
    header("location:index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>LR - Driver Copy</title>
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
                    <div class="card" id="data" >
                        <div class="card-body" style="border:2px solid black;">
                           
        
        <br>
           
                   
                       
                                <div class="invoice-title">
<div class="mb-4 text-center">
                                         <img src="assets/img/track01.jpg" style="width:120px; border-radius:50%; float: right; border:2px solid blue;" class="img-fluid">

<img class="img-fluid" width="100px" src="arc_logo.jpg">
<img src="assets/img/track03 .jpg" style="width:120px; height:120px; border-radius:50%; float: left; border:2px solid blue;" class="img-fluid">

                                       <h3 class="mb-1 fw-bold " style="color: #4682B4;">ANKIT ROAD CARRIER</h3>
                                     <h5 class="fw-bold" style="background-color: blue; color: white; border-radius: 10px; padding: 5px;">TRANSPORT CONTRACTOR & COMMISSION AGENT</h5>


                                       <p class="mb-1 fw-bold">Kamalpur,Rangia,Assam, MOB : 7099160142,7099161020,<br> 
                                       <span style="color: #4682B4;">EMAIL : ankitroadcarrier3@gmail.com,Website : www.ankitroadcarrier.in</span></p>
                                       
                                    </div>


        <hr>
                               
            
                                <div class="row">
                                    <?php
                                    include('include/connection.php');
                                    
// Check if trip_id is provided in the URL parameters
if(isset($_GET['trip_id'])) {
    // Sanitize the input to prevent SQL injection
    $trip_id = mysqli_real_escape_string($conn, $_GET['trip_id']);

    // Query to fetch data from trip_entry and party tables
    $query = "SELECT party.party_name, party.address, party.gstin, party.contact_phone, trip_entry.invoice_no, trip_entry.lr_date, trip_entry.lr_no, trip_entry.source, trip_entry.destination, trip_entry.loading_wt, trip_entry.party_rate, trip_entry.bill_freight, trip_entry.e_way_bill_no, consignee_Details.Consignee_name, vehicle.VehicleNo, products.product_name, driver.MobileNo, consignor_Details.Consignor_name, consignor_Details.Consignor_address, consignor_Details.Consignor_gstin,consignee_Details.Consignee_address
              FROM trip_entry
              INNER JOIN party ON trip_entry.party_id = party.party_id
              INNER JOIN consignee_Details ON trip_entry.Consignee_id = consignee_Details.Consignee_id
              INNER JOIN consignor_Details ON trip_entry.Consignor_id = consignor_Details.Consignor_id
              INNER JOIN vehicle ON trip_entry.vehicle_id = vehicle.VehicleID
              INNER JOIN products ON trip_entry.product_id = products.product_id
              INNER JOIN driver ON trip_entry.driver_id = driver.DriverID
              WHERE trip_entry.trip_id = '$trip_id'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        // Extract data from the fetched row
        $billedName = $row['party_name'];
        $address = $row['address'];
        $gstin = $row['gstin'];
        $contact_number = $row['contact_phone'];
        $bill_no = $row['invoice_no'];
        $lr_date = $row['lr_date'];
        $Consignee_name = $row['Consignee_name'];
        $lr_no = $row['lr_no'];
        $source = $row['source'];
        $destination = $row['destination'];
        $VehicleNo = $row['VehicleNo'];
        $MobileNo = $row['MobileNo'];
        $Consignor_name = $row['Consignor_name'];
        $Consignor_address = $row['Consignor_address'];
        $Consignor_gstin = $row['Consignor_gstin'];
        $product_name = $row['product_name'];
        $loading_wt = $row['loading_wt'];
        $party_rate = $row['party_rate'];
        $bill_freight = $row['bill_freight'];
        $invoice_no = $row['invoice_no'];
        $e_way_bill_no = $row['e_way_bill_no'];
        $Consignee_address=$row['Consignee_address'];
    } else {
        // Handle query error
        $billedName = "Unknown";
    }
} else {
    // Handle case when trip_id is not provided in the URL
    echo "Trip ID not provided!";
}
?>

  
                                  <div class="col-sm-4" style="border: 2px solid #4682B4; padding: 10px;">
    <div>
        <h3 class="font-size-20 fw-bold" style="color: #4682B4; border-bottom: 1px solid #4682B4;">Consignment Note</h3>
        <p class="mb-1" style="border-bottom: 1px dashed #4682B4; color: #4682B4; font-weight: bold;">GSTIN: 18JAZPS5085P1Z0</p>
        <p class="mb-1" style="border-bottom: 1px dashed #4682B4; color: #4682B4; font-weight: bold;">Pan No: JAZPS5085P</p>
        <p class="text-center" style="color: #4682B4; font-weight: bold;">GST PAYABLE</p>
    </div>
</div>
                        <div class="col-sm-4" style="border: 2px solid #4682B4; padding: 5px;">
        <div >
            <h5 class="font-size-20 fw-bold text-center" style="color: #4682B4;">AT OWNER'S RISK</h5>
       
                     <p class="mb-1 text-center fw-bold" style="color: #4682B4;">The Customer has stated that
he has not insured the consigment
OR He has insured the consignment</p>
                
            <p class="text-center fw-bold" style="color: #4682B4;" >    Company _________________________________</p>
             <p class="mb-1 text-center fw-bold" style="color: #4682B4;">   Policy No N/A</p>
              <p class="mb-1 text-center fw-bold" style="color: #4682B4;" >Amount ________________ &nbsp;Risk : N/A   </p>
                
              
              
               
                    </div>
    </div>
    
    
     <div class="col-sm-4">
    <div style="border: 2px solid #4682B4; padding: 5px;">
        <div>
            <h6 class="font-size-15 mb" style="border-bottom: 1px dashed #4682B4; color: #4682B4; font-weight: bold;">LR No : <?php echo  $lr_no; ?></h6>
            <h6 class="font-size-15 mb" style="border-bottom: 1px dashed #4682B4; color: #4682B4; font-weight: bold;">Date : <?php echo $lr_date; ?></h6>
            <h6 class="font-size-15 mb" style="border-bottom: 1px dashed #4682B4; color: #4682B4; font-weight: bold;">From : <?php echo  $source; ?></h6>
            <h6 class="font-size-15 mb" style="border-bottom: 1px dashed #4682B4; color: #4682B4; font-weight: bold;">To : <?php echo $destination; ?></h6>
            <h6 class="font-size-15 mb" style="border-bottom: 1px dashed #4682B4; color: #4682B4; font-weight: bold;">Truck No : <?php echo $VehicleNo; ?></h6>
            <h6 class="font-size-15 mb" style="color: #4682B4; font-weight: bold;">Driver No: <?php echo $MobileNo; ?></h6>
        </div>
    </div>
</div>

                                    <!-- end col -->
                                </div>
                                
                                <!-- end row -->
                            
    <hr mb-0>
                                <div class="py-2">
                                   
            
 <div class="row" style=" color: #4682B4;">
                                        <div class="col-md-6">
                                          <div class="box left">
                                         
<div class="text">
                 <h6 class="font-size-15 mb-1 fw-bold">Consignor : <?php echo $Consignor_name; ?></h6>
                  <h6 class="font-size-15 mb-1 fw-bold">Address : <?php echo $Consignor_address; ?></h6>
                  <br>
                   <h6 class="font-size-15 mb-1 fw-bold">GSTIN : <?php echo $Consignor_gstin; ?></h6>
                
</div>
                                          
                                          </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                          <div class="box right">
                                            <div class="text text-end">
                                                <h6 class=" mb-1 fw-bold"  style="color: #4682B4; font-size:20px;"><u>Buyer : <?php echo $billedName; ?></u></h6>
                                                  <h6 class="font-size-15 mb-1 fw-bold">Consignee : <?php echo  $Consignee_name; ?></h6>
                                                    <h6 class="font-size-15 mb-1 fw-bold">Address : <?php echo $Consignee_address; ?></h6>
                                                      <h6 class="font-size-15 mb-1 fw-bold">GSTIN : <?php echo $gstin; ?></h6>
                                              
                               </div>
                               
                                          </div>
                                        </div>
                                        <!--<h5 class="card-title">Amount In Word: THREE LAKHS FIFTY-SEVEN THOUSAND ONE HUNDRED TWENTY-NINE RUPEES ONLY</h5>-->
                                      </div>





                                   <div class="table-responsive">
    <table class="table table-bordered text-center" style="border: 2px solid  #4682B4; color: #4682B4;">
        <thead>
            <tr>
                <th rowspan="2">No of Pkgs</th>
                <th rowspan="2">DESCRIPTION (Said to contain)</th>
                <th colspan="2" width="10%" >Weight</th>
                <th rowspan="2">Rate</th>
                <th colspan="3">Freight</th>
            </tr>
            <tr>
                <th>Actual</th>
                <th>Charged</th>
                <th>  Rs     To Pay  </th>
                <th>PS </th>
                <th>RS     Paid</th>
               
            </tr>
        </thead>
        <tbody>
            <tr>
                <td rowspan="2"><?php echo $rank; ?></td>
                <td rowspan="2"><?php echo $product_name; ?><br>Bill No <?php echo $invoice_no; ?><br>Eway Bill No <?php echo $e_way_bill_no;  ?><br>Inv Date <?php echo $lr_date; ?><br><b>Goods Transport Services by road</b></td>
                <td><?php echo $loading_wt; ?></td>
                <td><?php echo $party_rate; ?></td>
                <td class="fw-bold">Total Freight<br>GST Tax <br> Loading Charges <br> Bilty Charges<br> Other Charges <br> Advance <br> Balance</td>
                <td>0.00<br>0.00<br>0.00<br>0.00<br>0.00<br>0.00<br>0.00</td>
                <td><?php echo $freight_ps; ?></td>
                <td><?php echo $freight_rs; ?></td>
            </tr>
            <!-- Add more rows here if needed -->
        </tbody>
    </table>
</div>


<div class="row" style=" color: #4682B4;">
 <div class="col-md-8">
        <div class="box left">
            <h5 class="fw-bold" style="" >Terms & condition:</h5>
            <ul class="fw-bold" style="font-size:12px; ">
                <li>The Consignment note issued subject to condition printed overleaf. We are not responsible for leakage & Breakage.</li>
                <li>Short supply, damage if any must be mentioned in transporter delivery challan and duly signed by the driver</li>
                <li>Complaint regarding quality quantity should be informed immediately.</li>
            </ul>
            
            <h5 class="fw-bold">Bank Details:</h5>
            <ul>
                <li>Bank Name: HDFC BANK</li>
                <li>Account Number: 50200089119004</li>
                <li>IFSC Code: HDFC0005328</li>
                <!-- Add more details as needed -->
            </ul>
        </div>
    </div>
    
    
    <div class="col-md-4">
      <div class="box right">
       
       <div class="text text-end">
    <h5 class="fw-bold">For, Ankit Road Carrier</h5>
    <br>
   
    
    <img src="auth_sign88 copy.jpg" alt="Authorized Signatory" width="150px" class="img-fluid">
    <h6 class="font-size-15 mb-1">Authorized Signatory <br>E. & O. E.</h6>
</div>


      </div>
    </div>
   
  </div>
</div>
                            
               
          
            <div class="d-print-none mt-4">
                                        <div class="float-end">
                                            <button class="btn btn-lg btn-secondary" onclick="PrintResult();" ><i class="bi bi-printer-fill"></i>&nbsp;Print</button>
                                        </div>
                                    </div>
            
            
              </div>
              </div>
              </div>
              </div>
            </section>
            
        </main>
        <script>
    
    function PrintResult() {
  var body = document.body.innerHTML; // Get the current HTML content of the body
  var data = document.getElementById('data').innerHTML;



  // Replace the body's HTML with the content to be printed
  document.body.innerHTML = data;

  window.print(); // Trigger the print dialog

  // Restore the original HTML content of the body and display the header again
  document.body.innerHTML = body;
  header.classList.remove('print-hide');
}

</script>

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
