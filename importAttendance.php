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
    	<div id="header_content" >
        	<div id="site_title">
				    <p>Welcome to NCESS Family</p>         </div>
           
		 
		</div>
    </div> <!-- end of header -->
    
    <div id="templatemo_main_top" ></div>
    <div id="templatemo_main" style="height: 295px;"><span id="main_top" style="height: 160px;"></span><span id="main_bottom"  style="height: 160px;"></span>
    	
        <div id="templatemo_sidebar" style="height: 200px;">
        
        	<div id="templatemo_menu" >
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
            
            <div class="cleaner"></div>
        </div> <!-- end of sidebar -->
        
        <div id="templatemo_content" style="height: 125px;">
            <div class="container">
                <?php if(!empty($statusMsg)){
                    echo '<div class="alert '.$statusMsgClass.'">'.$statusMsg.'</div>';
                } ?>
            
            <div class="panel-body">
                <form action="" method="post" enctype="multipart/form-data" id="importFrm">
                    <table class="tab" cellspacing="10" cellpadding="5">
                        <tr><td>Type of Data</td>
                            <td><select name="ddlType" style="width: 180px;">
                                <option value="Attendance">Attendance </option>
                                <option value="History">Attendance History</option>
                                <option value="Leave">Leave</option>
                                <option value="Tour">Tour</option>
                                 <option value="Gate">Gate Register</option>
                                </select></td>
                        </tr>
                        <tr><td>Mode</td>
                            <td><select name="ddlMode"  style="width: 180px;">
                                <option value="Insert">Insert </option>
                                <option value="Update">Update</option>
                                </select></td>
                        </tr>
                        <tr><td>Upload File</td>
                            <td><input type="file" name="file" />
                            </td>
                        </tr>
                        <tr><td colspan="2" align="right">
                            <input type="submit" class="btn btn-primary" name="importSubmit" value="IMPORT" />
                            </td></tr>
                    </table>
                </form>
<?php
if(isset($_POST['importSubmit'])){
    $mode = $_POST['ddlMode'];
    $type = $_POST['ddlType'];
    //validate whether uploaded file is a csv file
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$csvMimes)){
        
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            
            //open uploaded csv file with read only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            
            //skip first line
            fgetcsv($csvFile);
            if($type == 'Attendance') {
                if($mode == 'Update') {
                //parse data from csv file line by line
                    while(($line = fgetcsv($csvFile)) !== FALSE){
                    //check whether member already exists in database with same email
                        $sql = "UPDATE employee_attendance SET employeeID = ".$line[0].", intime = '".$line[2]."', outtime = '".$line[3]."', status = '".$line[4]."', open_closed_status = '".$line[5]."', date = '".$line[1]."' WHERE date = '".$line[1]."' AND employeeID=" . $line[0];
                        $result = mysqli_query($conn,$sql);

                    }
                }
                else {
                    while(($line = fgetcsv($csvFile)) !== FALSE){
                      $sql = "INSERT INTO employee_attendance (employeeID, date, status, intime, outtime) VALUES (".$line[0].",'".$line[1]."','".$line[4]."','".$line[2]."','".$line[3]."')";
                      $result = mysqli_query($conn,$sql);
                    }
                }
            }
            elseif($type == 'History') {
                
                    while(($line = fgetcsv($csvFile)) !== FALSE){
                      $sql = "INSERT INTO employee_attendance (employeeID, date, status, intime, outtime,open_closed_status) VALUES (".$line[0].",'".$line[1]."','".$line[4]."','".$line[2]."','".$line[3]."','".$line[5]."')";
                      $result = mysqli_query($conn,$sql);
                    }
            }
            elseif($type == 'Leave') {
                if($mode == 'Update') {
                    while(($line = fgetcsv($csvFile)) !== FALSE){
                        $sql = "UPDATE employee_leave SET leaveStatus = '".$line[5]."', leaveTypeID = ". $line[1] ." WHERE employeeCode=" . $line[0] . " AND startDate='" . $line[2] . "' AND endDate='"
                                . $line[3] . "'";
                        $result = mysqli_query($conn,$sql);

                    }
                }
                else {
                    while(($line = fgetcsv($csvFile)) !== FALSE){
                      $sql = "INSERT INTO employee_leave (employeeCode, leaveTypeID, startDate,endDate, duration, leaveStatus) VALUES (".$line[0].",".$line[1].",'".$line[2]."','".$line[3]."',".$line[4].",'". $line[5]."')";
                      $result = mysqli_query($conn,$sql);
                    }
                }
            }
            elseif($type == 'Tour') {
                while(($line = fgetcsv($csvFile)) !== FALSE){
                      $sql = "INSERT INTO employee_tour (employeeCode, startDate, endDate, place, remarks) VALUES (".$line[0].",'".$line[1]."','".$line[2]."','".$line[3]."','".$line[4]."')";
                      $result = mysqli_query($conn,$sql);
                }
            }
            elseif($type == 'Gate') {
                if($mode == 'Update') {
                
                }
                else {
                    
                    while(($line = fgetcsv($csvFile)) !== FALSE){
                      
                      $sql = "INSERT INTO gate_register (employeeCode, date, outtime, intime, remarks) VALUES (".$line[0].",'".$line[1]."','".$line[2]."','".$line[3]."','".$line[4]."')";
                      $result = mysqli_query($conn,$sql);
                    }
                }
            }
            //close opened csv file
            fclose($csvFile);
            echo '<span style="color:green;"> Saved Successfully!</span>';
           
        }else{
            $qstring = 'Failed to save!';
        }
    }else{
        $qstring = '?status=invalid_file';
    }
}

?>

            </div>
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

</body>
</html>