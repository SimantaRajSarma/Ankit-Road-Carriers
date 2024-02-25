<?php
error_reporting(0);
require_once('include/connection.php');

// Function to store data into the 'driver' table
function insertDriverData($conn, $data) {
    $sql = "INSERT INTO driver (DriverName, PhotoPath, PermanentAddress, TemporaryAddress, MobileNo, GuarantorName, GuarantorMobileNo, LicenseNo, LicenseIssueDate, LicenseExpiryDate, HAZExpiryDate, HAZLicenseNo, OpBalance, Cr_Dr) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssssis", $data['driver_name'], $data['driver_photo'], $data['permanent_address'], $data['temporary_address'], $data['mobile_number'], $data['guarantor_name'], $data['guarantor_mobile_no'], $data['license_no'], $data['license_issue_date'], $data['license_expiry_date'], $data['haz_expiry_date'], $data['haz_license_no'], $data['opening_balance'], $data['cr_dr']);
    $stmt->execute();
    $stmt->close();
}

// Function to store data into the 'driverbankdetails' table
function insertDriverBankDetails($conn, $driverID, $data) {
    $sql = "INSERT INTO driverbankdetails (DriverID, BankName, AccountNo, BranchName, IFSCCode) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $driverID, $data['bank_name'], $data['account_number'], $data['branch_name'], $data['ifsc_code']);
    $stmt->execute();
    $stmt->close();
}

// Function to store data into the 'driverdocuments' table
function insertDriverDocuments($conn, $driverID, $data) {
    // Assuming $data['document_files'] contains an array of file paths
    foreach ($data['document_files']['tmp_name'] as $key => $tmp_name) {
        $documentType = $data['document_type'][$key];
        $documentName = $data['document_name'][$key];
        $remarks = $data['remarks'][$key];
        $documentPath = "assets/driverdocuments/" . basename($data['document_files']['name'][$key]); // Change 'path_to_upload_folder/' to your desired upload folder path

        // Move uploaded file to upload folder
        move_uploaded_file($tmp_name, $documentPath);

        $sql = "INSERT INTO driverdocuments (DriverID, DocumentType, DocumentName, Remarks, DocumentPath) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss", $driverID, $documentType, $documentName, $remarks, $documentPath);
        $stmt->execute();
        $stmt->close();
    }
}

// Function to store data into the 'joiningdetails' table
function insertJoiningDetails($conn, $driverID, $data) {
    $sql = "INSERT INTO joiningdetails (DriverID, JoiningDate, LeaveDate, TotalDate, VehicleNo, BasicSalary, SalaryType, Allowance, AllowanceType, Remarks, Status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isiiissssss", $driverID, $data['joining_date'], $data['leave_date'], $data['total_days'], $data['vehicle_no_of_driver'], $data['basic_salary'], $data['salary_type'], $data['allowance'], $data['allowance_type'], $data['remarks'], $data['status']);
    $stmt->execute();
    $stmt->close();
}

