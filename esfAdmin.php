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
            <?php if(isset($_SESSION['user'])) { ?><p align="right" style="padding-right: 50px;color:#fff;"><b><?php        echo 'Welcome ' . $_SESSION['user']; ?></b>&nbsp; <a href="logout.php" style="color: #fff;">Logout</a></p>;<?php } ?>
    	<span id="header_icon"></span>
    	<div id="header_content">
        	<div id="site_title">
				    <p>Welcome to NCESS Family</p>         </div>
           
		 
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
            <form method="post" enctype="multipart/form-data">
                <table cellspacing="5">
                <tr>
                    <td width="100px;"><span class="mandatory">*</span> Heading</td><td colspan="3"><input type="text" name="txtTitle" id="txtTitle" style="width:450px;" required /></td>
                </tr>
                <tr>
                    <td><span class="mandatory">*</span>Subject</td><td colspan="3"><input type="text" name="txtDesc" id="txtDesc" style="width:450px;" required /></td>
                </tr>
                <tr>
                    <td><span class="mandatory">*</span>Speaker</td><td colspan="3"><input type="text" name="txtSpeaker" id="txtSpeaker" style="width:450px;" required /></td>
                </tr>
                <tr>
                    <td><span class="mandatory">*</span>Date & Venue</td><td colspan="3"><input type="text" name="txtVenue" id="txtVenue" style="width:450px;" required /></td>
                </tr>
                <tr>
                    <td /><td align="right"><input type="submit" name="btnUpload" id="btnUpload" value="Save" />
                        <input type="hidden" name="txtEsfID" id="txtEsfID" /></td>
                </tr>
                 <tr>
                    <td colspan="4">
                        <div style="max-height: 520px; overflow-y: auto;">
                        <table id="tblEsf" class="tbl" >
                            <?php
                                $sql = "SELECT * FROM esf ORDER by updatedOn DESC";
                                $result = mysqli_query($conn,$sql);
                                if(mysqli_num_rows($result)>0) {
                                    echo '<thead><tr><th>Heading</th><th>Subject</th><th>Speaker</th><th>Date&Venue</th><th>Edit</th><th>Delete</th><th>Stop</th></tr></thead>';
                                    while($data= mysqli_fetch_array($result)) {
                                        echo '<tr><td>'.$data['matter'].'</td><td>'.$data['title'].'</td><td>'.$data['speaker'].'</td><td>'.$data['date'].'</td>'
                                                
                                                . '<td><img src="images/edit.png" onclick="editESF(this)" style="cursor:pointer;" />'
                                                . '<input type="hidden" name="txtID[]" value="'. $data['id'] . '" /></td>'
                                                 .'<td><img src="images/erase.png" onclick="deleteESF('.$data['id']. ','. "'delete'" .')" style="cursor:pointer;" /></td>';
                                        if($data['status']==1)
                                                echo '<td><img src="images/no.ico" onclick="deleteESF('.$data['id']. ','. "'stop'" .')" style="cursor:pointer;" /></td>';
                                        
                                        echo '</tr>';
                                                
                                    }
                                }
                            ?>                            
                        </table>
                        </div>
                    </td>
                </tr>
            </table>
            </form>
          <?php
            if(isset($_POST['btnUpload'])){
                if($_POST['btnUpload']=='Save') 
                    $sql = "INSERT INTO esf(matter,title,speaker,date,status) VALUES('". $_POST['txtTitle'] . "','" . $_POST['txtDesc']. "','" . $_POST['txtSpeaker']. "','" . $_POST['txtVenue']. "',1)"; 
                else
                    $sql = "UPDATE esf SET matter='" . $_POST['txtTitle']."', title='" . $_POST['txtDesc'] . "', speaker='". $_POST['txtSpeaker'] . "', date='".
                        $_POST['txtVenue'] . "' WHERE id=" . $_POST['txtEsfID'] ;
                $result = mysqli_query($conn,$sql);
                if($result) {
                    echo '<script>alert("Successfully Uploaded!");document.location="esfAdmin.php";</script>';
                }    
                    else {
                        echo 'Upload failed!';
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

<div id="templatemo_footer_wrapper">
	<div id="templatemo_footer">
       Copyright © 2018 <a href="#">NCESS</a> | Contact Us : adm@ncess.gov.in | Ext : 1669 
        
    </div>
</div>
 <script type="text/javascript">
        
        function deleteESF($id,$mode) {
            if($mode=='delete')
                $str = "Do you want to delete this event?";
            else
                $str = "Do you want to stop this scrolling in home page?";
            if(confirm($str)) {
                if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                    } else {
                        // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            alert(this.responseText);document.location='esfAdmin.php';
                        }
                    };
                    xmlhttp.open("GET","delete.php?id="+$id+"&table=esf&mode="+$mode);
                    xmlhttp.send();
            }
       }  
       function editESF(e) {
            document.getElementById('txtTitle').value =  e.parentElement.parentElement.cells[0].innerHTML;
            document.getElementById('txtDesc').value =  e.parentElement.parentElement.cells[1].innerHTML;
            document.getElementById('txtSpeaker').value =  e.parentElement.parentElement.cells[2].innerHTML;
            document.getElementById('txtVenue').value =  e.parentElement.parentElement.cells[3].innerHTML;
            document.getElementById('txtEsfID').value = e.parentElement.parentElement.cells[4].children[1].value;
            document.getElementById('btnUpload').value = "Update";
       }
    </script>
</html>