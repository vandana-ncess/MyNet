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

 <link rel="shortcut icon" href="images/logo1.png" type="image/x-icon"/>
<link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet" />

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
    
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
            }
        };
        xmlhttp.open("GET","getEmployee.php?str="+$str);
        xmlhttp.send();
      }
   </script>
<!--////// END  \\\\\\\-->
</head>
    <body onload="loadDesignation()">

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
            </div> 
          
        </div> <!-- end of sidebar -->
        
        <div id="templatemo_content">
            <form method="post" action="">
            <table  class="tab" style="padding-left: 10px;">
                    <tr>
                        <td >Division</td> <td>Category</td><td  >Designation</td>
                    </tr>
                <tr>
                        <td ><input type="hidden" name="txtDiv" id='txtDiv' /><select id="ddlDivision" name="ddlDivision" onchange="loadEmployee()" style="width: 200px;">
                                <option value="-1">All</option>
                            <?php
                                $sql = "SELECT divisionID,divisionName FROM division WHERE divisionStatus=1  AND divisionName<>''";
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
                    
                       <td  width="200px"><select id="ddlCategory" name="ddlCategory" onchange="loadDesignation()" style="width: 200px;" ><option value="0">All</option>
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
                        <td ><select id="ddlDesignation" name="ddlDesignation" onchange="loadEmployee()" style="width: 200px;">

                            </select>
                        </td>

                    </tr>
                    <tr>

                        <td> Employee</td><td /><td>Leave Type</td>
                          </tr>
                    <tr>
                        <td colspan="2" ><select id="ddlEmployee" name="ddlEmployee" style="width: 400px;"  ><option value="0"></option>

                            </select></td>
                        <td><select name="ddlLeave" id="ddlLeave" style="width: 200px;" onchange="setDuration()">
                             <?php
                                    $sql = "SELECT leaveTypeID,leaveType FROM leave_type WHERE status=1";
                                    $result = mysqli_query($conn,$sql);
                                    if(mysqli_num_rows($result) > 0)
                                    {
                                        while ($row = mysqli_fetch_array($result)) {
                                            echo "<option value=" . $row['leaveTypeID'] . ">" . $row['leaveType'] . "</option>";
                                        }
                                    }
                                ?>
                            </select> </td>
                    </tr>
                    <tr>
                        <td colspan="2"><span class="mandatory">* </span>From Date<span class="mandatory" style="padding-left: 70px;">* </span>To Date<span  style="padding-left:80px;"> <span class="mandatory">* </span>Duration(Days)</span></td><td>Status</td>
                     </tr>
                    <tr >    
                        <td colspan="2"><div class="control-group"><div class="controls input-append date fromDate" data-date="1979-09-16T05:25:07Z" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
                    <input size="16" type="text" value="" readonly>
                    <span class="add-on"><i class="icon-remove"></i></span>
					<span class="add-on"><i class="icon-th"></i></span>
                                </div></div>
                            </td>
                    </tr>
                    <tr >
                        <td colspan="3" align="right">
                            <input type="submit" name="btnSave" id="btnSave" value="Save" style="width:100px; border-radius: 12px;" />
                            <input type="hidden" name="txtUpdateID" id="txtUpdateID"  />
                        </td> 
                    </tr>
                
                    <tr >
                        <td colspan="3">
                            <div class="content_box" style="padding-bottom: 0px;padding-left: 2px;width: 100%;">
                <div class="card mb-3" style="box-sizing: border-box;">
        <div class="card-header" style="box-sizing: border-box;background-color: blueviolet;color: #fff;font-size: 14;">
            <i class="fa fa-table" style="box-sizing: border-box;"></i> Leave History</div>
        <div class="card-body" style="box-sizing: border-box;">
          <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="box-sizing: border-box;color: black;">
                  <thead style='background-color: blueviolet;'><tr><th>Employee</th><th>Leave Type</th><th>From</th><th>To</th><th>Duration</th><th>Status</th><th /><th /></tr></thead><tbody>
                                <?php
                                    $sql = "SELECT leaveID,employeeName,A.employeeCode,shortname,DATE_FORMAT(startDate,'%m/%d/%Y') as start, "
                                            . "DATE_FORMAT(endDate,'%m/%d/%Y') as end,A.leaveTypeID,duration,leaveStatus"
                                            . " FROM employee_leave A JOIN leave_type B ON A.leaveTypeID=B.leaveTypeID JOIN employee C "
                                            . " ON C.employeeCode=A.employeeCode WHERE updatedBy=" . $_SESSION['loggedUserID'] . " ORDER BY DATE(startDate) DESC";
                                    $result = mysqli_query($conn,$sql);
                                    if(mysqli_num_rows($result) > 0)
                                    {                                               
                                        while ($row = mysqli_fetch_array($result)) {
                                            echo "<tr><td>".$row['employeeName']."</td><td>".$row['shortname']."<input type='hidden' id = 'txtLeave' value='".$row['leaveTypeID'].
                                                "' /></td><td>". $row['start'] .
                                                    "</td><td>".$row['end']."</td><td align='center'>".$row['duration']."</td><td>".$row['leaveStatus'].
                                                    "</td><td><img src='images/edit.png' onclick='edit(this)' style='cursor:pointer;' /><input type='hidden' id = 'txtLeaveID' value='".$row['leaveID']."' /></td> "
                                                    . "<td><img src='images/erase.png' onclick='deleteLeave(".$row['leaveID'].")' style='cursor:pointer;' /></td></tr>";
                                        }
                                    }
                                ?> 
              </tbody></table></div></div></div></div>     
                        </td>
                    </tr>
            </table>
               
            </form>
              
        </div>
        
        <div class="cleaner"></div>    
    </div>
    
    <div id="templatemo_main_bottom" >
    </div>

