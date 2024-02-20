<?php
error_reporting(0);
require_once('include/connection.php');

// Function to sanitize user inputs
function sanitizeInput($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}


function sanitizeArray($array) {
  if (!is_array($array)) {
      // If $array is not an array, sanitize and return it
      return htmlspecialchars(stripslashes(trim($array)));
  } else {
      // If $array is an array, sanitize each element recursively
      $sanitizedArray = [];
      foreach ($array as $key => $value) {
          $sanitizedArray[$key] = sanitizeArray($value);
      }
      return $sanitizedArray;
  }
}



// Function to insert data into the Vehicle table
function insertVehicleData($conn, $vehicleNo, $vehicleOwner, $capacity, $panName, $panCardNo, $tareWeight, $vehicleType, $ownerType, $vehicleModelType) {
  $sql = "INSERT INTO vehicle (VehicleNo, VehicleOwner, Capacity, PANName, PANCardNo, TareWeight, VehicleType, OwnerType, VehicleModelType) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssissssss", $vehicleNo, $vehicleOwner, $capacity, $panName, $panCardNo, $tareWeight, $vehicleType, $ownerType, $vehicleModelType);
  $stmt->execute();
  $stmt->close();
}

// Function to insert data into the RTO table
function insertRTOData($conn, $vehicleID, $taxExpiry, $fitnessNo, $fitnessExpiry, $statePermitNo, $statePermitExpiry, $permittedState, $aipPermit, $aipPermitExpiry, $insurancePolicyNo, $insuranceExpiry, $explosiveLicNo, $explosiveExpiry, $pucNo, $pucExpiry, $calibrationNo, $calibrationExpiry, $numOfComp) {
  $sql = "INSERT INTO rto (VehicleID, TaxExpiry, FitnessNo, FitnessExpiry, StatePermitNo, StatePermitExpiry, PermittedState, AIPPermit, AIPPermitExpiry, InsurancePolicyNo, InsuranceExpiry, ExplosiveLicNo, ExplosiveExpiry, PUCNo, PUCExpiry, CalibrationNo, CalibrationExpiry, NumOfComp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("issssssssssssssssi", $vehicleID, $taxExpiry, $fitnessNo, $fitnessExpiry, $statePermitNo, $statePermitExpiry, $permittedState, $aipPermit, $aipPermitExpiry, $insurancePolicyNo, $insuranceExpiry, $explosiveLicNo, $explosiveExpiry, $pucNo, $pucExpiry, $calibrationNo, $calibrationExpiry, $numOfComp);
  $stmt->execute();
  $stmt->close();
}

// Function to insert data into the VehicleDocument table
function insertVehicleDocumentData($conn, $vehicleID, $documentType, $documentName, $remarks, $filePaths) {
  foreach ($filePaths as $index => $filePath) {
      // Insert data into database for this file
      $sql = "INSERT INTO vehicledocument (VehicleID, DocumentType, DocumentName, Remarks, DocumentFile) VALUES (?, ?, ?, ?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("issss", $vehicleID, $documentType[$index], $documentName[$index], $remarks[$index], $filePath);
      if ($stmt->execute()) {
          $stmt->close();
          // Continue to the next file
          continue;
      } else {
          // Failed to execute SQL statement, handle error for this file
          $stmt->close();
          return "Error: Failed to execute SQL statement for one or more files.";
      }
  }
  // All files uploaded and inserted successfully
  return "Success: All files uploaded and data inserted successfully.";
}



// Sanitize and store form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize RTO section data
    $taxExpiry = sanitizeInput($_POST["tax_expiry"]);
    $fitnessNo = sanitizeInput($_POST["fitness_no"]);
    $fitnessExpiry = sanitizeInput($_POST["fitness_expiry"]);
    $statePermitNo = sanitizeInput($_POST["state_permit_no"]);
    $statePermitExpiry = sanitizeInput($_POST["state_permit_expiry"]);
    $permittedState = sanitizeInput($_POST["permitted_state"]);
    $aipPermit = sanitizeInput($_POST["aip_permit"]);
    $aipPermitExpiry = sanitizeInput($_POST["aip_permit_expiry"]);
    $insurancePolicyNo = sanitizeInput($_POST["insurance_policy_no"]);
    $insuranceExpiry = sanitizeInput($_POST["insurance_expiry"]);
    $explosiveLicNo = sanitizeInput($_POST["explosive_lic_no"]);
    $explosiveExpiry = sanitizeInput($_POST["explosive_expiry"]);
    $pucNo = sanitizeInput($_POST["puc_no"]);
    $pucExpiry = sanitizeInput($_POST["puc_expiry"]);
    $calibrationNo = sanitizeInput($_POST["calibration_no"]);
    $calibrationExpiry = sanitizeInput($_POST["calibration_expiry"]);
    $numOfComp = sanitizeInput($_POST["num_of_comp"]);

    // Sanitize Vehicle section data
    $vehicleNo = sanitizeInput($_POST["vehicle_no"]);
    $vehicleOwner = sanitizeInput($_POST["vehicle_owner"]);
    $capacity = sanitizeInput($_POST["capacity"]);
    $panName = sanitizeInput($_POST["pan_name"]);
    $panCardNo = sanitizeInput($_POST["pan_card_no"]);
    $rtoID = 1; // Assuming RTO ID is 1 for simplicity
    $tareWeight = sanitizeInput($_POST["tare_weight"]);
    $vehicleType = sanitizeInput($_POST["vehicle_type"]);
    $ownerType = sanitizeInput($_POST["owner_type"]);
    $vehicleModelType = sanitizeInput($_POST["vehicle_model_type"]);

 
   // Get the last inserted vehicle ID

