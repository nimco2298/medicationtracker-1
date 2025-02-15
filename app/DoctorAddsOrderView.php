<?php
session_start();
    
if(!isset($_SESSION['username']) || $_SESSION['role'] != "doctor"){
    header("location:index.php");
}
include_once("OrderController.php");
include_once("DoctorInputsCode.php");
include_once("Model.php");

include_once("Globals.php");
 
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>MedicationTracker | Doctor Dashboard</title>

  <style>

  div.med1 {border-style: groove;}
  div.med2 {border-style: groove;}
  div.med3 {border-style: groove;}
  div.med4 {border-style: groove;}
  </style>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="DoctorPatientsListView.php" class="nav-link">Home</a>
      </li>
     
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
            class="fas fa-th-large"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
            <li class="nav-item d-none d-sm-inline-block">
                <a href="logout.php" class="nav-link">Logout</a>
            </li>
        </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="DoctorPatientsListView.php" class="brand-link">
      <img src="" alt="" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">MedicationTracker</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/doctorimage.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Role: Doctor</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="./DoctorPatientsListView.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Display Patient IDs </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./DoctorAddsOrderView.php" class="nav-link active">
                  <i class="far fa-check-circle nav-icon"></i>
                  <p>Create An Order</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./DoctorDisplaysOrdersView.php" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Display All Orders</p>
                </a>
              </li>
              
            </ul>
          </li>
          

      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"> Hello, Doctor! </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Create An Order</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        

        <!-- /.row -->
        <!-- TABLE: LATEST ORDERS -->
        <div class="card card-secondary">
          <div class="card-header border-transparent">
            <h3 class="card-title"><b>CREATE ORDER</b></h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-plus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>

          <?php

          $nextOrderID = 0;                             
          global $conn;                                  
              if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
              }                                             
           $sql = "SELECT ";
           $sql .= "`order`.`order_id` AS `order_id`";
           $sql .= " FROM `order` ";
           $sql .= " ORDER BY `order_id` ";
           $sql .= " DESC ";
           $sql .= " LIMIT 1";
           $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                   $nextOrderID = (int)$row['order_id'] + 1; //new orderID is set to next orderID availible
              }
           }
                                          
                                    
        ?>
      <!-- form start -->
      <form action="" method="post">
        <div class="card-body">
          <div class="form-group">
            <input type="hidden" class="form-control" id="orderID2" name="inputOrderID1"  value="<?php echo $nextOrderID; ?>">       
          </div>
          <div class="card-body">
            <div class="form-group">
              <label for="inputDate1">Order Creation Date</label>
              <input type="text" class="form-control" id="orderDate1" name="inputOrderDate1"  placeholder="" disabled>
              <script>
                  function genOrderDate() {
                    var orderDate = new Date();;
                    return orderDate;
                  }
                  document.getElementById("orderDate1").value = genOrderDate();
            </script>
            </div>
          <div class="form-group">
            <?php 
             //Code gets doctor's id from Model to be used for creating order
             include_once("Model.php");
             $model = Model::getInstance(); 
             $currDoctor = $model->getCurrentUserId(); 
             ?>
            <input type="hidden" class="form-control" id = "doctorID" name="inputDoctorID1"  value="<?php echo $currDoctor; ?>">
          </div>
          <div class="form-group">
            <label for="inputPatientID1">PatientID</label>
            <input type="text" class="form-control" id = "patientID" name="inputPatientID1" placeholder="Enter the PatientID">
          </div>
         

        <div class="form-group">
          <div class="med1">
            <label>Medication Name</label>
            <select class="form-control" id="med1" name= "inputMedication1">
              <option>lidocaine patch 5%</option> 
              <option>furosemide</option> 
              <option>fluticasone 100mcg </option>
              <option>metformin</option>
              <option>clonidine</option> 
              <option>atenolol</option>  
              <option>albuterol 100mcg </option>
              <option>omeperazole</option>
              <option>carafate</option> 
            </select>
            <label for="inputMedicationQty1">Medication 1 Quantity </label>
            <input type="text" class="form-control" id="medQty1" name="inputMedicationQty1" placeholder="Enter daily dose a patient would take for Medication">
            <div class="form-group">
            <label>Select Administer Time(AM to PM)</label>
            <select class="form-control" id="medTime1" name= "inputMedicationTime1">
              <option>08:00:00</option>
              <option>12:00:00</option>
              <option>04:00:00</option>
              <option>08:00:00</option>
            </select>
            </select>
          </div>
          <div class="med2">
            <label>Medication Name</label>
            <select class="form-control" id="med2" name= "inputMedication2">
              <option>lidocaine patch 5%</option> 
              <option>furosemide</option> 
              <option>fluticasone 100mcg </option>
              <option>metformin</option>
              <option>clonidine</option> 
              <option>atenolol</option>  
              <option>albuterol 100mcg </option>
              <option>omeperazole</option>
              <option>carafate</option>
            </select>
            <label for="inputMedicationQty1">Medication 2 Quantity </label>
            <input type="text" class="form-control" id="medQty2" name="inputMedicationQty2" placeholder="Enter daily dose a patient would take for Medication">
            <label>Select Administer Time(AM to PM)</label>
            <select class="form-control" id="medTime2" name= "inputMedicationTime2">
              <option>08:00:00</option>
              <option>12:00:00</option>
              <option>04:00:00</option>
              <option>08:00:00</option>
            </select>
          </div>
          <div class="med3">
            <label>Medication Name</label>
            <select class="form-control" id="med3" name= "inputMedication3">
              <option>lidocaine patch 5%</option> 
              <option>furosemide</option> 
              <option>fluticasone 100mcg </option>
              <option>metformin</option>
              <option>clonidine</option> 
              <option>atenolol</option>  
              <option>albuterol 100mcg </option>
              <option>omeperazole</option>
              <option>carafate</option>
            </select>
            <label for="inputMedicationQty3">Medication 3 Quantity </label>
            <input type="text" class="form-control" id="medQty3" name="inputMedicationQty3" placeholder="Enter daily dose a patient would take for Medication">
            <label>Select Administer Time(AM to PM)</label>
            <select class="form-control" id="medTime3" name= "inputMedicationTime3">
              <option>08:00:00</option>
              <option>12:00:00</option>
              <option>04:00:00</option>
              <option>08:00:00</option>
            </select>
          </div>

          <div class="med4">
            <label>Medication Name</label>
            <select class="form-control" id="med4" name= "inputMedication4">
              <option>lidocaine patch 5%</option> 
              <option>furosemide</option> 
              <option>fluticasone 100mcg </option>
              <option>metformin</option>
              <option>clonidine</option> 
              <option>atenolol</option>  
              <option>albuterol 100mcg </option>
              <option>omeperazole</option>
              <option>carafate</option>
            </select>
            <label for="inputMedicationQty1">Medication 4 Quantity </label>
            <input type="text" class="form-control" id="medQty4" name="inputMedicationQty4" placeholder="Enter daily dose a patient would take for Medication">
            <label>Select Administer Time(AM to PM)</label>
            <select class="form-control" id="medTime4" name= "inputMedicationTime4">
              <option>08:00:00</option>
              <option>12:00:00</option>
              <option>04:00:00</option>
              <option>08:00:00</option>
            </select>
          </div>
        </div>
       
        <!-- /.card-body -->
        <div class="card-footer">
          <button type="submit" name="submitOrder1"  class="btn btn-primary">Submit Order</button>
        </div>
      </form>
    </div>

    
    
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.2
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="dist/js/demo.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="plugins/raphael/raphael.min.js"></script>
<script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>

<!-- PAGE SCRIPTS -->
<script src="dist/js/pages/dashboard2.js"></script>
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="../../plugins/datatables/jquery.dataTables.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- page script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
</body>
</html>
