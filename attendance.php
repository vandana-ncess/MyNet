<?php 
    session_start();
    if(!isset($_SESSION['user']))
        echo "<script>document.location='index.php';</script>";
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        // last request was more than 30 minutes ago
        session_unset();     // unset $_SESSION variable for the run-time 
        session_destroy();   // destroy session data in storage
        echo "<script>document.location='index.php';</script>";
    }
    else {
        $_SESSION['LAST_ACTIVITY'] = time();   
   }
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
$sql = "SELECT COUNT(*) as empNo FROM employee_attendance A JOIN employee B ON A.employeeID = B.employeeID WHERE date = '" . date('Y-m-d') . "' AND intime <> '' AND outtime='';";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0)
{
    $data = mysqli_fetch_array($result);
    $pre_no = $data['empNo'];
}
$sql = "SELECT MAX(lastUpdated) as last FROM employee_attendance";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0)
{
    $data = mysqli_fetch_array($result);
    $pre_last=$data['last'];
}
$sql = "SELECT COUNT(*) as empNo FROM employee_leave WHERE startDate <= '" .date('Y-m-d'). "' AND endDate >= '" . date('Y-m-d') . "';";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0)
{
    $data = mysqli_fetch_array($result);
    $leave_no = $data['empNo'];
}
$sql = "SELECT MAX(lastUpdated) as last FROM employee_leave";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0)
{
    $data = mysqli_fetch_array($result);
    $leave_last=$data['last'];
}
$sql = "SELECT COUNT(*) as empNo FROM employee_tour WHERE startDate <= '" .date('Y-m-d'). "' AND endDate >= '" . date('Y-m-d') . "';";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0)
{
    $data = mysqli_fetch_array($result);
    $tour_no = $data['empNo'];
}
$sql = "SELECT MAX(lastUpdated) as last FROM employee_tour";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0)
{
    $data = mysqli_fetch_array($result);
    $tour_last=$data['last'];
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>NCESS Intranet</title>
<meta name="keywords" content="free css templates, web design, 2-column, html css" />
<meta name="description" content="Web Design is a 2-column website template (HTML/CSS) provided by templatemo.com" />
<link href="templatemo_style.css" rel="stylesheet" type="text/css" />
<!--////// CHOOSE ONE OF THE 3 PIROBOX STYLES  \\\\\\\-->
<link href="css_pirobox/white/style.css" media="screen" title="shadow" rel="stylesheet" type="text/css" />
<!--<link href="css_pirobox/white/style.css" media="screen" title="white" rel="stylesheet" type="text/css" />
<link href="css_pirobox/black/style.css" media="screen" title="black" rel="stylesheet" type="text/css" />-->
<!--////// END  \\\\\\\-->
  <!-- Custom fonts for this template-->
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
   <link rel="shortcut icon" href="images/logo1.png" type="image/x-icon"/>

  <!-- Custom styles for this template-->
<!--////// INCLUDE THE JS AND PIROBOX OPTION IN YOUR HEADER  \\\\\\\-->
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/piroBox.1_2.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$().piroBox({
			my_speed: 600, //animation speed
			bg_alpha: 0.5, //background opacity
			radius: 4, //caption rounded corner
			scrollImage : false, // true == image follows the page, false == image remains in the same open position
			pirobox_next : 'piro_next', // Nav buttons -> piro_next == inside piroBox , piro_next_out == outside piroBox
			pirobox_prev : 'piro_prev',// Nav buttons -> piro_prev == inside piroBox , piro_prev_out == outside piroBox
			close_all : '.piro_close',// add class .piro_overlay(with comma)if you want overlay click close piroBox
			slideShow : 'slideshow', // just delete slideshow between '' if you don't want it.
			slideSpeed : 4 //slideshow duration in seconds(3 to 6 Recommended)
	});
});
</script>
<!--////// END  \\\\\\\-->
</head>
<body>

