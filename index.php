<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Ankit Road Carrier</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="https://ankitroadcarrier.in/arc_logo.jpg" rel="icon">
  <link href="https://ankitroadcarrier.in/arc_logo.jpg" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  
</head>

<body>
<?php
ob_start();
session_start();
include("include/connection.php");

if (isset($_POST['submit'])) {
  $admin_id = mysqli_real_escape_string($conn, $_POST['username']);
  $pass = mysqli_real_escape_string($conn, $_POST['password']);

  $query = "SELECT * FROM sys_moss WHERE username='$admin_id' && password='$pass'";
  $data = mysqli_query($conn, $query);
  $result = mysqli_num_rows($data);

  if ($result == true) {
    $_SESSION['admin_id'] = $admin_id;

    // Check if the "Remember Me" checkbox is selected
    if (isset($_POST['remember']) && $_POST['remember'] === 'true') {
      // Set a cookie with the username and password that expires in 7 days
      setcookie('remember_username', $admin_id, time() + (7 * 24 * 60 * 60), "/");
      setcookie('remember_password', $pass, time() + (7 * 24 * 60 * 60), "/");
    } else {
      // Clear the "Remember Me" cookie if it exists
      if (isset($_COOKIE['remember_username'])) {
        setcookie('remember_username', '', time() - 3600, "/");
      }
      if (isset($_COOKIE['remember_password'])) {
        setcookie('remember_password', '', time() - 3600, "/");
      }
    }

    header("location:dashboard.php");
  } else {
    echo "<script>alert('Admin ID and Password Incorrect')</script>";
  }
} else {
  // Check if the "Remember Me" cookie exists
  if (isset($_COOKIE['remember_username']) && isset($_COOKIE['remember_password'])) {
    $remember_username = $_COOKIE['remember_username'];
    $remember_password = $_COOKIE['remember_password'];
  }
}
?>


  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="login.php" class="logo d-flex align-items-center w-auto">
                  <img src="https://ankitroadcarrier.in/arc_logo.jpg"  alt="" width="40" height="auto">
                  <span class="d-none d-lg-block">Ankit Road Carrier</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Admin Login</h5>
                    <p class="text-center small">Enter your username & password to login</p>
                  </div>

                  <form class="row g-3 needs-validation" method="POST" action=""  novalidate>

                   
<div class="col-12">
  <label for="yourUsername" class="form-label">Username</label>
  <div class="input-group has-validation">
    <span class="input-group-text" id="inputGroupPrepend">@</span>
    <input type="text" name="username" class="form-control" required <?php if (isset($remember_username)) echo 'value="' . $remember_username . '"'; ?>>
    <div class="invalid-feedback">Please enter your username.</div>
  </div>
</div>

<div class="col-12">
  <label for="yourPassword" class="form-label">Password</label>
  <input type="password" name="password" class="form-control" required <?php if (isset($remember_password)) echo 'value="' . $remember_password . '"'; ?>>
  <div class="invalid-feedback">Please enter your password!</div>
</div>






<div class="col-12">
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe" <?php if (isset($remember_username) && isset($remember_password)) echo 'checked'; ?>>
    <label class="form-check-label" for="rememberMe">Remember me</label>
  </div>
</div>
                    
                    
                    <div class="col-12">
                      <button class="btn btn-primary w-100" name="submit" type="submit">Login</button>
                    </div>
                   
                  </form>

                </div>
              </div>

              <div class="credits">
         
                Designed by <a href="https://www.prakity.com/">Prakity.com</a>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>