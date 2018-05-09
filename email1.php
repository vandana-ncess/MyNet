<?php
error_reporting(E_ALL);
session_start();   
$conn = require_once('databaseconnection.php');
include_once('fpdf.php');
$col = array('Emp Code','Name','Designation','Email ID'); 
            $smallTable = array(30,80,60,100);
    $pdf = new FPDF( );
    $pdf->AddPage('L');
    $pdf->SetFont('Times','B',14);
    $pdf->SetTextColor(51,51,255);
    $pdf->MultiCell(0,5,'NATIONAL CENTRE FOR EARTH SCIENCE STUDIES',0,'C');
    $pdf->SetFont('Times','',12);
    $pdf->MultiCell(0,5,'Ulloor - Akkulam road, Akkulam, Thiruvananthapuram, Kerala 695011',0,'C');

    $pdf->SetFont('Times','B',14);
    $pdf->MultiCell(0,7,'Email Address Book',0,'C');
    
    $pdf->Line(10,40,280,40);
    $pdf->Ln(); $pdf->Ln();$pdf->Ln();
     $pdf->MultiCell(0,7,'Scientists',0,'L');
     $sql = "SELECT employeeCode,employeeName,designation,emailID FROM employee A JOIN designation B ON A.designationID = B.designationID WHERE A.categoryID=1 ORDER BY level,joining_date";
    $result = mysqli_query($conn,$sql);
    $pdf->SetFont('times','',12);
    $pdf->Ln();
    $pdf->FancyTable($col,$result,$smallTable);
    
    
    $pdf->SetFont('Times','B',14);
    $pdf->SetTextColor(51,51,255);
     $pdf->MultiCell(0,7,'Scientific Support Staffs',0,'L');
     $sql = "SELECT employeeCode,employeeName,designation,emailID FROM employee A JOIN designation B ON A.designationID = B.designationID WHERE A.categoryID=3 ORDER BY level,joining_date";
    $result = mysqli_query($conn,$sql);
    $pdf->SetFont('times','',12);
    $pdf->Ln();
    $pdf->FancyTable($col,$result,$smallTable);
    $pdf->Ln();
    
    $pdf->SetFont('Times','B',14);
    $pdf->SetTextColor(51,51,255);
     $pdf->MultiCell(0,7,'Technical Support Staffs',0,'L');
     $sql = "SELECT employeeCode,employeeName,designation,emailID FROM employee A JOIN designation B ON A.designationID = B.designationID WHERE A.categoryID=4 ORDER BY level,joining_date";
    $result = mysqli_query($conn,$sql);
    $pdf->SetFont('times','',12);
    $pdf->Ln();
    $pdf->FancyTable($col,$result,$smallTable);
    $pdf->Ln();
    
    $pdf->SetFont('Times','B',14);
    $pdf->SetTextColor(51,51,255);
     $pdf->MultiCell(0,7,'Administrative Staffs',0,'L');
     $sql = "SELECT employeeCode,employeeName,designation,emailID FROM employee A JOIN designation B ON A.designationID = B.designationID WHERE A.categoryID=5 ORDER BY level,joining_date";
    $result = mysqli_query($conn,$sql);
    $pdf->SetFont('times','',12);
    $pdf->Ln();
    $pdf->FancyTable($col,$result,$smallTable);
    $pdf->Ln();
    
    $pdf->SetFont('Times','B',14);
    $pdf->SetTextColor(51,51,255);
     $pdf->MultiCell(0,7,'Senior Consultants',0,'L');
     $sql = "SELECT employeeCode,employeeName,designation,emailID FROM employee A JOIN designation B ON A.designationID = B.designationID WHERE A.categoryID=6  ORDER BY  divisionID,joining_date";
    $result = mysqli_query($conn,$sql);
    $pdf->SetFont('times','',12);
    $pdf->Ln();
     $smallTable = array(30,60,80,100);
    $pdf->FancyTable($col,$result,$smallTable);
    $pdf->Ln();
    
    $pdf->SetFont('Times','B',14);
    $pdf->SetTextColor(51,51,255);
     $smallTable = array(30,80,60,100);
     $pdf->MultiCell(0,7,'Contractual/Project Staffs',0,'L');
     $sql = "SELECT employeeCode,employeeName,designation,emailID FROM employee A JOIN designation B ON A.designationID = B.designationID WHERE A.categoryID=7  ORDER BY level,joining_date";
    $result = mysqli_query($conn,$sql);
    $pdf->SetFont('times','',12);
    $pdf->Ln();
    $pdf->FancyTable($col,$result,$smallTable);
    $pdf->Ln();
    
    $pdf->Output();

?>  