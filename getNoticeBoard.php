<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="windows-1252">
        <title></title>
    </head>
    <body>
        <?php
            $conn = require_once('databaseconnection.php');
            $sql= "SELECT * from noticeboard WHERE status=1";
            $result = mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)>0) {
                echo '<table id="tblCircular" class="tbl"><thead><tr><th>Title</th><th>Delete</th></tr></thead>';
                while($row = mysqli_fetch_array($result)) {
                    echo '<tr><td>'. $row['title'].'</td><td><img src="images/erase.png" onclick="deleteNoticeBoard('.$row['id']. ')" style="cursor:pointer;" /></td></tr>';
                }
                echo '</table>';
            }
        ?>
    </body>
</html>
