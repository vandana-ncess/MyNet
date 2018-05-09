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
    $conn =  require_once('databaseconnection.php'); 
    if($_SESSION['user'] != 'admin') {
        $sql = "SELECT * FROM report_privileges where employeeCode='" . $_SESSION['loggedUserID'] . "'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)==0) {
            echo '<script>alert("You are not authorised to view Reports, Kindly contact the System Administrator!");document.location="index.php";</script>';
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
<script type="text/javascript">
    var datefield=document.createElement("input")
    datefield.setAttribute("type", "date")
    if (datefield.type!="date"){ //if browser doesn't support input type="date", load files for jQuery UI Date Picker
        document.write('<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />\n')
        document.write('<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"><\/script>\n')
        document.write('<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"><\/script>\n') 
    }
</script>
 <style>
.ui-datepicker-trigger { vertical-align: middle; }
 /* {} is the value according to your need */
</style>
<script>
if (datefield.type!="date"){ //if browser doesn't support input type="date", initialize date picker widget:
    jQuery(function($){ //on document.ready
        $('#datepicker1').datepicker({ dateFormat: 'yy-mm-dd',showOn: "both",
        buttonImage: "images/calendar.ico",
        buttonImageOnly: true,
        showOn: "both" });
        $('#datepicker2').datepicker({ dateFormat: 'yy-mm-dd',showOn: "button",
        buttonImage: "images/calendar.ico",
        buttonImageOnly: true,
        showOn: "both" });
        
    })
}
</script>
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
                loadEmployee();
            }
        };
        xmlhttp.open("GET","getDesignation.php?catID="+$catID);
        xmlhttp.send();
      }
      function setEmp()
      {
          element = document.getElementById('ddlEmployee');
          document.getElementById('txtEmp').value = element.options[element.selectedIndex].text;
      }
      function loadEmployee()
      {
          $catID = document.getElementById('ddlCategory').value;
          $desigID = document.getElementById('ddlDesignation').value;
          $divID = document.getElementById('ddlDivision').value;
          element = document.getElementById('ddlDivision');
          document.getElementById('txtDiv').value = element.options[element.selectedIndex].text;
          $str = "";
          if($catID>0)
              $str = $str + " AND categoryID=" + $catID;
          if($desigID>0)
               $str = $str + " AND designationID=" + $desigID;
          if($divID>=0)
              $str = $str + " AND divisionID =" + $divID;
          if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("ddlEmployee").innerHTML = this.responseText ;
                setEmp();
            }
        };
        xmlhttp.open("GET","getEmployee.php?str="+$str);
        xmlhttp.send();
      }
      function getLeaves()
      {
          $empID = document.getElementById('ddlEmployee').value;
          $from = document.getElementById('datepicker1').value;
          $to = document.getElementById('datepicker2').value;
          if($from == '' || $to == ''){
              alert('Please enter valid date range!');
              exit;
          }
          if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("tbl").innerHTML = this.responseText ;
                alert(this.responseText);
            }
        };
        xmlhttp.open("GET","getLeaveHistory.php?empID="+$empID+"&from='" + $from.replace(/(\d\d)\/(\d\d)\/(\d{4})/, "$3-$1-$2") + "'&to='" + $to.replace(/(\d\d)\/(\d\d)\/(\d{4})/, "$3-$1-$2") + "'");
        xmlhttp.send();
      }
  </script>
