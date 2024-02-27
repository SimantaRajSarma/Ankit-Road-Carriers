<?php
session_start();
include("include/connection.php");

// Check if admin is logged in
if (!isset($_SESSION["admin_id"])) {
    header("location: index.php");
    exit();
}

if (isset($_POST['submit'])) {
    // Retrieve form data
    $driver_name = $_POST['driver_name'];
    $mobile_number = $_POST['mobile_number'];
    $dl_no = $_POST['dl_no'];
  
    // SQL query to insert data into the 'driver' table
    $sql = "INSERT INTO driver (DriverName, MobileNo, LicenseNo) 
            VALUES ('$driver_name', '$mobile_number', '$dl_no')";

    if ($conn->query($sql) === TRUE) {
        $alertMessage = "Driver added successfully!";
        $alertClass = "alert-success";
    } else {
        $alertMessage = "Error: " . $sql . "<br>" . $conn->error;
        $alertClass = "alert-danger";
    }

    $conn->close();
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
     <style>
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
              <div class="card-body">
                <h5 class="card-title text-center">Add New Driver</h5>
               <?php if (isset($alertMessage)): ?>
      <div class="alert <?php echo $alertClass; ?> alert-dismissible fade show" role="alert">
    <?php echo $alertMessage; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
            <?php endif; ?> 
                <!-- Vertical Form -->
                <form
                  class="row g-3"
                  method="post"
                  enctype="multipart/form-data"
                  action=""
                >
                  <div class="col-md-6 col-sm-12">
                    <label for="driver_name" class="form-label fw-bold"
                      >Driver Name :</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      name="driver_name"
                      placeholder="Enter Driver Name"
                      required
                    />
                  </div>
                 

                 
                  <div class="col-md-6 col-sm-12">
                    <label for="mobile_number" class="form-label fw-bold"
                      >Mobile No. :</label
                    >
                    <input
                      type="number"
                      class="form-control"
                      name="mobile_number"
                      placeholder="Enter mobile number"
                      required
                    />
                  </div>

                  <div class="col-md-12 col-sm-12">
                    <label for="guarantor_mobile_no" class="form-label fw-bold"
                      >DL No :</label
                    >
                    <input
                      type="text"
                      name="dl_no"
                      class="form-control"
                    />
                  </div>


                 
                
                   <div class="text-center mt-3">
                    <button
                      type="submit"
                      name="submit"
                      class="btn btn-lg btn-primary shadow"
                    >
                     <i class="fa-solid fa-floppy-disk"></i>&nbsp; Submit
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

    <script>
      $(document).ready(function () {
        // Show the Joining Details section by default since it has the 'show' and 'active' classes
        $("#joining-details").addClass("show active");
        $("#documents-section").removeClass("show active");

        // Event handler for when Joining Details tab is clicked
        $("#joining-details-tab").click(function () {
          // Hide the Documents and Driver Bank Details sections
          $("#documents-section").removeClass("show active");
          $("#bank-details-section").removeClass("show active");
          // Show the Joining Details section
          $("#joining-details").addClass("show active");
        });

        // Event handler for when Documents tab is clicked
        $("#documents-tab").click(function () {
          // Hide the Joining Details and Driver Bank Details sections
          $("#joining-details").removeClass("show active");
          $("#bank-details-section").removeClass("show active");
          // Show the Documents section
          $("#documents-section").addClass("show active");
        });

        // Event handler for when Driver Bank Details tab is clicked
        $("#bank-details-tab").click(function () {
          // Hide the Joining Details and Documents sections
          $("#joining-details").removeClass("show active");
          $("#documents-section").removeClass("show active");
          // Show the Driver Bank Details section
          $("#bank-details-section").addClass("show active");
        });

      });

      function cloneDocumentUploadRow(button) {
        var container = document.getElementById('document-upload-container');
        var rowToClone = button.parentElement.parentElement.cloneNode(true);
        container.appendChild(rowToClone);
      }
    </script>
  </body>
</html>
