<?php 
    $str = $_GET['str'];
    $conn  = require_once('databaseconnection.php');
    $sql = "SELECT employeeCode,employeeName FROM employee WHERE employeeStatus=1 " . $str . " ORDER BY employeeName"; 
    $result = mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)>0) {
        echo '<select id="ddlEmployee" name="ddlEmployee" ><option value="-1"></option>';
        while($data = mysqli_fetch_array($result)){
            echo '<option value=' . $data['employeeCode'] . '>' . $data['employeeName'] . '</option>' ;
        }
        echo '</select>';
    }
?>