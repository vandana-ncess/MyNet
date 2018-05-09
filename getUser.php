<?php
    $str = $_GET['str'];
    $menuID = $_GET['menuID'];
    $conn = require_once('databaseconnection.php');
    $sql = "SELECT employeeCode,employeeName FROM employee A JOIN designation B ON A.designationID=B.designationID where employeeCode NOT IN(SELECT users FROM adminmenu_privileges WHERE menuID=" . $menuID . ")".$str."  ORDER BY A.categoryID,level";
    $result = mysqli_query($conn,$sql);
    $i=1;
    if(mysqli_num_rows($result)>0) {
         echo '<table id="tblEmp" style="overflow-x:   scroll;overflow-y: auto;"><tr><td bgcolor="#4E49D4" height="25px;" style="color: white;width:60px;"><input type="checkbox" name="chkAll" id="chkAll" onchange="checkAll()" /><strong>&nbsp;Select</strong></td><td bgcolor="#4E49D4" height="25px;"  width="100px" style="color: white;"><strong>Emp Code</strong></td> '
        .   '<td bgcolor="#4E49D4" height="25px;"  width="350px" style="color: white;"><strong>Name</strong></td></tr>';
            while($row=mysqli_fetch_array($result)) {
                echo '<tr><td align="center"><input type="checkbox" name="chkSelect[]" id="chkAll'.$i.'" /><input type="hidden" name="txtSelect[]" id="txtSelect'.$i.'" /></td><td  align="center">'. $row['employeeCode'] . '<input type="hidden" name="txtEmpCode[]" value="'. $row['employeeCode'] .'"/></td><td>' . $row['employeeName'] . '</td></tr>';
                $i++;
            } 
            echo '</table>';
        }
?>