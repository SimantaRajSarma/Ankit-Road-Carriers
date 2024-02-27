<?php
  
  session_start();
include("include/connection.php");

if (!isset($_SESSION["admin_id"])) {
    header("location:login.php");
    exit();
}

  // Handle form submission
if (isset($_POST['submit'])) {
  $oldPassword = $_POST['Password'];
  $newPassword = $_POST['Password2'];
  $confirmPassword = $_POST['Password3'];

  // Add your validation and error handling logic here
  $alertClass = ""; // Initialize the alert class
  $alertMessage = ""; // Initialize the alert message

  // Check if old password and new password are the same
  if ($oldPassword === $newPassword) {
      $alertClass = "alert-danger";
      $alertMessage = "Old password and new password cannot be the same.";
  } elseif ($newPassword !== $confirmPassword) {
      // Check if the new password and confirm password match
      $alertClass = "alert-danger";
      $alertMessage = "Password and confirm password do not match.";
  } else {

      // Check if the current password is correct
      $query = "SELECT password FROM sys_moss WHERE password = '$oldPassword'";
      $result = mysqli_query($conn, $query);

      if (mysqli_num_rows($result) === 1) {
          // Update password in the database if the current password is correct
          $updateQuery = "UPDATE sys_moss SET password = '$newPassword' WHERE password = '$oldPassword'";
          $updateResult = mysqli_query($conn, $updateQuery);

          if ($updateResult) {
              // Password updated successfully
              $alertClass = "alert-success";
              $alertMessage = "Password updated successfully";
          } else {
              // Error updating password
              $alertClass = "alert-danger";
              $alertMessage = "Error updating password";
          }
      } else {
          // Current password is not correct
          $alertClass = "alert-danger";
          $alertMessage = "Current password is not correct.";
      }
  }





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
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Change Password</title>

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
<script src="assets/vendor/fontawesome/fontawesome.js"></script>
  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>
<?php

  include('include/header.php');
?>

   <main id="main" class="main">
    <div class="pagetitle">
      <h1>Password Manager</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
          <li class="breadcrumb-item">Academics</li>
          <li class="breadcrumb-item active">Password Manager</li>
        </ol>
      </nav>
    </div>
    <?php if (isset($alertMessage)): ?>
      <div class="alert <?php echo $alertClass; ?> alert-dismissible fade show" role="alert">
    <?php echo $alertMessage; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
            <?php endif; ?> 
    <div class="card">
      <div class="card-body">
        <div class="card-title">
        </div>
        <form class="form-horizontal" action="" method="post" name="password">
          <div class="form-group">
            <label class="control-label col-sm-2">Old Password</label>
            <div class="col-sm-4">
              <input class="form-control" value="" name="Password" type="password" id="Password" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">New Password</label>
            <div class="col-sm-4">
              <input class="form-control" name="Password2" type="new_password" id="Password2" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Confirm New Password</label>
            <div class="col-sm-4">
              <input class="form-control" name="Password3" type="confrm_password" id="Password3" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2"></label>
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-lg btn-primary" name="submit"><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;Save</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </main>
  <!-- ======= Footer ======= -->
  <?php
  include('include/footer.php');
  ?>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>
