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
            <?php if(isset($_SESSION['user'])) { ?><p align="right" style="padding-right: 50px;color:#fff;"><b><?php        echo 'Welcome ' . $_SESSION['user']; ?></b>&nbsp; <a href="adminlogout.php" style="color: #fff;">Logout</a></p>;<?php } ?>
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
                        <td><input type="text" name="txtTitle" id="txtTitle" style="width:450px;" /><input type ="hidden" name="txtEditID" id="txtEditID" /></td>
                        <td><input type="submit" name="btnSave" id="btnSave" value="Add" /> </td>
                    </tr> 
                    <tr>
                        <td colspan="2">
                            <?php
                                $sql = "SELECT * FROM main_projects WHERE status=1";
                                $result = mysqli_query($conn,$sql);
                                if(mysqli_num_rows($result)) {
                                    echo '<table><tr  style="background-color:#424066;color:white;height:25px;"><td>Project Area</td><td>Edit</td><td>Delete</td>';
                                    while($data = mysqli_fetch_array($result)) {
                                        echo '<tr><td>'. $data['title'] . '</td><td><img src="images/edit.png"  onclick="editTopics(this)" style="cursor:pointer;"></td> '
                                                . '<td><img src="images/erase.png"  onclick="deleteTopics(this)" style="cursor:pointer;"><input type="hidden" name="txtID" id="txtID" value="'.$data['mainPjctID'].'" /></td></tr>';
                                    }
                                    echo '</table>';
                                }
                            ?>
                            
                        </td>
                    </tr>
                </table>
            </form>
            <?php
                if(isset($_POST['btnSave'])) {
                    if($_POST['btnSave'] == 'Add') {
                        $sql = "INSERT INTO main_projects(title,status) VALUES('" . $_POST['txtTitle'] . "',1)";
                        $result = mysqli_query($conn,$sql);
                        if($result) {
                            echo 'Saved successfully!';
                            echo '<script>document.location="admMainProjects.php";</script>';
                        }
                        else
                            echo 'Failed to save!';
                    }
                    else {
                        $sql = "UPDATE main_projects SET title='" . $_POST['txtTitle'] . "' WHERE mainPjctID=" . $_POST['txtEditID'];
                        $result = mysqli_query($conn,$sql);
                        if($result) {
                            echo 'Updated successfully!';
                            echo '<script>document.location="admMainProjects.php";</script>';
                        }
                        else
                            echo 'Failed to update!';
                    }
                }
            ?>
        </div>
        
        <div class="cleaner"></div>    
    </div>
    
    <div id="templatemo_main_bottom" >
    </div>

</div> <!-- end of wrapper -->
</div>
    <script type="text/javascript">
        function deleteTopics(e) {
            $id =  e.parentElement.children[1].value;
            if (window.XMLHttpRequest) {
              // code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp = new XMLHttpRequest();
          } else {
              // code for IE6, IE5
              xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                  alert(this.responseText) ;document.location='admMainProjects.php';
              }
          };
          xmlhttp.open("GET","delete.php?id="+$id+"&table=mainproject");
          xmlhttp.send();
        }
        function editTopics(e) {
            document.getElementById('txtTitle').value =  e.parentElement.parentElement.cells[0].innerHTML;
            document.getElementById('txtEditID').value = e.parentElement.parentElement.cells[2].children[1].value;
            document.getElementById('btnSave').value = "Update";
        }
        
    </script>
<div id="templatemo_footer_wrapper">
	<div id="templatemo_footer">
       Copyright © 2018 <a href="#">NCESS</a> | Contact Us : adm@ncess.gov.in | Ext : 1669 
        
    </div>
</div>
    </body>
</html>