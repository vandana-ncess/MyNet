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
   mysql_set_charset('utf8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>NCESS Intranet</title>
<meta name="keywords" content="free css templates, web design, 2-column, html css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
                <li><a href="employees.php">Staff</a></li>
                <li>Project Staff</li>
            </ul>
            <div align="right"><input type="text" name="txtSearch" id="txtSearch" class="search" style="width:200px;height: 23px;padding: 0px 10px 0px 20px;margin: 5px 5px;" /><img src="images/search.ico" style="cursor: pointer;" onclick="search()" /> </div>   
        	<div class="content_box" style="height : 550px; overflow-x:   scroll;overflow-y: auto;" id="search">
                    <?php
                        $sql = "SELECT *,designation FROM employee A JOIN designation B ON A.designationID=B.designationID WHERE A.categoryID=6 AND "
                                . "employeeStatus=1 ORDER BY  divisionID,joining_date";mysql_set_charset('utf8');
                        $result = mysqli_query($conn,$sql);
                        $i=1;
                        if(mysqli_num_rows($result)>0) {
                             echo '<table><tr>';
                            echo '<td style="font-size:18px;padding-bottom:10px;padding-top:10px;" colspan="4">Senior Consultants</td></tr><tr>';
                            while($row=mysqli_fetch_array($result)) {
                               echo '<td ><a href="employeeProfile.php?empID=' . $row['employeeCode'] . '" target="_blank" ><img class="image_wrapper image_fl" src="images/profile/'.$row['employeeCode'] . '.jpg" alt="Image 1"  width="120px" height="140px" /><b>' . $row['employeeName'] .'<br />Scientist G(Rtd.),<br /> Senior Consultant</b></a></td>';
                                    if(($i%4)==0)
                                        echo '</tr><tr>';
                                   $i++;
                               }
                               
                            }
                        $last = "";
                        $sql = "SELECT A.*,designation,divisionName FROM employee A JOIN designation B ON A.designationID=B.designationID  JOIN division C ON A.divisionID = C.divisionID where A.categoryID=7 AND employeeStatus=1 ORDER BY divisionID,level";
                        mysql_set_charset('utf8');$result = mysqli_query($conn,$sql);
                        $i=1;
                        if(mysqli_num_rows($result)>0) {
                           
                            $row=mysqli_fetch_array($result);
                            if(file_exists("images/profile/". $row['employeeCode']. ".jpg"))
                                $fileName = $row['employeeCode'] . ".jpg";
                            else
                                $fileName = "blank.ico";
                            $last = $row['divisionName'];
                             echo '</tr><tr><td style="font-size:16px;padding-bottom:10px;width:285px;" colspan="4">' . $row['divisionName'] . '</td></tr><tr><td width="170px"><a href="employeeProfile.php?empID=' . $row['employeeCode'] . '" target="_blank" ><img width="120px" height="140px" class="image_wrapper image_fl" src="images/profile/'.$fileName . '" alt="Image 1" /><b>' . $row['employeeName'] .'<br />' . $row['designation']. '</b></a></td>';
                            $last = $row['divisionName'];
                             while($row=mysqli_fetch_array($result)) {
                                if(file_exists("images/profile/". $row['employeeCode']. ".jpg"))
                                    $fileName = $row['employeeCode'] . ".jpg";
                                else
                                    $fileName = "blank.ico"; 
                               if($last == $row['divisionName']) {
                                    echo '<td width="180px"><a href="employeeProfile.php?empID=' . $row['employeeCode'] . '" target="_blank" ><img class="image_wrapper image_fl" src="images/profile/'.$fileName . '" alt="Image 1" width="120px" height="140px" /><b>' . $row['employeeName'] .'<br />' . $row['designation']. '</b></a></td>';
                                    if(($i%4)==0)
                                        echo '</tr><tr>';
                                   $i++;
                                   $last = $row['divisionName'];
                               }
                               else {
                                   echo '<tr><td  style="font-size:16px;padding-bottom:10px;padding-top:10px;" colspan="4">' . $row['divisionName'] . '</td></tr><tr>';
                                   $i = 1;
                                   echo '<td  width="180px"><a href="employeeProfile.php?empID=' . $row['employeeCode'] . '" target="_blank" ><img class="image_wrapper image_fl" src="images/profile/'.$fileName . '" alt="Image 1" width="120px" height="140px" /><b>' . $row['employeeName'] .'<br />' . $row['designation']. '</b></a></td>';
                                    if(($i%4)==0)
                                        echo '</tr><tr>';
                                   $i++;
                                   $last = $row['divisionName'];
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
            var uri = "getStaff.php?category=project&str="+ $str;
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