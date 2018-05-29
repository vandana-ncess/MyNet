<?php 
    session_start();
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        // last request was more than 30 minutes ago
        session_unset();     // unset $_SESSION variable for the run-time 
        session_destroy();   // destroy session data in storage
        echo "<script>document.location='index.php';</script>";
    }
    else {
        $_SESSION['LAST_ACTIVITY'] = time();   
   }

    $conn = require_once('databaseconnection.php'); 
    $sql = "SELECT A.*,divisionName,designation FROM employee A JOIN division B ON A.divisionID=B.divisionID JOIN designation C ON "
                        . "A.designationID=C.designationID WHERE username='" . $_SESSION['user'] . "'";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result);
    $_SESSION['employeeCode'] = $row['employeeCode'];
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
            </div> 
           
            
           
            
            <div class="cleaner"></div>
        </div> <!-- end of sidebar -->
        
        <div id="templatemo_content">
           <!-- <div align="right" >Search <input type="text" name="txtSearch" id="txtSearch" /><img src="images/search.ico" style="padding-left: 3px;cursor: pointer;" onclick="search()"/></a></div>
            --><form method="POST" action="" enctype="multipart/form-data">
            <div id="myModal" class="modal">

                <!-- Modal content -->
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <table class="tab">
                        <tr>
                            <td>Address</td><td colspan="3"><textarea name="txtAddress" id="txtAddress" cols="30" ><?php echo $row['residenceAddress']; ?></textarea></td>
                        </tr>
                        <tr>
                            <td>Email ID</td><td colspan="3"><input type="text" id="txtEmail" name="txtEmail" style="width:280px;" <?php echo "value='".  $row['emailID'] . "'"; ?> />
                        </tr>
                        <tr>
                            <td>Mobile No</td><td><input type="text" id="txtMobile" name="txtMobile"  style="width:280px;" <?php echo "value='". $row['mobileNo'] . "'"; ?></td>
                        </tr>
                        <tr>
                          <td>Residence Contact </td><td><input type="text" id="txtContact"  style="width:280px;" name="txtContact" <?php echo "value='".$row['residenceContact'] . "'"; ?></td>  
                        </tr>
                        <tr>
                          <td>Extension No</td><td><input type="text" id="txtExt"  style="width:280px;" name="txtExt" <?php echo "value='".$row['extension'] . "'"; ?></td> 
                          <td><input type="submit" name="btnUpdate" id="btnUpdate" value="Update" /></td>
                        </tr>
                       
                    </table>
                </div>

            </div>
                <div id="myModal1" class="modal">

                <!-- Modal content -->
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3>Upload Biodata for Website Updation</h3>
                    <table class="tab">
                        <tr>
                            <td><input type="file" name="updBiodata" id="updBiodata" accept=".docx" /></td><td><input type="submit" id="UpdProfile" name="UpdProfile" value="Upload" /></td>
                        <tr>
                         Note : Upload  .docx Files only.
                       
                    </table>
                </div>

            </div>
                <div id="myModal2" class="modal">

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
            </form>
            <form method="post">
  
        <table class="tab">
           
            <tr>
                <td width="120px">Full Name</td><td width="320px" style="padding-left: 10px;"  ><?php if($_SESSION['user']=='admin') echo 'Administrator'; else echo $row['employeeName']; ?></td><td rowspan="9"><?php echo '<img src="images/profile/' . $row['employeeCode'] . '.jpg" width="180" height="200" />'; ?></td>
            </tr>
           <tr>
                <td>Designation</td><td style="padding-left: 10px;" ><?php if($_SESSION['user']=='admin') echo 'Administrator'; else echo $row['designation']; ?></td>
            </tr>
            <tr>
                <td>Division</td><td style="padding-left: 10px;" ><?php if($_SESSION['user']=='admin') echo 'Administrator'; else echo $row['divisionName']; ?></td>
            </tr>
            <tr>
                <td>Date of Birth</td><td style="padding-left: 10px;" ><?php echo date("d-m-Y", strtotime($row['dateOfBirth']));  ?></td>
            </tr>
            <tr>
                <td>Address</td><td style="padding-left: 10px;" ><?php echo $row['residenceAddress']; ?></td>
            </tr>
            <tr>
                <td>Email ID</td><td style="padding-left: 10px;" ><?php if($_SESSION['user']=='admin') echo 'adm@ncess.gov.in'; else echo $row['emailID'] ; ?></td>
            </tr>
            <tr>
                <td>Mobile No</td><td style="padding-left: 10px;" ><?php echo $row['mobileNo'] ; ?></td>
            </tr>
            <tr>
                <td>Residence Contact </td><td style="padding-left: 10px;" ><?php echo $row['residenceContact'] ; ?></td>
            </tr>
            <tr>
                 <td>Extension No</td><td style="padding-left: 10px;" > <?php if($_SESSION['user']=='admin') echo '1669'; else echo $row['extension']; ?></td> 
            </tr>
            <tr>
                <td>Blood Group </td><td style="padding-left: 10px;" ><?php echo $row['bloodgrp'] ; ?></td><td align="right" ><a onclick='myModal2.style.display = "block";'>Edit Photo </a></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;"><button id="myBtn">Edit Profile</button></td>
            </tr>
            <tr><td colspan="3" style="padding-top: 20px;"><h3>Profile Updation in NCESS Website</h3></tr>
            <tr><td colspan="3"> For profile updation in NCESS Website, kindly <a href="documents/Biodata_Template.docx" target="_blank" style="text-decoration: none;color: #666;" >download this </a> <a href="documents/Biodata_Template.docx" target="_blank" >template</a> and upload below
                    <input type="button" id="btnUpload" name="btnUpload" value="Upload" /></td></tr>
            <tr><td colspan="3" style="padding-top: 20px;"><h3>Add Publications</h3></tr>
            <tr>
                <td colspan="3">
                    <table class="tab">
                        <tr>
                            <td style="width:350px;"><span class="mandatory">* </span>Year</td>
                        <td><select name="ddlYear" id="ddlYear"  style="width:100px;height:25px;" required>
                                        
                                        <?php 
                                            $curr_yr = date('Y');
                                            for($i=$curr_yr;$i>=1979;$i--) {
                                                echo "<option value='" . $i . "'>" . $i. "</option>";
                                            }
                                        ?>

                                    </select>
                        </td>
                            <td align="right"><span class="mandatory">* </span>Research Area</td> <td colspan="2"><select name="ddlArea" required id="ddlArea" style="height: 25px;">
                                        
                                        <option value="Crustal Processes Group">Crustal Processes Group</option>
                                        <option value="Coastal Processes Group">Coastal Processes Group</option>
                                        <option value="Atmospheric Processes Group">Atmospheric Processes Group</option>

                                        <option value="Hydrological Processes Group">Hydrological Processes Group</option>
                                    </select>
                        </td>
                        
                    </tr>
                        <tr>
                            <td><span class="mandatory">* </span>Author(s)</td><td colspan="4"><input type="text" name="txtAuthor" id="txtAuthor" style="width:480px;" required /></td>
                            
                        </tr>
                        <tr>
                            <td><span class="mandatory">* </span>Title</td> <td colspan="4"><input type="text" id="txtTitle" name="txtTitle" style="width:480px;" required /></td>
                        </tr>
                        <tr>
                            <td><span class="mandatory">* </span>Journal Name</td><td colspan="2"><input type="text" id="txtJounal" name="txtJournal" required  style="width:266px;"  /></td><td style="padding-left: 20px;">Issue</td><td ><input type="text" id="txtIssue" name="txtIssue" style="width:112px;" /></td>
                        </tr>
                        <tr>
                            <td>DOI</td><td colspan="2"><input type="text" id="txtDOI" name="txtDOI"  style="width:266px;"   /></td><td style="padding-left: 20px;">Page No(s)</td><td><input type="text" id="txtPage" name="txtPage" style="width:112px;"  /></td>
                        </tr>
                        <tr>
                            <td colspan="5" align="right"><input type="submit" name="btnSave" id="btnSave" value="Save" /></td>
                        </tr>
                 </table>       
                </td>       
            </tr>
           <?php
            if(isset($_POST['btnSave'])) {
                $sql = "INSERT INTO research_publications(year,authors,researchArea,journal) VALUES(' " . $_POST['ddlYear'] . "','" . $_POST['txtAuthor']. 
                        "','" . $_POST['ddlArea'] . "','" . $_POST['txtTitle']. "; " . $_POST['txtJournal'].  ";" . $_POST['txtIssue'].  "; pp-" . 
                        $_POST['txtPage']. "; DOI : " . $_POST['txtDOI']  .  "');";
                $result = mysqli_query($conn,$sql);
                 if($result)
                    echo "<script>alert('Submitted Publication!');document.location='profile.php';</script>";
                else {
                    echo "<script>alert(Failed to save!');</script>";
                 }
            }
            if(isset($_POST['btnUpdate'])) {
               $sql = "UPDATE employee SET residenceAddress = '" . $_POST['txtAddress'] . "',residenceContact='" . $_POST['txtContact']. 
                        "',mobileNo='" . $_POST['txtMobile'] . "',extension='" . $_POST['txtExt']. "',emailID=' " . $_POST['txtEmail'] .
                       "' WHERE username = '" . $_SESSION['user'] .  "'" ;
                $result = mysqli_query($conn,$sql);
                if($result)
                    echo "<script>alert('Updated Successfully!');document.location='profile.php';</script>";
                else {
                    echo "<script>alert(Failed to update!');</script>";
                } 
            }
            if(isset($_POST['UpdProfile'])){
                $sql = "UPDATE employee SET biodataModified = 1 WHERE username = '" . $_SESSION['user'] .  "'" ;
                $result = mysqli_query($conn,$sql);
                $info = pathinfo($_FILES['updBiodata']['name']);
                    $ext = $info['extension']; // get the extension of the file
                    $filename = date('Y-m-d_H-i-s') . ".".$ext;
                    $target = 'documents/'.$filename;
                   // $sql = "INSERT INTO circulars(title,description,fileName,year) VALUES('". $_POST['txtTitle'] . "','" . $_POST['txtDesc']. "','" . $filename . "'," . date('Y').")"; 
                if(move_uploaded_file( $_FILES['updBiodata']['tmp_name'], $target))
                        echo "<script>alert('Updated Successfully!')</script>";
                    else {
                        echo "<script>alert(Failed to update!');</script>";
                    }
                }
            if(isset($_POST['btnPhoto'])){
                $info = pathinfo($_FILES['updPhoto']['name']);
                    $ext = $info['extension']; // get the extension of the file
                    $filename = $_SESSION['employeeCode'] . ".".$ext;
                    $target = 'images/profile/'.$filename;
                   // $sql = "INSERT INTO circulars(title,description,fileName,year) VALUES('". $_POST['txtTitle'] . "','" . $_POST['txtDesc']. "','" . $filename . "'," . date('Y').")"; 
                if(move_uploaded_file( $_FILES['updPhoto']['tmp_name'], $target))
                        echo "<script>alert('Updated Successfully!');;document.location='profile.php';</script>";
                    else {
                        echo "<script>alert(Failed to update!');</script>";
                    }
                }
           ?>
                
        </table>
            
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
  <script>
// Get the modal
var modal = document.getElementById('myModal');
var modal1 = document.getElementById('myModal1');
// Get the button that opens the modal
var btn = document.getElementById("myBtn");
var btn1 = document.getElementById("btnUpload");
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
var span1 = document.getElementsByClassName("close")[1];
// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}
btn1.onclick = function() {
    modal1.style.display = "block";
}
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}
span1.onclick = function() {
     modal1.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
    else if (event.target == modal1) {
        modal1.style.display = "none";
    }
}
</script>
 
</body>
</html>