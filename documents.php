<?php 
    session_start();
    if(!isset($_SESSION['user']))
        echo "<script>document.location='login.php';</script>";
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
                    <li><a href="employees.php" target="_parent">Staff</a></li>
                    <li><a href="announcements.php" target="_parent" >Notice Board</a></li>
                    <li><a href="documents.php" target="_parent" class="current">Documents</a></li>
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
           <!-- <div align="right" >Search <input type="text" name="txtSearch" id="txtSearch" /><img src="images/search.ico" style="padding-left: 3px;cursor: pointer;" onclick="search()"/></a></div>
        -->	
        <div class="content_box" style="padding-bottom: 150px;padding-top: 20px;">
                <div >
                    <a href="downloads.php" target="_parent"><h5>Requisition Forms</h5><img class="image_wrapper image_fl" src="images/downloads.ico" alt="Image 1" /></a>
                
                
                </div>
          </div>
           <div class="content_box" style="padding-bottom: 180px;padding-top: 50px;">
                <div style='float: left;width:300px;'>
            	<a href="circulars.php" target="_parent"><h5>OMs/Circulars</h5><img class="image_wrapper image_fl" src="images/om.ico" alt="Image 1" /></a>
                
                
                </div><div style='float: right;width:300px;' >
                    <a href="agenda.php"  target="_parent"><h5>Agenda & Minutes</h5><img class="image_wrapper image_fl" src="images/minutes.ico" alt="Image 1" /></a>
                
                
                </div>
          </div>
            <div class="content_box" style="padding-bottom: 180px;padding-top: 50px;">
                <div style='float: left;width:300px;'>
            	<a href="courtorder.php"><h5>Court Order</h5><img class="image_wrapper image_fl" src="images/law.ico" alt="Image 1" /></a>
                
               
              </div><div style='float: right;width:300px;'>
            	<a href="rti.php" target="_parent"> <h5>RTIs</h5><img class="image_wrapper image_fl" src="images/rti.png" alt="Image 1" /></a>
               
                
                
              </div>  
          </div>
            
            
            <script type="text/javascript">
                function search() {
                    document.location='search.php?key=' + document.getElementById('txtSearch').value;
                }
            </script>
            
           
            
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
   
</body>
</html>