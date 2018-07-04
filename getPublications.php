<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<?php 
    $str = iconv('utf-8', 'ascii//TRANSLIT',$_GET['str']);
    if($str == '')
        $str = " WHERE  approvalStatus='Approved'";
    else 
        $str = $str . " AND approvalStatus='Approved'"; 
    $st = str_replace('A.','',$str);
    $conn  = require_once('databaseconnection.php');
    $sql = "SELECT * FROM `research_publications` A JOIN (SELECT count(*) as total,year from research_publications ".$st ." GROUP by year ) as B ON A.year=B.year "
            . $str ." ORDER BY A.year desc,publicationsID desc" ;
    $result = mysqli_query($conn,$sql);
    $no = mysqli_num_rows($result);
    if($no>0) {
        $yr =1;
        while($data = mysqli_fetch_array($result)){
  
            if($yr != $data['year'])
                echo '<span style="color:red;font-weight:bold;">Year : ' . $data['year'] . "; " . $data['total'] . ' Publication(s) </span>';
            
            echo '<div class="content_box" style="padding-bottom:  10px;color:black;">';
            echo $data['authors'] . ','  . $data['year'] .' : '. $data['journal']. '</div>' ;          
            $yr = $data['year'];
        }
    }
?>
</html>