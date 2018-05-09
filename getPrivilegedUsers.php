<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>

<?php
	$menuID = $_GET['menuID'];
	$con = require_once('databaseconnection.php');
	if (!$con) {
    	die('Could not connect: ' . mysqli_error($con));
	}
	 $sql="SELECT employeeCode,employeeName FROM employee where employeeCode IN(SELECT users FROM adminmenu_privileges WHERE menuID=" . $menuID . ")";
         $result = mysqli_query($con,$sql);
	 if(mysqli_num_rows($result)>0) {
             echo '<table id="tblUsers" width="100%"><thead><tr bgcolor="#424066" height="30px" style="color:white;"><th>Emp Code</th><th style="float:left;padding-top:5px;padding-left:5px;">Employee Name</th><th /></tr></thead><tbody>';
             while($row= mysqli_fetch_array($result)) {
                 echo '<tr><td width="100px" align="center">' . $row['employeeCode'] . '</td><td width="300px" style="padding-left:5px;">' . $row['employeeName']. '</td><td align="center"><img src="images/erase.png" onclick="delete()" style="cursor:pointer;" /></td></tr>'; 
             }
             echo '</tbody></table>';
         }
  
	mysqli_close($con);
?>
<script type="text/javascript">

</script>
</body>
</html>
         