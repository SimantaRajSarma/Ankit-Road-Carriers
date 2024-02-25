<?php
error_reporting(0);
require_once("include/connection.php");

if(isset($_POST['submit'])) {
    $alertClass = ""; // Initialize the alert class
    $alertMessage = ""; // Initialize the alert message

    $client_name = $_POST['client_name'];
    $client_type = $_POST['client_type'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $client_address = $_POST['client_address'];
    

    // Check if all required fields are filled
    if(!empty($client_name) ) {
        // Proceed with inserting data into the database
        $sql = "INSERT INTO party (party_name,party_type,contact_phone, contact_email,address) 
                VALUES ('$client_name', '$client_type','$mobile','$email','$client_address')";

        $result = mysqli_query($conn, $sql);

    } else {
        // Display an error if any required field is empty
        $alertClass = "alert-danger";
        $alertMessage = "Please fill in all required fields";
    }

    echo "<script>alert('Client Added Successfully!');</script>";
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
            <div class="card">
              <div class="card-body">
                <h5 class="card-title text-center">Add New Client</h5>
                <!-- Vertical Form -->
                <form class="row g-3" method="post" enctype="multipart/form-data" action="">


                  <div class="col-6">
                    <label for="vehicle_type" class="form-label fw-bold" >Client Name :</label>
                    <input
                      type="text"
                      class="form-control"
                      id="inputNanme4"
                      placeholder="Enter Client Name"
                      name="client_name"
                     
                     
                    />
                  </div>

                  <div class="col-6">
    <label for="client_type" class="form-label fw-bold">Client Type :</label>
    <select id="client_type" name="client_type" class="form-select">
        <option value="Customer">Customer</option>
        <option value="Supplier">Supplier</option>
        <option value="Other">Other</option>
    </select>
</div>



                  <div class="col-6">
                    <label for="mobile" class="form-label fw-bold"
                      >Contact Number :</label
                    >
                    <input
                      type="number"
                      class="form-control"
                      name="mobile"
                      placeholder="Enter Contact Number"
                     
                    />
                  </div>


 
                  <div class="col-6">
                    <label for="email" class="form-label fw-bold"
                      >Contact Emails :</label
                    >
                    <input
                      type="email"
                      class="form-control"
                      name="email"
                      placeholder="Enter Contact Email"
                     
                    />
                  </div>


                 

                  <div class="col-12">
    <label for="client_address" class="form-label fw-bold">Client Address:</label>
    <textarea id="client_address" name="client_address" class="form-control" placeholder="Enter Client Address" rows="3"></textarea>
</div>



                 

                </div>
                
                  <div class="text-center m-1">
                    <button
                      type="submit"
                      name="submit"
                      class="btn btn-success shadow"
                    >
                      Submit
                    </button>
                    <button type="reset" class="btn btn-secondary">
                      Reset
                    </button>
                  </div>
                  <br>
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
