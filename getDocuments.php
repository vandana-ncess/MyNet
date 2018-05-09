<?php
    $type = $_GET['type'];
    $str = $_GET['str'];
    $str = str_replace(' ','%',$str);
    $conn = require_once('databaseconnection.php');
    $table = "";
    switch ($type)
    {
        case 'rac':
            $table = 'rac_meetings';
            break;
        case 'fc':
            $table = 'fc_meetings';
            break;
        case 'gc':
            $table = 'gc_meetings';
            break;
    }
    $sql = "SELECT * FROM " . $table . " where  CONCAT_WS(' ',title,description,year) LIKE '%" . $str . "%'"  ;
    $result = mysqli_query($conn,$sql);
    $i=1;
    if(mysqli_num_rows($result)>0) {
        echo '<table id="tblDocument"><tr>';
        while($row=mysqli_fetch_array($result)) {
            echo '<td  style="padding-right:20px;"><a href="' . $type . 'documents.php?' . $type. 'Name=' . $row['title'] . '" target="_parent" ><h5>' . $row['title']  .'</h5><img class="image_wrapper image_fl" src="images/racfolder.ico" alt="Image 1" /></a></td>';
            if(($i%5)==0)
                echo '</tr><tr>';
            $i++;
        }
    }
    echo '</tr></table>';
?>