// Insert data into Vehicle table
insertVehicleData($conn, $vehicleNo, $vehicleOwner, $capacity, $panName, $panCardNo, $tareWeight, $vehicleType, $ownerType, $vehicleModelType);

$lastVehicleID = $conn->insert_id;
// Insert data into RTO table
insertRTOData($conn, $lastVehicleID, $taxExpiry, $fitnessNo, $fitnessExpiry, $statePermitNo, $statePermitExpiry, $permittedState, $aipPermit, $aipPermitExpiry, $insurancePolicyNo, $insuranceExpiry, $explosiveLicNo, $explosiveExpiry, $pucNo, $pucExpiry, $calibrationNo, $calibrationExpiry, $numOfComp);


    // Check if the 'document_files' array is set and not null
if(isset($_FILES['document_files']) && $_FILES['document_files'] !== null) {
  // Sanitize Vehicle Document section data
  $documentType = sanitizeArray($_POST["document_type"]);
  $documentName = sanitizeArray($_POST["document_name"]);
  $remarks = sanitizeArray($_POST["remarks"]);

  // Specify the target directory
  $targetDirectory = 'assets/vehicleDocuments/';

  // Array to store file paths
  $filePaths = [];

  if ($_FILES['document_files']['error'][0] !== UPLOAD_ERR_OK) {
    echo "File upload error: " . $_FILES['document_files']['error'][0];
    exit;
}


  // Check if files were uploaded
  if(!empty($_FILES['document_files']['tmp_name'])) {
      // Move each uploaded file to target directory and store file paths
      foreach ($_FILES['document_files']['tmp_name'] as $index => $tmpName) {
          // Sanitize file name
          $uniqueFilename = uniqid() . '-' . basename($_FILES['document_files']['name'][$index]);
          $targetPath = $targetDirectory . $uniqueFilename;

          // Move the uploaded file to the target directory
          if (move_uploaded_file($tmpName, $targetPath)) {
              // Store the file path
              $filePaths[] = $targetPath;
          } else {
              // Handle error if failed to move uploaded file
              echo "Error: Failed to move uploaded file for one or more files.";
              exit; // or return an error message, or redirect the user
          }
      }
  } else {
      // Handle case where no files were uploaded
      echo "Error: No files were uploaded.";
      exit; // or return an error message, or redirect the user
  }

  // Call the function to insert data into the VehicleDocument table
  $result = insertVehicleDocumentData($conn, $lastVehicleID, $documentType, $documentName, $remarks, $filePaths);

  // Handle the result accordingly
  echo $result;
} else {
  // Handle case where the 'document_files' array is not set or null
  echo "Error: No files were uploaded.";
  exit; // or return an error message, or redirect the user
}


    // Close database connection
    $conn->close();

    echo '<script>alert("Form submitted successfully!");</script>';
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
                <h5 class="card-title text-center">Add New Vehicle</h5>
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
                  <div class="col-6">
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
                  <div class="col-6">
                    <label for="vehicle_type" class="form-label fw-bold"
                      >Vehicle Type :</label
                    >
                    <select name="vehicle_type" class="form-select" required>
                      <option selected>Choose Vehicle Type</option>
                      <option value="truck">Truck</option>
                    </select>
                  </div>

                  <div class="col-6">
                    <label for="owner_type" class="form-label fw-bold"
                      >Owner Type :</label
                    >
                    <select name="owner_type" class="form-select" required>
                      <option selected>Choose Owner Type</option>
                      <option value="OWN">OWN</option>
                      <option value="OUTSIDE">OUTSIDE</option>
                    </select>
                  </div>

                  <div class="col-6">
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

                  <div class="col-6">
                    <label for="capacity" class="form-label fw-bold"
                      >Capacity :</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      name="capacity"
                      placeholder="Enter Capacity"
                      required
                    />
                  </div>

                  <div class="col-6">
                    <label for="vehicle_model_type" class="form-label fw-bold"
                      >Vehicle Model Type :</label
                    >
                    <select name="vehicle_model_type" class="form-select" required>
                      <option selected>Choose Vehicle Model Type</option>
                      <option value="2 tire">2 Tire</option>
                    </select>
                  </div>

                  <div class="col-6">
                    <label for="pan_name" class="form-label fw-bold"
                      >Name of PAN :</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      id="inputNanme4"
                      name="pan_name"
                      placeholder="Enter PAN Name"
                      required
                    />
                  </div>

                  <div class="col-6">
                    <label for="pan_card_no" class="form-label fw-bold"
                      >PAN Card No. :</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      id="inputNanme4"
                      name="pan_card_no"
                      placeholder="Enter PAN Card No."
                      required
                    />
                  </div>

                  <div class="col-12">
                    <h5 class="card-title text-center">Select Section:</h5>
                    <ul class="nav nav-tabs justify-content-center">
                      <li class="nav-item">
                        <a
                          class="nav-link active"
                          id="rto-tab"
                          data-toggle="tab"
                          href="#rto-section"
                          >Vehicle RTO Details</a
                        >
                      </li>
                      <li class="nav-item">
                        <a
                          class="nav-link"
                          id="documents-tab"
                          data-toggle="tab"
                          href="#documents-section"
                          >Vehicle Documents</a
                        >
                      </li>
                    </ul>
                  </div>
                  <div class="tab-content col-12 mt-4 mb-2">
                  <div class="tab-pane fade show active" id="rto-section">
                    <div class="col-12">
                      <label for="tax_expiry" class="form-label fw-bold"
                        >Tax Expiry:</label
                      >
                      <input
                        type="date"
                        class="form-control"
                        name="tax_expiry"
                      />
                    </div>

                    <div class="row">
                    <!-- Fitness No. -->
                    <div class="col-6">
                      <label for="fitness_no" class="form-label fw-bold"
                        >Fitness No :</label
                      >
                      <input
                        type="text"
                        class="form-control"
                        name="fitness_no"
                      />
                    </div>

                    <div class="col-6">
                      <label for="fitness_expiry" class="form-label fw-bold"
                        >Fitness Expiry:</label
                      >
                      <input
                        type="date"
                        class="form-control"
                        name="fitness_expiry"
                      />
                    </div>
                </div>

                    <!-- Fitness No. end -->

                    <!-- State Permit No. -->
                    <div class="row">
                    <div class="col-6">
                      <label for="state_permit_no" class="form-label fw-bold"
                        >State Permit No. :</label
                      >
                      <input
                        type="text"
                        class="form-control"
                        name="state_permit_no"
                      />
                    </div>

                    <div class="col-6">
                      <label for="state_permit_expiry" class="form-label fw-bold"
                        >St. Permit Expiry:</label
                      >
                      <input
                        type="date"
                        class="form-control"
                        name="state_permit_expiry"
                      />
                    </div>
