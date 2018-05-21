<?php
error_reporting(E_ALL);
session_start();   
$conn = require_once('databaseconnection.php');
include_once('fpdf.php');
$report = $_GET['report'];
$mode = $_GET['mode'];
$start = $_SESSION['start'];
$end = $_SESSION['end'];
$pdf = new FPDF( );
$title1='';
if($report == 'attendance' || $report == 'late') {
    $len = 280;
    $pdf->AddPage('L');
    $head_font=18;
        $body_font=14;
}
else{
    $len = 200;
    $pdf->AddPage();
    $head_font=14;
    $body_font=12;
}
    
$title = '';
if($mode == 'single') {
    switch ($report)
    {
        case 'leave':
            $title='Leave Register Report';
            $sql1 = "SELECT MAX(lastUpdated) as last FROM employee_leave";
            $sql = "SELECT employeeName,designation, leaveType, DATE_FORMAT(startDate,'%d-%m-%Y'),DATE_FORMAT(endDate,'%d-%m-%Y') FROM employee_leave A  JOIN employee C on A.employeeCode =C.employeeCode JOIN designation E ON C.designationID = E.designationID JOIN leave_type B ON A.leaveTypeID = B.leaveTypeID WHERE '" . date('Y-m-d') . "' "
                    . "BETWEEN startDate AND endDate";
            $col = array('Name','Designation','Leave Type','From','To');
            $smallTable = array(50,50,45,23,23);
            break;
        case 'tour':
            $title='Tour Register Report';
            $sql1="SELECT MAX(lastUpdated) as last FROM employee_tour";
            $sql = "SELECT employeeName,designation, place, DATE_FORMAT(startDate,'%d-%m-%Y'),DATE_FORMAT(endDate,'%d-%m-%Y'),remarks FROM employee_tour A  JOIN employee C on A.employeeCode =C.employeeCode JOIN designation E ON C.designationID = E.designationID WHERE '" . date('Y-m-d') . "' "
                    . "BETWEEN startDate AND endDate";
            $col = array('Name','Designation','Place','From','To','Purpose');    
            $smallTable = array(40,40,40,23,23,30);
            break;
        case 'attendance':
            $title='Attendance Register Report';
            $sql1 = "SELECT MAX(lastUpdated) as last FROM employee_attendance";
            $sql = "SELECT employeeName, divisionName,designation,intime FROM employee_attendance A  JOIN employee C on A.employeeID =C.employeeID JOIN division D ON C.divisionID=D.divisionID JOIN designation E ON C.designationID = E.designationID WHERE date = '" . date('Y-m-d') . "' AND status ='P'" ;
            $col = array('Name','Division','Designation','Time In');    
            $smallTable = array(75,110,70,20);
            break;
        case 'absentee':
           $title='Absentee Report';
            $sql1 = "SELECT MAX(lastUpdated) as last FROM employee_attendance";
            $sql = "SELECT employeeName,divisionName,designation FROM employee_attendance A JOIN employee B on A.employeeID =B.employeeID JOIN designation E ON B.designationID = E.designationID "
                    . "JOIN division F ON B.divisionID=F.divisionID LEFT JOIN employee_leave C ON "
                    . "B.employeeCode = C.employeeCode AND A.date BETWEEN startDate AND endDate WHERE A.status = 'A' AND leaveTypeID IS NULL AND A.date = '" . date('Y-m-d') ."' ORDER BY B.categoryID,level";
            $col = array('Name','Division','Designation'); 
            $smallTable = array(50,85,60);
            break; 
        case 'late':
            $title='Late Comers Report';
            $sql1 = "SELECT MAX(lastUpdated) as last FROM employee_attendance";
            $sql = "SELECT employeeName,divisionName,designation,intime FROM employee B JOIN employee_attendance A on A.employeeID =B.employeeID JOIN designation E ON B.designationID = E.designationID "
                    . "JOIN division F ON B.divisionID=F.divisionID WHERE TIME_FORMAT(intime,'%H:%i:%s')>TIME_FORMAT('09:31:00','%H:%i:%s')  AND A.status<>'H' AND A.date = '" . date('Y-m-d') ."' ORDER BY TIME_FORMAT(intime,'%H:%i:%s') desc";
            $col = array('Name','Division','Designation',"In Time"); 
            $smallTable = array(75,115,55,30);
            break; 
        case 'early':
            $title='Early Goers Report';
            $sql1 = "SELECT MAX(lastUpdated) as last FROM employee_attendance";
            $sql = "SELECT employeeName,designation,intime,outtime FROM employee B JOIN employee_attendance A on A.employeeID =B.employeeID JOIN designation E ON B.designationID = E.designationID "
                    . "JOIN division F ON B.divisionID=F.divisionID WHERE TIME_FORMAT(outtime,'%H:%i:%s')<TIME_FORMAT('17:30:00','%H:%i:%s')  AND A.status<>'H' AND A.date = '" . date('Y-m-d') ."' ORDER BY TIME_FORMAT(outtime,'%H:%i:%s') desc";
            $col = array('Name','Designation',"In Time",'Out Time'); 
            $smallTable = array(60,65,30,30);
            break; 
        case 'employee':
            $title='Staff List';
            $sql1 = "SELECT MAX(lastUpdated) as last FROM employee_attendance";
            $sql = "SELECT employeeName,designation,divisionName FROM employee B JOIN designation E ON B.designationID = E.designationID "
                    . " JOIN division F ON B.divisionID=F.divisionID WHERE employeeStatus=1 ORDER BY B.categoryID,level";
            $col = array('Name','Designation',"Division"); 
            $smallTable = array(53,59,84);
            break; 
    }
    $pdf->SetFont('Times','B',$head_font);
    $pdf->SetTextColor(51,51,255);
    $pdf->MultiCell(0,5,'NATIONAL CENTRE FOR EARTH SCIENCE STUDIES',0,'C');
    $pdf->SetFont('Times','',$body_font);
    $pdf->MultiCell(0,5,'Ulloor - Akkulam road, Akkulam, Thiruvananthapuram, Kerala 695011',0,'C');

    $pdf->SetFont('Times','B',$head_font);
    $pdf->MultiCell(0,7,$title,0,'C');
    
    $pdf->Line(10,40,$len,40);
     $pdf->SetFont('times','',$body_font);
            $pdf->cell(0,10,"Date : " . date('d-m-Y'),0,0,'L');
            $res = mysqli_query($conn,$sql1);
            $data=mysqli_fetch_array($res);
            $last = $data['last'];
           $pdf->Ln(1);  
            $pdf->cell(0,10,"Last Updated On : " . date('d-m-Y h:i:s',strtotime($last)) ,0,0,'R');
   
    /* $conn=mysqli_connect("localhost","root","");
    mysqli_select_db($conn,"ncess_intranet");
   $sql = "SELECT A.date, A.intime,A.outtime,leaveType,place,CONCAT(F.outtime,'-', F.intime ) FROM employee_attendance A "
                . " JOIN employee B ON A.employeeID = B.employeeID LEFT JOIN employee_leave C ON B.employeeCode = C.employeeCode AND "
                . " A.date between C.startDate AND C.endDate LEFT JOIN employee_tour E ON B.employeeCode=E.employeeCode AND A.date between E.startDate "
                . " AND E.endDate LEFT JOIN gate_register F ON F.employeeCode = B.employeeCode AND a.date=f.date LEFT JOIN leave_type D ON "
                . "C.leaveTypeID = D.leaveTypeID WHERE A.employeeID=" . $_SESSION['empID'] . " AND A.date between '" . $_SESSION['fromDate'] . "' AND '" . $_SESSION['toDate'] ."'";
     */
    $result = mysqli_query($conn,$sql);
    $pdf->SetFont('times','',$body_font);
    $pdf->SetFillColor(200,220,255);
    
 $pdf->Ln();
    //$pdf->Cell(0,5, "Employee ID :   " . $_SESSION['empID'] . "   Report From  :  " . $_SESSION['fromDate']. "   To  :  " . $_SESSION['toDate'],0,1,'L',true);
    $pdf->Ln();
    //$col = array('Date','In Time','Out Time','Leave','Tour','Gate Register');
    $pdf->FancyTable($col,$result,$smallTable);
    $pdf->Ln(1);

    $pdf->Output();
}
elseif($report == 'late') {
    $sqll = "SELECT * FROM holidays WHERE year=" . date('Y');
    $re = mysqli_query($conn,$sqll);
    if(mysqli_num_rows($re)>0) {
        $arr = "";
        while($dat = mysqli_fetch_array($re)) {
            $arr = $arr . '"' . date("m-d-Y", strtotime($dat['date'])) . '",';
        }
    }
    $holidays=array($arr);
    $holidays = array("04-30");
    $holSql = "SELECT COUNT(*) As cnt FROM holidays where date BETWEEN '". $start . "' AND '" . $end . "'";
    $holRes = mysqli_query($conn, $holSql);
     $rows = [];
    if(mysqli_num_rows($holRes) >0)
    {
       
        while($row = mysqli_fetch_array($holRes))
        {
            $rows[] = $row;
        }
    }
    
    $days =  getWorkingDays($start,$end,$holidays);
   // $days = $days - $holDays;
    if($mode == 'division') {
        if($_SESSION['division'] < 0)
            $whr = '';
        else {
            $whr = ' AND B.divisionID = ' . $_SESSION['division'];
        }
        $cond = "Division : " . $_SESSION['div'];
    }
    else {
        $whr = ' AND B.employeeCode = ' . $_SESSION['employee'];
        $cond = "Employee : " . $_SESSION['emp'];
    }
        $pdf->SetFont('Times','B',$head_font);
            $pdf->SetTextColor(51,51,255);
            $pdf->MultiCell(0,5,'NATIONAL CENTRE FOR EARTH SCIENCE STUDIES',0,'C');
            $pdf->SetFont('Times','',$body_font);
            $pdf->MultiCell(0,5,'Ulloor - Akkulam road, Akkulam, Thiruvananthapuram, Kerala 695011',0,'C');
            $pdf->SetFont('Times','B',$head_font);
             $pdf->Ln();
            $pdf->MultiCell(0,7,"Late Comers & Early Goers Report",0,'C');
            $pdf->Line(10,40,$len,40);
             $pdf->SetFont('times','',$body_font);
            $pdf->cell(0,10,$cond,0,0,'L');
            $pdf->cell(0,10,"Period : " . date('d-m-Y',strtotime($start)) . "  To  " . date('d-m-Y',strtotime($end)),0,0,'R');
           $pdf->Ln();
           $pdf->Ln();
           
        $sql = "SELECT employeeName,designation,". $days .",pres,IFNULL(in_cnt,0),IFNULL(intime_short,0),IFNULL(out_cnt,0),IFNULL(outtime_short,0), "
            . "TIME_FORMAT(SEC_TO_TIME(TIME_TO_SEC(IFNULL(intime_short,0))+TIME_TO_SEC(IFNULL(outtime_short,0))),'%H:%i:%s') as tot, IFNULL(open_status,0) FROM "
            . " employee_attendance A JOIN employee B ON A.employeeID=B.employeeID JOIN designation C ON B.designationID=C.designationID "
            . " JOIN (SELECT employeeID,COUNT(*) as pres FROM employee_attendance WHERE status = 'P' AND date BETWEEN '". $start . "' AND '" . $end 
            ."' GROUP BY employeeID) AS F ON A.employeeID=F.employeeID LEFT JOIN (SELECT employeeID,COUNT(*) as open_status FROM employee_attendance "
                . " WHERE open_closed_status='Open' AND date BETWEEN '"  . $start . "' AND '" . $end . "' AND status <> 'H' GROUP BY employeeID) AS G "
                . " ON A.employeeID = G.employeeID LEFT JOIN "
            . " (SELECT employeeID,COUNT(*) as in_cnt,SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(TIME_FORMAT(intime,'%H:%i:%s'),TIME_FORMAT('09:31:00','%H:%i:%s'))))) "
            . "as intime_short FROM employee_attendance WHERE TIME_FORMAT(intime,'%H:%i:%s')>TIME_FORMAT('09:31:00','%H:%i:%s') AND date BETWEEN '" 
            . $start . "' AND '" . $end . "' AND status <> 'H' GROUP BY employeeID) AS D ON A.employeeID=D.employeeID LEFT JOIN "
            . "(SELECT employeeID,COUNT(*) as out_cnt,SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(TIME_FORMAT('17:30:00','%H:%i:%s'),TIME_FORMAT(outtime,'%H:%i:%s'))))) "
            . "as outtime_short FROM employee_attendance WHERE TIME_FORMAT(outtime,'%H:%i:%s') <TIME_FORMAT('17:30:00','%H:%i:%s') AND date BETWEEN '"
            . $start . "' AND '" . $end . "' AND status <> 'H'  GROUP BY employeeID) as E ON A.employeeID=E.employeeID WHERE A.date BETWEEN '" 
            . $start . "' AND '" . $end . "' AND status <> 'H' " . $whr. " GROUP BY A.employeeID ORDER BY tot DESC";
         $col = array('','','No. Of ', 'No. of','InTime','InTime','OutTime','OutTime','Total','Days with'); 
         $col1 = array('Employee Name','Designation','Working', 'Days','Late','Short','Late','Short','Short','Open');
         $col2 = array('','','Days', 'Present','Days','Fall','Days','Fall','Fall','Status');
         $smallTable = array(65,52,20,20,20,20,20,20,20,20);
          $result = mysqli_query($conn,$sql);
                      $pdf->FancyTable1($col,$col1,$col2,$result,$smallTable);

         
           
                $sql1 = "SELECT employeeCode, employeeName,designation, COUNT(intime) AS cnt,SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(TIME_FORMAT(intime,'%H:%i:%s'),TIME_FORMAT('09:31:00','%H:%i:%s'))))) as late,open_status "
                        . "FROM employee_attendance A JOIN employee B ON A.employeeID=B.employeeID JOIN designation E ON B.designationID = E.designationID LEFT JOIN (SELECT employeeID,COUNT(*) as open_status FROM employee_attendance "
                . " WHERE open_closed_status='Open' AND date BETWEEN '"  . $start . "' AND '" . $end . "' AND status <> 'H' GROUP BY employeeID) AS G "
                . " ON B.employeeID = G.employeeID "
                    . " WHERE TIME_FORMAT(intime,'%H:%i:%s')>TIME_FORMAT('09:31:00','%H:%i:%s') AND A.date BETWEEN '" . $start . "' AND '" . $end . "' "
                    . $whr . "  AND status <> 'H' " . $whr. "  GROUP BY A.employeeID ORDER BY late DESC" ;
                $col1 = array('Emp Code','Employee Name','Designation','No. of Days', 'Short Fall','Days with Open Status'); 
                $sql2 = "SELECT employeeCode, employeeName,designation, COUNT(outtime) AS cnt,SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(TIME_FORMAT('17:30:00','%H:%i:%s'),TIME_FORMAT(outtime,'%H:%i:%s'))))) as late,open_status "
                        . "FROM employee_attendance A JOIN employee B ON A.employeeID=B.employeeID JOIN designation E ON B.designationID = E.designationID LEFT JOIN (SELECT employeeID,COUNT(*) as open_status FROM employee_attendance "
                . " WHERE open_closed_status='Open' AND date BETWEEN '"  . $start . "' AND '" . $end . "' AND status <> 'H' GROUP BY employeeID) AS G "
                . " ON B.employeeID = G.employeeID "
                    . " WHERE TIME_FORMAT(outtime,'%H:%i:%s')<TIME_FORMAT('17:30:00','%H:%i:%s') AND A.date BETWEEN '" . $start . "' AND '" . $end . "' "
                    . $whr . "  AND status <> 'H'  " . $whr. " GROUP BY A.employeeID ORDER BY late DESC" ;
                $col2 = array('Emp Code','Employee Name','Designation','No. of Days', 'Short Fall','Days with Open Status');   
          
           
            $smallTable = array(30,70,70,25,30,55);
            
           // $conn=mysqli_connect("localhost","root","");
           // mysqli_select_db($conn,"ncess_intranet");
   
            $result = mysqli_query($conn,$sql1);
            
            $pdf->SetFillColor(200,220,255);
            $pdf->Ln();

            //$pdf->Cell(0,5, "Employee ID :   " . $_SESSION['empID'] . "   Report From  :  " . $_SESSION['fromDate']. "   To  :  " . $_SESSION['toDate'],0,1,'L',true);
            $pdf->Ln();$pdf->SetTextColor(51,51,255);
               $pdf->SetFont('times','',$head_font);
            $pdf->MultiCell(0,7,"Late Comer's Report",0,'L');
            //$col = array('Date','In Time','Out Time','Leave','Tour','Gate Register');
            $pdf->FancyTable($col1,$result,$smallTable);
            $pdf->Ln(1);
               $pdf->SetFont('times','',$body_font);
            $result = mysqli_query($conn,$sql2);
            $pdf->SetFillColor(200,220,255);
            $pdf->SetTextColor(51,51,255);
               $pdf->SetFont('times','',$head_font);
                $pdf->Ln(5);  
            $pdf->MultiCell(0,7,"Early Goers Report",0,'L');   $pdf->Ln(1);
            
               $pdf->SetFont('times','',$body_font);
            $pdf->FancyTable($col2,$result,$smallTable);
            $pdf->Ln(1);
            $pdf->Output();
   
}
elseif($mode=='employee') {
    switch ($report)
    {
        case 'leave':
            $title='Leave Register Report';
            $sql = "SELECT leaveType,DATE_FORMAT(startDate,'%d-%m-%Y'),DATE_FORMAT(endDate,'%d-%m-%Y'),duration FROM employee_leave A JOIN leave_type B ON A.leaveTypeID = B.leaveTypeID WHERE ('" . $start . "' "
                    . " BETWEEN startDate AND endDate OR '" . $end . "' BETWEEN startDate AND endDate OR startDate BETWEEN '" . $start . "' AND '" . $end . "') AND employeeCode = " . $_SESSION['employee'];
            $col = array('Leave Type','Start Date','End Date','Duration(Days)');
            $smallTable = array(50,50,50,30);
            break;
        case 'tour':
            $title='Tour Register Report';
            $sql = "SELECT DATE_FORMAT(startDate,'%d-%m-%Y'),DATE_FORMAT(endDate,'%d-%m-%Y'),place,remarks FROM employee_tour A  WHERE ('" . $start . "' "
                    . " BETWEEN startDate AND endDate OR '" . $end . "' BETWEEN startDate AND endDate OR startDate BETWEEN '" . $start . "' AND '" . $end . "') AND employeeCode = " . $_SESSION['employee'];
            $col = array('From','To','Place','Purpose');    
            $smallTable = array(40,40,40,50);
            break;
        case 'attendance':
            $title='Attendance Register Report';
            $sql = "SELECT DATE_FORMAT(A.date,'%d-%m-%Y'),A.intime,A.outtime,leaveType,place,CONCAT(F.outtime,'-', F.intime ) as gate,A.status  FROM employee_attendance "
                    . " A JOIN employee B on A.employeeID =B.employeeID LEFT JOIN "
                    . " employee_leave C ON B.employeeCode = C.employeeCode AND "
            . " A.date between C.startDate AND C.endDate LEFT JOIN employee_tour E ON B.employeeCode=E.employeeCode AND A.date between E.startDate "
            . " AND E.endDate LEFT JOIN gate_register F ON F.employeeCode = B.employeeCode AND a.date=f.date LEFT JOIN leave_type D ON "
            . "C.leaveTypeID = D.leaveTypeID WHERE A.date BETWEEN '" . $start . "' AND '" . $end . "' AND B.employeeCode = " . $_SESSION['employee'] . " ORDER BY A.date" ;
            $col = array('Date','Time In','Time Out','Leave','Tour','Gate Register','Status');   
            $smallTable = array(30,20,25,60,60,50,20);
            break;
        case 'absentee':
           $title='Absentee Report';
            $title1="(List of absent days without applying Leave or Tour)";
            $sql = "SELECT DATE_FORMAT(date,'%d-%m-%Y') FROM employee_attendance A JOIN employee B on A.employeeID =B.employeeID  LEFT JOIN employee_leave C ON "
                    . "B.employeeCode = C.employeeCode AND A.date BETWEEN startDate AND endDate WHERE A.date BETWEEN '" . $start . "' AND '" . $end . "' "
                    . "AND A.status = 'A' AND leaveTypeID IS NULL AND B.employeeCode = " . $_SESSION['employee'] . " ORDER BY date";
            $col = array('Date'); 
            $smallTable = array(60);
            break; 
        
        
    }
    $pdf->SetFont('Times','B',$head_font);
    $pdf->SetTextColor(51,51,255);
    $pdf->MultiCell(0,5,'NATIONAL CENTRE FOR EARTH SCIENCE STUDIES',0,'C');
    $pdf->SetFont('Times','',$body_font);
    $pdf->MultiCell(0,5,'Ulloor - Akkulam road, Akkulam, Thiruvananthapuram, Kerala 695011',0,'C');

    $pdf->SetFont('Times','B',$head_font);
    $pdf->MultiCell(0,7,$title,0,'C');
    $pdf->SetFont('Times','',10);
    $pdf->MultiCell(0,7,$title1,0,'C');
    $pdf->Ln(2);
    $pdf->SetFont('times','',$body_font);
    $pdf->cell(0,10,"Employee : " . $_SESSION['emp'],0,0,'L');
    $pdf->cell(0,10,"Preiod : " . date('d-m-Y',strtotime($start)) . "  To  " . date('d-m-Y',strtotime($end)),0,0,'R');
    $pdf->Line(10,45,$len,45);
    $pdf->Ln(2);
     /*$conn=mysqli_connect("localhost","root","");
    mysqli_select_db($conn,"ncess_intranet");
   $sql = "SELECT A.date, A.intime,A.outtime,leaveType,place,CONCAT(F.outtime,'-', F.intime ) FROM employee_attendance A "
                . " JOIN employee B ON A.employeeID = B.employeeID LEFT JOIN employee_leave C ON B.employeeCode = C.employeeCode AND "
                . " A.date between C.startDate AND C.endDate LEFT JOIN employee_tour E ON B.employeeCode=E.employeeCode AND A.date between E.startDate "
                . " AND E.endDate LEFT JOIN gate_register F ON F.employeeCode = B.employeeCode AND a.date=f.date LEFT JOIN leave_type D ON "
                . "C.leaveTypeID = D.leaveTypeID WHERE A.employeeID=" . $_SESSION['empID'] . " AND A.date between '" . $_SESSION['fromDate'] . "' AND '" . $_SESSION['toDate'] ."'";
     */
    $result = mysqli_query($conn,$sql);
    
    $pdf->SetFillColor(200,220,255);
    $pdf->Ln();

    //$pdf->Cell(0,5, "Employee ID :   " . $_SESSION['empID'] . "   Report From  :  " . $_SESSION['fromDate']. "   To  :  " . $_SESSION['toDate'],0,1,'L',true);
    $pdf->Ln();
    //$col = array('Date','In Time','Out Time','Leave','Tour','Gate Register');
    $pdf->FancyTable($col,$result,$smallTable);
    $pdf->Ln(1);

    $pdf->Output();
}
else {
    if($_SESSION['division'] < 0)
            $whr = '';
        else {
            $whr = ' AND emp.divisionID = ' . $_SESSION['division'];
        }
    switch ($report)
    {
        
        case 'leave':
            $title='Leave Register Report';
            $sql = "SELECT employeeName,designation,leaveType ,DATE_FORMAT(startDate,'%d-%m-%Y'),DATE_FORMAT(endDate,'%d-%m-%Y'),duration FROM employee_leave A JOIN employee emp ON A.employeeCode = emp.employeeCode JOIN designation E ON emp.designationID = E.designationID JOIN leave_type B ON A.leaveTypeID = B.leaveTypeID WHERE ('" . $start . "' "
                    . " BETWEEN startDate AND endDate OR '" . $end . "' BETWEEN startDate AND endDate OR startDate BETWEEN '" . $start . "' AND '" . $end . "')" . $whr ." ORDER BY employeeName"; ;
            $col = array('Name','Designation','Leave Type','Start Date','End Date','Duration');
            $smallTable = array(40,45,40,23,23,20);
            break;
        case 'tour':
            $title='Tour Register Report';
            $sql = "SELECT employeeName,designation,DATE_FORMAT(startDate,'%d-%m-%Y'),DATE_FORMAT(endDate,'%d-%m-%Y'),place,remarks FROM employee_tour A  JOIN employee emp on A.employeeCode =emp.employeeCode JOIN designation E ON emp.designationID = E.designationID WHERE ('" . $start . "' "
                    . " BETWEEN startDate AND endDate OR '" . $end . "' BETWEEN startDate AND endDate OR startDate BETWEEN '" . $start . "' AND '" . $end . "')" . $whr . " ORDER BY employeeName";
                    
            $col = array('Name','Designation','From','To','Place','Purpose');    
            $smallTable = array(40,40,23,23,40,40);
            break;
        case 'attendance':
            $title='Attendance Register Report';
            $sql = "SELECT DATE_FORMAT(A.date,'%d-%m-%Y'),employeeName,A.intime,A.outtime,shortname,place,CONCAT(F.outtime,'-', F.intime ) as gate,open_closed_status,A.status FROM "
                    . " employee_attendance A JOIN employee emp ON A.employeeID =emp.employeeID JOIN designation des ON emp.designationID = des.designationID LEFT JOIN employee_leave C ON "
                    . " C.employeeCode = emp.employeeCode AND A.date between C.startDate AND C.endDate LEFT JOIN employee_tour E ON "
                    . " emp.employeeCode=E.employeeCode AND A.date between E.startDate AND E.endDate LEFT JOIN gate_register F ON "
                    . "F.employeeCode = emp.employeeCode AND a.date=f.date LEFT JOIN leave_type D ON C.leaveTypeID = D.leaveTypeID WHERE A.date "
                    . "BETWEEN '" . $start . "' AND '" . $end . "'" . $whr . " ORDER BY emp.categoryID,level,A.employeeID,A.date";
            $col = array('Date','Name','In','Out','Leave','Tour','Gate Register','Open/Closed','Status');    
            $smallTable = array(25,65,20,20,25,40,40,28,15);
            
            break;
        case 'absentee':
           $title='Absentee Report';
            $title1 = "(List Employees who were absent on this period and have not applied Leave or Tour)";
            $sql = "SELECT employeeName,designation,DATE_FORMAT(A.date,'%d-%m-%Y'),IFNULL(TIME_FORMAT(A.outtime,'%H:%i:%s')-TIME_FORMAT(A.intime,'%H:%i:%s'),0) as duration FROM employee_attendance A JOIN employee emp on A.employeeID =emp.employeeID "
                    . "JOIN designation E ON emp.designationID = E.designationID  LEFT JOIN employee_leave C ON "
                    . "emp.employeeCode = C.employeeCode AND A.date BETWEEN C.startDate AND C.endDate LEFT JOIN employee_tour D ON "
                    . "emp.employeeCode = D.employeeCode AND A.date BETWEEN D.startDate AND D.endDate WHERE A.date BETWEEN '" . $start . "' AND '" . $end . "' " 
                    . $whr . " AND (A.status = 'A' OR (TIME_FORMAT(A.outtime,'%H:%i:%s')-TIME_FORMAT(A.intime,'%H:%i:%s') < 5)) AND leaveTypeID IS NULL AND place IS NULL ORDER BY emp.categoryID,level,employeeName,date";
            $col = array('Name','Designation','Date','Duration'); 
            $smallTable = array(60,70,25,20);
            break; 
       
        
            } 
    $pdf->SetFont('Times','B',$head_font);
    $pdf->SetTextColor(51,51,255);
    $pdf->MultiCell(0,5,'NATIONAL CENTRE FOR EARTH SCIENCE STUDIES',0,'C');
    $pdf->SetFont('Times','',$body_font);
   
    $pdf->MultiCell(0,5,'Ulloor - Akkulam road, Akkulam, Thiruvananthapuram, Kerala 695011',0,'C');
$pdf->Ln(2);
    $pdf->SetFont('Times','B',$head_font);
    $pdf->MultiCell(0,7,$title,0,'C');
     $pdf->SetFont('Times','',11);
     $pdf->MultiCell(0,5,$title1,0,'C');
 $pdf->SetFont('times','B',$body_font);
   
    $pdf->cell(0,10,"Division : " . $_SESSION['div'],0,0,'L');
    $pdf->cell(0,10,"Preiod : " . date('d-m-Y',strtotime($start)) . "  To  " . date('d-m-Y',strtotime($end)),0,0,'R');
    
     $pdf->Line(10,45,$len,45);
     
    $pdf->Ln(2);
   // $conn=mysqli_connect("localhost","root","");
   // mysqli_select_db($conn,"ncess_intranet");
    /*$sql = "SELECT A.date, A.intime,A.outtime,leaveType,place,CONCAT(F.outtime,'-', F.intime ) FROM employee_attendance A "
                . " JOIN employee B ON A.employeeID = B.employeeID LEFT JOIN employee_leave C ON B.employeeCode = C.employeeCode AND "
                . " A.date between C.startDate AND C.endDate LEFT JOIN employee_tour E ON B.employeeCode=E.employeeCode AND A.date between E.startDate "
                . " AND E.endDate LEFT JOIN gate_register F ON F.employeeCode = B.employeeCode AND a.date=f.date LEFT JOIN leave_type D ON "
                . "C.leaveTypeID = D.leaveTypeID WHERE A.employeeID=" . $_SESSION['empID'] . " AND A.date between '" . $_SESSION['fromDate'] . "' AND '" . $_SESSION['toDate'] ."'";
     */
    $result = mysqli_query($conn,$sql);
   
    $pdf->SetFillColor(200,220,255);
    $pdf->Ln();

    //$pdf->Cell(0,5, "Employee ID :   " . $_SESSION['empID'] . "   Report From  :  " . $_SESSION['fromDate']. "   To  :  " . $_SESSION['toDate'],0,1,'L',true);
    $pdf->Ln();
    //$col = array('Date','In Time','Out Time','Leave','Tour','Gate Register');
    $pdf->FancyTable($col,$result,$smallTable);
    $pdf->Ln(1);

    $pdf->Output();
}
function  getWorkingDays($date1, $date2, $publicHolidays) {
    $workSat = False;
    $patron   = NULL;
  if (!defined('SATURDAY')) define('SATURDAY', 6);
  if (!defined('SUNDAY')) define('SUNDAY', 0);
  // Array of all public festivities
 //  = array('04-30');
  // The Patron day (if any) is added to public festivities
  if ($patron) {
    $publicHolidays[] = $patron;
  }
  /*
   * Array of all Easter Mondays in the given interval
   */
  $yearStart = date('Y', strtotime($date1));
  $yearEnd   = date('Y', strtotime($date2));
  for ($i = $yearStart; $i <= $yearEnd; $i++) {
    $easter = date('Y-m-d', easter_date($i));
    list($y, $m, $g) = explode("-", $easter);
    $monday = mktime(0,0,0, date($m), date($g)+1, date($y));
    $easterMondays[] = $monday;
  }
  $start = strtotime($date1);
  $end   = strtotime($date2);
  $workdays = 0;
  for ($i = $start; $i <= $end; $i = strtotime("+1 day", $i)) {
    $day = date("w", $i);  // 0=sun, 1=mon, ..., 6=sat
    $mmgg = date('m-d', $i);
    if ($day != SUNDAY &&
      !in_array($mmgg, $publicHolidays) &&
      !in_array($i, $easterMondays) &&
      !($day == SATURDAY && $workSat == FALSE)) {
        $workdays++;
    }
  }
  return intval($workdays);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>NCESS Intranet</title>
 <link rel="shortcut icon" href="images/logo1.png" type="image/x-icon"/>
</head>
</html>