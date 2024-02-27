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

    <title>Logistics Software</title>
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

// Check if bill_id is provided in the URL
if(isset($_GET['bill_id'])) {
    // Sanitize the input to prevent SQL injection
    $bill_id = mysqli_real_escape_string($conn, $_GET['bill_id']);

    // Query to fetch data from trip_entry, party, consignee_Details, and party_bill tables
    $query = "SELECT party.party_name, party.address, party.gstin, party.contact_phone, trip_entry.invoice_no, trip_entry.lr_date, trip_entry.lr_no, trip_entry.source, trip_entry.destination, trip_entry.loading_wt, trip_entry.party_rate, trip_entry.bill_freight, trip_entry.e_way_bill_no,trip_entry.advance_amount, consignee_Details.Consignee_name, vehicle.VehicleNo, products.product_name, driver.MobileNo, consignor_Details.Consignor_name, consignor_Details.Consignor_address, consignor_Details.Consignor_gstin
              FROM trip_entry
              INNER JOIN party ON trip_entry.party_id = party.party_id
              INNER JOIN consignee_Details ON trip_entry.Consignee_id = consignee_Details.Consignee_id
              INNER JOIN consignor_Details ON trip_entry.Consignor_id = consignor_Details.Consignor_id
              INNER JOIN vehicle ON trip_entry.vehicle_id = vehicle.VehicleID
              INNER JOIN products ON trip_entry.product_id = products.product_id
              INNER JOIN driver ON trip_entry.driver_id = driver.DriverID
              
               INNER JOIN party_bill_lr ON trip_entry.trip_id = party_bill_lr.lr_id
              
              WHERE party_bill_lr.bill_id = '$bill_id'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        // Extracting data from the fetched row
        $billedName = $row['party_name'];
        $address = $row['address'];
        $gstin = $row['gstin'];
        $contact_number = $row['contact_phone'];
        $bill_no = $row['invoice_no'];
        $lr_date = $row['lr_date'];
        $Consignee_name = $row['Consignee_name'];
    } else {
        // Handle query error
        $billedName = "Unknown";
    }
} else {
    // Handle case when bill_id is not provided in the URL
    echo "Bill ID is missing!";
}

?>
                                 
                                   <div class="col-sm-6" style="border: 2px solid #4682B4; padding: 10px;">
        <div >
            <h6 class="font-size-20 mb-3 fw-bold" style="color: #4682B4;" >Billed's Name & Address:-</h6>
       
                <h6 class="font-size-15 mb-2" style="border: 2px solid #4682B4; padding: 10px;"><?php echo $billedName; ?></h6>
                    <p class="mb-1" style="border: 2px solid #4682B4; padding: 10px;"><?php echo $address; ?></p>
                     <p class="mb-1" style="border: 2px solid #4682B4; padding: 10px;">GSTIN : <?php echo $gstin; ?> | PAN No.:</p>
                <p class="mb-1" style="border: 2px solid #4682B4; padding: 10px;">CONTACT NO : <?php echo $contact_number;  ?></p>
                
                    </div>
    </div>
                                    <!-- end col -->
                                  <div class="col-sm-6" style="border: 2px solid #4682B4; padding: 10px;">
        <div class="text-end" >
            <div>
                <h6 class="font-size-15 mb" style="border: 2px solid #4682B4; padding: 10px;" >Bill No. : <?php echo  $bill_no; ?></h6>
                <h6 class="font-size-15 mb" style="border: 2px solid #4682B4; padding: 10px;">Bill Date :<?php echo $lr_date; ?></h6>
                <h6 class="font-size-15 mb" style="border: 2px solid #4682B4; padding: 10px;">GSTIN No : 18JAZPS5085P1Z0</h6>
                <h6 class="font-size-15 mb" style="border: 2px solid #4682B4; padding: 10px;">PAN No : JAZPS5085P</h6>
                
            </div>
            
        </div>
    </div>
                                    <!-- end col -->
                                </div>
                                
                                <!-- end row -->
                              
                            <h5 class="card-title">Buyer:- <?php echo $Consignee_name; ?></h5>

                               
    
                                <div class="py-2">
                                   
            
                                    <div class="table-responsive">
                                        <table  class="table table-bordered text-center" style="border: 2px solid  #4682B4; color: #4682B4;">
                                            <thead>
                                                <tr>
                                                    <th width="1%">Sr.</th>
                                                    <th width="4%">Date</th>
                                                    <th width="3%">Vehicle No</th>
                                                    <th width="3%">LR No</th>
                                                    <th width="5%">inv. No</th>
                                                    <th width="4%">FROM - TO</th>
                                                    <th width="4%">Consignee</th>
                                                    <th width="5%">Product</th>
                                                    <th width="5%">Act.Wt</th>
                                                    <th width="5%"> Charge Wt</th>
                                                    <th width="5%">Rate</th>
                                                    <th width="3%">Freight</th>
                                                       
                                                </tr>
                                            </thead><!-- end thead -->
                                            <tbody>
                                           <?php
