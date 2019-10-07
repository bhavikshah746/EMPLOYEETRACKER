<?php 
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

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
        <!-- partial:partials/_sidebar.html -->
        <?php require_once("sidebar.php"); ?>
        <!-- partial -->

        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> New Task Form </h3>
            </div>
            <div class="row">
              
              
              
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">From Details</h4>
                    <form class="form-sample">
                      <div class="row">
                      
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Task Name</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="fName"/>
                            </div>
                          </div>
                        </div>
                        
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Task Details</label>
                            <div class="col-sm-9">
                            <textarea class="form-control" col="50" rows="5" id="taskDetails"></textarea>
                            </div>
                          </div>
                        </div>

                      </div>

                      <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Assign To</label>
                                <div class="col-sm-9">
                                    <select class="form-control" placeholder="dd/mm/yyyy" id="DOB">
                                        <option>Select Employee</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                      </div>
                    
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label"> Location </label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="addr1"/>
                            </div>
                          </div>
                        </div>

                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">address 2</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="addr2"/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Postcode</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="pCode"/>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">City</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="city"/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">State</label>
                            <div class="col-sm-9">
                              <select class="form-control" id="state">
                                <option value="defaultValue" selected>Select State</option>  
                                <option value="QLD">QLD</option>
                                <option value="NSW">NSW</option>
                                <option value="VIC">VIC</option>
                                
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <button class="btn btn-info btn-fw" id="btnSubmit" omClick="fn_save_profile()" disabled>Save</button>
                    </form>
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
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <!-- endinject -->

    <!-- Custom js for this page -->
    <script src="assets/js/file-upload.js"></script>
    <script src="js/addtask.js"></script>
    <!-- End custom js for this page -->
  </body>
</html>