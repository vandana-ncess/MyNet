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
<body>

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
          
        </div> <!-- end of sidebar -->
        
        <div id="templatemo_content">
            <form method="post" enctype="multipart/form-data" action="">
            <table>
                <tr>
                    <td>Document Type</td><td>
                        <select name="ddlType" id="ddlType" onchange="loadCircular()" >
                            <option value="circular">OM/Circular</option>
                            <option value="rti">RTI</option>
                            <option value="court">Court Order</option>
                            <option value="notice">Notice Board</option>
                            
                            <option value="general">General Requisition Forms</option>
                            <option value="lab">Lab Requisition Forms</option>
                        </select>
                    </td>
                    <td>Year</td>
                    <td>
                        <select name="ddlYear">
                            <?php 
                                for($i = date('Y');$i>=1979;$i--){
                                    echo "<option value=" . $i . ">" . $i . "</option>";
                                }
                            ?>
                        </select>
                </tr>
                <tr>
                    <td>Title</td><td colspan="3"><input type="text" name="txtTitle" id="txtTitle" style="width:250px;" /></td>
                </tr>
                <tr>
                    <td>Description</td><td colspan="3"><input type="text" name="txtDesc" id="txtDesc" style="width:450px;" /></td>
                </tr>
                <tr>
                    <td>Upload File</td><td colspan="2"><input type="file"  name="file" /> </td><td><input type="submit" name="btnUpload" id="btnUpload" value="Upload" /></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <table id="tblCircular" class="tbl" ></table>
                    </td>
                </tr>
            </table>
            </form>
          <?php
            if(isset($_POST['btnUpload'])){
                $info = pathinfo($_FILES['file']['name']);
                    $ext = $info['extension']; // get the extension of the file
                if($_POST['ddlType'] == 'circular') {
                    $filename = "cir_" .date('Y-m-d_H-i-s') . ".".$ext;
                    $target = 'documents/circulars/'.$filename;
                    $sql = "INSERT INTO circulars(title,description,fileName,year) VALUES('". $_POST['txtTitle'] . "','" . $_POST['txtDesc']. "','" . $filename . "'," . date('Y').")"; 
                }
                elseif($_POST['ddlType'] == 'rti'){
                    $filename = "rti_" .date('Y-m-d_H-i-s') . ".".$ext;
                    $target = 'documents/rti/'.$filename;
                    $sql = "INSERT INTO rti(title,description,fileName,year) VALUES('". $_POST['txtTitle'] . "','" . $_POST['txtDesc']. "','" . $filename . "'," . date('Y').")"; 
                }
                elseif($_POST['ddlType'] == 'lab'){
                    $filename = "lab_" .date('Y-m-d_H-i-s') . ".".$ext;
                    $target = 'documents/forms/'.$filename;
                    $sql = "INSERT INTO lab_forms(title,fileName) VALUES('". $_POST['txtTitle'] .  "','" . $filename ."')"; 
                }
                elseif($_POST['ddlType'] == 'general'){
                    $filename = "general_" .date('Y-m-d_H-i-s') . ".".$ext;
                    $target = 'documents/forms/'.$filename;
                    $sql = "INSERT INTO general_forms(title,fileName) VALUES('". $_POST['txtTitle'] . "','"  . $filename ."')"; 
                }
                elseif($_POST['ddlType'] == 'court') {
                    $filename = "court_" .date('Y-m-d_H-i-s') . ".".$ext;
                    $target = 'documents/court_order/'.$filename;
                    $sql = "INSERT INTO court_orders(title,description,fileName,year) VALUES('". $_POST['txtTitle'] . "','" . $_POST['txtDesc']. "','" . $filename . "'," . date('Y').")"; 
                }
                elseif($_POST['ddlType'] == 'notice') {
                    $filename = "notice_" .date('Y-m-d_H-i-s') . ".".$ext;
                    $target = 'documents/'.$filename;
                    $sql = "INSERT INTO noticeboard(title,keyword,filename,status) VALUES('". $_POST['txtTitle'] . "','" . $_POST['txtDesc']. "','" . $filename . "',1)"; 
                }
                $result = mysqli_query($conn,$sql);
                if($result)
                {                    
                   if(move_uploaded_file( $_FILES['file']['tmp_name'], $target))
                        echo "Successfully Uploaded!";
                    else {
                        echo 'Upload failed!';
                    }
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
        function loadCircular() {
            if(document.getElementById('ddlType').value=='notice') {
                if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                    } else {
                        // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById('tblCircular').innerHTML= this.responseText ;
                        }
                    };
                    xmlhttp.open("GET","getNoticeBoard.php");
                    xmlhttp.send();
                }
                else
                    document.getElementById('tblCircular').innerHTML="";
        }
        function deleteNoticeBoard($id) {
            if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                    } else {
                        // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            alert(this.responseText) ;document.location='adminDocuments.php';
                        }
                    };
                    xmlhttp.open("GET","delete.php?id="+$id+"&table=notice");
                    xmlhttp.send();
       }   
    </script>
<div id="templatemo_footer_wrapper">
	<div id="templatemo_footer">
       Copyright © 2018 <a href="#">NCESS</a> | Contact Us : adm@ncess.gov.in | Ext : 1669 
        
    </div>
</div>

</html>