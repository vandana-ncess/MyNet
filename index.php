<?php 
    session_start();
    $conn = require_once('databaseconnection.php');
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        // last request was more than 30 minutes ago
        session_unset();     // unset $_SESSION variable for the run-time 
        session_destroy();   // destroy session data in storage
        
    }
 else {
     $_SESSION['LAST_ACTIVITY'] = time();   
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
<link href="css/calendar.css" rel="stylesheet" type="text/css" />
<link href="css/demo.css" rel="stylesheet" type="text/css" />
 <link rel="stylesheet" type="text/css" href="css/custom_3.css" />
 <link rel="shortcut icon" href="images/logo1.png" type="image/x-icon"/>
        <script src="js/modernizr.custom.63321.js"></script>
<!--////// CHOOSE ONE OF THE 3 PIROBOX STYLES  \\\\\\\-->
<link href="css_pirobox/white/style.css" media="screen" title="shadow" rel="stylesheet" type="text/css" />
<!--<link href="css_pirobox/white/style.css" media="screen" title="white" rel="stylesheet" type="text/css" />
<link href="css_pirobox/black/style.css" media="screen" title="black" rel="stylesheet" type="text/css" />-->
<!--////// END  \\\\\\\--><link href="calendar.css" type="text/css" rel="stylesheet" />

<!--////// INCLUDE THE JS AND PIROBOX OPTION IN YOUR HEADER  \\\\\\\-->
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/piroBox.1_2.js"></script>
<script type="text/javascript" src="js/crawler.js"></script>
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
<style>
*{margin:0px; padding:0px; font-family:Helvetica, Arial, sans-serif;}

/* Full-width input fields */
input[type=text], input[type=password] {
    width: 90%;
    padding: 12px 20px;
    margin: 8px 26px;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
	font-size:16px;
}

/* Set a style for all buttons */
button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 26px;
    border: none;
    cursor: pointer;
    width: 90%;
	font-size:20px;
}
button:hover {
    opacity: 0.8;
}

/* Center the image and position the close button */
.imgcontainer {
    text-align: center;
    margin: 24px 0 12px 0;
    position: relative;
}
.avatar {
    width: 220px;
	height:200px;
    border-radius: 50%;
}

/* The Modal (background) */
.modal {
	display:none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.4);
}

/* Modal Content Box */
.modal-content {
    background-color: #fefefe;
    margin: 4% auto 15% auto;
    border: 1px solid #888;
    width: 40%; 
    height:80%;
	padding-bottom: 40px;
}

/* The Close Button (x) */
.close {
    position: absolute;
    right: 25px;
    top: 0;
    color: #000;
    font-size: 35px;
    font-weight: bold;
}
.close:hover,.close:focus {
    color: red;
    cursor: pointer;
}

/* Add Zoom Animation */
.animate {
    animation: zoom 0.6s
}
@keyframes zoom {
    from {transform: scale(0)} 
    to {transform: scale(1)}
}
</style>
<script type="text/javascript">
    function login() {
        var request = false;
        if(window.XMLHttpRequest) { // Mozilla/Safari
            request = new XMLHttpRequest();
        } else if(window.ActiveXObject) { // IE
            request = new ActiveXObject("Microsoft.XMLHTTP");
        }
        request.open('POST', 'SessionCheck.php', true);
        request.onreadystatechange = function() {
            if(request.readyState == 4) {
                var session = eval('(' + request.responseText + ')');
                if(session) {
                    document.getElementById('modal-wrapper').style.display='none';
                } else {
                     document.getElementById('modal-wrapper').style.display='block';
                }
            }
        }
        request.send(null);
       
    }
