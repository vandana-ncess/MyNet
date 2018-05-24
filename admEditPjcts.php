<?php 
    session_start();
    if(!isset($_SESSION['user']))
        echo "<script>document.location='login.php';</script>";
   if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        // last request was more than 30 minutes ago
        session_unset();     // unset $_SESSION variable for the run-time 
        session_destroy();   // destroy session data in storage
        echo "<script>document.location='login.php';</script>";
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
    <body onload="loadPrivilegedUsers()">

<div id="templatemo_body_wrapper">
<div id="templatemo_wrapper">
   
	<div id="tempaltemo_header">
            <?php if(isset($_SESSION['user'])) { ?><p align="right" style="padding-right: 50px;color:#fff;"><b><?php        echo 'Welcome ' . $_SESSION['user']; ?></b>&nbsp; <a href="logout.php" style="color: #fff;">Logout</a></p>;<?php } ?>
    	<span id="header_icon"></span>
    	<div id="header_content">
        	<div id="site_title">
				    <p>Welcome to NCESS Intranet</p>         </div>
           
		 
		</div>
    </div> <!-- end of header -->
    
    <div id="templatemo_main_top"></div>
    <div id="templatemo_main"><span id="main_top"  style="height: 164px;"></span><span id="main_bottom" style="height: 164px;"></span>
        <div id="templatemo_sidebar">
            <div id="templatemo_menu" style="min-height: 275px;">
                <?php
                        if($_SESSION['user'] == 'admin')
                            $sql ="SELECT * FROM adminmenu WHERE status =1 " ;
                        else 
                            $sql ="SELECT * FROM adminmenu A JOIN adminmenu_privileges B ON A.menuID = B.menuID  AND ". $_SESSION['loggedUserID'] . " = users WHERE A.status =1 " ;
                         $result = mysqli_query($conn,$sql);
                        if(mysqli_num_rows($result)>0) {
                            echo "<ul>";
                            while($row = mysqli_fetch_array($result)) {
                                        echo "<li><a href='". $row['page'] . "' target='_parent'>".$row['menu']. "</a></li>";
                            }
                            echo '</ul>';
                        }
                
                   ?>  	
            </div> 
        
        </div> 
        
        <div id="templatemo_content">
            <h5>Plan Project Areas</h5>
            <form method="post">
                <table>
                     
                    <tr>
                        <td>Main Project</td>
                        <td>
                            <select name="ddlProjects" id="ddlProjects" style="width:350px;">
                            <?php
                                $sql = "SELECT * FROM main_projects WHERE status=1";
                                $result = mysqli_query($conn,$sql);
                                if(mysqli_num_rows($result)) {
                                    while($data = mysqli_fetch_array($result)) {
                                        echo '<option value="' . $data['mainPjctID'].'">'. $data['title'] . '</option>';
                                    }
                                }
                            ?>
                            </select> 
                        </td>
                        <td><input type="submit" name="btnView" value="View" /></td>
                    </tr>
                    <?php
                        if(isset($_POST['btnView'])) {
                            $sql = "SELECT * FROM projects A JOIN division B ON A.divisionID = B.divisionID  "
                        . " JOIN employee D ON A.projectLeader = D.employeeCode WHERE mainPjctID = " . $_POST['ddlProjects'] . " AND A.status=1 ORDER BY A.divisionID";
                        $result = mysqli_query($conn,$sql);
                        if(mysqli_num_rows($result)>0) {
                            echo '<tr><td colspan="3"><table class="tbl"><thead><tr><th>Project Title</th><th width="100px">Project Leader</th><th>Investigators</th><th>Research Area</th><th>Delete</th></tr></thead><tbody>';
                            while($data = mysqli_fetch_array($result)) {
                                echo '<tr class="border_bottom"><td class="tdText">' . $data['projectTitle'].'</td><td class="border_bottom">'.$data['employeeName'].'</td><td class="border_bottom">';
                                $subSql = "SELECT * FROM project_investigators A JOIN employee B ON A.investigatorID=B.employeeCode WHERE projectID=" . $data['projectID'];
                                $res = mysqli_query($conn,$subSql);
                                if(mysqli_num_rows($res) > 0) {
                                    while($invest = mysqli_fetch_array($res)) {
                                        echo $invest['employeeName'] . '</br>';
                                    }
                                }
                                echo '</td><td>'.$data['divisionName'].'</td><td><img src="images/erase.png"  onclick="deleteProject('.$data['projectID'].')" style="cursor:pointer;"> '
                                        . '<br /><br /> <a style="color:blue;" href="admProjects.php?id='.$data['projectID'].'">Edit</a></td></tr>';
                            }
                            echo '</tbody></table></td></tr>';
                        }    
                        }
                    ?>
                </table>
            </form>
            
        </div>
        
        <div class="cleaner"></div>    
    </div>
    
    <div id="templatemo_main_bottom" >
    </div>

</div> <!-- end of wrapper -->
</div>
    <script type="text/javascript">
        function deleteProject($id) {
            if (window.XMLHttpRequest) {
              // code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp = new XMLHttpRequest();
          } else {
              // code for IE6, IE5
              xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                  alert(this.responseText) ;document.location='admEditPjcts.php';
              }
          };
          xmlhttp.open("GET","delete.php?id="+$id+"&table=subproject");
          xmlhttp.send();
        }
       
    </script>
<div id="templatemo_footer_wrapper">
	<div id="templatemo_footer">
       Copyright © 2018 <a href="#">NCESS</a> | Contact Us : adm@ncess.gov.in | Ext : 1669 
        
    </div>
</div>
    </body>
</html>