</div>

                    <!-- State Permit No. end -->

                    <!-- Permitted State -->
                    <div class="row">
                    <div class="col-12">
                      <label for="permitted_state" class="form-label fw-bold"
                        >Permitted State :</label
                      >
                      <input
                        type="text"
                        class="form-control"
                        name="permitted_state"
                      />
                    </div>
                </div>

                    <!-- Permitted State end -->

                    <!-- AIP Permit No. -->
                    <div class="row">
                    <div class="col-6">
                      <label for="aip_permit" class="form-label fw-bold"
                        >AIP Permit No. :</label
                      >
                      <input
                        type="text"
                        class="form-control"
                        name="aip_permit"
                      />
                    </div>

                    <div class="col-6">
                      <label for="aip_permit_expiry" class="form-label fw-bold"
                        >AIP Permit Expiry:</label
                      >
                      <input
                        type="date"
                        class="form-control"
                        name="aip_permit_expiry"
                      />
                    </div>
</div>

                    <!-- AIP Permit No. end -->

                    <!-- Insurance Policy No. -->
                    <div class="row">
                    <div class="col-6">
                      <label for="insurance_policy_no" class="form-label fw-bold"
                        >Insurance Policy No. :</label
                      >
                      <input
                        type="text"
                        class="form-control"
                        name="insurance_policy_no"
                      />
                    </div>

                    <div class="col-6">
                      <label for="insurance_expiry" class="form-label fw-bold"
                        >Ins. Policy Expiry:</label
                      >
                      <input
                        type="date"
                        class="form-control"
                        name="insurance_expiry"
                      />
                    </div>