</script>
</head>
    <body onload="login()">
        <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.12';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div id="modal-wrapper" class="modal">
  
    <form class="modal-content animate" action="" method="post">
        
    <div class="imgcontainer">
      
      <img src="images/logo.jpg" alt="Avatar" class="avatar">
      <h1 style="text-align:center;font-family: serif;">NCESS Intranet Login</h1>
    </div>

    <div class="container">
      <input type="text" placeholder="Enter Username" name="txtUser">
      <input type="password" placeholder="Enter Password" name="txtPswd">        
      <button type="submit" name="btnLogin">Login</button>
      <a href="register.php" style="text-decoration:none;float: right; margin-right: 34px; margin-top:6px;"> Sign Up</a>   <br />   
      <span style="text-align: center;padding-left: 120px;">Kindly mail to adm@ncess.gov.in to reset password!</span>
    </div>
    <?php
        if(isset($_POST['btnLogin']))
        {
            $sql = "SELECT * FROM ncess_users WHERE username='" . $_POST['txtUser']. "' AND password='" . $_POST['txtPswd'] . "'";
            $result=mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)>0)
            {
                $_SESSION['user'] = $_POST['txtUser'];
                if($_SESSION['user'] != 'admin') {
                    $sql = "SELECT * FROM employee WHERE username = '" . $_SESSION['user'] . "'";
                    $result =mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result)>0)
                    {
                        $ro = mysqli_fetch_array($result);
                        $_SESSION['loggedUserID'] = $ro['employeeCode'];
                    }
                }
                else
                     $_SESSION['loggedUserID'] =0;
                $_SESSION['LAST_ACTIVITY'] = time();
                echo '<script>document.location="index.php";</script>';
            }
            else { echo "<p style='color:red;'>Incorrect Username/Password</p>";}
        }
    ?>
  </form>
  
</div>
        
