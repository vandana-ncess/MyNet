<?php
//load the database configuration file
$conn = require_once('databaseconnection.php');
$mode = $_GET['mode'];

if(isset($_POST['importSubmit'])){
    
    //validate whether uploaded file is a csv file
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$csvMimes)){
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            
            //open uploaded csv file with read only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            
            //skip first line
            fgetcsv($csvFile);
            if($mode == 'Update') {
            //parse data from csv file line by line
                while(($line = fgetcsv($csvFile)) !== FALSE){
                //check whether member already exists in database with same email
                    $sql = "UPDATE employee_attendance SET employeeID = ".$line[0].", intime = '".$line[3]."', outtime = '".$line[4]."', status = '".$line[2]."', open_closed_status = '".$line[5]."', date = '".$line[1]."' WHERE date = '".$line[1]."' AND employeeID=" . $line[0];
                    $result = mysqli_query($conn,$sql);
                    
                }
            }
            else {
                  $sql = "INSERT INTO employee_attendance (employeeID, date, status, intime, outtime) VALUES (".$line[0].",'".$line[1]."','".$line[4]."','".$line[2]."','".$line[3]."')";
                  $result = mysqli_query($conn,$sql);
            }
            //close opened csv file
            fclose($csvFile);

            $qstring = '?status='. mysqli_error($result);
        }else{
            $qstring = '?status=err';
        }
    }else{
        $qstring = '?status=invalid_file';
    }
}

//redirect to the listing page
header("Location: importAttendance.php".$qstring);
?>