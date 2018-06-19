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
     $conn = require_once('databaseconnection.php');
    if($_SESSION['user'] != 'admin') {
        $sql = "SELECT * FROM gc_privileges where employeeCode=" . $_SESSION['loggedUserID'] ;
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)==0) {
            echo '<script>alert("You are not authorised to view this folder, Kindly contact the System Administrator!");document.location="agenda.php";</script>';
        }
    }
    
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
            <ul class="breadcrumb" style="padding-top: 2px;">
                <li><a href="index.php">Home</a></li>
                <li><a href="agenda.php">Committees</a></li>
                <li>Governing Council</li>
            </ul>
            <a href="gc.php" style="float: right;padding-top: 10px;padding-right: 5px;font-size: 14px;">Agendas & Minutes</a>
            <div style="background-color: white;">
                <h3 style="padding-top: 20px;margin-bottom: 5px;padding-left: 20px;">Governing Council Members</h3>
                <table cellpadding="5" cellspacing="20">
                <tbody>
                    <tr>
                        <td>
                            <b>Secretary</b><br />
Ministry of Earth Sciences, <br />
Prithvi Bhavan, Lodhi Road, New Delhi-110 003, India
                        </td>
                        <td>
                            Chairman
(Ex-Officio)
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Additional Secretary & Financial Adviser /
Joint Secretary & Financial Adviser</b><br />
Ministry of Earth Sciences, <br />
Prithvi Bhavan, Lodhi Road, New Delhi-110 003, India
                        </td>
                        <td>
                            Member
(Ex-Officio)
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Additional Secretary / Joint Secretary </b><br />
Ministry of Earth Sciences, <br />
Prithvi Bhavan, Lodhi Road, New Delhi-110 003, India
                        </td>
                        <td>
                            Member
(Ex-Officio)
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>RAC Chairman</b><br />

                        </td>
                        <td>
                            Member
(Ex-Officio)
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Dr. Suresh Das</b><br />
Executive Vice President(EVP), KSCSTE &<br />
Principal Secretary, S&T Dept, Govt. of Kerala<br />
Sasthra Bhavan, Pattom,Thiruvananthapuram 695004, Kerala, India
                        </td>
                        <td>
                            Member
(Ex-Officio)
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Dr. Anil Bhardwaj</b><br />
Director, PRL, Ahmedabad
                        </td>
                        <td>
                            Member
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Director</b><br />
NCAOR, Goa
                        </td>
                        <td>
                            Member
(Ex-Officio)
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Dr. Radhika Ramachandran</b><br />
Director, Space Physics Laboratory,<br />
ISRO, Thiruvananthapuram
                        </td>
                        <td>
                            Member
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Director</b><br />
                            NCS <br />
Ministry of Earth Sciences, <br />
Prithvi Bhavan, Lodhi Road, New Delhi-110 003, India
                        </td>
                        <td>
                            Member
(Ex-Officio)
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Programme Head (NCESS) </b><br />
Ministry of Earth Sciences, <br />
Prithvi Bhavan, Lodhi Road, New Delhi-110 003, India
                        </td>
                        <td>
                            Permanent Invitee
(Ex-Officio)
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Niti Aayog Representative</b><br />

                        </td>
                        <td>
                           Invitee
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Director</b><br />
National Centre for Earth Science Studies (NCESS),<br />
Akkulam, Thiruvanathapuram,Kerala-695011, India
                        </td>
                        <td>
                            Member Secretary
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
        
        <div class="cleaner"></div>    
    </div>
    
    <div id="templatemo_main_bottom">
    </div>

</div> <!-- end of wrapper -->
</div>
<script type="text/javascript">
        function loadDocuments()
        {
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
                    document.getElementById("tblDocument").innerHTML = this.responseText ;
                    alert(this.responseText);
                }
            };
            xmlhttp.open("GET","getDocuments.php?type=rac&str="+$str);
            xmlhttp.send();
        }
    </script>
<div id="templatemo_footer_wrapper">
	<div id="templatemo_footer">
        Copyright © 2018 <a href="#">NCESS</a> | Contact Us : adm@ncess.gov.in | Ext : 1669 
        
    </div>
</div>

</html>