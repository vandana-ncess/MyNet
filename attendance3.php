<?php 
    session_start();
    if(!isset($_SESSION['user']))
        echo "<script>document.location='login.php';</script>";
    
?>
<!DOCTYPE html>
<html lang="en">
<?php 
$conn = require_once('databaseconnection.php');
$sql = "SELECT COUNT(*) as empNo,MAX(lastUpdated) as last FROM employee WHERE employeeStatus=1;";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0)
{
    $data = mysqli_fetch_array($result);
    $emp_no = $data['empNo'];
    $emp_last=$data['last'];
}
$sql = "SELECT COUNT(*) as empNo,MAX(lastUpdated) as last FROM employee_attendance WHERE date = '" . date('Y-m-d') . "' AND intime <> '' AND outtime='';";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0)
{
    $data = mysqli_fetch_array($result);
    $pre_no = $data['empNo'];
    $pre_last=$data['last'];
}
$sql = "SELECT COUNT(*) as empNo,MAX(lastUpdated) as last FROM employee_leave WHERE startDate <= '" .date('Y-m-d'). "' AND endDate >= '" . date('Y-m-d') . "';";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0)
{
    $data = mysqli_fetch_array($result);
    $leave_no = $data['empNo'];
    $leave_last=$data['last'];
}
$sql = "SELECT COUNT(*) as empNo,MAX(lastUpdated) as last FROM employee_tour WHERE startDate <= '" .date('Y-m-d'). "' AND endDate >= '" . date('Y-m-d') . "';";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0)
{
    $data = mysqli_fetch_array($result);
    $tour_no = $data['empNo'];
    $tour_last=$data['last'];
}
?>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>NCESS Intranet</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {

    var data = google.visualization.arrayToDataTable([
      ['Language', 'Rating'],
      <?php
      $sql = "SELECT timerange, COUNT(timerange) as total FROM employee_attendance WHERE date = '" . date('Y-m-d') . "' AND timerange <> '' GROUP BY timerange order by timegraph;";
      $result = mysqli_query($conn,$sql);
      if(mysqli_num_rows($result) > 0){
          while($row = mysqli_fetch_array($result)){
            echo "['".$row['timerange']."', ".$row['total']."],";
          }
      }
      ?>
    ]);
    var chart = new google.visualization.PieChart(document.getElementById('divPieChart'));
    var options = {
        title: 'In-Time Statistics',
        width: 400,
        height: 250,
                  legend: { position: 'bottom' }

    };
    
    chart.draw(data, options);
       
    var data1 = google.visualization.arrayToDataTable([
      ['In-Time', 'In-Time Trend'],
      <?php
     $sql = "SELECT timegraph, COUNT(timegraph) as total FROM employee_attendance WHERE date = '" . date('Y-m-d') . "' AND timegraph <> '' GROUP BY timegraph ;";
      $result = mysqli_query($conn,$sql);
      if(mysqli_num_rows($result) > 0){
          while($row = mysqli_fetch_array($result)){
            echo "['".$row['timegraph']."', ".$row['total']."],";
          }
      }
      ?>
    ]);
    
    var line = new google.visualization.LineChart(document.getElementById('divLineChart'));

    var options = {
        title: 'In-Time Statistics',
        width: 500,
        height: 250,
                  curveType: 'function',

                  legend: { position: 'bottom' }

    };
    
    line.draw(data1,options);
}
</script>

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
      
    </div>
  </nav>
  <div  class="content-wrapper">
    <div  class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">My Dashboard</li>
      </ol>
      <!-- Icon Cards-->
      <div class="row">
          <div class="col-xl-3 col-sm-6 mb-3" style="width: 350px;">
          <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw "></i>
              </div>
              <div class="mr-5"><?php echo $emp_no; ?> Total Employees!</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="#">
              <span class="float-left"><?php echo "last Updated On : " . $emp_last . " &nbsp; &nbsp; &nbsp; &nbsp;"; ?></span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw "></i>
              </div>
              <div class="mr-5"><?php echo $pre_no; ?> Employee(s) Present</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="#">
              <span class="float-left"><?php echo "last Updated On : " . $pre_last; ?></span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-danger o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw "></i>
              </div>
              <div class="mr-5"><?php echo $leave_no; ?> Employee(s) on leave!</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="#">
              <span class="float-left"><?php echo "last Updated On : " . $leave_last; ?></span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-warning o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw "></i>
              </div>
              <div class="mr-5"><?php echo $tour_no; ?> Employee(s) on Tour!</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="#">
              <span class="float-left"><?php echo "last Updated On : " . $tour_last; ?></span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
      </div>
      <!-- Area Chart Example-->
      
      <div class="row">
        <div class="col-lg-8">
          <!-- Example Bar Chart Card-->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa "></i> Line Chart </div>
              <div class="card-body" id="divLineChart">
                    
              </div>
            </div>
          </div>
        <div class="col-lg-4">
          <!-- Example Pie Chart Card-->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-pie-chart"></i> Pie Chart</div>
            <div class="card-body" id="divPieChart">
            </div>
          </div>
          <!--               <canvas id="myPieChart" width="100%" height="100"></canvas>
