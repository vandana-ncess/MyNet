<?php 
    $conn = require_once('databaseconnection.php');
    $emp_ID = $_GET['empID'];
    $sql = "SELECT A.employeeID,employeeCode,employeeName,categoryName,divisionName,designation,intime,outtime FROM employee A JOIN employee_attendance "
            . " B ON A.employeeID = B.employeeID AND B.date = ' " . date('Y-m-d') . "' JOIN division C on A.divisionID = C.divisionID JOIN designation D ON A.designationID = D.designationID "
            . " JOIN category E ON E.categoryID = A.categoryID WHERE A.employeeID=" . $emp_ID;
    $result = mysqli_query($conn,$sql);
    $data = mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>NCESS INTRANET</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="index.php">NCESS INTRANET</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
            <a class="nav-link" href="attendance.php">
            <i class="fa fa-fw"></i>
            <span class="nav-link-text">Today's Attendance</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
            <a class="nav-link" href="leaveHistory.php">
            <i class="fa fa-fw"></i>
            <span class="nav-link-text">Reports</span>
          </a>
        </li>
         
      </ul>
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      
    
       <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        
        </ul>
    </div>
  </nav>
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index.html">Dashboard</a>
        </li>
        <li class="breadcrumb-item active"> Employee Details</li>
      </ol>
      <div class="row">
        <div class="col-12" style="padding-left: 80px;padding-top: 20px;">
            <table >
                <tr>
                    <td> Empoyee Code </td> <td style="padding-left: 50px;"><?php $empCode = $data['employeeCode']; echo $empCode; ?></td> <td style="padding-left: 50px;">Name</td><td style="padding-left: 50px;"> <?php echo $data['employeeName'] ?></td>
                </tr>
                <tr>
                    <td>Category </td><td style="padding-left: 50px;"><?php echo $data['categoryName'] ?></td><td style="padding-left: 50px;">Division</td><td style="padding-left: 50px;"><?php echo $data['divisionName'] ?></td>
                </tr>
                <tr>
                    <td>Designation</td><td style="padding-left: 50px;"><?php echo $data['designation'] ?></td><td style="padding-left: 50px;">In Time : <?php echo $data['intime'] ?> &nbsp;&nbsp; Out Time : <?php echo $data['outtime'] ?>
                </tr>
                <tr>
                    <td colspan="4"><h2>Leave Details</h2></td>
                </tr>
                <tr>
                    <?php
                        $sql = "SELECT leaveType,startDate,endDate FROM employee_leave A JOIN leave_type B ON A.leaveTypeID =  B.leaveTypeID WHERE "
                                . " startDate <= '" . date('Y-m-d') . "' AND endDate >= '" . date('Y-m-d') . "' AND employeeCode = " . $empCode;
                        $result = mysqli_query($conn,$sql);
                        if(mysqli_num_rows($result)>0)
                        {
                            $data = mysqli_fetch_array($result);
                            echo "<td>Leave Type  " . $data['leaveType'] . "</td><td>StartDate " . $data['startDate'] . "</td><td>End Date : " . $data['endDate'] . "</td>";
                       
                        }
                        else 
                            echo "<td colspan='4'>No Data!</td>";
                        
                    ?>
                </tr>
                 <tr>
                    <td colspan="4"><h2>Tour Details</h2></td>
                </tr>
                <tr>
                    <td colspan="4">
                    <table
                        <tr>
                    <?php
                        $sql = "SELECT place,startDate,endDate,remarks FROM employee_tour  WHERE "
                                . " startDate <= '" . date('Y-m-d') . "' AND endDate >= '" . date('Y-m-d') . "' AND employeeCode = " . $empCode;
                        $result = mysqli_query($conn,$sql);
                        if(mysqli_num_rows($result)>0)
                        {
                            $data = mysqli_fetch_array($result);
                            echo "<td>Place  :  </td><td>" . $data['place'] . "</td></tr><tr><td>StartDate</td><td> " . $data['startDate'] . "</td><td style='padding-left:50px;'>End Date : </td><td>" . $data['endDate'] . "</td></tr><tr><td>Purpose : " . $data['remarks'] . "</td>";
                       
                        }
                        else 
                            echo "<td colspan='4'>No Data!</td>";
                        
                    ?>
                        </tr>
                    </table>
                    </td>
                </tr>
            </table>
          </div>
      </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
         Copyright © 2018 <a href="#">NCESS</a> | Contact Us : adm@ncess.gov.in | Ext : 1669 
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
  </div>
</body>

</html>
