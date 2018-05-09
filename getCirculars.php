<?php
    $type = $_GET['type'];
    $str = $_GET['str'];
    $str = str_replace(' ','%',$str);
    $conn = require_once('databaseconnection.php');
    $table = "";
    switch ($type)
    {
        case 'circular':
            $table = 'circulars';
            break;
        case 'court':
            $table = 'court_orders';
            break;
        case 'rti':
            $table = 'rti';
            break;
    }
    $sql = "SELECT * FROM " . $table . " where  CONCAT_WS(' ',title,description,year) LIKE '%" . $str . "%'"  ;
    $result = mysqli_query($conn,$sql);
    $i=1;
    if(mysqli_num_rows($result)>0) {
        echo '<table id="tblDocument"><tr>';
        while($row=mysqli_fetch_array($result)) {
            echo '<td  style="padding-right:20px;"><a href="documents/circulars/' . $row['fileName'] . '" target="_blank" ><h5>' . $row['title'] .'</h5><img class="image_wrapper image_fl" src="images/file.ico" alt="Image 1" /></a></td>';
            if(($i%5)==0)
                echo '</tr><tr>';
            $i++;
        }
    }
    echo '</tr></table>';
?>