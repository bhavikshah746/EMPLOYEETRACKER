<?php 
session_start();

if(empty($_SESSION) || (isset($_SESSION["empID"]) && $_SESSION["empID"]=="")){
  header("Location: logout.php");
}

?><!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Employee Tracker</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
    
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <?php require_once("header.php"); ?>
      <!-- partial -->

      <div class="container-fluid page-body-wrapper">

        <!-- sidebar: include sidebar.php -->
        <?php require_once("sidebar.php"); ?>
        <!-- sidebar -->
        
        <div class="main-panel">
          <div class="content-wrapper">
            
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                  <i class="mdi mdi-home"></i>
                </span> Dashboard </h3>
              
            </div>
            
            <!-- Recently Added Tasks -->
            <div class="row">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Recently Added Tasks</h4>
                    <div class="table-responsive">
                      <table class="table" id="recentTaskTbl">
                        <thead>
                          <tr>
                            <th> Assigned User </th>
                            <th> Task Name </th>
                            <th> Task Created Date </th>
                            <!-- Here if you want to add any table header you can add here (Bhavik) -->
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              
            </div>

            <!-- Completed Tasks -->
            <div class="row">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Completed Tasks</h4>
                    <div class="table-responsive">
                      <table class="table" id="completedTaskTbl">
                        <thead>
                          <tr>
                            <th> Assigned User </th>
                            <th> Task Name </th>
                            <th> Task Created Date </th>
                            <!-- Here if you want to add any table header you can add here (Bhavik) -->
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
           
            
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2019 <a href="http://emptrack.ictatjcub.com/" target="_blank">EmployeeTracker</a>. All rights reserved.</span>
              
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    
    <!-- Plugin js for this page -->
    <script src="assets/vendors/chart.js/Chart.min.js"></script>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/dashboard.js"></script>
    <!-- End plugin js for this page -->
    
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <!-- endinject -->
    
    <!-- Custom js for this page -->
    <script src="assets/js/dashboard.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- End custom js for this page -->
  </body>
</html>