<?php
session_start();
                $conn = require_once('databaseconnection.php');
                $sql = "SELECT * FROM rac_privileges where userName='" . $_SESSION['user'] . "'";
                $result = mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)>0){
                    echo '<script>document.location="agenda.php";</script>';
                }
 else {
     echo "'You are not authorised to view this folder, Kindly contact the System Administrator!'";
 }
            ?>