-->
                </div> 
  
       </div>
     
       </div>
      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Attendance Today</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Division</th>
                  <th>Designation</th>
                  <th>In Time</th>
                  <th>Out Time</th>
                  <th>Leave</th>
                  <th>Tour</th>
                  <th>Gate Register</th>                 
                  <th>Status</th>
                  
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Name</th>
                  <th>Division</th>
                  <th>Designation</th>
                  <th>In Time</th>
                  <th>Out Time</th>
                  <th>Leave</th>
                  <th>Tour</th>
                  <th>Gate Register</th>
                  <th>Status</th>
                  </tr>
              </tfoot>
              <tbody>
                <?php
                    $sql = "SELECT A.employeeID as empID,employeeName,divisionName,designation,B.intime,"
                            . "B.outtime,leaveType,place, H.outtime as gateout, H.intime as gatein,B.status  FROM employee A JOIN employee_attendance B ON A.employeeID = B.employeeID JOIN division C on "
                            . "A.divisionID = C.divisionID JOIN designation D ON A.designationID = D.designationID LEFT JOIN gate_register H ON A.employeeCode = H.employeeCode "
                            . " AND H.date <= '" . date('Y-m-d') . "' AND H.outtime <> '' LEFT JOIN employee_tour F ON A.employeeCode = F.employeeCode AND "
                            . "F.startDate <= '" . date('Y-m-d') . "' AND F.endDate >= '" .  date('Y-m-d') . "' LEFT JOIN employee_leave E ON A.employeeCode  = E.employeeCode"
                            . " AND E.startDate <= '" . date('Y-m-d') . "' AND E.endDate >= ' " . date('Y-m-d') . "' LEFT JOIN leave_type G ON E.leaveTypeID = G.leaveTypeID WHERE A.employeeStatus=1 AND b.date ='" . date('Y-m-d') . "';";
                    $result = mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result) > 0)
                    {
                        while ($row = mysqli_fetch_array($result)) {
                           echo "<tr><td><a href='empSearch.php?empID=" . $row['empID'] . "' target='_blank'>" . $row['employeeName'] . "</a></td>";
                           echo "<td>" . $row['divisionName'] . "</td><td>" . $row['designation'] . "</td><td>" . $row['intime'] . "</td><td>" . $row['outtime'] . "</td>";
                           echo "<td>" . $row['leaveType'] . "</td><td>" . $row['place'] . "</td><td>" . $row['gateout'] . " - " . $row['gatein'] . "</td><td >";
                           if($row['status'] == 'A')
                           {
                               if($row['leaveType'] != '')
                                   echo "L";
                               else if($row['place'] != '')
                                   echo "T";
                               else 
                                   echo "A";
                           }
                           else {
                               if($row['gateout'] !== null && $row['gatein'] == null)
                                   echo "A";
                               else
                                   echo 'P';
                           }
                           echo "</td></tr>";
                        }
                        
                    }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © NCESS 2018</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="login.html">Logout</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="js/sb-admin-datatables.min.js"></script>
    <script src="js/sb-admin-charts.min.js"></script>
  </div>
</body>

</html>
