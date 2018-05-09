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
    if(isset($_GET['empID'])) 
        $empID = $_GET['empID'];
    else 
        $empID = '';
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
<style>
body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 35%;
}

/* The Close Button */
.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

</style>
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
    <body onload="setData()">

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
                    <li><a href="adminHome.php" target="_parent" class="current">OM/RTI/Court</a></li>
                    <li><a href="admMinutes.php" target="_parent">Minutes & Agenda</a></li>
                    <li><a href="importAttendance.php" target="_parent">Attendance</a></li>
                    <li><a href="adminEmployee.php" target="_parent">Employee</a></li>
                </ul>   	  	
            </div> 
           
           
            
            <div class="cleaner"></div>
        </div> <!-- end of sidebar -->
        
        <div id="templatemo_content">
            <form method="post" action="" enctype="multipart/form-data">
            <div id="myModal" class="modal">
                
                <!-- Modal content -->
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3>Photo Updation</h3>
                    <table class="tab">
                        <tr>
                            <td><input type="file" name="updPhoto" id="updPhoto" accept=".jpg" size="30kb" /></td><td><input type="submit" id="btnPhoto" name="btnPhoto" value="Upload" /></td>
                        <tr>
                         Note : Upload  .jpg Files only File size should not exceed 30kb.
                       
                    </table>
                </div>

            </div>
        	<div class="content_box" style="padding-top: 10px;padding-bottom: 10px;">
                    <?php
                    if($empID != '' ) {
                         $sql = "SELECT A.*,categoryName,divisionName,designation FROM employee A "
            . " JOIN division C on A.divisionID = C.divisionID JOIN designation D ON A.designationID = D.designationID "
            . " JOIN category E ON E.categoryID = A.categoryID WHERE A.employeeCode=" . $empID;
                        
                        $result = mysqli_query($conn,$sql);
                        $data1 = mysqli_fetch_array($result);
                    }
                    ?>
                    <table style="font-size: 15px;color: #666;">
                <tr>
                    <td> Emp Code </td> <td style="padding-left: 20px;"><?php if($empID != '') {$empCode = $data1['employeeCode']; echo $empCode; } 
                    else echo '<input type="text" name="txtEmpCode" stye="width:40px;" required /> ';  ?>  </td> 
                    <td>Emp ID</td><td  ><input type="text" name="txtEmpID" id="txtEmpID"   <?php if($empID != '') echo 'value="' . $data1['employeeID'].'"'  ;?> style="width: 100px;"  /></td>
                    <td rowspan="6" colspan="2" > <img <?php if($empID != '') echo 'src="images/profile/' . $empID . '.jpg"'; else echo 'src="images/profile/blank.ico"' ; ?>  width="150px" height="170px"/> </td>
                </tr>
                        <tr>
                            <td>Name</td><td style="padding-left:20px;" colspan="3"> <input type="text" name="txtName" id="txtName" style="width: 330px;"  <?php if($empID != '') echo 'value="' . $data1['employeeName'] . '"' ;?> /></td>
                        </tr>
               
                <tr>
                    <td >Division</td><td style="padding-left: 20px;"  colspan="3">
                        <select name="ddlDiv" id="ddlDiv" style="width: 335px;">
                            <?php
                                $sql = "SELECT * FROM division WHERE divisionStatus=1 AND divisionName<>'' AND divisionID>0";
                                $res = mysqli_query($conn,$sql);
                                if(mysqli_num_rows($res)) {
                                    while($row = mysqli_fetch_array($res)) {
                                        echo "<option value='" . $row['divisionID'] . "'>" . $row['divisionName'] . "</option>";
                                    }
                                }
                            ?>
                        </select>
                    </td>
                </tr>  
                <tr>
                    <td>Category</td><td style="padding-left: 20px;"  colspan="3"> <select name="ddlCat" id="ddlCat" style="width: 335px;" onchange="loadDesignation()">
                            <?php
                                $sql = "SELECT * FROM category WHERE categoryStatus=1 ";
                                $res = mysqli_query($conn,$sql);
                                if(mysqli_num_rows($res)) {
                                    while($row = mysqli_fetch_array($res)) {
                                        echo "<option value='" . $row['categoryID'] . "'>" . $row['categoryName'] . "</option>";
                                    }
                                }
                            ?>
                        </select></td>
                    
                </tr>
                <tr>
                    <td>Designation</td><td style="padding-left: 20px;"  colspan="3"> <select name="ddlDesig" id="ddlDesig" style="width: 335px;">
                            <?php
                                $sql = "SELECT * FROM designation WHERE designationStatus=1 ";
                                $res = mysqli_query($conn,$sql);
                                if(mysqli_num_rows($res)) {
                                    while($row = mysqli_fetch_array($res)) {
                                        echo "<option value='" . $row['designationID'] . "'>" . $row['designation'] . "</option>";
                                    }
                                }
                            ?>
                        </select></td>
                    
                </tr>
                        <tr>
                    <td >Email ID</td><td style="padding-left: 20px;"  colspan="3"><input type="text" name="txtEmail" style="width: 330px;" id="txtEmail"  <?php if($empID != '') echo 'value="' . $data1['emailID'] . '"' ;?> /></td>
                </tr>        
                <tr>
                     <td>Residence Addr</td><td style="padding-left: 20px;" colspan="3"><textarea name="txtAddr" id="txtAddr" style="width: 330px;"> <?php if($empID != '') echo $data1['residenceAddress']  ;?> </textarea></td>
                    
                     <td align="right"colspan="2"> <input type="button" name="btn" id="btn" value="Change" style="border-radius: 22px;"  /></td>
                </tr>
                <tr>
                   
                    <td>Res Contact</td><td style="padding-left: 20px;"><input type="text" name="txtResContact" id="txtResContact" <?php if($empID != '') echo 'value="' . $data1['residenceContact'] . '"' ;?> style="width: 100px;"  /></td>
                <td style="padding-left: 5px;">Mobile</td><td style="padding-left: 20px;"><input type="text" name="txtMobile" style="width: 120px;" id="txtMobile"  <?php if($empID != '') echo 'value="' . $data1['mobileNo'] . '"' ;?>  /></td>
                    <td>Extension</td><td><input type="text" name="txtExt" id="txtExt" <?php if($empID != '') echo 'value="' . $data1['extension'] . '"' ;?> style="width: 60px;"  /></td>
                </tr>       
                <tr>
                    <td >Date of Join</td><td style="padding-left: 20px;" ><input type="date" name="txtDOJ" id="txtDOJ"   <?php if($empID != '') echo 'value="' . $data1['joining_date'].'"'  ;?> style="width:100px;" /></td>
                     <td style="padding-left: 5px;">Blood Grp</td><td style="padding-left: 20px;" ><select name="ddlBloodGrp" id="ddlBloodGrp" >
                                    <option value="A +ve">A +ve</option><option value="A -ve">A -ve</option><option value="B +ve">B +ve
                                        </option><option value="B -ve">B -ve</option><option value="AB +ve">AB +ve</option>
                                        <option value="AB -ve">AB -ve</option><option value="O +ve">O +ve</option><option value="O -ve">O -ve</option>
                                </select> </td>
                             <td>DoB</td><td  ><input type="date" name="txtDOB" id="txtDOB" style="width: 90px;"  <?php if($empID != '') echo 'value="' . $data1['dateOfBirth'].'"'  ;?> /></
                </tr> 
                        <tr>
                            <td >Retirement Date</td><td style="padding-left: 20px;" colspan="3"><input type="date" name="txtDOR" id="txtDOR"   <?php if($empID != '') echo 'value="' . $data1['retirement_date'].'"'  ;?> style="width:100px;"/></td>

                            <td align="right" colspan="2"> <input type="submit" name="btnUpdate" <?php if($empID != '') echo 'value="Update"'  ; else echo 'value="Save"'?> style="border-radius: 22px;"  /></td>
                </tr>
            </table>
                    <?php
                    if(isset($_POST['btnPhoto'])){
                        $info = pathinfo($_FILES['updPhoto']['name']);
                            $ext = $info['extension']; // get the extension of the file
                            $filename = ($empID=='') ? $_POST['txtEmpCode'] : $data1['employeeCode'] . ".".$ext;
                            $target = 'images/profile/'.$filename;
                           // $sql = "INSERT INTO circulars(title,description,fileName,year) VALUES('". $_POST['txtTitle'] . "','" . $_POST['txtDesc']. "','" . $filename . "'," . date('Y').")"; 
                        if(move_uploaded_file( $_FILES['updPhoto']['tmp_name'], $target))
                                echo  "<script>alert('Updated Successfully!');</script>";
                            else {
                                echo "<script>alert(Failed to update!');</script>";
                            }
                    }
                    else if(isset($_POST['btnUpdate'])){
                        if($empID =='')
                            $sql = "INSERT INTO employee(employeeID,employeeCode,employeeName,categoryID,designationID,divisionID,dateOfBirth,joining_date,retirement_date,bloodgrp,residenceAddress, "
                                . "residenceContact,emailID,mobileNo,extension,employeeStatus) VALUES(" . $_POST['txtEmpID'] . "," . $_POST['txtEmpCode'].",'" . $_POST['txtName'] . "'," . $_POST['ddlCat'] . "," 
                                . $_POST['ddlDesig'] . "," . $_POST['ddlDiv'] . ",'" . $_POST['txtDOB'] . "','" . $_POST['txtDOJ'] . "','" . $_POST['txtDOR'] . "','" . $_POST['ddlBloodGrp'] 
                                . "','" . $_POST['txtAddr'] . "','" .$_POST['txtResContact'] . "','" . $_POST['txtEmail'] . "','". $_POST['txtMobile']."','" .$_POST['txtExt'] . "',1)";
                        else {
                            $sql = "UPDATE employee SET employeeName = '" . $_POST['txtName'] . "',categoryID=" . $_POST['ddlCat'] . ",designationID=".
                                    $_POST['ddlDesig'] . ",divisionID=" . $_POST['ddlDiv'] . ",dateOfBirth='" . $_POST['txtDOB'] . "',joining_date='" .
                                    $_POST['txtDOJ'] . "',retirement_date='" . $_POST['txtDOR'] . "',residenceAddress='" . $_POST['txtAddr'] . "',residenceContact='" .
                                    $_POST['txtAddr'] . "',emailID='" . $_POST['txtEmail'] . "',mobileNo='" . $_POST['txtMobile'] . "',extension='" . $_POST['txtExt'] . 
                                    "' WHERE employeeCode=" . $empID;
                        }
                        $result = mysqli_query($conn,$sql);
                        if($result) {
                            echo "<script>alert('Saved successfully!');document.location='editEmployee.php?empID=" . $_POST['txtEmpCode'] ."';</script>";
                        }    
                        else {
                            echo "Failed to save!";
                        }
                    }    
                    ?>
          </div>
            </form>  
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
            function setData() {
                <?php if($empID != '') { ?>
               document.getElementById('ddlDiv').value = <?php echo $data1['divisionID']; ?>;
               document.getElementById('ddlCat').value = <?php echo $data1['categoryID']; ?>;
               document.getElementById('ddlDesig').value = <?php echo $data1['designationID']; ?>;
               document.getElementById('ddlBloodGrp').value =<?php echo "'". $data1['bloodgrp']. "'"; ?>;
                <?php } ?>
            }
        </script>
        <script>
// Get the modal
var modal = document.getElementById('myModal');
var btn = document.getElementById("btn");
btn.onclick = function() {
    modal.style.display = "block";
}
span.onclick = function() {
    modal.style.display = "none";
}
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
   
}
function loadDesignation()
      {
          $catID = document.getElementById('ddlCat').value;
          if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("ddlDesig").innerHTML = this.responseText ;
                loadEmployee();
            }
        };
        xmlhttp.open("GET","getDesignation.php?catID="+$catID);
        xmlhttp.send();
      }
</script>

</html>