</head>
    <body onload="activate()">

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
                    <li><a href="announcements.php" target="_parent">Notice Board</a></li>
                    <li><a href="documents.php" target="_parent">Documents</a></li>
                    <li><a href="attendance.php" target="_parent">Attendance</a></li>
                    <li><a href="eGovernance.php" target="_parent">e-Governance</a></li>
                    <li><a href=http://ncess.gov.in/notifications/awards.html" target="_parent">Awards</a></li>
                    <li><a href="publications.php" target="_parent">Research Publications</a></li>
                    <li><a href="http://ncess.gov.in/facilities/laboratories.html" target="_parent">Laboratories</a></li>
                    <li><a href="http://192.168.17.11:8001/" target="_parent">Online Library</a></li>
                    <li><a href="directory.php" target="_parent">Contact Directory</a></li>
                    <li><a href="email.php" target="_parent">Email Address Book</a></li>
                    <li><a href="profile.php" target="_parent">Profile Updations</a></li>
                    <li><a href="discussion.php" target="_parent">Discussion Forum</a></li>
                    <li><a href="reports.php" target="_parent"  class="current">Reports</a></li>
                    <li><a href="feedback.php" target="_parent">Feedback</a></li>
              </ul>    	
            </div> 
           
           
            
            <div class="cleaner"></div>
        </div> <!-- end of sidebar -->
        
        <div id="templatemo_content">
            <div class="content_box" style="padding-top: 10px;">
                <form method="post" action="" onsubmit="validateForm(event)"><fieldset>
                        <table class="tab">
                    <tr>
                        <td colspan="2" align="right">Select Report</td><td colspan="4">
                            <select name="ddlReport" id="ddlReport">
                                <option value="emd">Employee Master Details</option>
                                <option value="attendance">Attendance Summary Report</option>
                                <option value="leave">Leave Report</option>
                                <option value="tour">Tour Report</option>
                                <option value="late">Late Comers & Early Goers' Report</option>
                                <option value="absentee">Absentee Report</option>
                            </select>
                        </td>
                        <td>
                            <input type="radio" name="rdoDivision" id="rdoDivision" onchange="activate()" value="Division" checked /> Division Wise 
                            <input type="radio" name="rdoDivision" id="rdoEmp" value="Employee" onchange="activate()"  /> Employee Wise
                        </td>
                        
                    </tr>
                </table></fieldset>
                    <table  class="tab" style="padding-left: 10px;">
                    <tr>
                        <td >Division</td><td style="padding-left: 10px;" colspan="3"><input type="hidden" name="txtDiv" id='txtDiv' /><select id="ddlDivision" name="ddlDivision" onchange="loadEmployee()" style="width: 500px;">
                                <option value="-1">All</option>
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
                    </tr>
                    <tr>
                        <td>Category</td><td style="padding-left: 10px;" width="200px"><select id="ddlCategory" name="ddlCategory" onchange="loadDesignation()" style="width: 180px;" ><option value="0">All</option>
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
                        <td  >Designation</td><td colspan="3" style="padding-left: 10px;"><select id="ddlDesignation" name="ddlDesignation" onchange="loadEmployee()" style="width: 215px;">

                            </select>
                        </td>

                    </tr>
                    <tr>

                        <td> Employee</td><td style="padding-left: 10px;" colspan="3"><input type="hidden" name="txtEmp" id='txtEmp' /><select id="ddlEmployee" name="ddlEmployee" style="width: 500px;" onchange="setEmp()" ><option value="0"></option>

                            </select></td>
                       
                    </tr>
                    <tr>
                        <td ><span class="mandatory">* </span>From Date</td><td style="padding-left: 10px;"><input type="date" name="datepicker1" id='datepicker1'  style="width:170px;height: 18px;"   > </input></td>
                        <td style="padding-left: 10px;"><span class="mandatory">* </span>To Date</td><td style="padding-left: 10px;"><input type="date" name="datepicker2" id='datepicker2'   style="width:182px;height: 18px;"  /></td>

                    </tr>
                    <tr >
                        <td colspan="3" /><td align="right" style="padding-top: 20px; padding-bottom: 20px;"><input type="submit" name="btnShow" id="btnShow" value="Show" style="width:100px; border-radius: 12px;" /></td>
                    </tr>
                    <tr>
                        <td colspan="4"><div class="card mb-3" id="tbl">

                            </div></td>
                    </tr>    
                </table>
                </form>
            </div>
        </div>
        
        <div class="cleaner"></div>    
    </div>
    
    <div id="templatemo_main_bottom">
    </div>

</div> <!-- end of wrapper -->
</div>
<?php
    if(isset($_POST['btnShow'])) {
        if($_POST['ddlReport'] == 'emd') {
             echo "<script>document.location='emd.php';</script>";  
            
        }
        else {
            $_SESSION['start'] = $_POST['datepicker1'];
            $_SESSION['end'] = $_POST['datepicker2'];
            if($_POST['rdoDivision']=='Division') {
                $_SESSION['division'] = $_POST['ddlDivision'];
                $_SESSION['div'] = $_POST['txtDiv'];
                echo '<script>window.open("rptToday.php?report='. $_POST['ddlReport'] . '&mode=division","_blank");</script>';
            }
            else {
                $_SESSION['employee'] = $_POST['ddlEmployee'];
                $_SESSION['emp'] = $_POST['txtEmp'];
                echo '<script>window.open("rptToday.php?report='. $_POST['ddlReport'] . '&mode=employee","_blank");</script>';
            }
        }
    }
?>
<div id="templatemo_footer_wrapper">
	<div id="templatemo_footer">
        Copyright © 2018 <a href="#">NCESS</a> | Contact Us : adm@ncess.gov.in | Ext : 1669 
        
    </div>
</div>
    <script type="text/javascript">
        function activate()
        {
            if(document.getElementById('rdoEmp').checked) {
                document.getElementById('ddlCategory').disabled = false;
                document.getElementById('ddlDesignation').disabled = false;
                document.getElementById('ddlEmployee').disabled = false;
            }
            else {
                document.getElementById('ddlCategory').disabled = true;
                document.getElementById('ddlDesignation').disabled = true;
                document.getElementById('ddlEmployee').disabled = true;
            }
            loadDesignation();
        }
        function validateForm(e)
        {
            if(document.getElementById('ddlReport').value != 'emd') {
                if(document.getElementById('datepicker1').value == ''){
                    alert('Please enter Sart date!');
                    e.preventDefault();
                }
                if(document.getElementById('datepicker2').value == ''){
                    alert('Please enter End date!');
                    e.preventDefault();
                }
                if(document.getElementById('datepicker1').value>document.getElementById('datepicker2').value) {
                    alert('Start date should be less than End date!');
                    e.preventDefault();
                }
            }
            
            if(document.getElementById('rdoEmp').checked) {
               if(document.getElementById('ddlEmployee').value == ''){
                   alert('Kindly select an Employee!');
                   exit;
               }
            }
            else
            {
              if(document.getElementById('ddlDivision').value == ''){
                   alert('Kindly select a Division!');
                   exit;
               }  
            }
            
        }
        function check()
        {
           $val = document.getElementById('ddlReport').value;
           if($val == 'absentee' || $val == 'late'){
               document.getElementById('rdoEmp').disabled = true;
               document.getElementById('rdoDivision').checked = true;
           }
           else
               document.getElementById('rdoEmp').disabled = false;
           activate();
        }
    </script>
    </body>
</html>