// Check if the bill_id is set in the URL
if(isset($_GET['bill_id'])) {
    // Sanitize and assign the bill_id value from the URL
    $bill_id = mysqli_real_escape_string($conn, $_GET['bill_id']);
    
    // Include database connection file
    include('include/connection.php');

    // Perform the database query
    $query = "SELECT party.party_name, party.address, party.gstin, party.contact_phone, trip_entry.invoice_no, trip_entry.lr_date, trip_entry.lr_no, trip_entry.source, trip_entry.destination, trip_entry.loading_wt, trip_entry.party_rate, trip_entry.bill_freight, trip_entry.e_way_bill_no,trip_entry.advance_amount, consignee_Details.Consignee_name, vehicle.VehicleNo, products.product_name, driver.MobileNo, consignor_Details.Consignor_name, consignor_Details.Consignor_address, consignor_Details.Consignor_gstin
              FROM trip_entry
              INNER JOIN party ON trip_entry.party_id = party.party_id
              INNER JOIN consignee_Details ON trip_entry.Consignee_id = consignee_Details.Consignee_id
              INNER JOIN consignor_Details ON trip_entry.Consignor_id = consignor_Details.Consignor_id
              INNER JOIN vehicle ON trip_entry.vehicle_id = vehicle.VehicleID
              INNER JOIN products ON trip_entry.product_id = products.product_id
              INNER JOIN driver ON trip_entry.driver_id = driver.DriverID
              
               INNER JOIN party_bill_lr ON trip_entry.trip_id = party_bill_lr.lr_id
              
              WHERE party_bill_lr.bill_id = '$bill_id'"; // Use the retrieved bill_id in the query
    $result = mysqli_query($conn, $query);

    // Initialize subtotal variable
    $subTotal = 0;
    $total_adv=0;
    $rank = 1;
    ?>
    <tbody>
        <?php
        // Fetch data and display rows
        while ($row = mysqli_fetch_array($result)) {
        ?>
            <tr>
                <td><?php echo $rank; ?></td>
                <td><?php echo $row['lr_date']; ?></td>
                <td><?php echo $row['VehicleNo']; ?></td>
                <td><?php echo $row['lr_no']; ?></td>
                <td><?php echo $row['invoice_no']; ?></td>
                <td><?php echo $row['source']; ?> To <?php echo $row['destination']; ?></td>
                <td><?php echo $row['Consignee_name']; ?></td>
                <td><?php echo $row['product_name']; ?></td>
                <td><?php echo $row['loading_wt']; ?></td>
                <td><?php echo $row['unload_wt']; ?></td>
                <td><?php echo $row['party_rate']; ?></td>
                <td><?php echo number_format($row['bill_freight'], 2); ?></td>
            </tr>
        <?php
            // Add bill_freight to subtotal
            $subTotal += $row['bill_freight'];
            $total_adv +=$row['advance_amount'];
            $rank++;
        }
        ?>

        <!-- Subtotal row -->
        <tr>
            <th scope="row" colspan="11" class="text-end">Sub Total</th>
            <td class="text-end"><?php echo number_format($subTotal, 2); ?></td>
        </tr>
    </tbody>
    <?php
} else {
    // If the bill_id is not set in the URL, display an error message
    echo "<p>Error: Bill ID not specified.</p>";
}
?>

                                                <!-- end tr -->
                                             
                                                
                                                <!-- end tr -->
                                            </tbody><!-- end tbody -->
                                        </table><!-- end table -->
                                    </div><!-- end table responsive -->

                                    <br>
                                    <div class="row" style=" color: #4682B4;">
                                        <div class="col-md-6">
                                          <div class="box left">
                                           <h5 class="fw-bold">Banking Details</h5>
<div class="text">
                 <h6 class="font-size-15 mb-1">Account Name : Ankit Road Carrier</h6>
                <h6 class="font-size-15 mb-1">Account No : 50200089119004</h6>
                <h6 class="font-size-15 mb-1">Bank Name : HDFC Bank</h6>
                <h6 class="font-size-15 mb-1">Branch Name : Baihata Chariali</h6>
                <h6 class="font-size-15 mb-1">IFSC Code : HDFC0005328</h6>
</div>
                                          
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="box right">
                                            <div class="text text-end">
                                                <h6 class="font-size-15 mb-1">Detension charges(+) : 0</h6>
                                               <h6 class="font-size-15 mb-1">Load Unload Charge (+) : 0.00</h6>
                                               <h6 class="font-size-15 mb-1">Bilty Charge (+) : 0</h6>
                                               <h6 class="font-size-15 mb-1">Total Amt : 0.00</h6>
                                               <h6 class="font-size-15 mb-1">Advance Amount : <?php echo number_format($total_adv, 2); ?></h6>
                                               <h6 class="font-size-15 mb-1">Round Off : 0.00</h6>
                                               <h6 class="font-size-15 mb-1">Net Amount :   <?php echo number_format($subTotal - $total_adv, 2); ?></h6>
                                            

                               </div>
                               
                                          </div>
                                        </div>
                                      
                                      </div>

<hr>


<div class="row" style=" color: #4682B4;">
    <div class="col-md-6">
      <div class="box left">
       <h5>Terms & condition:</h5>
<ul style="font-size:10px; font-weight:bold;">
    <li>Payment should be made within 7 days of receipt of this bill.</li>
    <li>Payment should be made within 7 days of receipt of this bill.</li>
    <li>TDS deducted @ 1%only.</li>
</ul>
      <p  style="font-size:15px; font-weight:bold;">As par provision of GST tax on gta services is payable by consignee/consignor on RCM basis Subject To Guwahati Jurisdiction</hp>
      </div>
    </div>
    <div class="col-md-6">
      <div class="box right">
       
        <div class="text text-end">
            <h5>For, Ankit Road Carrier</h5>
           <br>
            <img src="auth_sign88 copy.jpg" width="150px" class="img-fluid">
          
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