<div id="templatemo_body_wrapper">
<div id="templatemo_wrapper">
   
	<div id="tempaltemo_header">
            <?php if(isset($_SESSION['user'])) { ?><p align="right" style="padding-right: 50px;color:#fff;"><b><?php        echo 'Welcome ' . $_SESSION['user']; ?></b>&nbsp; <a href="logout.php" style="color: #fff;">Logout</a></p>;<?php } ?>
    	<span id="header_icon"></span>
    	<div id="header_content">
        	<div id="site_title">
				    <p>Welcome to NCESS Family</p>         </div>
           
		 
		</div>
    </div> <!-- end of header -->
    
    <div id="templatemo_main_top"></div>
    <div id="templatemo_main" style="padding-right: 0px;width:930px;"><span id="main_top"></span><span id="main_bottom"></span>
    	
        <div id="templatemo_sidebar">
        
        	<div id="templatemo_menu">
                <?php
                        $menuSql= "SELECT * FROM menu WHERE status=1";
                        $menuRes = mysqli_query($conn,$menuSql);
                        if(mysqli_num_rows($menuRes) > 0) {
                            echo '<ul>';
                            while ($menuData= mysqli_fetch_array($menuRes)) {
                                echo '<li><a href="'.$menuData['menuPage'] . '" target="_parent">' . $menuData['menu'] . '</a></li>';
                            }
                            echo '</ul>'; 
                        }
                    ?>  	
            </div> 
          
            
           
            
            <div class="cleaner"></div>
        </div> <!-- end of sidebar -->
        
        <div id="templatemo_content" style="float: left;padding-left: 30px;width: 655px;">
            
        	<div class="content_box" style="border: 1px;vertical-align: middle; padding-bottom: 0px;padding-left: 10px;width: 685px;">
                <div  style="vertical-align: middle; width:93%;padding-left: 10px;padding-top: 10px;background-color: blueviolet;height: 40px;color: white;font-family: sans-serif;font-size: 20px;">
            	Today's Attendance Summary</div>
                    <table class="attendance" style="width: 645px;">
                        <tr style="background-color:   #F9CFAE;">
                            <td>Total Employees</td><td><?php echo $emp_no; ?></td><td>Last Updated On : <?php echo $pre_last; ?></td>
                            <td><a href="rptToday.php?report=employee&mode=single" target="_blank"> View Details <a/></td>
                        </tr>
                        <tr style="background-color:   #B6F9AE;">
                            <td>Employees Present</td><td><?php echo $pre_no; ?></td><td>Last Updated On : <?php echo $pre_last; ?></td>
                            <td><a href="rptToday.php?report=attendance&mode=single" target="_blank"> View Details <a/></td>
                        </tr>
                        <tr style="background-color:   #F98A9D;">
                            <td>Employees Absent</td><td><?php echo ($emp_no-($pre_no+$leave_no+$tour_no)); ?></td><td>Last Updated On : <?php echo $pre_last; ?></td>
                            <td><a href="rptToday.php?report=absentee&mode=single" target="_blank"> View Details <a/></td>
                        </tr>
                        <tr style="background-color:   #9A95C3;">
                            <td>Employee(s) on Leave</td><td><?php echo $leave_no; ?></td><td>Last Updated On : <?php echo $leave_last; ?></td>
                            <td><a href="rptToday.php?report=leave&mode=single" target="_blank"> View Details <a/></td>
                        </tr>
                        <tr style="background-color:   #E0E472;">
                            <td>Employee(s) on Tour</td><td><?php echo $tour_no; ?></td>
                            <td>Last Updated On : <?php echo $tour_last; ?></td>
                            <td><a href="rptToday.php?report=tour&mode=single" target="_blank"> View Details <a/></td>
                        </tr>
                        <tr style="background-color:   #FFB4FA;">
                            <?php
                                $sql = "SELECT COUNT(*) as cnt FROM employee A JOIN employee_attendance B ON A.employeeID=B.employeeID WHERE TIME_FORMAT(intime,'%H:%i:%s')>TIME_FORMAT('09:31:00','%H:%i:%s') AND date =' " . date('Y-m-d') ."'";
                                $result = mysqli_query($conn,$sql);
                                $row = mysqli_fetch_array($result);
                                $late_no = $row['cnt'];
                            ?>
                            <td>Late Comers</td><td><?php echo $late_no; ?></td>
                            <td>Last Updated On : <?php echo $pre_last; ?></td>
                            <td><a href="rptToday.php?report=late&mode=single" target="_blank"> View Details <a/></td>
                        </tr>
                        <tr style="background-color:   #C8F3F0;">
                            <?php
                                $sql = "SELECT COUNT(*) as cnt FROM employee A JOIN employee_attendance B ON A.employeeID=B.employeeID WHERE TIME_FORMAT(outtime,'%H:%i:%s')<TIME_FORMAT('17:30:00','%H:%i:%s') AND date =' " . date('Y-m-d') ."'";
                                $result = mysqli_query($conn,$sql);
                                $row = mysqli_fetch_array($result);
                                $late_no = $row['cnt'];
                            ?>
                            <td>Early Goers</td><td><?php echo $late_no; ?></td>
                            <td>Last Updated On : <?php echo $pre_last; ?></td>
                            <td><a href="rptToday.php?report=early&mode=single" target="_blank"> View Details <a/></td>
                        </tr>
                    </table>
                
                
          </div>
            <div class="content_box" style="padding-bottom: 0px;padding-left: 2px;">
                <div class="card mb-3" style="box-sizing: border-box;">
        <div class="card-header" style="box-sizing: border-box;background-color: blueviolet;color: #fff;font-size: 18;">
            <i class="fa fa-table" style="box-sizing: border-box;"></i> Today's Attendance List</div>
        <div class="card-body" style="box-sizing: border-box;">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="box-sizing: border-box;color: black;">
                <thead style="background-color: yellowgreen;">
                <tr>
                  <th>Name</th>
                  <th>In Time</th>
                  <th>Out Time</th>
                  <th>Leave</th>
                  <th>Tour</th>
                  <th>Gate Register</th>  
                 <!-- <th>Status</th>-->
                  <th>Status</th>
                  
                </tr>
              </thead>
              <tfoot style="background-color: yellowgreen;">
                <tr>
                  <th>Name</th>
                  <th>In Time</th>
                  <th>Out Time</th>
                  <th>Leave</th>
                  <th>Tour</th>
                  <th>Gate Register</th>
                <!--  <th>Open/Closed</th>-->
                  <th>Status</th>
                  </tr>
              </tfoot>
              <tbody>
                <?php
                    $_SESSION['start'] =  date('Y-m-d');
                    $_SESSION['end'] =  date('Y-m-d');
                    $sql = "SELECT A.employeeID as empID,A.employeeCode,employeeName,divisionName,designation,B.intime,"
                            . "B.outtime,leaveType,shortname,place, H.outtime as gateout, H.intime as gatein,B.status,open_closed_status,TIME_FORMAT(B.outtime,'%H:%i:%s')-TIME_FORMAT(B.intime,'%H:%i:%s') as timediff   FROM employee A JOIN employee_attendance B ON A.employeeID = B.employeeID JOIN division C on "
                            . "A.divisionID = C.divisionID JOIN designation D ON A.designationID = D.designationID LEFT JOIN gate_register H ON A.employeeCode = H.employeeCode "
                            . " AND H.date = '" . date('Y-m-d') . "' AND H.outtime <> '' LEFT JOIN employee_tour F ON A.employeeCode = F.employeeCode AND "
                            . "F.startDate <= '" . date('Y-m-d') . "' AND F.endDate >= '" .  date('Y-m-d') . "' LEFT JOIN employee_leave E ON A.employeeCode  = E.employeeCode"
                            . " AND E.startDate <= '" . date('Y-m-d') . "' AND E.endDate >= ' " . date('Y-m-d') . "' LEFT JOIN leave_type G ON E.leaveTypeID = G.leaveTypeID WHERE A.employeeStatus=1 AND b.date ='" . date('Y-m-d') . "';";
                    $result = mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result) > 0)
                    {
                        while ($row = mysqli_fetch_array($result)) {
                           echo "<tr><td style='color:red;'><a style='color:red;' href='employeeProfile.php?empID=" . $row['employeeCode'] . "' target='_blank'>" . $row['employeeName'] . "</a></td>";
                           echo "<td>" . $row['intime'] . "</td><td>" . $row['outtime'] . "</td>";
                           echo "<td>" . $row['shortname'] . "</td><td>" . $row['place'] . "</td><td align='center'>" . $row['gateout'] . " - " . $row['gatein'] . "</td><td >" ; 
                                  //$row['open_closed_status']. "</td><td >";
                           if($row['status'] == 'A')
                           {
                               if($row['leaveType'] != '')
                                   echo "<span style='color:blue;'>L</span>";
                               else if($row['place'] != '')
                                   echo "<span style='color:orange;'>T</span>";
                               else 
                                   echo "<span style='color:red;'>A</span>";
                           }
                           else {
                               if($row['gateout'] !== null && $row['gatein'] == null)
                                   echo "<span style='color:red;'>A</span>";
                               else if($row['outtime'] != '' && $row['leaveType'] != '')
                                   echo "<span style='color:purple;'>HL</span>";
                               else if($row['outtime'] != '' && $row['leaveType'] == '') {
                                   if($row['timediff']<4)
                                        echo "<span style='color:red;'>A</span>";
                                   else if($row['timediff']<6)
                                        echo "<span style='color:orange;'>HD</span>";
                                    else {
                                        echo "<span style='color:green;'>P</span>";
                                    }
                               }
                               else
                                   echo "<span style='color:green;'>P</span>";
                           }
                           echo "</td></tr>";
                        }
                        
                    }
                ?>
              </tbody>
            </table>
          </div>
            <div><span style='color:green;'>P - Present; </span>&nbsp;<span style='color:red;'> A - Absent; </span>&nbsp;<span style='color:orange;'> HD - Half Day; </span>&nbsp;
                <span style='color:blue;'> L - Leave; </span>&nbsp;<span style='color:purple;'> HL - Half Day Leave; </span>&nbsp;<span style='color:orange;'> T - Tour </span></div>
        </div>
                    
      </div>
          </div>
            
            <div class="content_box" style="padding-bottom: 5px;">
                 
                 <input type="button" name="btnView" id="btnView" value="View Attendance History" onclick="document.location='leaveHistory.php';" style="width: 320px;height: 50px;font-weight: bold;cursor: pointer;background-color: blueviolet;" /> 
                <input type="button" name="btnAttendance" id="btnAttendance" value="NCESS AE-BAS Portal" onclick="window.open('http://ncesskl.attendance.gov.in/','_blank');"  style="width: 320px;height: 50px;font-weight: bold;cursor: pointer;background-color: blueviolet;" /> 
             </div>
            
        </div>
        
        <div class="cleaner"></div>    
    </div>
    
    <div id="templatemo_main_bottom">
    </div>

</div> <!-- end of wrapper -->
</div>

<div id="templatemo_footer_wrapper">
	<div id="templatemo_footer">
        Copyright © 2018 <a href="#">NCESS</a> | Contact Us : adm@ncess.gov.in | Ext : 1669 
        
    </div>
</div>
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
</body>
</html>