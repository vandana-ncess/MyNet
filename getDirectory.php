<?php
    $str = $_GET['str'];
    $type = $_GET['type'];
    $conn = require_once('databaseconnection.php');
    $sql = "SELECT * FROM employee A JOIN designation B ON A.designationID=B.designationID WHERE employeeStatus=1" . $str . " ORDER BY A.categoryID,level";
    $result = mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)>0) {
        if($type == 'all') {
            echo '<table id="tblDirectory" style="overflow-x:   scroll;overflow-y: auto;"><tr><td bgcolor="#4E49D4" height="25px;" width="210px" style="color: white;"><strong>Name</strong></td><td bgcolor="#4E49D4" height="25px;"  width="210px" style="color: white;"><strong>Email ID</strong></td> '
        .   '<td bgcolor="#4E49D4" height="25px;"  width="100px" style="color: white;"><strong>Mobile No</strong></td><td bgcolor="#4E49D4" height="25px;" style="color: white;"><strong>Extension</strong></td></tr>';
            while($row=mysqli_fetch_array($result)) {
                echo '<tr><td>'. $row['employeeName'] . '</td><td>' . $row['emailID'] . '</td><td>' . $row['mobileNo'] .'</td><td>'. $row['extension'].'</td></tr>';
            }
        }
        elseif($type == 'email') {
            $i=0;
            echo '<table id="tblDirectory" style="overflow-x:   scroll;overflow-y: auto;"><tr><td bgcolor="#4E49D4" height="25px;" width="210px" style="color: white;"><input type="checkbox" name="chkAll" id="chkAll" onchange="checkAll()" /><strong>&nbsp;Select</strong></td><td bgcolor="#4E49D4" height="25px;"  width="210px" style="color: white;"><strong>Name</strong></td> '
        .   '<td bgcolor="#4E49D4" height="25px;"  width="250px" style="color: white;"><strong>Email ID</strong></td></tr>';
            while($row=mysqli_fetch_array($result)) {
                echo '<tr><td><input type="checkbox" name="chkSelect[]" id="chkAll'.$i.'" /></td><td>'. $row['employeeName'] . '</td><td>' . $row['emailID'] . '</td></tr>';
                $i++;
            } 
        }
    }
    echo '</table>';
?>