// Main code to process form submission
if($_SERVER["REQUEST_METHOD"] == "POST") {


   // Process driver data
$driverData = [
  'driver_name' => $_POST['driver_name'],
  'permanent_address' => $_POST['permanent_address'],
  'temporary_address' => $_POST['temporary_address'],
  'mobile_number' => $_POST['mobile_number'],
  'guarantor_name' => $_POST['guarantor_name'],
  'guarantor_mobile_no' => $_POST['guarantor_mobile_no'],
  'license_no' => $_POST['license_no'],
  'license_issue_date' => $_POST['license_issue_date'],
  'license_expiry_date' => $_POST['license_expiry_date'],
  'haz_expiry_date' => $_POST['haz_expiry_date'],
  'haz_license_no' => $_POST['haz_license_no'],
  'opening_balance' => $_POST['opening_balance'],
  'cr_dr' => $_POST['cr_dr']
];

// Check if file is uploaded successfully
if(isset($_FILES['driver_photo']) && $_FILES['driver_photo']['error'] === UPLOAD_ERR_OK) {
  $uploadDir = 'assets/driverdocuments/';
  $uploadFileName = uniqid() . '_' . basename($_FILES['driver_photo']['name']); // Unique random filename
  $uploadFile = $uploadDir . $uploadFileName;

  // Move the uploaded file to the upload directory
  if(move_uploaded_file($_FILES['driver_photo']['tmp_name'], $uploadFile)) {
      // File uploaded successfully, add photo path to driver data
      $driverData['driver_photo'] = $uploadFile;
  } else {
      // Error occurred while moving the uploaded file
      echo "Failed to move uploaded file.";
      exit;
  }
} else {
  // No file uploaded or upload error occurred
  echo "No file uploaded or upload error occurred.";
  exit;
}

// Insert driver data into the database
insertDriverData($conn, $driverData);

    // Get last inserted driver ID
    $driverID = $conn->insert_id;

    // Process driver bank details
    $bankDetails = [
        'bank_name' => $_POST['bank_name'],
        'account_number' => $_POST['account_number'],
        'branch_name' => $_POST['branch_name'],
        'ifsc_code' => $_POST['ifsc_code']
    ];
    insertDriverBankDetails($conn, $driverID, $bankDetails);

    // Process driver documents
    insertDriverDocuments($conn, $driverID, $_FILES);

    // Process joining details
    $joiningDetails = [
        'joining_date' => $_POST['joining_date'],
        'leave_date' => $_POST['leave_date'],
        'total_days' => $_POST['total_days'],
        'vehicle_no_of_driver' => $_POST['vehicle_no_of_driver'],
        'basic_salary' => $_POST['basic_salary'],
        'salary_type' => $_POST['salary_type'],
        'allowance' => $_POST['allowance'],
        'allowance_type' => $_POST['allowance_type'],
        'remarks' => $_POST['remarks'],
        'status' => $_POST['status']
    ];
    insertJoiningDetails($conn, $driverID, $joiningDetails);
    
    echo "<script>alert('Driver Added Successfully!');</script>";
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
                <h5 class="card-title text-center">Add New Driver</h5>
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
                    <label for="driver_photo" class="form-label fw-bold"
                      >Driver Photo :</label
                    >
                    <input
                      type="file"
                      name="driver_photo"
                      class="form-control"
                      required
                    />
                  </div>

                  <div class="col-md-6 col-sm-12">
                    <label for="permanent_address" class="form-label fw-bold"
                      >Address(P) :</label
                    >
                    <textarea
                      name="permanent_address"
                      rows="3"
                      class="form-control"
                    ></textarea>
                  </div>

                  <div class="col-md-6 col-sm-12">
                    <label for="temporary_address" class="form-label fw-bold"
                      >Address(T) :</label
                    >
                    <textarea
                      name="temporary_address"
                      rows="3"
                      class="form-control"
                    ></textarea>
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

                  <div class="col-md-6 col-sm-12">
                    <label for="guarantor_name" class="form-label fw-bold"
                      >Guarantor Name :</label
                    >
                    <input
                      type="text"
                      name="guarantor_name"
                      class="form-control"
                    />
                  </div>

                  <div class="col-md-6 col-sm-12">
                    <label for="guarantor_mobile_no" class="form-label fw-bold"
                      >Guarantor Mobile No. :</label
                    >
                    <input
                      type="text"
                      name="guarantor_mobile_no"
                      class="form-control"
                    />
                  </div>

                  <div class="col-md-6 col-sm-12">
                    <label for="license_no" class="form-label fw-bold"
                      >License No. :</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      name="license_no"
                      placeholder="Enter License No."
                      required
                    />
                  </div>

                  <div class="col-md-6 col-sm-12">
                    <label for="license_issue_date" class="form-label fw-bold"
                      >License issue date. :</label
                    >
                    <input
                      type="date"
                      class="form-control"
                      name="license_issue_date"
                      required
                    />
                  </div>

                  <div class="col-md-6 col-sm-12">
                    <label for="license_expiry_date" class="form-label fw-bold"
                      >License Expiry date. :</label
                    >
                    <input
                      type="date"
                      class="form-control"
                      name="license_expiry_date"
                      required
                    />
                  </div>

                  <div class="col-md-6 col-sm-12">
                    <label for="haz_expiry_date" class="form-label fw-bold"
                      >HAZ Expiry date. :</label
                    >
                    <input
                      type="date"
                      class="form-control"
                      name="haz_expiry_date"
                      required
                    />
                  </div>

                  <div class="col-md-6 col-sm-12">
                    <label for="haz_license_no" class="form-label fw-bold"
                      >HAZ License no. :</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      name="haz_license_no"
                      required
                    />
                  </div>

                  <div class="col-md-6 col-sm-12">
                    <label for="opening_balance" class="form-label fw-bold"
                      >Opening Balance :</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      name="opening_balance"
                      required
                    />
                  </div>
                  <div class="col-md-6 col-sm-12">
                    <label for="cr_dr" class="form-label fw-bold">Type:</label>
                    <select name="cr_dr" class="form-select">
                      <option selected></option>
                      <option value="CR">CR</option>
                      <option value="DR">DR</option>
                    </select>
                  </div>

                  <div class="col-12">
                    <h5 class="card-title text-center">Select Section:</h5>
                    <ul class="nav nav-tabs justify-content-center">
                      <li class="nav-item">
                        <a
                          class="nav-link active"
                          id="joining-details-tab"
                          data-toggle="tab"
                          href="#joining-details"
                          >Joining Details</a
                        >
                      </li>
                      <li class="nav-item">
                        <a
                          class="nav-link"
                          id="documents-tab"
                          data-toggle="tab"
                          href="#documents-section"
                          >Driver Documents</a
                        >
                      </li>
                      <li class="nav-item">
                        <a
                          class="nav-link"
                          id="bank-details-tab"
                          data-toggle="tab"
                          href="#bank-details-section"
                          >Driver Bank Details</a
                        >
                      </li>
                    </ul>
                  </div>
                  <div class="tab-content col-12 mt-4 mb-2">
                    <div class="tab-pane fade" id="joining-details">
                      <div class="row">
                        <div class="col-4">
                          <label for="joining_date" class="form-label fw-bold"
                            >Joining Date</label
                          >
                          <input
                            type="date"
                            class="form-control"
                            name="joining_date"
                          />
                        </div>
                        <div class="col-4">
                          <label for="leave_date" class="form-label fw-bold"
                            >Leave Date :</label
                          >
                          <input
                            type="date"
                            class="form-control"
                            name="leave_date"
                          />
                        </div>

                        <div class="col-4">
                          <label for="total_days" class="form-label fw-bold"
                            >Total Days:</label
                          >
                          <input
                            type="text"
                            class="form-control"
                            name="total_days"
                          />
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-4">
                          <label
                            for="vehicle_no_of_driver"
                            class="form-label fw-bold"
                            >Veh. no. of Driver:</label
                          >
                          <input
                            type="text"
                            class="form-control"
                            name="vehicle_no_of_driver"
                          />
                        </div>
                        <div class="col-4">
                          <label for="basic_salary" class="form-label fw-bold"
                            >Basic Salary:</label
                          >
                          <input
                            type="text"
                            class="form-control"
                            name="basic_salary"
                          />
                        </div>
                        <div class="col-4">
                          <label for="salary_type" class="form-label fw-bold"
                            >Salary Type :</label
                          >
                          <select name="salary_type" class="form-select">
                            <option selected></option>
                            <option value="Fixed">Fixed</option>
                            <option value="Pay">Pay</option>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-4">
                          <label for="allowance" class="form-label fw-bold"
                            >Allowance :</label
                          >
                          <input
                            type="text"
                            class="form-control"
                            name="allowance"
                          />
                        </div>
                        <div class="col-4">
                          <label for="allowance_type" class="form-label fw-bold"
                            >Allowance Type:</label
                          >
                          <select name="allowance_type" class="form-select">
                            <option selected></option>
                            <option value="Fixed">Fixed</option>
                            <option value="Pay">Pay</option>
                          </select>
                        </div>
                        <div class="col-4">
                          <label for="status" class="form-label fw-bold"
                            >Status :</label
                          >
                          <select name="status" class="form-select">
                            <option selected></option>
                            <option value="Working">Working</option>
                            <option value="Leaved">Leaved</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-12">
                        <label for="remarks" class="form-label fw-bold"
                          >Remarks :</label
                        >
                        <textarea
                          name="remarks"
                          rows="2"
                          class="form-control"
                        ></textarea>
                      </div>
                    </div>

                    <!-- documents -->
                    <div class="tab-pane fade" id="documents-section">
                      <div class="row" id="document-upload-container">
                        <div class="col-2">
                          <label for="document_file" class="form-label fw-bold"
                            >Choose documents:</label
                          >
                          <input
                            type="file"
                            class="form-control document-file"
                            name="document_files[]"
                          />
                        </div>

                        <div class="col-3">
                          <label for="inputNanme4" class="form-label fw-bold"
                            >Document Type:</label
                          >
                          <select
                            name="document_type[]"
                            class="form-select document-type"
                          >
                            <option selected>Choose Document Type</option>
                            <option value="License">License</option>
                          </select>
                        </div>

                        <div class="col-3">
                          <label for="document_name" class="form-label fw-bold"
                            >Document Name:</label
                          >
                          <input
                            type="text"
                            class="form-control document-name"
                            name="document_name[]"
                          />
                        </div>

                        <div class="col-3">
                          <label for="remarks" class="form-label fw-bold"
                            >Remarks:</label
                          >
                          <input
                            type="text"
                            class="form-control remarks"
                            name="remarks[]"
                          />
                        </div>

                        <div class="col-1 py-4">
                          <button type="button"  class="btn btn-lg btn-primary add-row-btn" onclick="cloneDocumentUploadRow(this)">
                            +
                          </button>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="bank-details-section">
                      <div class="col-4">
                        <label for="bank_name" class="form-label fw-bold"
                          >Bank Name</label
                        >
                        <input
                          type="text"
                          class="form-control"
                          name="bank_name"
                        />
                      </div>
                      <div class="col-4">
                        <label for="account_number" class="form-label fw-bold"
                          >Account No. :</label
                        >
                        <input
                          type="text"
                          class="form-control"
                          name="account_number"
                        />
                      </div>

                      <div class="col-4">
                        <label for="branch_name" class="form-label fw-bold"
                          >Branch Name:</label
                        >
                        <input
                          type="text"
                          class="form-control"
                          name="branch_name"
                        />
                      </div>
                      <div class="col-4">
                        <label for="ifsc_code" class="form-label fw-bold"
                          >IFSC code:</label
                        >
                        <input
                          type="text"
                          class="form-control"
                          name="ifsc_code"
                        />
                      </div>
                    </div>
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
