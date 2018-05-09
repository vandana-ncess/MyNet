<?php 
    $empID = $_GET['empID'];
    $from = $_GET['from'];
    $to = $_GET['to'];
    $conn  = require_once('databaseconnection.php');
    $sql = "SELECT A.date, A.intime,A.outtime,leaveType,place,F.outtime as gateout,F.intime as gatein,A.status FROM employee_attendance A "
            . " JOIN employee B ON A.employeeID = B.employeeID LEFT JOIN employee_leave C ON B.employeeCode = C.employeeCode AND "
            . " A.date between C.startDate AND C.endDate LEFT JOIN employee_tour E ON B.employeeCode=E.employeeCode AND A.date between E.startDate "
            . " AND E.endDate LEFT JOIN gate_register F ON F.employeeCode = B.employeeCode AND a.date=f.date LEFT JOIN leave_type D ON "
            . "C.leaveTypeID = D.leaveTypeID WHERE A.employeeID=" . $empID . " AND A.date between" . $from . " AND " . $to ; 
    $result = mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)>0) {
        echo '<div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Attendance History</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>In Time</th>
                  <th>Out Time</th>
                  <th>Leave</th>
                  <th>Tour</th>
                  <th>Gate Register</th>
                  <th>Status</th>
                  
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Date</th>
                  <th>In Time</th>
                  <th>Out Time</th>
                  <th>Leave</th>
                  <th>Tour</th>
                  <th>Gate Register</th>
                  <th>Status</th>
                  </tr>
              </tfoot>
              <tbody>';
        if(mysqli_num_rows($result) > 0)
                    {
                        while ($row = mysqli_fetch_array($result)) {
                           echo "<tr><td>" . $row['date'] .  "</td>";
                           echo "<td>" . $row['intime'] . "</td><td>" . $row['outtime'] . "</td>";
                           echo "<td>" . $row['leaveType'] . "</td><td>" . $row['place'] . "</td><td>" . $row['gateout'] . " - " . $row['gatein'] . "</td><td >";
                           if($row['status'] == 'A')
                           {
                               if($row['leaveType'] != '')
                                   echo "L";
                               else if($row['place'] != '')
                                   echo "T";
                               else 
                                   echo "A";
                           }
                           else {
                               if($row['gateout'] !== null && $row['gatein'] == null)
                                   echo "A";
                               else
                                   echo 'P';
                           }
                           echo "</td></tr>";
                        }
                       
                    }
        echo '</tbody></table>
          </div>
        </div><input type = "submit" name="btnExport" id="btnExport" value="Export" />
      </div>';
    }
?>