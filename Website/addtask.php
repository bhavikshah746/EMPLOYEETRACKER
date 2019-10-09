<?php 
//start session 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//if user is not logged in then redirect to logout.php fro where he will be redirected to login page
if(empty($_SESSION) || (isset($_SESSION["empID"]) && $_SESSION["empID"]=="")){
    header("Location: logout.php");
}
  

//include Appfunc.php
include_once("function/Appfunc.php");

//create DBFunction object to call its functions
$funcObj = new DBFunction();

//if user is neither admin nor Team Leader then redirect to error.php   
if($funcObj->check_user_type($_SESSION["userID"])==3){
    header("Location: logout.php");
}

//call function to get all the employee name to show in drop down
$userArr = $funcObj->getEmpName();

?>

<!DOCTYPE html>
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
                    <h4 class="card-title">Task Details</h4>
                    
                        <input type="hidden" name="lat" id="lat"/>
                        <input type="hidden" name="lng" id="lng"/>
                        <input type="hidden" name="streetAddress" id="streetAddress"/>
                        <input type="hidden" name="locality" id="locality"/>
                        <input type="hidden" name="administrative_area_level_2" id="administrative_area_level_2"/>
                        <input type="hidden" name="administrative_area_level_1" id="administrative_area_level_1"/>
                        <input type="hidden" name="postal_code" id="postal_code"/>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Task Name</label>
                              <div class="col-sm-9">
                              <input type="text" class="form-control" id="taskName"/>
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
                                    <select class="form-control" id="userSelect">
                                        <option id="0">Select Employee</option>
                                        <?php 
                                            foreach($userArr as $userID=>$userName){
                                                echo "<option id=".$userID.">".$userName."</option>";
                                            }
                                            ?>
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
                              <button class="btn btn-info" id="LocationMaps" onclick="window.open('locationMap.php', 'Employeen Tracker Window', 'window settings');return false;">Select Location</button>
                              <label class="col-sm-6 col-form-label" id="location" value="">  </label>
                            </div> 
                          </div>
                        </div>
                       </div>
                      <button class="btn btn-info btn-fw" id="btnSave" onClick="fn_save_task()">Save</button>
                    
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
    
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <!-- endinject -->

    <!-- Custom js for this page -->
    <script src="assets/js/file-upload.js"></script>
    <script src="js/addTask.js"></script>
    <!-- End custom js for this page -->
  </body>

</html>