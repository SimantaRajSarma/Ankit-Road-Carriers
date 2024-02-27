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
    $VehicleNo = $_POST['vehicle_no'];
    $vehicle_type = $_POST['vehicle_type'];
    $owner_type = $_POST['owner_type'];
    $vehicle_model_type = $_POST['vehicle_model_type'];
    $mobile_no = $_POST['mobile_no'];
    $vehicle_owner = $_POST['vehicle_owner'];

    // SQL query to insert data into the 'vehicle' table
    $sql = "INSERT INTO vehicle (VehicleNo, VehicleOwner, mobile_no, VehicleType, OwnerType, VehicleModelType) 
            VALUES ('$VehicleNo', '$vehicle_owner', '$mobile_no', '$vehicle_type', '$owner_type', '$vehicle_model_type')";

    if ($conn->query($sql) === TRUE) {
        $alertMessage = "Vehicle added successfully!";
        $alertClass = "alert-success";
    } else {
        $alertMessage = "Error: " . $sql . "<br>" . $conn->error;
        $alertClass = "alert-danger";
    }

    $conn->close();

    // Display alert message
    echo '<script>
        window.onload = function() {
            document.getElementById("passwordAlert").classList.remove("d-none");
        }
    </script>';
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
                <h5 class="card-title text-center">Add New Vehicle</h5>
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
                    <label for="vehicle_no" class="form-label fw-bold"
                      >Vehicle No. :</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      id="inputNanme4"
                      name="vehicle_no"
                      placeholder="Enter Vehicle No."
                      required
                    />
                  </div>
                  <div class="col-md-6 col-sm-12">
                    <label for="vehicle_type" class="form-label fw-bold"
                      >Vehicle Type :</label
                    >
                    <select name="vehicle_type" class="form-select" required>
                     
                      <option value="truck">Truck</option>
                    </select>
                  </div>
                  

                  <div class="col-md-6 col-sm-12">
                    <label for="owner_type" class="form-label fw-bold"
                      >Owner Type :</label
                    >
                    <select name="owner_type" class="form-select" required>
                      <option selected>Choose Owner Type</option>
                      <option value="OWN">OWN</option>
                      <option value="OUTSIDE">OUTSIDE</option>
                    </select>
                  </div>

                  <div class="col-md-6 col-sm-12">
                    <label for="vehicle_owner" class="form-label fw-bold"
                      >Vehicle Owner :</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      name="vehicle_owner"
                      placeholder="Enter Vehicle Owner"
                      required
                    />
                  </div>

                 

                  <div class="col-md-6 col-sm-12">
                    <label for="vehicle_model_type" class="form-label fw-bold"
                      >Vehicle Model Type :</label
                    >
                    <select name="vehicle_model_type" class="form-select" required>
                      <option selected>Choose Vehicle Model Type</option>
                      <option value="2 tire">6 Tire</option>
                      <option value="2 tire">10 Tire</option>
                      <option value="2 tire">12 Tire</option>
                      <option value="2 tire">14 Tire</option>
                      <option value="2 tire">16 Tire</option>
                      <option value="2 tire">18 Tire</option>
                      <option value="2 tire">22 Tire</option>
                      
                    </select>
                  </div>

                  <div class="col-md-6 col-sm-12">
                    <label for="mobile_no" class="form-label fw-bold"
                      >Mobile No:</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      name="mobile_no"
                      placeholder="Mobile No"
                      required
                    />
                  </div>

                 
               
                   <div class="text-center m-3">
                    <button
                      type="submit"
                      name="submit"
                      class="btn btn-lg btn-primary shadow m-2"
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
  // Show the RTO section by default since it has the 'show' and 'active' classes
  $("#documents-section").removeClass("show active");

  // Event handler for when RTO tab is clicked
  $("#rto-tab").click(function () {
    // Hide the Documents section
    $("#documents-section").removeClass("show active");
    // Show the RTO section
    $("#rto-section").addClass("show active");
  });

  // Event handler for when Documents tab is clicked
  $("#documents-tab").click(function () {
    // Hide the RTO section
    $("#rto-section").removeClass("show active");
    // Show the Documents section
    $("#documents-section").addClass("show active");
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
