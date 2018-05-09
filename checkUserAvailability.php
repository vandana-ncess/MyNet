<?php
    $user = $_GET['user'];
    $conn = require_once('databaseconnection.php');
    $sql = "SELECT * FROM ncess_users where userName='" . $user . "'";
    $result = mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)>0){
        echo '<span style="color:red;">Username Not Available!</span>';
    }
    else {
        echo '';
    }
?>