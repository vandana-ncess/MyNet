<?php
    $conn = require_once('databaseconnection.php');
    $sql = "SELECT employeeCode,employeeName,designation,divisionName,dateOfBirth,joining_date,retirement_date,emailID,mobileNo,extension,residenceAddress,residenceContact,bloodgrp "
                    . "FROM employee emp JOIN designation E ON emp.designationID = E.designationID JOIN division D ON emp.divisionID=D.divisionID AND employeeStatus=1  ORDER BY emp.categoryID,level,emp.divisionID,joining_date " ;
            $result = mysqli_query($conn,$sql);    
            $columnHeader = ''; 
            $columnHeader = "Employee Code" . "\t" . "Name" . "\t" . "Designation" . "\t" . "Division". "\t" . "Date of Birth". "\t". "Date of Join". "\t" . "Retirement Date". "\t". "Email ID". "\t". "Mobile No". "\t". "Extension". "\t". "Residence Address". "\t" . "Residence ContactNo". "\t" . "Blood Group"; 
            $setData = ''; 
            while ($rec = mysqli_fetch_row($result  )) { 
                $rowData = ''; 
                foreach ($rec as $value) { 
                    $value = '"' . $value . '"' . "\t"; 
                    $rowData .= $value; 
                } 
                $setData .= trim($rowData) . "\n"; 
            } 
            header("Content-type: application/octet-stream"); 
            header("Content-Disposition: attachment; filename=User_Detail.xls"); 
            header("Pragma: no-cache"); 
            header("Expires: 0"); 
            echo ucwords($columnHeader) . "\n" . $setData . "\n";       
?>