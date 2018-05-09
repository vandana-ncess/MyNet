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
            <div id="templatemo_menu" style="height:320px;">
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
        
        <div id="templatemo_content" style="height: 295px;">
            <form method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Year</td>
                    <td>
                        <select name="ddlYear">
                            <?php 
                                for($i = date('Y');$i>=1979;$i--){
                                    echo "<option value=" . $i . ">" . $i . "</option>";
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Document Type</td><td>
                        <select name="ddlType" id="ddlType" >
                            <option value="rac">RAC</option>
                            <option value="fc">FC</option>
                            <option value="gc">GC</option>
                            <option value="others">Internal Committees</option>
                        </select>
                    </td>
                    <td id="tdCommittee"></td>
                </tr>
                <tr>
                    <td>Title</td><td colspan="3"><input type="text" name="txtTitle" id="txtTitle" style="width:250px;" /></td>
                </tr>
                <tr>
                    <td>Description</td><td colspan="3"><input type="text" name="txtDesc" id="txtDesc" style="width:450px;" /></td>
                </tr>
                <tr>
                    <td>Upload Agenda</td><td colspan="2"><input type="file"  name="file1" /> </td>
                </tr>
                <tr>
                    <td>Upload Minutes</td><td colspan="2"><input type="file"  name="file2" /> </td><td><input type="submit" name="btnUpload" id="btnUpload" value="Upload" /></td>
                </tr>
            </table>
            </form>
          <?php
            if(isset($_POST['btnUpload'])){
                $info1 = pathinfo($_FILES['file1']['name']);
                $info2 = pathinfo($_FILES['file2']['name']);
                    $ext1 = $info1['extension'];
                     $ext2 = $info2['extension'];// get the extension of the file
                if($_POST['ddlType'] == 'rac') {
                    //$filename = "cir_" .date('Y-m-d_H-i-s') . ".".$ext;
                    $filename1 = "rac_agenda_" .date('Y-m-d_H-i-s') . ".".$ext1;
                    $filename2 = "rac_minutes_" .date('Y-m-d_H-i-s') . ".".$ext2;
                    $target = 'documents/rac/';
                    $sql1 = "INSERT INTO rac_meetings(title,description,year,fileName) VALUES('". $_POST['txtTitle'] . "','" . $_POST['txtDesc'].  "'," . date('Y'). ",'". $filename1."')"; 
                    $sql2 = "INSERT INTO rac_meetings(title,description,year,fileName) VALUES('". $_POST['txtTitle'] . "','" . $_POST['txtDesc'].  "'," . date('Y'). ",'". $filename2."')"; 
                }
                elseif($_POST['ddlType'] == 'gc'){
                    $filename1 = "gc_agenda_" .date('Y-m-d_H-i-s') . ".".$ext1;
                    $filename2 = "gc_minutes_" .date('Y-m-d_H-i-s') . ".".$ext2;
                    $target = 'documents/gc/';
                    $sql1 = "INSERT INTO gc_meetings(title,description,year,fileName) VALUES('". $_POST['txtTitle'] . "','" . $_POST['txtDesc'].  "'," . date('Y'). ",'". $filename1."')"; 
                    $sql2 = "INSERT INTO gc_meetings(title,description,year,fileName) VALUES('". $_POST['txtTitle'] . "','" . $_POST['txtDesc'].  "'," . date('Y'). ",'". $filename2."')"; 
                }
                elseif($_POST['ddlType'] == 'fc') {
                    $filename1 = "fc_agenda_" .date('Y-m-d_H-i-s') . ".".$ext1;
                    $filename2 = "fc_minutes_" .date('Y-m-d_H-i-s') . ".".$ext2;
                    $target = 'documents/fc/';
                    $sql1 = "INSERT INTO fc_meetings(title,description,year,fileName) VALUES('". $_POST['txtTitle'] . "','" . $_POST['txtDesc'].  "'," . date('Y'). ",'". $filename1."')"; 
                    $sql2 = "INSERT INTO fc_meetings(title,description,year,fileName) VALUES('". $_POST['txtTitle'] . "','" . $_POST['txtDesc'].  "'," . date('Y'). ",'". $filename2."')"; 
                }
                else {
                    $filename1 = "oc_agenda_" .date('Y-m-d_H-i-s') . ".".$ext1;
                    $filename2 = "oc_minutes_" .date('Y-m-d_H-i-s') . ".".$ext2;
                    $target = 'documents/oc/';
                    $sql1 = "INSERT INTO oc_meetings(ocCommitteeID,title,description,year,fileName) VALUES(".$_POST['ddlCommittee']. ",'". $_POST['txtTitle'] . "','" . $_POST['txtDesc'].  "'," . date('Y'). ",'". $filename1."')"; 
                    $sql2 = "INSERT INTO oc_meetings(ocCommitteeID,title,description,year,fileName) VALUES(".$_POST['ddlCommittee']. ",'". $_POST['txtTitle'] . "','" . $_POST['txtDesc'].  "'," . date('Y'). ",'". $filename2."')"; 
                }
                if (!file_exists($target)) {
                     mkdir($target, 0777, true);
}
                $result = mysqli_query($conn,$sql1);
                $result = mysqli_query($conn,$sql2);
                if($result)
                {
                    move_uploaded_file( $_FILES['file1']['tmp_name'], $target. $filename1 );
                    if(move_uploaded_file( $_FILES['file2']['tmp_name'], $target. $filename2 ))
                        echo "Successfully Uploaded!";
                    else {
                        echo 'Upload failed!';
                    }
                }
            }
          ?>   
            <script type="text/javascript">
                function loadCommittee() {
                    if(document.getElementById('ddlType').value == 'others') {
                        if (window.XMLHttpRequest) {
                            // code for IE7+, Firefox, Chrome, Opera, Safari
                                xmlhttp = new XMLHttpRequest();
                            } else {
                            // code for IE6, IE5
                                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                            }
                            xmlhttp.onreadystatechange = function() {
                                if (this.readyState == 4 && this.status == 200) {
                                    document.getElementById("tdCommittee").innerHTML = this.responseText ;
                                }
                            };
                            xmlhttp.open("GET","getCommittee.php"+$str);
                            xmlhttp.send();
                    }
                }
            </script>
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

</html>