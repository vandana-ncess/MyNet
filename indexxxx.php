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
        <script src="js/modernizr.custom.63321.js"></script>
<!--////// CHOOSE ONE OF THE 3 PIROBOX STYLES  \\\\\\\-->
<link href="css_pirobox/white/style.css" media="screen" title="shadow" rel="stylesheet" type="text/css" />
<!--<link href="css_pirobox/white/style.css" media="screen" title="white" rel="stylesheet" type="text/css" />
<link href="css_pirobox/black/style.css" media="screen" title="black" rel="stylesheet" type="text/css" />-->
<!--////// END  \\\\\\\--><link href="calendar.css" type="text/css" rel="stylesheet" />

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
      
      <img src="images/logo.png" alt="Avatar" class="avatar">
      <h1 style="text-align:center;font-family: serif;">NCESS Intranet Login</h1>
    </div>

    <div class="container">
      <input type="text" placeholder="Enter Username" name="txtUser">
      <input type="password" placeholder="Enter Password" name="txtPswd">        
      <button type="submit" name="btnLogin">Login</button>
      <a href="register.php" style="text-decoration:none;float: right; margin-right: 34px; margin-top:6px;"> Sign Up</a>   <br />   
      <a href="#" style="text-decoration:none; float:right;margin-right: -40px; margin-top:26px;">Forgot Password ?</a>
    </div>
    <?php
        if(isset($_POST['btnLogin']))
        {
            $sql = "SELECT * FROM ncess_users WHERE username='" . $_POST['txtUser']. "' AND password='" . $_POST['txtPswd'] . "'";
            $result=mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)>0)
            {
                $_SESSION['user'] = $_POST['txtUser'];
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
            	<div class="sb_title">Birthdays </div>
                <div class="sb_content">
                    <img src="images/cookie.ico" />
                    <div >
                        <?php
                            $sql = "SELECT employeeName FROM employee WHERE DATE_FORMAT(dateOfBirth,'%m-%d') = '" . date('m-d') . "'";
                            $result = mysqli_query($conn,$sql);
                            if(mysqli_num_rows($result)>0) {
                                echo '<ul>';
                                while ($row = mysqli_fetch_array($result)) {
                                    echo '<li style="list-style-type:none;color:green;font-weight:bold;">' . $row['employeeName'] . '</li>';
                                }
                                echo '</ul>NCESS wishes a wonderful Birthday!';
                            }
                        ?>
                        
                    </div>
                   	  
               </div>
               
              <div class="sb_bottom"></div>  
                        
            </div>
            
            
           <div class="sidebar_box">
            	<div class="sb_title">Notice Board</div>
                <div class="sb_content" style="height:220px">
                    <marquee direction = "up" height="200"  scrollamount="1" onmouseover='this.stop();' onmouseout='this.start();'>
                	
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
            
           
        </div> <!-- end of sidebar -->
        
        <div id="templatemo_content">
        	
            <div class="content_box" style="padding-top: 30px;">
                <div style='float: left;width:300px;'>
            	<a href="employees.php" target="_parent"><img class="image_wrapper image_fl" src="images/employee.ico" alt="Image 1" />
                <h5>Staff Details</h5></a>
                <p>Get Full details of NCESS family here.</p>
                </div><div style='float: left;width:300px;'>
                    <a href="documents.php" target="_parent"><img class="image_wrapper image_fl" src="images/folder.ico" alt="Image 1" />
                <h5>Documents</h5></a>
                <p>Get different documents like Minutes & Agendas here.</p>
                </div>
          </div>
           <div class="content_box">
               <div style='float: left;width:300px;'>
            	<a href="attendance.php"><img class="image_wrapper image_fl" src="images/attendance.ico" alt="Image 1" />
                <h5>Staff Attendance</h5></a>
                <p>Get Staff attendance details here. Entry restricted to concerned persons only.</p>
              </div>
              <div style='float: right;width:300px;'>
            	<a href="reports.php" target="_parent"><img class="image_wrapper image_fl" src="images/report.ico" alt="Image 1" />
                <h5>Reports</h5></a>
                <p>Attendance related reports are available here.</p>
                
              </div>  
          </div>
            <div class="content_box">
                <div style='float: left;width:300px;'>
            	<a href="publications.php" ><img class="image_wrapper image_fl" src="images/news.ico" alt="Image 1" />
                <h5>Research Publications</h5></a>
                <p>Provides staff's all publications</p>
                </div><div style='float: right;width:300px;'>
            	<a href="http://ncess.gov.in/notifications/awards.html" target="_blank"><img class="image_wrapper image_fl" src="images/medal.ico" alt="Image 1" />
                <h5>Awards</h5></a>
                <p>All recent awards are available here</p>
              </div>
          </div> 
            <div class="content_box">
                <div style='float: left;width:300px;'>
            	<a href="http://192.168.17.11:8001/" target="_blank"><img class="image_wrapper image_fl" src="images/library.ico" alt="Image 1" />
                <h5>Online Library</h5></a>
                <p>Acess our online library here.</p>
                </div><div style='float: right;width:300px;'>
                    <a href="directory.php" target="_parent"><img class="image_wrapper image_fl" src="images/directory.ico" alt="Image 1" />
                <h5>Directory</h5></a>
                <p>Contact details of all staff are available here</p>
              </div>
            </div>
            <div class="content_box">
                <div style='float: left;width:300px;'>
            	<a href="http://ncess.gov.in/facilities/laboratories.html" target="_blank"><img class="image_wrapper image_fl" src="images/laboratory.png" alt="Image 1" />
                <h5>Laboratories</h5></a>
                <p>Details about all laboratory services provided in NCESS.</p>
                </div><div style='float: right;width:300px;'>
            	<a href="announcements.php" target="_parent"><img class="image_wrapper image_fl" src="images/notice_board.ico" alt="Image 1" />
                <h5>Notice Board</h5></a>
                <p>All current announcements are available here.</p>
              </div>
          </div>
            
            <div class="content_box last_box" style="height:250px;">
                <h3 style="color:#999900; ">Social Media Pages of NCESS</h3>
            <table><tr><td width="300px" style="border-radius: 22px;">
                        <div class="fb-page" data-href="https://www.facebook.com/ESSO-NCESS" data-tabs="timeline" data-width="400px" data-height="250px" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/ESSO-NCESS" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/ESSO-NCESS">National Centre for Earth Science Studies</a></blockquote></div>                            </td>
<td width="300px"><div>            <a class="twitter-timeline"  href="https://twitter.com/hashtag/ESSO-NCESS" data-widget-id="982654893038202880">#ESSO-NCESS Tweets</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
          </div></td>
                </tr></table>
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