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
                    <label for="inputNanme4" class="form-label fw-bold"
                      >Vehicle No. :</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      id="inputNanme4"
                      name="name"
                      placeholder="Enter Member Name"
                    />
                  </div>
                  <div class="col-6">
                    <label for="inputEmail4" class="form-label fw-bold"
                      >Vehicle Type :</label
                    >
                    <select name="vehicle_type" class="form-select">
                      <option selected>Choose Vehicle Type</option>
                    </select>
                  </div>

                  <div class="col-6">
                    <label for="inputPassword4" class="form-label fw-bold"
                      >Owner Type :</label
                    >
                    <select name="owner_type" class="form-select">
                      <option selected>Choose Owner Type</option>
                    </select>
                  </div>

                  <div class="col-6">
                    <label for="inputNanme4" class="form-label fw-bold"
                      >Vehicle Owner :</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      id="inputNanme4"
                      name="position"
                      placeholder="Enter Member Position"
                    />
                  </div>

                  <div class="col-6">
                    <label for="inputNanme4" class="form-label fw-bold"
                      >Capacity :</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      id="inputNanme4"
                      name="position"
                      placeholder="Enter Member Position"
                    />
                  </div>

                  <div class="col-6">
                    <label for="inputNanme4" class="form-label fw-bold"
                      >Vehicle Model Type :</label
                    >
                    <select name="vehicle_model_type" class="form-select">
                      <option selected>Choose Vehicle Model Type</option>
                    </select>
                  </div>

                  <div class="col-6">
                    <label for="inputNanme4" class="form-label fw-bold"
                      >Name of PAN :</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      id="inputNanme4"
                      name="position"
                      placeholder="Enter Member Position"
                    />
                  </div>

                  <div class="col-6">
                    <label for="inputNanme4" class="form-label fw-bold"
                      >PAN Card No. :</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      id="inputNanme4"
                      name="position"
                      placeholder="Enter Member Position"
                    />
                  </div>

                  <h5 class="card-title text-center">Vehicle RTO Details</h5>
                  <hr>
                  <div class="col-12">
                    <label for="inputNanme4" class="form-label fw-bold"
                      >Tax Expiry:</label
                    >
                    <input
                      type="date"
                      class="form-control"
                      id="inputNanme4"
                      name="position"
                    />
                  </div>

                  <!-- Fitness No. -->
                  <div class="col-6">
                    <label for="inputNanme4" class="form-label fw-bold"
                      >Fitness No :</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      id="inputNanme4"
                      name="position"
                    />
                  </div>

                  <div class="col-6">
                    <label for="inputNanme4" class="form-label fw-bold"
                      >Fitness Expiry:</label
                    >
                    <input
                      type="date"
                      class="form-control"
                      id="inputNanme4"
                      name="position"
                    />
                  </div>

                  <!-- Fitness No. end -->

                  <!-- State Permit No. -->
                  <div class="col-6">
                    <label for="inputNanme4" class="form-label fw-bold"
                      >State Permit No. :</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      id="inputNanme4"
                      name="position"
                    />
                  </div>

                  <div class="col-6">
                    <label for="inputNanme4" class="form-label fw-bold"
                      >St. Permit Expiry:</label
                    >
                    <input
                      type="date"
                      class="form-control"
                      id="inputNanme4"
                      name="position"
                    />
                  </div>

                  <!-- State Permit No. end -->

                  <!-- Fitness No. -->
                  <div class="col-6">
                    <label for="inputNanme4" class="form-label fw-bold"
                      >Fitness No :</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      id="inputNanme4"
                      name="position"
                    />
                  </div>

                  <div class="col-6">
                    <label for="inputNanme4" class="form-label fw-bold"
                      >Fitness Expiry:</label
                    >
                    <input
                      type="date"
                      class="form-control"
                      id="inputNanme4"
                      name="position"
                    />
                  </div>

                  <!-- Fitness No. end -->
                  


                  <div class="text-center">
                    <button type="submit" name="submit" class="btn btn-primary">
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
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
  </body>
</html>
