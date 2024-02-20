

<?php
session_start();
include("include/connection.php");

if (!isset($_SESSION["admin_id"])) {
    header("location:index.php");
    exit();
}

?>
<?php
include("include/connection.php");

if(isset($_POST['submit'])) {
    $alertClass = ""; // Initialize the alert class
    $alertMessage = ""; // Initialize the alert message

    $date = $_POST['date'];
    $code = $_POST['code'];
    $product_name = $_POST['product_name'];
    $product_group = $_POST['product_group'];
    $unit = $_POST['unit'];
    $cgst = $_POST['cgst'];
    $sgst = $_POST['sgst'];
    $rate = $_POST['rate'];
    $qty = $_POST['qty'];
    $hsn = $_POST['hsn'];
    $godown = $_POST['godown'];
    $remarks = $_POST['remarks'];


    // Check if all required fields are filled
    if(!empty($date)  && !empty($product_name) ) {
        // Proceed with inserting data into the database
        $sql = "INSERT INTO products (date, code, product_name, product_group, unit, cgst, sgst, rate, opening_quantity, hsn_sac_code, godown, remarks) 
                VALUES ('$date', '$code', '$product_name', '$product_group', '$unit', '$cgst', '$sgst', '$rate', '$qty', '$hsn', '$godown', '$remarks')";

        $result = mysqli_query($conn, $sql);

        if($result) {
            // Product added successfully
            $alertClass = "alert-success";
            $alertMessage = "Product Added Successfully";
        } else {
            // Error adding product to database
            $alertClass = "alert-danger";
            $alertMessage = "Error adding product";
        }
    } else {
        // Display an error if any required field is empty
        $alertClass = "alert-danger";
        $alertMessage = "Please fill in all required fields";
    }

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
                <h5 class="card-title text-center">Add New Product</h5>
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


                  <div class="col-6">
                    <label for="date" class="form-label fw-bold"
                      >Date :</label
                    >
                    <input
                      type="date"
                      class="form-control"
                      id="inputNanme4"
                      name="date" 
                     
                      required
                    />
                  </div>
                  <div class="col-6">
                    <label for="vehicle_type" class="form-label fw-bold"
                      >Code :</label
                    >
                    <input
                      type="number"
                      class="form-control"
                      id="inputNanme4"
                      placeholder="Enter Code"
                      name="code"
                     
                     
                    />
                  </div>

                  <div class="col-12">
                    <label for="product_name" class="form-label fw-bold"
                      >Product Name :</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      id="inputNanme4"
                      placeholder="Enter Product Name"
                      name="product_name"
                     
                      required
                    />
                    
                  </div>

                  <div class="col-6">
                    <label for="vehicle_owner" class="form-label fw-bold"
                      >Product Group :</label
                    >
                    <select name="product_group" class="form-select" >
                      <option selected>Choose Group</option>
                      <option value="OWN">OWN</option>
                      <option value="OUTSIDE">OUTSIDE</option>
                    </select>
                  </div>

                  
                  <div class="col-6">
                    <label for="unit" class="form-label fw-bold"
                      >Product Unit :</label
                    >
                    <select name="unit" class="form-select" >
                      <option selected>Choose Unit</option>
                      <option value="OWN">OWN</option>
                      <option value="OUTSIDE">OUTSIDE</option>
                    </select>
                  </div>


                  <div class="col-6">
                    <label for="cgst" class="form-label fw-bold"
                      >CGST (%) :</label
                    >
                    <input
                      type="number"
                      class="form-control"
                      name="cgst"
                      placeholder="Enter CGST (%)"
                     
                    />
                  </div>


 
                  <div class="col-6">
                    <label for="sgst" class="form-label fw-bold"
                      >SGST (%) :</label
                    >
                    <input
                      type="number"
                      class="form-control"
                      name="sgst"
                      placeholder="Enter CGST (%)"
                     
                    />
                  </div>


                  <div class="col-6">
                    <label for="rate" class="form-label fw-bold"
                      >Rate :</label
                    >
                    <input
                      type="number"
                      class="form-control"
                      name="rate"
                      placeholder="Enter Rate"
                      required
                    />
                  </div>





                  <div class="col-6">
                    <label for="qty" class="form-label fw-bold"
                      >Opening Qty :</label
                    >
                    <input
                      type="number"
                      class="form-control"
                      name="qty"
                      placeholder="Enter Opening Qty"
                     
                    />
                  </div>

                  <div class="col-6">
                    <label for="hsn" class="form-label fw-bold"
                      >HSN/SAC Code :</label
                    >
                    <input
                      type="number"
                      class="form-control"
                      id="inputNanme4"
                      name="hsn"
                      placeholder="Enter HSN/SAC Code"
                     
                    />
                  </div>

                  <div class="col-6">
                    <label for="godown" class="form-label fw-bold"
                      >Godown :</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      id="inputNanme4"
                      name="godown"
                      placeholder="Enter Godown"
                    
                    />
                  </div>

                  <div class="col-12">
                    <label for="remarks" class="form-label fw-bold"
                      >Remarks :</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      id="inputNanme4"
                      name="remarks"
                      placeholder="Enter Remarks"
                      
                    />
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
