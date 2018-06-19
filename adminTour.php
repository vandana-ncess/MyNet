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

<link rel="stylesheet" href="css/jquery-ui-themes-1.12.1/themes/base/jquery-ui.css">
  <script src="js/jquery-1.12.4.js"></script>
  <script src="js/jquery-ui-1.12.1/jquery-ui.js"></script>
  <script> 
  $( function() {
    var currentDate = new Date();  
    
    var dateFormat = "dd/mm/yy",
      from = $( "#from" )
        .datepicker({
    showOn: "both",
      buttonImage: "images/calendar.ico",
      buttonImageOnly: true,
      buttonText: "Select date",
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 3
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#to" ).datepicker({
    showOn: "both",
      buttonImage: "images/calendar.ico",
      buttonImageOnly: true,
      buttonText: "Select date",
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 3
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      }
              );
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
 
  $("#from").datepicker("setDate",currentDate);
     $("#to").datepicker("setDate",currentDate); 
 } );
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
            <?php if(isset($_SESSION['user'])) { ?><p align="right" style="padding-right: 50px;color:#fff;"><b><?php        echo 'Welcome ' . $_SESSION['user']; ?></b>&nbsp; <a href="logout.php" style="color: #fff;">Logout</a></p>;<?php } ?>
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

                        <td> Employee</td><td /><td><span class="mandatory">* </span>From Date</td>
                          </tr>
                    <tr>
                        <td colspan="2" ><select id="ddlEmployee" name="ddlEmployee" style="width: 410px;"  ><option value="0"></option>

                            </select></td>
                        <td><input type="text" name="from" id='from'  style="width:110px;height: 18px;"   > 
                            </input></td>
                    </tr>
                    <tr>
                        <td colspan="2"><span class="mandatory" >* </span>Place</td>
                        <td><span class="mandatory">* </span>To Date</td>
                     </tr>
                    <tr >    
                        <td colspan="2"><input type="text" name="txtPlace" id="txtPlace" style="width: 400px;" /> </td>
                            <td>
                                <input type="text" name="to" id='to'   style="width:110px;height: 18px;"  />
                            </td>
                    </tr>
                <tr>
                    <td colspan="3">Purpose</td>
                </tr>
                <tr>
                    <td colspan="3"><textarea name="txtPurpose" id="txtPurpose" cols="70" ></textarea> </td>
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
            <i class="fa fa-table" style="box-sizing: border-box;"></i> Tour History</div>
        <div class="card-body" style="box-sizing: border-box;">
          <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="box-sizing: border-box;color: black;">
                  <thead style='background-color: blueviolet;height: 30px;'><tr><th>Employee</th><th>From</th><th>To</th><th>Place</th><th>Purpose</th><th /><th /></tr></thead><tbody>
                                <?php
                                    $sql = "SELECT tourID,employeeName,A.employeeCode,DATE_FORMAT(startDate,'%m/%d/%Y') as start, "
                                            . "DATE_FORMAT(endDate,'%m/%d/%Y') as end,place,remarks"
                                            . " FROM employee_tour A  JOIN employee C "
                                            . " ON C.employeeCode=A.employeeCode WHERE updatedBy=" . $_SESSION['loggedUserID'] . " ORDER BY DATE(startDate) DESC";
                                    $result = mysqli_query($conn,$sql);
                                    if(mysqli_num_rows($result) > 0)
                                    {                                               
                                        while ($row = mysqli_fetch_array($result)) {
                                            echo "<tr><td>".$row['employeeName']."</td><td>". $row['start'] .
                                                    "</td><td>".$row['end']."</td><td >".$row['place']."</td><td>".$row['remarks'].
                                                    "</td><td><img src='images/edit.png' onclick='edit(this)' style='cursor:pointer;' /><input type='hidden' id = 'txtTourID' value='".$row['tourID']."' /></td> "
                                                    . "<td><img src='images/erase.png' onclick='deleteTour(".$row['tourID'].")' style='cursor:pointer;' /></tr>";
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
                        $sql = "INSERT INTO employee_tour(employeeCode,startDate,endDate,place,remarks,updatedBy) VALUES(" .
                                 $_POST['ddlEmployee']. ",'" . date('Y-m-d',strtotime($_POST['from'])) . "','" . date('Y-m-d',strtotime($_POST['to'])) .
                                "','" . $_POST['txtPlace'] . "','" . $_POST['txtPurpose'] .
                                "'," . $_SESSION['loggedUserID'] . ")";
                        $result = mysqli_query($conn,$sql);
                        if($result){
                            echo '<script>alert("Saved successfully!");</script>';
                            echo '<script>document.location="adminTour.php";</script>';
                        }
                        else
                            echo 'Failed to save!';
                    }
                    else {
                        $sql = "UPDATE employee_tour SET employeeCode=" . $_POST['ddlEmployee'] . ", startDate ='" .
                             date('Y-m-d',strtotime($_POST['from'])) . "', endDate='" .  date('Y-m-d',strtotime($_POST['to'])). "',place='" . $_POST['txtPlace'].
                                "',remarks='" . $_POST['txtPurpose'] . "' WHERE tourID=" . $_POST['txtUpdateID'];
                        $result = mysqli_query($conn,$sql);
                        if($result){
                            echo '<script>alert("Updated successfully!");</script>';
                            echo '<script>document.location="adminTour.php";</script>';
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
           
            document.getElementById('from').value = e.parentElement.parentElement.cells[1].innerHTML;
            document.getElementById('to').value = e.parentElement.parentElement.cells[2].innerHTML;
            document.getElementById('txtPlace').value = e.parentElement.parentElement.cells[3].innerHTML;
            document.getElementById('txtPurpose').value = e.parentElement.parentElement.cells[4].innerHTML;
            document.getElementById('btnSave').value = "Update";
            document.getElementById('txtUpdateID').value = e.parentElement.children[1].value;
        }
        function deleteTour($id) {
            if(confirm("Do ypou want to delete this tour?")) {
              if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                    } else {
                        // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            alert(this.responseText) ;document.location='adminTour.php';
                        }
                    };
                    xmlhttp.open("GET","delete.php?id="+$id+"&table=tour");
                    xmlhttp.send();
               
        }   
        }     
    </script>
    </body>
</html>