<div id="templatemo_body_wrapper">
<div id="templatemo_wrapper">
   
	<div id="tempaltemo_header">
            <?php if(isset($_SESSION['user'])) { ?><p align="right" style="padding-right: 50px;color:#009900;font-size: 16px;font-family: Verdana; "><i><b><?php        echo 'Welcome ' . $_SESSION['user']; ?></b></i>&nbsp; <a href="logout.php" style="color: #0066cc;">Logout</a></p>;<?php } ?>
    	<span id="header_icon"></span>
        
    	<div id="header_content">
        	<div id="site_title">
                    <p>Welcome to NCESS Intranet Portal</p>       </div>
           
		 
		</div>
    </div> <!-- end of header -->
    
    <div id="templatemo_main_top"></div>
    <div id="templatemo_main"><span id="main_top"></span><span id="main_bottom"></span>
    	
        <div id="templatemo_sidebar">
        
        	<div class="sidebar_box" >
            	
                <div class="sb_content1" style="display: inline-block;">
                  <section class="main" style="width:230px;">
                <div class="custom-calendar-wrap">
                    <div id="custom-inner" class="custom-inner">
                        <div class="custom-header clearfix">
                            <nav>
                                <span id="custom-prev" class="custom-prev"></span>
                                <span id="custom-next" class="custom-next"></span>
                            </nav>
                            <h2 id="custom-month" class="custom-month"></h2>
                            <h3 id="custom-year" class="custom-year"></h3>
                        </div>
                        <div id="calendar" class="fc-calendar-container"></div>
                    </div>
                </div>
            </section>
               </div>
               
             
                        
            </div>
           
            
            
           <div class="sidebar_box">
            	<div class="sb_title">Notice Board</div>
                <div class="sb_content" style="height:220px">
                    <marquee direction = "up" height="200"  scrollamount="1" onmouseover='this.stop();' onmouseout='this.start();'>
                	
                            <?php
                            $sql = "SELECT title,filename,DATE_FORMAT(updatedOn,'%d-%m-%Y') as last FROM noticeboard WHERE status=1 order by updatedOn DESC ";
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
            
           <div class="sidebar_box">
            	<div class="sb_title">News & Events</div>
                <div class="sb_content" style="height:220px">
                    <marquee direction = "up" height="200"  scrollamount="1" onmouseover='this.stop();' onmouseout='this.start();'>
                	
                            <?php
                            $sql = "SELECT eventName,url,DATE_FORMAT(updatedOn,'%d-%m-%Y') as last FROM events WHERE status=1 order by updatedOn DESC limit 5 ";
                            $result = mysqli_query($conn,$sql);
                            if(mysqli_num_rows($result)>0) {
                                while ($row = mysqli_fetch_array($result)) {
                                    echo '<div class="sb_news_box"><a href="'. $row['url'] .'" target="_blank">' . $row['eventName'] . '</a><span>' . $row['last'] . '</span></div>';
                                }
                            }
                        ?>
				
                    </marquee>     
                   
                   
               </div>
              
              <div class="sb_bottom"></div>  
                        
            </div>
            <div class="sidebar_box" style="height:280px;">
            	<div class="sb_title">Birthdays </div>
                <div class="sb_content" style="height: 280px;">
                    <img src="images/cookie.ico" />
                    <div style="height: 280px;padding-top: 5px;padding-bottom: 5px;">
                        <?php
                            $sql = "SELECT employeeName FROM employee WHERE DATE_FORMAT(dateOfBirth,'%m-%d') = '" . date('m-d') . "'";
                            $result = mysqli_query($conn,$sql);
                            if(mysqli_num_rows($result)>0) {
                                echo '<ul>';
                                while ($row = mysqli_fetch_array($result)) {
                                    echo '<li style="list-style-type:none;color:green;font-weight:bold;padding-bottom: 4px;">' . $row['employeeName'] . '</li>';
                                }
                                echo '</ul>NCESS wishes a wonderful Birthday!';
                            }
                        ?>
                        
                    </div>
                   	  
               </div>
               
              <div class="sb_bottom"></div>  
                        
            </div>
        </div> <!-- end of sidebar -->
        
        <div id="templatemo_content">
            <div>
                <?php
                    $sql = "SELECT * FROM esf WHERE status=1";
                    $result = mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result)>0) {
                        echo '<marquee scrollamount="4"><span style="color:red;">ESF Alerts : </span>';
                        while ($row=mysqli_fetch_array($result)) {
                            echo '<a href="esf.php" target="_blank" >' . $row['matter'] . '</a>;&nbsp;&nbsp;';
                        }
                        echo '</marquee>';
                    }
                ?>
                
            </div>
            <div align="right"><input type="text" name="txtSearch" class="search" id="txtSearch" style="width:200px;height: 25px;padding: 0px 0px;margin: 5px 5px;" /><img src="images/search.ico" style="cursor: pointer;" onclick="search()" /> </div>   
            <div class="content_box" style="padding-top: 30px;">
                <div style='float: left;width:300px;'>
            	<a href="employees.php" target="_parent"><img class="image_wrapper image_fl" src="images/employee.ico" alt="Image 1" />
                <h5>Staff Details</h5></a>
                <p>Get Full details of NCESS Staffs here.</p>
                </div><div style='float: right;width:300px;'>
            	<a href="announcements.php" target="_parent"><img class="image_wrapper image_fl" src="images/notice_board.ico" alt="Image 1" />
                <h5>Notice Board</h5></a>
                <p>All current announcements are available here.</p>
              </div>
          </div>
            <div class="content_box" style="height:20px;">
               <div style='float: left;width:300px;'>
            	<a href="attendance.php"><img class="image_wrapper image_fl" src="images/attendance.ico" alt="Image 1" />
                <h5>Staff Attendance</h5></a>
                <p>Get Staff attendance details here. </p>
              </div><div style='float: left;width:300px;'>
                    <a href="documents.php" target="_parent"><img class="image_wrapper image_fl" src="images/folder1.ico" alt="Image 1" />
                <h5>Documents</h5></a>
                <p>Get different documents like various requisition forms,circulars, Minutes & Agendas here.</p>
                </div>
              
          </div>
             <div class="content_box">
                 <div style='float: left;width:300px;'>
                    <a href="http://ncess.gov.in" target="_blank"><img class="image_wrapper image_fl" src="images/logo3.png" alt="Image 1" />
                <h5>NCESS Website</h5></a>
                <p>Official Website of NCESS.</p>
                </div>
                <div style='float: right;width:300px;'>
            	<a href="http://192.168.17.11:8001/" target="_blank"><img class="image_wrapper image_fl" src="images/library.ico" alt="Image 1" />
                <h5>Online Library</h5></a>
                <p>Access our online library here.</p>
                </div>
            </div>
            <div class="content_box">
                <div style='float: left;width:300px;'>
            	<a href="publications.php" ><img class="image_wrapper image_fl" src="images/news.ico" alt="Image 1" />
                <h5>Research Publications</h5></a>
                <p>All our research publications are available here</p>
                </div><div style='float: right;width:300px;'>
            	<a href="http://ncess.gov.in/facilities/laboratories.html" target="_blank"><img class="image_wrapper image_fl" src="images/laboratory.png" alt="Image 1" />
                <h5>Laboratories</h5></a>
                <p>Details about all laboratory services provided in NCESS.</p>
                </div>
          </div> 
           
            <div class="content_box">
                <div style='float: left;width:300px;'>
            	<a href="esf.php" target="_blank"><img class="image_wrapper image_fl" src="images/ESF.jpg" alt="Image 1" />
                <h5>Earth Science Forum</h5></a>
                <p>Get NCESS-ESF related activities.</p>
              </div>
               <div style='float: right;width:300px;'>
                   <a href="eGovernance.php" target="_blank"><img class="image_wrapper image_fl" src="images/eoffice.jpg" alt="Image 1" />
                <h5>e-Governance</h5></a>
                <p>NCESS s-Governance activities</p>
                </div>
          </div>
             <div class="content_box">
                 <div style='float: left;width:300px;'>
            	<a href="profile.php" target="_parent"><img class="image_wrapper image_fl" src="images/profile.ico" alt="Image 1" />
                <h5>Profile Updations</h5></a>
                <p>View & update your profile and research publications here.</p>
              </div>
                 <div style='float: right;width:300px;'>
            	<a href="reports.php" target="_parent"><img class="image_wrapper image_fl" src="images/report.ico" alt="Image 1" />
                <h5>Reports</h5></a>
                <p>All reports are available here.</p>
                
              </div>  
               
                
          </div>
            <div class="content_box">
                <div style='float: left;width:300px;'>
                    <a href="email.php" target="_blank"><img class="image_wrapper image_fl" src="images/address.ico" alt="Image 1" />
                        <h5 >Email Address Book</h5></a>
                <p>Email IDs of all employees</p>
                </div>
                <div style='float: right;width:300px;'>
            	<a href="http://ncess.gov.in/notifications/awards.html" target="_blank"><img class="image_wrapper image_fl" src="images/medal.ico" alt="Image 1" />
                <h5>Awards</h5></a>
                <p>All recent awards are available here</p>
              </div>
            </div>
            <div class="content_box" style="height: 10px;">
               <!-- <div style='float: left;width:300px;'>
                    <a href="http://ncess.gov.in" target="_blank"><img class="image_wrapper image_fl" src="images/logo2.png" alt="Image 1" />
                <h5>NCESS Website</h5></a>
                <p>Official Website of NCESS.</p>
                </div>-->
                <div style='float: left;width:300px;'>
                    <a href="directory.php" target="_parent"><img class="image_wrapper image_fl" src="images/directory.ico" alt="Image 1" />
                <h5>Contact Directory</h5></a>
                <p>Contact details of all staff are available here</p>
              </div>
               <div style='float: right;width:300px;'>
                     <a href="feedback.php" target="_parent"><img class="image_wrapper image_fl" src="images/app.ico" alt="Image 1" />
                <h5>Feedback</h5></a>
                  <p>Enter your valuable comments / suggestions for improving the NCESS  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;Intranet portal.</p>
              </div>
               
          </div>
           
            
            
             <div class="content_box" >
                 <div style='float: left;width:300px;padding-bottom: 2px;'>
                     <a href="discussion.php" target="_parent"><img class="image_wrapper image_fl" src="images/char.ico" alt="Image 1" />
                <h5>Discussion Forum</h5></a>
                <p>You can discuss about various topics here.</p>
              </div>
                 
          </div>
            
            <div class="content_box" style="height:250px;">
                <h4 style="color:#999900; ">Follow Social Media Pages of NCESS</h4>
            <table><tr><td width="300px" style="border-radius: 22px;">
                        <div class="fb-page" data-href="https://www.facebook.com/ESSO-NCESS" data-tabs="timeline" data-width="400px" data-height="250px" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/ESSO-NCESS" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/ESSO-NCESS">National Centre for Earth Science Studies</a></blockquote></div>                            </td>
