<?php
// session_start();
include("include/connection.php");

// if (!isset($_SESSION["admin_id"])) {
//     header("location:login.php");
//     exit();
// }

// Default values for filter criteria
$cemail = isset($_POST['email']) ? $_POST['email'] : 'All';
$fdate = isset($_POST['fdate']) ? $_POST['fdate'] : '';
$tdate = isset($_POST['tdate']) ? $_POST['tdate'] : '';

// Modify the query based on the selected center
if ($cemail == 'All') {
    $query = "SELECT fname, lname, course, cname, doa, id FROM aa_students WHERE doa BETWEEN '$fdate' AND '$tdate'";
} else {
    $query = "SELECT fname, lname, course, cname, doa, id FROM aa_students WHERE doa BETWEEN '$fdate' AND '$tdate' AND cemail='$cemail'";
}

$result = mysqli_query($conn, $query);

// Fetch the student records and store them in an array
$studentRecords = array();
while ($row = mysqli_fetch_assoc($result)) {
    $studentRecords[] = $row;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Student Report</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/logo1.png" rel="icon">
  <link href="assets/img/logo1.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Mar 09 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  <style>
    .report{
        border-radius:5px;
        font-weight:bold;
    }
    input[type=date]{
        border-radius:5px;
        width:200px;
        height:40px;
        font-weight:bold;
    }
    button{
        width:100px;
        height:40px;
        border-radius:5px;
        background:gold;
        font-weight:bold;
        color:black;
        border:none;
    }
    input[type=text]{
      border-radius:5px;
      width:300px;
      height:40px;
    }
    
  </style>
</head>

<body>

<?php
include('include/header.php');

?>
 
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Report</h1>
            <section class="section">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <br>
                                <div class="report">
                                    <form method="post" action="">
                                        From &nbsp;<input type="date" class="form-control" id="startDate" name="fdate">
                                       
                                        To &nbsp;<input type="date" id="endDate" class="form-control" name="tdate">
                                        &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                                        <select id="courseSelect" class="form-select" name="email">
                                            <option value="none" selected disabled>Select a Centre</option>
                                            <option value="All">All</option>
                                            <?php
                                            include('include/connection.php');
                                            // Query to fetch center names and email addresses from aa_franchise table
                                            $query = "SELECT cname, email FROM aa_franchise WHERE status='Approve' ";
                                            // Execute the query
                                            $result = mysqli_query($conn, $query);
                                            // Check if there are any rows in the result
                                            if (mysqli_num_rows($result) > 0) {
                                                // Loop through the rows and display each center name as an option
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $selected = ($row['email'] == $cemail) ? 'selected' : '';
                                                    echo '<option value="' . $row['email'] . '" ' . $selected . '>' . $row['cname'] . '</option>';
                                                }
                                            } else {
                                                echo '<option value="">No centers found</option>';
                                            }
                                            ?>
                                        </select>
                                       <br>
                                        <button type="submit" >Show</button>
                                    </form>
                                </div>
                                <br>
                                <div class="table-responsive">
                                    <!-- Table with stripped rows -->
                                    <table class="table datatable">
                                        <thead>
                                            <tr>
                                                <th scope="col">Slno</th>
                                                <th scope="col">Id</th>
                                                <th scope="col">Student Name</th>
                                                <th scope="col">Course</th>
                                                <th scope="col">Centre</th>
                                                <th scope="col">Date of Addmission</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $rank = 1;
                                            if (count($studentRecords) > 0) {
                                                foreach ($studentRecords as $row) {
                                                    echo '<tr>';
                                                    echo '<td>' . $rank . '</td>';
                                                    echo '<td>' . $row['id'] . '</td>';
                                                    echo '<td>' . $row['fname'] . '&nbsp;' . $row['lname'] . '</td>';
                                                    echo '<td>' . $row['course'] . '</td>';
                                                    echo '<td>' . $row['cname'] . '</td>';
                                                    echo '<td>' . $row['doa'] . '</td>';
                                                    echo '</tr>';
                                                    $rank++;
                                                }
                                            } else {
                                                // No student data found based on the selected criteria
                                                echo '<tr><td colspan="6">No records found</td></tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <!-- End Table with stripped rows -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
<?php
include('include/footer.php');
?>
  

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
 
</body>

</html>