<?php 
    session_start();
    if(!isset($_SESSION['user']))
        echo "<script>document.location='login.php';</script>";
    
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
    <div id="templatemo_main"><span id="main_top"></span><span id="main_bottom"></span>
    	
        <div id="templatemo_sidebar">
        
        	<div id="templatemo_menu">
                <ul>
                    <li><a href="index.php" target="_parent" class="current">Home</a></li>
                    <li><a href="employees.php" target="_parent">Staff</a></li>
                    <li><a href="documents.php" target="_parent">Documents</a></li>
                    <li><a href="ammouncements.php" target="_parent">Awards</a></li>
                    <li><a href="ammouncements.php" target="_parent">Publications</a></li>
                    <li><a href="calendar" target="_parent">Attendance</a></li>
                    <li><a href="directory.php" target="_parent">Directory</a></li>
                    
                    
              </ul>    	
            </div> <!-- end of templatemo_menu 
        
        	<div class="sidebar_box">
            	<div class="sb_title">Staff Login</div>
                <div class="sb_content">
                	<div id="login_form">
                        <form method="post" action="#">
                        	<p><span>User Name:</span>
                            <input type="text" id="username" name="username" class="login_input" />
                            </p>
                            <p><span>Password:</span>
                            <input type="password" id="password" name="password" class="login_input" />
                            </p>
                            <input type="submit" name="submit" id="login_submit" value=" " />
                        </form>
					</div>                  
                </div>
                <div class="sb_bottom"></div>            
            </div>-->
            <div class="sidebar_box">
            	<div class="sb_title">Birthdays Today</div>
                <div class="sb_content">
                    <img src="images/cookie.ico" />
                	<div class="sb_news_box">
						<a href="#">Staff X</a>
                    </div>
                    
                    <div class="sb_news_box">
						<a href="#">Staff Y</a>
                        				
                    </div>
                      <span>Wish you a wonderful birthday!</span>	  
               </div>
               
              <div class="sb_bottom"></div>  
                        
            </div>
            <div class="sidebar_box">
            	<div class="sb_title">Latest Updates</div>
                <div class="sb_content">
                
                	<div class="sb_news_box">
						<a href="#">Test Test Test Test Test.</a>
                        <span>25 February 2018</span>					
                    </div>
                    
                    <div class="sb_news_box">
						<a href="#">Test Test Test.</a>
                        <span>18 February 2018</span>					
                    </div>
                        
                    <a href="#"><strong>View All</strong></a>
               </div>
               
              <div class="sb_bottom"></div>  
                        
            </div>
            
           
            
            <div class="cleaner"></div>
        </div> <!-- end of sidebar -->
        
        <div id="templatemo_content">
        	
            <div class="content_box">
                <div style='float: left;width:300px;'>
            	<a href="employees.php" target="_parent"><img class="image_wrapper image_fl" src="images/employee.ico" alt="Image 1" /></a>
                <h5>Notice Board</h5>
                
                </div><div style='float: left;width:300px;'>
            	<a href="employees.php" target="_parent"><img class="image_wrapper image_fl" src="images/folder.ico" alt="Image 1" /></a>
                <h5>Minutes</h5>
                
                </div>
          </div>
           <div class="content_box">
               <div style='float: left;width:300px;'>
            	<a href="attendance.php"><img class="image_wrapper image_fl" src="images/attendance.ico" alt="Image 1" /></a>
                <h5>Agenda</h5>
               
              </div>
              <div style='float: right;width:300px;'>
            	<a href="employees.php" target="_parent"><img class="image_wrapper image_fl" src="images/report.ico" alt="Image 1" /></a>
                <h5>Court Order & RTI</h5>
                
                
              </div>  
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