<td width="300px"><div>            <a class="twitter-timeline"  href="https://twitter.com/hashtag/ESSO-NCESS" data-widget-id="982654893038202880">#ESSO-NCESS Tweets</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
          </div></td>
                </tr></table>
            </div>
            <div class="content_box last_box"  style="height:170px;padding-bottom:10px;">
            	<h4 style="color:#999900; ">NCESS Gallery</h4>
              <div id="gallery">  
                   <script src="../js/jssor.slider.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        jssor_1_slider_init = function() {

            var jssor_1_options = {
              $AutoPlay: 1,
              $AutoPlaySteps: 4,
              $SlideDuration: 160,
              $SlideWidth: 200,
              $SlideSpacing: 3,
              $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$,
                $Steps: 5
              },
              $BulletNavigatorOptions: {
                $Class: $JssorBulletNavigator$
              }
            };

            var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

            /*#region responsive code begin*/

            var MAX_WIDTH = 980;

            function ScaleSlider() {
                var containerElement = jssor_1_slider.$Elmt.parentNode;
                var containerWidth = containerElement.clientWidth;

                if (containerWidth) {

                    var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);

                    jssor_1_slider.$ScaleWidth(expectedWidth);
                }
                else {
                    window.setTimeout(ScaleSlider, 30);
                }
            }

            ScaleSlider();

            $Jssor$.$AddEvent(window, "load", ScaleSlider);
            $Jssor$.$AddEvent(window, "resize", ScaleSlider);
            $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
            /*#endregion responsive code end*/
        };
    </script>
    <style>
        /* jssor slider loading skin spin css */
        .jssorl-009-spin img {
            animation-name: jssorl-009-spin;
            animation-duration: 1.6s;
            animation-iteration-count: infinite;
            animation-timing-function: linear;
        }

        @keyframes jssorl-009-spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }


        .jssorb057 .i {position:absolute;cursor:pointer;}
        .jssorb057 .i .b {fill:none;stroke:#fff;stroke-width:2000;stroke-miterlimit:10;stroke-opacity:0.4;}
        .jssorb057 .i:hover .b {stroke-opacity:.7;}
        .jssorb057 .iav .b {stroke-opacity: 1;}
        .jssorb057 .i.idn {opacity:.3;}

        .jssora073 {display:block;position:absolute;cursor:pointer;}
        .jssora073 .a {fill:#ddd;fill-opacity:.7;stroke:#000;stroke-width:160;stroke-miterlimit:10;stroke-opacity:.7;}
        .jssora073:hover {opacity:.8;}
        .jssora073.jssora073dn {opacity:.4;}
        .jssora073.jssora073ds {opacity:.3;pointer-events:none;}
    </style>
    <div id="jssor_1" style="position:relative;margin:0 auto;top:0px;left:0px;width:980px;height:150px;overflow:hidden;visibility:hidden;">
        <!-- Loading Screen -->
        <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
            <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="../svg/loading/static-svg/spin.svg" />
        </div>
        <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:980px;height:150px;overflow:hidden;">
            <?php
            for($i=1;$i<=12;$i++) {
            echo '<div>
                <img data-u="image" src="images/Website Gallery/'.$i.'.jpg" />
            </div>';}
            ?>
           
            <div style="background-color:#ff7c28;">
                <div style="position:absolute;top:3px;left:16px;width:150px;height:62px;z-index:0;font-size:16px;color:#000000;line-height:24px;text-align:left;padding:5px;box-sizing:border-box;">Photos in this slider are to demostrate jssor slider,<br />
                    which are not licensed for any other purpose.
                </div>
            </div>
        </div>
        <!-- Bullet Navigator -->
        <div data-u="navigator" class="jssorb057" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
            <div data-u="prototype" class="i" style="width:16px;height:16px;">
                <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                    <circle class="b" cx="8000" cy="8000" r="5000"></circle>
                </svg>
            </div>
        </div>
        <!-- Arrow Navigator -->
        <div data-u="arrowleft" class="jssora073" style="width:50px;height:50px;top:0px;left:30px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
            <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                <path class="a" d="M4037.7,8357.3l5891.8,5891.8c100.6,100.6,219.7,150.9,357.3,150.9s256.7-50.3,357.3-150.9 l1318.1-1318.1c100.6-100.6,150.9-219.7,150.9-357.3c0-137.6-50.3-256.7-150.9-357.3L7745.9,8000l4216.4-4216.4 c100.6-100.6,150.9-219.7,150.9-357.3c0-137.6-50.3-256.7-150.9-357.3l-1318.1-1318.1c-100.6-100.6-219.7-150.9-357.3-150.9 s-256.7,50.3-357.3,150.9L4037.7,7642.7c-100.6,100.6-150.9,219.7-150.9,357.3C3886.8,8137.6,3937.1,8256.7,4037.7,8357.3 L4037.7,8357.3z"></path>
            </svg>
        </div>
        <div data-u="arrowright" class="jssora073" style="width:50px;height:50px;top:0px;right:30px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
            <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                <path class="a" d="M11962.3,8357.3l-5891.8,5891.8c-100.6,100.6-219.7,150.9-357.3,150.9s-256.7-50.3-357.3-150.9 L4037.7,12931c-100.6-100.6-150.9-219.7-150.9-357.3c0-137.6,50.3-256.7,150.9-357.3L8254.1,8000L4037.7,3783.6 c-100.6-100.6-150.9-219.7-150.9-357.3c0-137.6,50.3-256.7,150.9-357.3l1318.1-1318.1c100.6-100.6,219.7-150.9,357.3-150.9 s256.7,50.3,357.3,150.9l5891.8,5891.8c100.6,100.6,150.9,219.7,150.9,357.3C12113.2,8137.6,12062.9,8256.7,11962.3,8357.3 L11962.3,8357.3z"></path>
            </svg>
        </div>
    </div>
    <script type="text/javascript">jssor_1_slider_init();</script>

              </div><a href="gallery.php" target="_blank"><strong>View All</strong></a>
             </div>
        </div>
        
        <div class="cleaner"></div>    
    </div>
    
    <div id="templatemo_main_bottom">
    </div>

</div> <!-- end of wrapper -->
        </div>
        <script type="text/javascript">
            function search() {
                document.location='searchHome.php?str=' + document.getElementById('txtSearch').value;
            }
        </script>
        <script>
            var input = document.getElementById("txtSearch");
            input.addEventListener("keyup", function(event) {
                event.preventDefault();
                if (event.keyCode === 13) {
                    search();
                }
            });
        </script>
<div id="templatemo_footer_wrapper">
	<div id="templatemo_footer">
        Copyright © 2018 <a href="#">NCESS</a> | Contact Us : adm@ncess.gov.in | Ext : 1669 
        
    </div>
</div>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.calendario.js"></script>
        <script type="text/javascript" src="js/data.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script type="text/javascript"> 
            $(function() {
                var pop_title = '', pop_content = '';
                $(document).popover({
                    delay: { show: 100, hide: 200 },
                    html: true,
                    trigger: 'hover',
                    selector: 'div.fc-content',
                    placement: 'auto',
                    content: function() {
                                return pop_content;
                             },
                    title: function() {
                                return pop_title;
                           },
                    container: 'body'
                });
                var transEndEventNames = {
                        'WebkitTransition' : 'webkitTransitionEnd',
                        'MozTransition' : 'transitionend',
                        'OTransition' : 'oTransitionEnd',
                        'msTransition' : 'MSTransitionEnd',
                        'transition' : 'transitionend'
                    },
                    transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
                    $wrapper = $( '#custom-inner' ),
                    $calendar = $( '#calendar' ),
                    cal = $calendar.calendario({
                        onDayMouseenter : function( $el, data, dateProperties ) {
                            if( data.content.length > 0 ) {
                                pop_title = dateProperties.monthname + ' ' + dateProperties.day + ', ' + dateProperties.year;
                                pop_content = data.content.join('');
                                cal.feed(logFeed);
                            }
                        },
                        caldata : codropsEvents,
                        events: 'mouseenter',
                        displayWeekAbbr : true,
                        fillEmpty: false
                    }),
                    $month = $( '#custom-month' ).html( cal.getMonthName() ),
                    $year = $( '#custom-year' ).html( cal.getYear() );

                $( '#custom-next' ).on( 'click', function() {
                    cal.gotoNextMonth( updateMonthYear );
                } );
                $( '#custom-prev' ).on( 'click', function() {
                    cal.gotoPreviousMonth( updateMonthYear );
                } );

                function updateMonthYear() {                
                    $month.html( cal.getMonthName() );
                    $year.html( cal.getYear() );
                }

                function logFeed( data ) {              
                    console.log(data);
                }
            });
        </script>
     
</body>
</html>