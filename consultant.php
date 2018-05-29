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
    <div id="templatemo_main" ><span id="main_top"></span><span id="main_bottom"></span>
    	
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
            </div> <div class="sidebar_box">
            	<div class="sb_title">Latest Updates</div>
                <div class="sb_content" style="height:120px">
                    <marquee direction = "up" height="100"  scrollamount="1" onmouseover='this.stop();' onmouseout='this.start();'>
                	
                            <?php
                            $sql = "SELECT title,filename,DATE_FORMAT(updatedOn,'%d-%m-%Y') as last FROM noticeboard order by updatedOn limit 5 ";
                            $result = mysqli_query($conn,$sql);
                            if(mysqli_num_rows($result)>0) {
                                while ($row = mysqli_fetch_array($result)) {
                                    echo '<div class="sb_news_box"><a href="documents/' . $row['filename'] .'" target="_blank">' . $row['title'] . '</a><span>' . $row['last'] . '</span></div>';
                                }
                            }
                        ?>
				
                    </marquee>     
                    <a href="announcements.php"><strong>View All</strong></a>
                   
               </div>
               
              <div class="sb_bottom"></div>  
                        
            </div>
            
           
            
            <div class="cleaner"></div>
        </div> <!-- end of sidebar -->
        
        <div id="templatemo_content">
            <ul class="breadcrumb" style="padding-top: 2px;">
                <li><a href="index.php">Home</a></li>
                <li><a href="employees.php">Staff</a></li>
                <li>Senior Consultants</li>
            </ul>
            <div class="content_box" style="height : 550px; overflow-x:   scroll;overflow-y: auto;">
                    <?php
                        $last = "";
                        $sql = "SELECT A.*,designation FROM employee A JOIN designation B ON A.designationID=B.designationID where A.categoryID=6 ORDER BY level";
                        $result = mysqli_query($conn,$sql);
                        $i=1;
                        if(mysqli_num_rows($result)>0) {
                            echo '<table style="font-size:12px;"><tr>';
                           // $$last = $row['divisionName'];
                             echo '<td style="font-size:18px;padding-bottom:10px;width:300px;" colspan="3">Senior Consultants</td></tr><tr>';
                            while($row=mysqli_fetch_array($result)) {
                              
                                    echo '<td style="padding-right:2px;"><img class="image_wrapper image_fl" src="images/profile/'.$row['employeeCode'] . '.jpg" alt="Image 1" width="140px" height="120px" /><a href="employeeProfile.php?empID=' . $row['employeeCode'] . '" target="_blank" ><b>' . $row['employeeName'] .'<br />' . $row['designation']. '</b></a></td>';
                                    if(($i%3)==0)
                                        echo '</tr><tr>';
                                   $i++;
                                  
                              
                               
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

<div id="templatemo_footer_wrapper">
	<div id="templatemo_footer">
        Copyright © 2018 <a href="#">NCESS</a> | 
        
    </div>
</div>

</html>