</div> <!-- end of wrapper -->
</div>
   <?php
            if(isset($_POST['btnSave'])) {
                    if($_POST['btnSave'] == 'Save') {
                        $sql = "INSERT INTO employee_leave(leaveTypeID,employeeCode,startDate,endDate,duration,leaveStatus,updatedBy) VALUES(" . $_POST['ddlLeave'] . 
                                "," . $_POST['ddlEmployee']. ",'" . date('Y-m-d',strtotime($_POST['from'])) . "','" . date('Y-m-d',strtotime($_POST['to'])) . "'," . $_POST['txtDuration'] . ",'" . $_POST['ddlStatus'] .
                                "'," . $_SESSION['loggedUserID'] . ")";
                        $result = mysqli_query($conn,$sql);
                        if($result){
                            echo '<script>alert("Saved successfully!");</script>';
                            echo '<script>document.location="adminLeave.php";</script>';
                        }
                        else
                            echo 'Failed to save!';
                    }
                    else {
                        $sql = "UPDATE employee_leave SET leaveTypeID = " . $_POST['ddlLeave'] . ", employeeCode=" . $_POST['ddlEmployee'] . ", startDate ='" .
                             date('Y-m-d',strtotime($_POST['from'])) . "', endDate='" .  date('Y-m-d',strtotime($_POST['to'])). "',duration=" . $_POST['txtDuration'].
                                ",leaveStatus='" . $_POST['ddlStatus'] . "' WHERE leaveID=" . $_POST['txtUpdateID'];
                        $result = mysqli_query($conn,$sql);
                        if($result){
                            echo '<script>alert("Updated successfully!");</script>';
                            echo '<script>document.location="adminLeave.php";</script>';
                        }
                        else
                            echo 'Failed to update!';
                    }
            }
                ?>  
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="js/sb-admin-datatables.min.js"></script>
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet" />
<div id="templatemo_footer_wrapper">
	<div id="templatemo_footer">
       Copyright © 2018 <a href="#">NCESS</a> | Contact Us : adm@ncess.gov.in | Ext : 1669 
        
    </div>
</div>
    <script type="text/javascript">
        function edit(e) {
            var emp = document.getElementById('ddlEmployee');
            for (var i = 0; i < emp.options.length; i++) {
                if (emp.options[i].text === e.parentElement.parentElement.cells[0].innerHTML) {
                    emp.selectedIndex = i;
                    break;
                }
            }
            document.getElementById('ddlLeave').value = e.parentElement.parentElement.cells[1].children[0].value;
            
            var status = document.getElementById('ddlStatus');
            for (var i = 0; i < status.options.length; i++) {
                if (status.options[i].text === e.parentElement.parentElement.cells[5].innerHTML) {
                    status.selectedIndex = i;
                    break;
                }
            }
            document.getElementById('from').value = e.parentElement.parentElement.cells[2].innerHTML;
            document.getElementById('to').value = e.parentElement.parentElement.cells[3].innerHTML;
            document.getElementById('txtDuration').value = e.parentElement.parentElement.cells[4].innerHTML;
            document.getElementById('btnSave').value = "Update";
            document.getElementById('txtUpdateID').value = e.parentElement.children[1].value;
        }
        function setDuration() {
            if(document.getElementById('ddlLeave').value == 9)
                document.getElementById('txtDuration').value=0.5;
            else
                document.getElementById('txtDuration').value='';
        }
        function deleteLeave($id) {
            if(confirm("Do ypou want to delete this leave?")) {
              if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                    } else {
                        // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            alert(this.responseText) ;document.location='adminLeave.php';
                        }
                    };
                    xmlhttp.open("GET","delete.php?id="+$id+"&table=leave");
                    xmlhttp.send();
               
        }   
        }   
    </script>
    <script type="text/javascript" src="jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript">
    $('.fromDate').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });

</script>

    </body>
</html>