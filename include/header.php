 <!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

<div class="d-flex align-items-center justify-content-between">
  <a href="s-dashboard.php" class="logo d-flex align-items-center">
    
    <span class="d-none d-lg-block">Logistics Software</span>
  </a>
  <i class="bi bi-list toggle-sidebar-btn"></i>
</div><!-- End Logo -->



<nav class="header-nav ms-auto">
  <ul class="d-flex align-items-center">

    <li class="nav-item d-block d-lg-none">
      <a class="nav-link nav-icon search-bar-toggle " href="#">
        <i class="bi bi-search"></i>
      </a>
    </li><!-- End Search Icon-->

    <li class="nav-item dropdown">

      <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
        <i class="bi bi-bell"></i>
        <span class="badge bg-primary badge-number">0</span>
      </a>
      <!-- End Notification Icon -->

      <!-- End Notification Dropdown Items -->

    </li><!-- End Notification Nav -->

    <li class="nav-item dropdown">

      <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
        <i class="bi bi-chat-left-text"></i>
        <span class="badge bg-success badge-number">0</span>
      </a><!-- End Messages Icon -->

      <!-- End Messages Dropdown Items -->

    </li><!-- End Messages Nav -->

    <li class="nav-item dropdown pe-3">

      <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
        <!--<img src="../centre/images/6002957819_16887906934711_dp.jpg" alt="Profile" class="rounded-circle">-->
       
        <span class="d-none d-md-block dropdown-toggle ps-2">Logistics Software</span>

      </a><!-- End Profile Iamge Icon -->

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
        <li class="dropdown-header">
          <h6>Logistics Software</h6>
          <span>Admin </span>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="#">
            <i class="bi bi-person"></i>
            <span>My Profile</span>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="#">
            <i class="bi bi-gear"></i>
            <span>Account Settings</span>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="#">
            <i class="bi bi-question-circle"></i>
            <span>Need Help?</span>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="logout.php">
            <i class="bi bi-box-arrow-right"></i>
            <span>Sign Out</span>
          </a>
        </li>

      </ul><!-- End Profile Dropdown Items -->
    </li><!-- End Profile Nav -->

  </ul>
</nav><!-- End Icons Navigation -->


</header><!-- End Header -->


<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="dashboard.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>

      
      <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
            <i class="fa-solid fa-truck"></i><span>Vehicle Management</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                
                  <li class="nav-item">
            <a class="nav-link collapsed" href="add_vehicle.php">
            <i class="fa-solid fa-circle-plus"></i>
              <span>Add Vehicle</span>
            </a>
          </li><!-- End Register Page Nav -->
          
                
                  <li class="nav-item">
            <a class="nav-link collapsed" href="manage_vehicle.php">
            <i class="fa-solid fa-bars-progress"></i>
              <span>Manage Vehicle</span>
            </a>
          </li><!-- End Register Page Nav -->
               
                </ul>
                </li>




                <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav4" data-bs-toggle="collapse" href="#">
            <i class="fa-solid fa-user"></i><span>Driver Management</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav4" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                
                  <li class="nav-item">
            <a class="nav-link collapsed" href="add_driver.php">
            <i class="bi bi-circle"></i>
              <span>Add Driver</span>
            </a>
          </li><!-- End Register Page Nav -->
          
                
                  <li class="nav-item">
            <a class="nav-link collapsed" href="manage_driver.php">
            <i class="bi bi-circle"></i>
              <span>Manage Driver</span>
            </a>
          </li><!-- End Register Page Nav -->
               
                </ul>
                </li>




                <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav7" data-bs-toggle="collapse" href="#">
            <i class="fa-solid fa-box"></i><span>Product Management</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav7" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                
                  <li class="nav-item">
            <a class="nav-link collapsed" href="add_product.php">
            <i class="bi bi-circle"></i>
              <span>Add Product</span>
            </a>
          </li><!-- End Register Page Nav -->
          
                
                  <li class="nav-item">
            <a class="nav-link collapsed" href="manage_product.php">
            <i class="bi bi-circle"></i>
              <span>Manage Product</span>
            </a>
          </li><!-- End Register Page Nav -->
               
                </ul>
                </li>
     
     
     
     
                <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav8" data-bs-toggle="collapse" href="#">
            <i class="fa-solid fa-face-smile"></i><span>Client Management</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav8" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                
                  <li class="nav-item">
            <a class="nav-link collapsed" href="add_client.php">
            <i class="bi bi-circle"></i>
              <span>Add New Client</span>
            </a>
          </li><!-- End Register Page Nav -->
          
                
                  <li class="nav-item">
            <a class="nav-link collapsed" href="manage_client.php">
            <i class="bi bi-circle"></i>
              <span>Manage Clients</span>
            </a>
          </li><!-- End Register Page Nav -->
         
                </ul>
                </li>
     
            <li class="nav-item">
                <a class="nav-link collapsed" href="trip_Lr_entry.php">
                <i class="fa-solid fa-table-list"></i><span>Trip/LR Entry</span>
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link collapsed" href="#">
                <i class="fa-solid fa-table-columns"></i><span>Party Bill Entry</span><i class="fa-solid fa-lock ms-auto"></i>
                </a>
            </li><!-- End Register Page Nav -->
          


            <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#" data-bs-toggle="collapse" href="#">
            <i class="fa-solid fa-paste"></i><span>Reports</span><i class="fa-solid fa-lock ms-auto"></i>
            </a>
            <ul id="#" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                
                  <li class="nav-item">
            <a class="nav-link collapsed" href="add_vehicle.php">
            <i class="fa-solid fa-circle-plus"></i>
              <span>LR Report</span>
            </a>
          </li><!-- End Register Page Nav -->
          
                
                  <li class="nav-item">
            <a class="nav-link collapsed" href="manage_vehicle.php">
            <i class="fa-solid fa-bars-progress"></i>
              <span>Something..</span>
            </a>
          </li><!-- End Register Page Nav -->
               
                </ul>
                </li>

    
      <li class="nav-item">
            <a class="nav-link collapsed" href="#">
            <i class="fa-solid fa-key"></i>
              <span>Change Password</span>
            </a>
          </li>

      <li class="nav-item">
            <a class="nav-link collapsed" href="#">
            <i class="fa-solid fa-right-from-bracket"></i>
              <span>Log Out</span>
            </a>
          </li>
      <!-- End Profile Page Nav -->
</ul>
  </aside><!-- End Sidebar-->