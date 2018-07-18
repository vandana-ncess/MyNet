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
<link href="templatemo_style.css" rel="stylesheet" type="text/css" />
<!--////// CHOOSE ONE OF THE 3 PIROBOX STYLES  \\\\\\\-->
<link href="css_pirobox/white/style.css" media="screen" title="shadow" rel="stylesheet" type="text/css" />
<!--<link href="css_pirobox/white/style.css" media="screen" title="white" rel="stylesheet" type="text/css" />
<link href="css_pirobox/black/style.css" media="screen" title="black" rel="stylesheet" type="text/css" />-->
<!--////// END  \\\\\\\-->
 <link rel="shortcut icon" href="images/logo1.png" type="image/x-icon"/>
<script type="text/javascript" src="js/bootstrap.min.js"></script>

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
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
        /* Toggle between adding and removing the "active" class,
        to highlight the button that controls the panel */
        this.classList.toggle("active");

        /* Toggle between hiding and showing the active panel */
        var panel = this.nextElementSibling;
        if (panel.style.display === "block") {
            panel.style.display = "none";
        } else {
            panel.style.display = "block";
        }
    });
}
$('#accordion').collapse("hide");
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
                            $sql ="SELECT * FROM adminmenu A JOIN adminmenu_privileges B ON A.menuID = B.menuID  AND ". $_SESSION['loggedUserID'] . " = users WHERE A.status =1 ORDER BY privilegeID" ;
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
          
        </div> <!-- end of sidebar -->
        
        <div id="templatemo_content">
           <button class="accordion" style="margin-top:20px;">Leave</button>
           <div class="panel">
               <div style="overflow-y: auto;max-height: 500px;width: 100%;">
             <?php
                $sql = "SELECT A.*,C.employeeName as emp,B.employeeName as updatedBy,leaveType FROM employeeleave_history A JOIN employee B ON A.updatedBy = B.employeeCode "
                        . "JOIN employee C ON A.employeeCode=C.employeeCode JOIN leave_type D ON A.leaveTypeID = D.leaveTypeID ORDER BY A.updatedBy,A.updatedOn DESC";
                $result = mysqli_query($conn,$sql);   
                $lastUser='';
                if(mysqli_num_rows($result)>0) {
                    echo '<table ><thead><tr><th>Action</th><th>Action Time</th><th width="100px">Employee</th><th width="100px">Leave Type</th> '
                    . '<th width="100px">Start</th><th width="100px">End</th></tr></thead><tbody>';
                    while($data = mysqli_fetch_array($result)) {
                        if($lastUser != $data['updatedBy']) 
                            echo '<tr><td colspan="6" class="mainPjct">'.$data['updatedBy'].'</td></tr>';
                        echo '<tr><td>' . $data['actionName'].'</td><td>'.$data['updatedOn'].
                                '</td><td>'.$data['emp'].'</td><td>'.$data['leaveType'].'</td><td>'.$data['startDate'].'</td><td>'.$data['endDate'].'</td></tr>';
                        $lastUser = $data['updatedBy'];
                    }
                    echo '</tbody></table>';
                }
                ?></div>
            </div> 
           <button class="accordion" style="margin-top:20px;">Tour</button>
           <div class="panel" > <div style="overflow-y: auto;max-height: 500px;width: 100%;">
             <?php
                $sql = "SELECT A.*,C.employeeName as emp,B.employeeName as updatedBy FROM employeetour_history A JOIN employee B ON A.updatedBy = B.employeeCode "
                        . "JOIN employee C ON A.employeeCode=C.employeeCode ORDER BY A.updatedBy,A.updatedOn DESC";
                $result = mysqli_query($conn,$sql);
                $lastUser='';
                if(mysqli_num_rows($result)>0) {
                    echo '<table ><thead><tr><th>Action</th><th>Action Time</th><th width="100px">Employee</th><th width="100px">Place</th> '
                    . '<th width="100px">Start</th><th width="100px">End</th></tr></thead><tbody>';
                    while($data = mysqli_fetch_array($result)) {
                        if($lastUser != $data['updatedBy']) 
                            echo '<tr><td colspan="6" class="mainPjct">'.$data['updatedBy'].'</td></tr>';
                        echo '<tr><td>' . $data['actionName'].'</td><td>'.$data['updatedOn'].
                                '</td><td>'.$data['emp'].'</td><td>'.$data['place'].'</td><td>'.$data['startDate'].'</td><td>'.$data['endDate'].'</td></tr>';
                        $lastUser = $data['updatedBy'];
                    }
                    echo '</tbody></table>';
                }
                ?></div>
            </div> 
           <button class="accordion" style="margin-top:20px;">Publications</button>
           <div class="panel" > <div style="overflow-y: auto;max-height: 500px;width: 100%;">
             <?php
                $sql = "SELECT A.*,B.employeeName as updatedBy FROM publications_history A JOIN employee B ON A.updatedBy = B.employeeCode "
                        . " ORDER BY A.updatedBy,A.updatedOn DESC";
                $result = mysqli_query($conn,$sql);
                $lastUser='';
                if(mysqli_num_rows($result)>0) {
                    echo '<table ><thead><tr><th>Action</th><th>Action Time</th><th>Authors</th><th>Journal</th> '
                    . '</tr></thead><tbody>';
                    while($data = mysqli_fetch_array($result)) {
                        if($lastUser != $data['updatedBy']) 
                            echo '<tr><td colspan="4" class="mainPjct">'.$data['updatedBy'].'</td></tr>';
                        echo '<tr><td>' . $data['actionName'].'</td><td>'.$data['updatedOn'].
                                '</td><td>'.$data['authors'].'</td><td>'.$data['journal'].'</td></tr>';
                        $lastUser = $data['updatedBy'];
                    }
                    echo '</tbody></table>';
                }
                ?></div>
            </div> 
           <button class="accordion" style="margin-top:20px;">Notice Board</button>
           <div class="panel"> <div style="overflow-y: auto;max-height: 500px;width: 100%;">
             <?php
                $sql = "SELECT A.*,B.employeeName as updatedBy FROM noticeboard_history A JOIN employee B ON A.updatedBy = B.employeeCode "
                        . " ORDER BY A.updatedBy,A.updatedOn DESC";
                $result = mysqli_query($conn,$sql);
                $lastUser='';
                if(mysqli_num_rows($result)>0) {
                    echo '<table ><thead><tr><th>Action</th><th>Action Time</th><th>Title</th><th>Description</th> '
                    . '</tr></thead><tbody>';
                    while($data = mysqli_fetch_array($result)) {
                        if($lastUser != $data['updatedBy']) 
                            echo '<tr><td colspan="4" class="mainPjct">'.$data['updatedBy'].'</td></tr>';
                        echo '<tr><td>' . $data['actionName'].'</td><td>'.$data['updatedOn'].
                                '</td><td>'.$data['title'].'</td><td>'.$data['keyword'].'</td></tr>';
                        $lastUser = $data['updatedBy'];
                    }
                    echo '</tbody></table>';
                }
                ?></div>
            </div> 
           <button class="accordion" style="margin-top:20px;">OM/Circular</button>
           <div class="panel"> <div style="overflow-y: auto;max-height: 500px;width: 100%;">
             <?php
                $sql = "SELECT A.*,B.employeeName as updatedBy FROM circulars_history A JOIN employee B ON A.updatedBy = B.employeeCode "
                        . " ORDER BY A.updatedBy,A.updatedOn DESC";
                $result = mysqli_query($conn,$sql);
                $lastUser='';
                if(mysqli_num_rows($result)>0) {
                    echo '<table ><thead><tr><th>Action</th><th>Action Time</th><th>Title</th><th>Description</th> '
                    . '</tr></thead><tbody>';
                    while($data = mysqli_fetch_array($result)) {
                        if($lastUser != $data['updatedBy']) 
                            echo '<tr><td colspan="4" class="mainPjct">'.$data['updatedBy'].'</td></tr>';
                        echo '<tr><td>' . $data['actionName'].'</td><td>'.$data['updatedOn'].
                                '</td><td>'.$data['title'].'</td><td>'.$data['description'].'</td></tr>';
                        $lastUser = $data['updatedBy'];
                    }
                    echo '</tbody></table>';
                }
                ?></div>
            </div> 
           <button class="accordion" style="margin-top:20px;">Agenda & Minutes</button>
           <div class="panel"> <div style="overflow-y: auto;max-height: 500px;width: 100%;">
             <?php
                $sql = "SELECT A.actionName,title,description,'FC' as committee,B.employeeName as updatedBy,A.updatedOn FROM `fcmeetings_history` A JOIN employee B ON "
                        . "A.updatedBy = B.employeeCode UNION select C.actionName,title,description,'GC' as committee,D.employeeName as updatedBy,C.updatedOn from gcmeetings_history C "
                        . "JOIN employee D ON C.updatedBy = D.employeeCode  UNION select E.actionName,title,description,'RAC' as committee,F.employeeName as updatedBy, E.updatedOn "
                        . "from racmeetings_history E JOIN employee F ON E.updatedBy = F.employeeCode ORDER BY updatedBy,updatedOn";
                $result = mysqli_query($conn,$sql);
                $lastUser='';
                if(mysqli_num_rows($result)>0) {
                    echo '<table ><thead><tr><th>Action</th><th>Action Time</th><th>Committee</th><th>Meeting Title</th> '
                    . '</tr></thead><tbody>';
                    while($data = mysqli_fetch_array($result)) {
                        if($lastUser != $data['updatedBy']) 
                            echo '<tr><td colspan="4" class="mainPjct">'.$data['updatedBy'].'</td></tr>';
                        echo '<tr><td>' . $data['actionName'].'</td><td>'.$data['updatedOn'].
                                '</td><td align="center">'.$data['committee'].'</td><td>'.$data['title'].'</td></tr>';
                        $lastUser = $data['updatedBy'];
                    }
                    echo '</tbody></table>';
                }
              ?>
               </div> </div>
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
                            alert(this.responseText) ;document.location='adminHome.php';
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
 <script>
        var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight){
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  });
}
        </script>
</html>