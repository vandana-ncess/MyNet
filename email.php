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
    <body onload="loadDesignation()">

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
                    <li><a href="documents.php" target="_parent">Documents</a></li>
                    <li><a href="attendance.php" target="_parent">Attendance</a></li>
                    <li><a href="eGovernance.php" target="_parent">e-Governance</a></li>
                    <li><a href=http://ncess.gov.in/notifications/awards.html" target="_parent">Awards</a></li>
                    <li><a href="publications.php" target="_parent">Research Publications</a></li>
                    <li><a href="http://ncess.gov.in/facilities/laboratories.html" target="_parent">Laboratories</a></li>
                    <li><a href="http://192.168.17.11:8001/" target="_parent">Online Library</a></li>
                    <li><a href="directory.php" target="_parent">Contact Directory</a></li>
                    <li><a href="email.php" target="_parent" class="current">Email Address Book</a></li>
                    <li><a href="profile.php" target="_parent">Profile Updations</a></li>
                    <li><a href="discussion.php" target="_parent">Discussion Forum</a></li>
                    <li><a href="reports.php" target="_parent">Reports</a></li>
                    <li><a href="feedback.php" target="_parent">Feedback</a></li>
              </ul>    	   	
            </div>            
                      
            
            <div class="cleaner"></div>
        </div> <!-- end of sidebar -->
        
        <div id="templatemo_content">
        	<div class="content_box" >
                    <table width="100%"  align="left" cellpadding="0" cellspacing="0" class='directory' id="tbl">
			
                        <tr align="right">
			    <td colspan="6" align="left" bgcolor="#424066" height="25px;" style="color: white;" >Email Address Book</td>
                        </tr>
                        <tr>
                            <td  style="padding-top: 20px;">Division</td>
                            <td colspan="2"  style="padding-top: 20px;">
                                <select id="ddlDivision" name="ddlDivision"  style="width: 220px;"><option value="-1">All</option>
                                    <?php
                                        $sql = "SELECT divisionID,divisionName FROM division WHERE divisionStatus=1";
                                        $result = mysqli_query($conn,$sql);
                                        if(mysqli_num_rows($result) > 0)
                                        {
                                            while ($row = mysqli_fetch_array($result)) {
                                                echo "<option value=" . $row['divisionID'] . ">" . $row['divisionName'] . "</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </td>
                            <td  style="padding-top: 20px;padding-left: 5px;">Category</td>
                            <td colspan="2"  style="padding-top: 20px;"><select id="ddlCategory" name="ddlCategory" onchange="loadDesignation()" style="width: 200px;" ><option value="0">All</option>
                            <?php
                                $sql = "SELECT categoryID,categoryName FROM category WHERE categoryStatus=1";
                                $result = mysqli_query($conn,$sql);
                                if(mysqli_num_rows($result) > 0)
                                {
                                    while ($row = mysqli_fetch_array($result)) {
                                        echo "<option value=" . $row['categoryID'] . ">" . $row['categoryName'] . "</option>";
                                    }
                                }
                            ?>
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td >Designation</td>
                            <td colspan="2">
                                <select id="ddlDesignation" name="ddlDesignation"  style="width: 220px;">
                                </select>
                            </td>
                            <td   style="padding-left: 5px;">Name</td><td colspan="3"><input type="text" name="txtEmployee" id="txtEmployee" style="width: 194px;" /> </td>
                        </tr>
                        <tr>
                            <td colspan="6" align="right" style="padding: 10px;"><input type="button" name="btnSearch" id="btnSearch" value="Search" onclick="loadDirectory()" /></td>
                        </tr>
                        <tr align="right">
			    <td colspan="6" align="left" bgcolor="#424066" height="25px;" style="color: white;" ></td>
                        </tr>
                        <tr>
                            <td colspan="6" style="padding-top: 10px;"><div style="overflow-y:scroll;max-height: 350px;"> <table id ="tblDirectory" style="overflow-x:   scroll;overflow-y: auto;"></table></div></td>
                        </tr>
                        <tr><td colspan="6" style="padding-top: 10px;"><input type='button' name='btnCopy' id='btnCopy' value='Copy' style="display: none;float: right;" onclick="copyEmail()" /> </td></tr>
                        <tr><td colspan='6' style="padding-top: 10px;" ><textarea  name='txtEmail' rows="10" id='txtEmail' style='width:600px;display:none;'  ></textarea></td></tr>
                     </table>
               
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
        Copyright © 2018 <a href="#">NCESS</a> | Contact Us : adm@ncess.gov.in | Ext : 1669 
        
    </div>
</div>
<script type="text/javascript">
      function loadDesignation()
      {
          $catID = document.getElementById('ddlCategory').value;
          if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("ddlDesignation").innerHTML = this.responseText ;
            }
        };
        xmlhttp.open("GET","getDesignation.php?catID="+$catID);
        xmlhttp.send();
      }
      function loadDirectory()
      {
          document.getElementById('btnCopy').style.display = "none";
                document.getElementById('txtEmail').style.display = "none";
                document.getElementById('txtEmail').value='';
          $catID = document.getElementById('ddlCategory').value;
          $desigID = document.getElementById('ddlDesignation').value;
          $divID = document.getElementById('ddlDivision').value;
          $empName = document.getElementById('txtEmployee').value;
          $str = "";
          if($catID>0)
              $str = $str + " AND A.categoryID=" + $catID;
          if($desigID>0)
               $str = $str + " AND A.designationID=" + $desigID;
          if($divID>=0)
              $str = $str + " AND A.divisionID =" + $divID;
          if($empName != '')
              $str = $str + " AND employeeName like '%" + $empName + "%'";
          if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("tblDirectory").innerHTML = this.responseText ;
                document.getElementById('btnCopy').style.display = "block";
                document.getElementById('txtEmail').style.display = "block";
            }
        };
        xmlhttp.open("GET","getDirectory.php?type=email&str="+$str);
        xmlhttp.send();
      }
      function checkAll() {
          $checked = document.getElementById('chkAll').checked;
          $tbl = document.getElementById('tblDirectory');
          for (var i = 1; i<$tbl.rows.length ; i++) {
              chk = $tbl.rows[i].cells[0].children[0];
                chk.checked = $checked;
         }
      }
      function copyEmail() {
          $tbl = document.getElementById('tblDirectory');
          $mail = '';
          for (var i = 1; i<$tbl.rows.length ; i++) {
              if($tbl.rows[i].cells[0].children[0].checked && $tbl.rows[i].cells[2].innerHTML != '')
                $mail = $mail + $tbl.rows[i].cells[2].innerHTML + ",";
         }
         document.getElementById('txtEmail').value = $mail;
      }
   </script>
</body>
</html>