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
   if(isset($_GET['id'])) {
     $id=$_GET['id'];
     $sql = "SELECT * FROM projects WHERE projectID = " . $id . " AND status=1 ORDER BY divisionID";
     $editResult = mysqli_query($conn,$sql);
     if(mysqli_num_rows($editResult)>0)
         $editData = mysqli_fetch_array($editResult);
   }
   else $id= 0;
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
    <div id="templatemo_main"><span id="main_top"  style="height: 164px;"></span><span id="main_bottom" style="height: 164px;"></span>
        <div id="templatemo_sidebar">
            <div id="templatemo_menu" style="height:auto;">
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
          
        </div> <!-- end of sidebar -->
        
        <div id="templatemo_content" style="height: 295px;">
            <form method="post" >
            <table>
                <tr>
                    <td>Project Type</td>
                    <td>
                        <select name="ddlType"  style="width:200px;">
                            <option value="plan"> Plan Projects</option>
                            <option value="external">Extenal Funded Projects</option>
                        </select>
                    </td>
                    <td style="padding-left: 10px;">Project Area</td><td>
                        <select name="ddlArea"  style="width:220px;" >
                            <?php
                            if($id > 0) $mainID = $editData['mainPjctID']; else $mainID=0;
                                $sql = "SELECT * FROM main_projects WHERE status=1";
                                $result = mysqli_query($conn,$sql);
                                $selected="";
                                if(mysqli_num_rows($result)>0){
                                    while($data = mysqli_fetch_array($result)) {
                                        if($mainID == $data['mainPjctID'])
                                            $selected = "selected";
                                        echo '<option value="'.$data['mainPjctID'].'" '.$selected.'>' . $data['title'].'</option>'; 
                                                                                $selected = "";

                                    }
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Research Group</td><td>
                        <select name="ddlGrp"  style="width:200px;" >
                            <?php
                            if($id > 0) $mainID = $editData['divisionID']; else $mainID=0;
                                $sql = "SELECT * FROM division WHERE divisionStatus=1 AND divisionName<> ''";
                                $result = mysqli_query($conn,$sql);
                                if(mysqli_num_rows($result)>0){
                                    while($data = mysqli_fetch_array($result)) {
                                         if($mainID == $data['divisionID'])
                                            $selected = "selected";
                                        echo '<option value="'.$data['divisionID'].'" '.$selected.'>' . $data['divisionName'].'</option>'; 
                                    }
                                }
                            ?>
                        </select>
                    </td>
                    <td style="padding-left: 10px;">Project Leader</td><td ><select name="ddlPjctLeader"  style="width:220px;" >
                            <?php
                                if($id > 0) {$mainID = $editData['projectLeader']; $tit = $editData['projectTitle']; }else $mainID=0;
                                $sql = "SELECT employeeCode,employeeName FROM employee WHERE employeeStatus=1 AND categoryID=1 ORDER BY employeeName";
                                $result = mysqli_query($conn,$sql);
                                if(mysqli_num_rows($result)>0){
                                    while($data = mysqli_fetch_array($result)) {
                                        if($mainID == $data['employeeCode'])
                                            $selected = "selected";
                                        echo '<option value="'.$data['employeeCode'].'" '.$selected.'>' . $data['employeeName'].'</option>'; 
                                    }
                                }
                            ?>
                        </select></td>
                </tr>
                <tr>
                    <td>Project Title</td><td colspan="3"><input type="text" name="txtTitle" id="txtTitle" style="width:520px;" <?php if($id > 0) echo ' value="' . $tit .'"'; ?> required /></td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top: 20px;">
                        <h4>Add Investigators</h4>
                    </td>
                </tr>
                <tr>
                    <td >Division</td><td style="padding-left: 10px;"><select id="ddlDivision" name="ddlDivision" onchange="loadEmployee()" style="width: 200px;">
                                <option value="-1">All</option>
                            <?php
                                $sql = "SELECT divisionID,divisionName FROM division WHERE divisionStatus=1 AND divisionName<> ''";
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
                    <td style="padding-left: 10px;">Category</td><td style="padding-left: 10px;" ><select id="ddlCategory" name="ddlCategory" onchange="loadDesignation()" style="width: 200px;" ><option value="0">All</option>
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
                     <td  >Designation</td><td style="padding-left: 10px;"><select id="ddlDesignation" name="ddlDesignation" onchange="loadEmployee()" style="width: 200px;">

                            </select>
                        </td>
                      <td style="padding-left: 10px;"> Employee</td><td style="padding-left: 10px;" ><input type="hidden" name="txtEmp" id='txtEmp' /><select id="ddlEmployee" name="ddlEmployee" style="width: 200px;"  >

                            </select></td>
                </tr>
                <tr>
                    <td colspan="4" align="right"><input type="button" name="btnAdd" value="Add" onclick="AddInvestigators()" /></td>
                </tr>
                <tr>
                    <td colspan="4"><table id="tblInvestigators" >
                        <?php 
                            if($id > 0){
                                $subSql = "SELECT * FROM project_investigators A JOIN employee B ON A.investigatorID=B.employeeCode WHERE projectID=" . $editData['projectID'];
                                $res = mysqli_query($conn,$subSql);
                                if(mysqli_num_rows($res) > 0) {
                                    echo '<tr style="background-color:green;color:black;"><td>Investigators</td><td>Delete</td></tr>';
                                    while($invest = mysqli_fetch_array($res)) {
                                        echo "<tr><td><input type='hidden' name='txtInvID' value='". $invest['pjctInvID']."' />" . $invest['employeeName'] . '</td><td><img src="images/erase.png"  onclick="deleteInvestigator('.$data['projInvID'].')" style="cursor:pointer;"></td></tr>';
                                    }
                                }
                           
                            }
                        ?>
                    </table> </td>
                </tr>
                <tr>
                    <td colspan="4" align="right"><input type="submit" name="btnSave" value="Save" /></td>
                </tr>
            </table>
            </form>
         <?php
            if(isset($_POST['btnSave'])) {
                $sql = "INSERT INTO projects(mainPjctID,projectTitle,projectType,projectLeader,divisionID,status) VALUES(".$_POST['ddlArea'] .",'" . $_POST['txtTitle'] . "','" .
                        $_POST['ddlType'] . "','" . $_POST['ddlPjctLeader'] . "'," . $_POST['ddlGrp'] . ",1)";
                $result = mysqli_query($conn,$sql);
                if($result) {
                    $id = mysqli_insert_id($conn);
                    $invID = $_POST['txtID'];
                    for($i = 0; $i < sizeof($invID) ; $i++) {
                        $sql = "INSERT INTO project_investigators(projectID,investigatorID) VALUES(" . $id . "," . $invID[$i] . ")";
                        $result = mysqli_query($conn,$sql);
                    }
                }
                if($result)
                    echo "Saved successfully!";
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
      
            function loadEmployee()
            {
                $catID = document.getElementById('ddlCategory').value;
                $desigID = document.getElementById('ddlDesignation').value;
                $divID = document.getElementById('ddlDivision').value;
                element = document.getElementById('ddlDivision');
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
            function AddInvestigators() {
                $tab = document.getElementById('tblInvestigators');
               
                if($tab.rows.length == 0) {
                    var row = $tab.insertRow(0);
                    row.style.backgroundColor = "green";
                    row.style.color = "white";
                    row.style.height = "25px";
                    var cell1 = row.insertCell(0);
                    var cell3 = row.insertCell(1);
                    cell1.innerHTML="Investigator";
                    cell3.innerHTML="Remove";
                }
                var row = $tab.insertRow($tab.rows.length);
                    var cell1 = row.insertCell(0);
                    var cell3 = row.insertCell(1); 
                    ddl = document.getElementById('ddlEmployee');
                     cell1.innerHTML=ddl.options[ddl.selectedIndex].text;
                    cell3.innerHTML="<img src='images/erase.png' onclick='deleteInvestigator(this)' /><input type='hidden' name='txtID[]' value='" + ddl.value + "' />";
            }
            
            function deleteInvestigator($id) {
                    
            }
           
     </script>
<div id="templatemo_footer_wrapper">
	<div id="templatemo_footer">
        Copyright © 2018 <a href="#">NCESS</a> | Contact Us : adm@ncess.gov.in | Ext : 1669 
        
    </div>
</div>

</html>