</div>

                    <!-- Insurance Permit No. end -->

                    <!-- Explosive Lic. No. -->
                    <div class="row">
                    <div class="col-6">
                      <label for="explosive_lic_no" class="form-label fw-bold"
                        >Explosive Lic. No. :</label
                      >
                      <input
                        type="text"
                        class="form-control"
                        name="explosive_lic_no"
                      />
                    </div>

                    <div class="col-6">
                      <label for="explosive_expiry" class="form-label fw-bold"
                        >Expl. Policy Expiry:</label
                      >
                      <input
                        type="date"
                        class="form-control"
                        name="explosive_expiry"
                      />
                    </div>
</div>

                    <!-- Explosive Lic. No. end -->

                    <!--  PUC No. -->
                    <div class="row">
                    <div class="col-6">
                      <label for="puc_no" class="form-label fw-bold"
                        >PUC No. :</label
                      >
                      <input
                        type="text"
                        class="form-control"
                        name="puc_no"
                      />
                    </div>

                    <div class="col-6">
                      <label for="puc_expiry" class="form-label fw-bold"
                        >PUC Expiry:</label
                      >
                      <input
                        type="date"
                        class="form-control"
                        name="puc_expiry"
                      />
                    </div>
</div>

                    <!-- PUC No. end -->

                    <!-- Calibration No. -->
                    <div class="row">
                    <div class="col-6">
                      <label for="calibration_no" class="form-label fw-bold"
                        >Calibration No. :</label
                      >
                      <input
                        type="text"
                        class="form-control"
                        name="calibration_no"
                      />
                    </div>

                    <div class="col-6">
                      <label for="calibration_expiry" class="form-label fw-bold"
                        >Calibration Expiry:</label
                      >
                      <input
                        type="date"
                        class="form-control"
                        name="calibration_expiry"
                      />
                    </div>
</div>

                    <!-- Calibration No. end -->

                    <!-- No. of Comp. -->
                    <div class="row">
                    <div class="col-6">
                      <label for="num_of_comp" class="form-label fw-bold"
                        >No. of Comp. :</label
                      >
                      <input
                        type="number"
                        class="form-control"
                        name="num_of_comp"
                      />
                    </div>

                    <!-- Tare Weight -->
                    <div class="col-6">
                      <label for="tare_weight" class="form-label fw-bold"
                        >Tare Weight:</label
                      >
                      <input
                        type="date"
                        class="form-control"
                        name="tare_weight"
                      />
                    </div>
                    </div>
                  </div>

                  <!-- documents -->
                  <div class="tab-pane fade" id="documents-section">
    <div class="row document-upload-row">
        <div class="col-2">
            <label for="document_file" class="form-label fw-bold">Choose documents:</label>
            <input type="file" class="form-control document-file" name="document_files[]" />
        </div>

        <div class="col-3">
            <label for="inputNanme4" class="form-label fw-bold">Document Type:</label>
            <select name="document_type[]" class="form-select document-type">
                <option selected>Choose Document Type</option>
                <option value="License">License</option>
            </select>
        </div>

        <div class="col-3">
            <label for="document_name" class="form-label fw-bold">Document Name:</label>
            <input type="text" class="form-control document-name" name="document_name[]" />
        </div>

        <div class="col-3">
            <label for="remarks" class="form-label fw-bold">Remarks:</label>
            <input type="text" class="form-control remarks" name="remarks[]" />
        </div>

        <!-- <div class="col-1 py-4">
            <button class="btn btn-lg btn-primary add-row-btn">+</button>
        </div> -->
    </div>
</div>


<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Find the button and add click event listener
    var addButton = document.querySelector(".add-row-btn");
    addButton.addEventListener("click", function() {
        // Clone the document upload row
        var documentRow = this.parentElement.parentElement;
        var clonedRow = documentRow.cloneNode(true);
        
        // Clear file input value in the cloned row to avoid duplicating file uploads
        var fileInput = clonedRow.querySelector('.document-file');
        // fileInput.value = '';

        // Append the cloned row after the last row
        documentRow.parentElement.appendChild(clonedRow);
    });
});

</script>

                </div>
                  <div class="text-center m-1">
                    <button
                      type="submit"
                      name="submit"
                      class="btn btn-lg btn-success shadow"
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

    </script>
  </body>
</html>
