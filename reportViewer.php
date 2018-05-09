<?php
error_reporting(E_ALL);
 session_start();   
//Import the PhpJasperLibrary
include_once('databaseconnection.php');


include_once('fpdf.php');

$pdf = new FPDF( );
$pdf->AddPage();
//$pdf->Image('images/download.jpg',10,10,-100);
$pdf->SetFont('Times','B',14);
//$pdf->SetFillColor(255,153,51);
$pdf->SetTextColor(51,51,255);
//$pdf->SetFillColor(255,259,204);
$pdf->MultiCell(0,5,'NATIONAL CENTRE FOR EARTH SCIENCE STUDIES',0,'C');
$pdf->SetFont('Times','',11);
$pdf->MultiCell(0,5,'Ulloor - Akkulam road, Akkulam, Thiruvananthapuram, Kerala 695011',0,'C');

$pdf->SetFont('Times','B',14);
$pdf->MultiCell(0,7,'NCESS STAFF ATTENDANCE REPORT',0,'C');

$pdf->Line(10,40,200,40);
$conn=mysqli_connect("localhost","root","");
mysqli_select_db($conn,"ncess_intranet");
$sql = "SELECT A.date, A.intime,A.outtime,leaveType,place,CONCAT(F.outtime,'-', F.intime ) FROM employee_attendance A "
            . " JOIN employee B ON A.employeeID = B.employeeID LEFT JOIN employee_leave C ON B.employeeCode = C.employeeCode AND "
            . " A.date between C.startDate AND C.endDate LEFT JOIN employee_tour E ON B.employeeCode=E.employeeCode AND A.date between E.startDate "
            . " AND E.endDate LEFT JOIN gate_register F ON F.employeeCode = B.employeeCode AND a.date=f.date LEFT JOIN leave_type D ON "
            . "C.leaveTypeID = D.leaveTypeID WHERE A.employeeID=" . $_SESSION['empID'] . " AND A.date between '" . $_SESSION['fromDate'] . "' AND '" . $_SESSION['toDate'] ."'";
$result = mysqli_query($conn,$sql);
$smallTable = array(20,20,20,40,50,40);
$pdf->SetFont('times','',12);
$pdf->SetFillColor(200,220,255);
$pdf->Ln();

$pdf->Cell(0,5, "Employee ID :   " . $_SESSION['empID'] . "   Report From  :  " . $_SESSION['fromDate']. "   To  :  " . $_SESSION['toDate'],0,1,'L',true);
$pdf->Ln();
$col = array('Date','In Time','Out Time','Leave','Tour','Gate Register');
$pdf->FancyTable($col,$result,$smallTable);
$pdf->Ln(1);

$pdf->Output();
?>