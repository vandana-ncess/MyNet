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
    $empID=$_GET['empID'];
    $conn = require_once('databaseconnection.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
<link rel="shortcut icon" href="images/logo1.png" type="image/x-icon"/>
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
    <div id="templatemo_main"><span id="main_top"></span><span id="main_bottom"></span>
    	
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
        
        <div id="templatemo_content">
        	<div class="content_box" style="padding-top: 10px;padding-bottom: 10px;">
                    <?php
                         $sql = "SELECT A.employeeID,emailID,mobileNo,extension,A.employeeCode,employeeName,categoryName,divisionName,designation,intime,outtime,profilePath FROM employee A LEFT JOIN employee_attendance "
            . " B ON A.employeeID = B.employeeID AND B.date = ' " . date('Y-m-d') . "' JOIN division C on A.divisionID = C.divisionID JOIN designation D ON A.designationID = D.designationID "
            . " JOIN category E ON E.categoryID = A.categoryID WHERE A.employeeCode=" . $empID;
                        
                        $result = mysqli_query($conn,$sql);
                        $data1 = mysqli_fetch_array($result);
                    ?>
                    <table style="font-size: 15px;color: #666;">
                <tr>
                    <td> Employee Code </td> <td style="padding-left: 50px;"><?php $empCode = $data1['employeeCode']; echo $empCode; ?></td> 
                    <td rowspan="5" colspan="2" style="padding-left: 20px;"> <img <?php echo 'src="images/profile/' . $empID . '.jpg"';  ?> width="170px" height="190px"/> </td>
                </tr>
                        <tr>
                            <td>Name</td><td style="padding-left: 50px;"> <?php echo $data1['employeeName'] ?></td>
                        </tr>
               
                <tr>
                    <td >Division</td><td style="padding-left: 50px;"><?php echo $data1['divisionName'] ?></td>
                </tr>        
                <tr>
                    <td>Designation</td><td style="padding-left: 50px;"><?php echo $data1['designation'] ?></td>
                    
                </tr>
                        <tr>
                    <td >Email ID</td><td style="padding-left: 50px;"><?php echo $data1['emailID'] ?></td>
                </tr>        
                <tr>
                    <td>Mobile No.</td><td style="padding-left: 50px;"><?php echo $data1['mobileNo'] ?></td>
                    <td align="right"><a <?php echo 'href="' . $data1["profilePath"]. '" target="_blank"' ?> > <input type="button" name="btn" value="View Profile" style="border-radius: 22px;" /></a></td>
                </tr>
                       
                
            </table>
          </div>
            <div class="content_box" style="padding-top: 10px;padding-bottom: 10px;">
                <?php 
                    $sql = "SELECT B.intime,B.outtime,leaveType,shortname,place, H.outtime as gateout, H.intime as gatein,B.status  FROM employee A JOIN employee_attendance B ON A.employeeID = B.employeeID "
                            . " LEFT JOIN gate_register H ON A.employeeCode = H.employeeCode AND H.date = '" . date('Y-m-d') . "' LEFT JOIN employee_tour F ON A.employeeCode = F.employeeCode AND "
                            . "F.startDate <= '" . date('Y-m-d') . "' AND F.endDate >= '" .  date('Y-m-d') . "' LEFT JOIN employee_leave E ON A.employeeCode  = E.employeeCode"
                            . " AND E.startDate <= '" . date('Y-m-d') . "' AND E.endDate >= ' " . date('Y-m-d') . "' LEFT JOIN leave_type G ON E.leaveTypeID = G.leaveTypeID WHERE A.employeeCode=".$empID." AND b.date ='" . date('Y-m-d') . "';";
                    $result = mysqli_query($conn,$sql);
                    $row = mysqli_fetch_array($result)
                ?>
                <table class="tab">
                    <tr>
                        <td colspan="3">
                            <h5>Attendance Today</h5>
                        </td>
                    </tr>
                     <tr>
                         <td>In Time</td><td>:</td><td><?php echo $row['intime']; ?></td>
                    </tr>
                    <tr>
                         <td>Out Time</td><td>:</td><td><?php echo $row['outtime']; ?></td>
                    </tr>
                    <tr>
                         <td>Leave</td><td>:</td><td><?php echo $row['leaveType']; ?></td>
                    </tr>
                    <tr>
                         <td>Tour</td><td>:</td><td><?php $row['place'] ?></td>
                    </tr>
                    <tr>
                         <td>Gate Register</td><td>:</td><td><?php echo $row['gateout']. " - ".$row['gateout']; ?></td>
                    </tr>
                </table>
                
                
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

</html>