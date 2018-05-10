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
	 $sql="SELECT employeeCode,employeeName,privilegeID FROM employee A JOIN adminmenu_privileges B ON A.employeeCode=B.users WHERE menuID=" . $menuID;
         $result = mysqli_query($con,$sql);
	 if(mysqli_num_rows($result)>0) {
             echo '<table id="tblUsers" width="100%"><thead><tr bgcolor="#424066" height="30px" style="color:white;"><th>Emp Code</th><th style="float:left;padding-top:5px;padding-left:5px;">Employee Name</th><th /></tr></thead><tbody>';
            $i=1;
             while($row= mysqli_fetch_array($result)) {
                 echo '<tr><td width="100px" align="center">' . $row['employeeCode'] . ' </td><td width="300px" style="padding-left:5px;">' . $row['employeeName']. '</td><td align="center"><img src="images/erase.png" '
                         . 'onclick="deletePrivileges(this)" style="cursor:pointer;" /><input type="hidden" name="txtID" id="txtID'.$i.'" value="'.$row['privilegeID'].'" /></td></tr>'; 
             
                 $i++;
             }
             echo '</tbody></table>';
         }
  
	mysqli_close($con);
?>
<script type="text/javascript">

</script>
</body>
</html>
         