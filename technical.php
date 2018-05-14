<?php 
    session_start();
    if(!isset($_SESSION['user']))
        echo "<script>document.location='login.php';</script>";if(!isset($_SESSION['user']))
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
                <ul>
                  <li><a href="index.php" target="_parent">Home</a></li>
                    <li><a href="employees.php" target="_parent"  class="current">Staff</a></li>
                    <li><a href="announcements.php" target="_parent" >Notice Board</a></li>
                    <li><a href="documents.php" target="_parent" >Documents</a></li>
                    <li><a href="attendance.php" target="_parent">Attendance</a></li>
                    <li><a href="eGovernance.php" target="_parent">e-Governance</a></li>
                    <li><a href=http://ncess.gov.in/notifications/awards.html" target="_parent">Awards</a></li>
                    <li><a href="publications.php" target="_parent">Research Publications</a></li>
                    <li><a href="http://ncess.gov.in/facilities/laboratories.html" target="_parent">Laboratories</a></li>
                    <li><a href="http://192.168.17.11:8001/" target="_parent">Online Library</a></li>
                    <li><a href="directory.php" target="_parent">Contact Directory</a></li>
                    <li><a href="email.php" target="_parent">Email Address Book</a></li>
                    <li><a href="profile.php" target="_parent">Profile Updations</a></li>
                    <li><a href="discussion.php" target="_parent">Discussion Forum</a></li>
                    <li><a href="reports.php" target="_parent">Reports</a></li>
                    <li><a href="feedback.php" target="_parent">Feedback</a></li>
              </ul>    	    	
            </div> 
           
           
            
           
            
            <div class="cleaner"></div>
        </div> <!-- end of sidebar -->
        
        <div id="templatemo_content">
            <ul class="breadcrumb" style="padding-top: 2px;">
                <li><a href="index.php">Home</a></li>
                <li><a href="employees.php">Staff</a></li>
                <li>Technical Support Staff</li>
            </ul>
            <div align="right"><input type="text" name="txtSearch" id="txtSearch" class="search" style="width:200px;height: 23px;padding: 0px 10px 0px 20px;margin: 5px 5px;" /><img src="images/search.ico" style="cursor: pointer;" onclick="search()" /> </div>   
        	<div class="content_box" style="padding-bottom: 180px;padding-top: 50px;" id="search">
                    <?php
                       $last = "";
                        $sql = "SELECT A.*,designation FROM employee A JOIN designation B ON A.designationID=B.designationID where A.categoryID=4 AND employeeStatus=1 ORDER BY level";
                        $result = mysqli_query($conn,$sql);
                        $i=1;
                        if(mysqli_num_rows($result)>0) {
                            echo '<table><tr>';
                            $row=mysqli_fetch_array($result);
                            $last = $row['designation'];
                             echo '<td style="font-size:18px;padding-bottom:10px;">' . $row['designation'] . '</td></tr><tr><td><a href="employeeProfile.php?empID=' . $row['employeeCode'] . '" target="_blank" ><img class="image_wrapper image_fl"  width="140px" height="160px" src="images/profile/'.$row['employeeCode'] . '.jpg" alt="Image 1" /><h5>' . $row['employeeName'] .'</h5></a></td>';
                            while($row=mysqli_fetch_array($result)) {
                               if($last == $row['designation']) {
                                    echo '<td><a href="employeeProfile.php?empID=' . $row['employeeCode'] . '" target="_blank" ><img class="image_wrapper image_fl" src="images/profile/'.$row['employeeCode'] . '.jpg" alt="Image 1" width="140px" height="160px" /><h5>' . $row['employeeName'] .'</h5></a></td>';
                                    if(($i%4)==0)
                                        echo '</tr><tr>';
                                   $i++;
                                   $last = $row['designation'];
                               }
                               else {
                                   echo '<tr><td  style="font-size:18px;padding-bottom:10px;padding-top:10px;">' . $row['designation'] . '</td></tr><tr>';
                                   $i = 1;
                                   echo '<td><a href="employeeProfile.php?empID=' . $row['employeeCode'] . '" target="_blank" ><img class="image_wrapper image_fl"   width="140px" height="160px" src="images/profile/'.$row['employeeCode'] . '.jpg" alt="Image 1"  /><h5>' . $row['employeeName'] .'</h5></a></td>';
                                    if(($i%4)==0)
                                        echo '</tr><tr>';
                                   $i++;
                                   $last = $row['designation'];
                               }
                            }
                        }
                        echo '</tr></table>';
                    ?>
               
          </div>
        </div>
        
        <div class="cleaner"></div>    
    </div>
    
    <div id="templatemo_main_bottom">
    </div>

</div> <!-- end of wrapper -->
</div>
<script>
            var input = document.getElementById("txtSearch");
            input.addEventListener("keyup", function(event) {
                event.preventDefault();
                if (event.keyCode === 13) {
                    search();
                }
            });
        </script>
    <script type="text/javascript">
        function search() {
            $str = document.getElementById('txtSearch').value;
            if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            } 
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("search").innerHTML = this.responseText ;

                }
            };
            var uri = "getStaff.php?category=technical&str="+ $str;
            var res = encodeURI(uri);
            xmlhttp.open("GET",res);
            xmlhttp.send();
        }
    </script>
<div id="templatemo_footer_wrapper">
	<div id="templatemo_footer">
        Copyright © 2018 <a href="#">NCESS</a> | Contact Us : adm@ncess.gov.in | Ext : 1669 
        
    </div>
</div>

</html>