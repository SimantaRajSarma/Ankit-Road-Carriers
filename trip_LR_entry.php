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
                <h5 class="card-title text-center">Trip Entry</h5>
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
                <div class="col-4">
                    <label for="vehicle_no" class="form-label fw-bold">Vehicle No. :</label>
                    <select name="vehicle_no" class="form-select">
                        <option selected disabled>Select vehicle</option>
                        <?php 
                          $vehicle_numbers = fetchVehicleNumbers($conn);

                        foreach ($vehicle_numbers as $vehicle_number): ?>
                            <option value="<?php echo $vehicle_number; ?>"><?php echo $vehicle_number; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-4">
                  <label for="lr_date" class="form-label fw-bold">LR Date :</label>
                  <input
                      type="date"
                      name="lr_date"
                      class="form-control"
                      value="<?php echo date('Y-m-d'); ?>"
                      required
                  />
              </div>
              <div class="col-4">
                <label for="lr_number" class="form-label fw-bold">LR No. :</label>
                <input
                    name="lr_number"
                    class="form-control"
                    value="<?= $lr_number; ?>"
                    readonly
                />
            </div>
                </div>
                <div class="row">
                  <div class="col-4">
                    <label for="product" class="form-label fw-bold"
                      >Product :</label
                    >
                      <select name="product" class="form-select">
                          <option selected disabled>Select Product</option>
                          <?php 
                          $product_names = fetchProductNames($conn);
                          foreach ($product_names as $product_name): ?>
                              <option value="<?php echo $product_name; ?>"><?php echo $product_name; ?></option>
                          <?php endforeach; ?>
                      </select>
                  </div>

                  <div class="col-4">
                    <label for="from_station" class="form-label fw-bold"
                      >From Stat. :</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      name="from_station"
                      placeholder="From Station"
                      required
                    />
                  </div>

                  <div class="col-4">
                    <label for="to_station" class="form-label fw-bold"
                      >To Stat. :</label
                    >
                    <input
                      type="text"
                      name="to_station"
                      class="form-control"
                      placeholder="To Station"
                      required
                    />
                  </div>
              </div>
                    
                <div class="row">
                  <div class="col-3">
                    <label for="bill_mode" class="form-label fw-bold"
                      >Bill Mode :</label
                    >
                   <select name="bill_mode" class="form-select">
                    <option value="TO BE BLLED">TO BE BLLED</option>
                    <option value="TO PAY">TO PAY</option>
                    <option value="PAID">PAID</option>
                   </select>
                  </div>

                  <div class="col-9">
                    <label for="party_name" class="form-label fw-bold"
                      >Party Name :</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      name="party_name"
                      placeholder="Enter Party Name"
                      required
                    />
                  </div>
                </div>

                <h5 class="card-title text-center">LR Entry</h5>
                <div class="row">
                  <div class="col-4">
                    <label for="lr_type" class="form-label fw-bold"
                      >LR type :</label
                    >
                    <select name="lr_type" class="form-select">
                      <option selected disabled>Select</option>
                      <option value="SINGLE">SINGLE</option>
                      <option value="MULTIPLE">MULTIPLE</option>
                    </select>
                  </div>

                  <div class="col-4">
                    <label for="loading_weight" class="form-label fw-bold"
                      >Loading Weight(MT) :</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      name="loading_weight"
                      required
                    />
                  </div>

                  <div class="col-4">
                    <label for="unload_weight" class="form-label fw-bold"
                      >Unload Weight(MT) :</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      name="unload_weight"
                      required
                    />
                  </div>
                </div>
                  <div class="col-6">
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

                  <div class="col-8">
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
                  <div class="col-4">
                    <label for="cr_dr" class="form-label fw-bold">Type:</label>
                    <select name="cr_dr" class="form-select">
                      <option selected disabled></option>
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
                            <option selected disabled></option>
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
                            <option selected disabled></option>
                            <option value="Fixed">Fixed</option>
                            <option value="Pay">Pay</option>
                          </select>
                        </div>
                        <div class="col-4">
                          <label for="status" class="form-label fw-bold"
                            >Status :</label
                          >
                          <select name="status" class="form-select">
                            <option selected disabled></option>
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
                            <option selected disabled>Choose Document Type</option>
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
