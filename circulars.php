<?php 
    session_start();
    $conn = require_once('databaseconnection.php');
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
    if(isset($_GET['year'])) {
        $yr = $_GET['year'];
    }
 else {
     $yr = '';
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
           
            
            
           
            
            <div class="cleaner"></div>
        </div> <!-- end of sidebar -->
        
        <div id="templatemo_content">
            <ul class="breadcrumb" style="padding-top: 2px;">
                <li><a href="index.php">Home</a></li>
                <li><a href="documents.php">Documents</a></li>
                
                <?php if($yr != '') echo '<li><a href="circulars.php">Circulars</a></li><li>'.  $yr.'</li>'; else echo '<li>Circulars</li>'; ?>
            </ul>
            <div align="right" >Search <input type="text" name="txtSearch" id="txtSearch" /><img src="images/search.ico" style="padding-left: 3px;cursor: pointer;" onclick="loadCirculars()" /></div>
            <table>
                <tr>
                    <td>
                    <div  style="width:95%;padding-left: 50px;">    
                    	
            
                    <?php
                        if($yr == '') {
                            $year = date('Y');
                            echo '<table class="folder">';
                            for($i=0;$i<5;$i++){
                                echo '<tr><td>';
                                echo '<a href="circulars.php?year='. $year . '"><img class="image_wrapper image_fl" src="images/normal_folder.ico" alt="Image 1" /><h6>' . $year . '</h6></a>  </td></tr>';
                                $year--;
                            }
                            echo '</table>';
                        }
                        else {
                            $sql = "SELECT * FROM circulars where year=". $yr . " ORDER BY fileID DESC";
                            $result = mysqli_query($conn,$sql);
                            if(mysqli_num_rows($result)>0) {
                                echo '<div  style="overflow-y: scroll;min-height:650px;" ><table id="tblDocument" >';
                                while($row=mysqli_fetch_array($result)) {
                                    echo '<tr><td ><div class="content_box" style="padding-top: 3px;padding-bottom:3px;"><a href="documents/circulars/' . $row['fileName'] . 
                                            '" target="_blank" ><img class="image_wrapper image_fl1" src="images/pdf_document.ico" alt="Image 1" /><h6>' . $row['title'] .'</h6></a></div></td></tr>';
                                    
                            } echo '</table></div>';
                        }
                       
                            
                        }
                        /**/
                    ?>
                    </div>
             
                    </td>
                   <!-- <td valign="top"><div class="sidebar_box" style="float: right;padding-top: 20px;width: 100px;vertical-align: top;">
                            <div ><a style="font-size: 16px;" href="">View Archives</a></div>-->
                
            
                        
            </div>
                        </td>
                </tr>
            </table>
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
<script type="text/javascript">
        function loadCirculars()
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
                }
            };
            xmlhttp.open("GET","getCirculars.php?type=circular&str="+$str);
            xmlhttp.send();
        }
    </script>
</body>
</html>