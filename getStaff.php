<?php
    $type = $_GET['category'];
    $str = $_GET['str'];
    $str = str_replace(' ','%',$str);
    $conn = require_once('databaseconnection.php');
    switch ($type)
    {
        case 'admin':
            $sql1 = "SELECT A.*,designation,divisionName FROM employee A JOIN designation B ON A.designationID=B.designationID JOIN division C "
                . "ON A.divisionID = C.divisionID where A.categoryID=5 AND employeeStatus=1 AND employeeName LIKE '%" . $str . "%' AND A.designationID<>23 ORDER BY divisionID,level";
            $div = 3;
            break;
        case 'scientist':
            $sql1 = "SELECT A.*,designation,divisionName FROM employee A JOIN designation B ON A.designationID=B.designationID JOIN division C ON A.divisionID = C.divisionID "
                                . " where A.categoryID=1 AND employeeStatus=1 AND employeeName LIKE '%" . $str . "%' ORDER BY divisionID,level,joining_date";
            $div = 3;
            break;
        case 'technical':
            $sql1 = "SELECT A.*,designation,divisionName FROM employee A JOIN designation B ON A.designationID=B.designationID JOIN division C ON A.divisionID = C.divisionID where A.categoryID=4 AND employeeStatus=1 AND employeeName LIKE '%" . $str . "%' ORDER BY level";
            $div = 3;
            break;
        case 'scientific':
            $sql1 = "SELECT A.*,designation,divisionName FROM employee A JOIN designation B ON A.designationID=B.designationID JOIN division C "
                . "ON A.divisionID = C.divisionID where A.categoryID=3 AND employeeStatus=1 AND employeeName LIKE '%" . $str . "%' ORDER BY divisionID,level,joining_date";
            $div = 3;
            break;
        case 'project':
            $sql1 = "SELECT A.*,designation,divisionName FROM employee A JOIN designation B ON A.designationID=B.designationID  JOIN division C "
                . "ON A.divisionID = C.divisionID where A.categoryID=7 AND employeeStatus=1 AND employeeName LIKE '%" . $str . "%'  ORDER BY divisionID,level";
            $div = 4;
            break;
    }
    echo '<div class="content_box" style="height : 550px;" id="search">';
                        if($type == 'admin' && strpos(strtolower("Dr.Suresh Babu.D.S "), strtolower($str)) !== false) {
                            echo '<table><tr>';
                            echo '<td style="font-size:18px;padding-bottom:10px;">Chief Manager</td></tr><tr><td ><img class="image_wrapper image_fl"  width="140px" height="160px" src="images/profile/1517.jpg" alt="Image 1" /><a href="employeeProfile.php?empID=1517" target="_blank" ><b>Dr.Suresh Babu.D.S <br />Scientist F & Chief Manager (In-charge)</b></a></td></tr><tr>';
                        }
                       if($type == 'project')
                        {
                            $sql = "SELECT *,designation FROM employee A JOIN designation B ON A.designationID=B.designationID WHERE A.categoryID=6 AND "
                                    . "employeeStatus=1 AND employeeName LIKE '%" . $str . "%' ORDER BY  divisionID,joining_date";
                            $result = mysqli_query($conn,$sql);
                            $i=1;
                            if(mysqli_num_rows($result)>0) {
                                 echo '<table><tr>';
                                echo '<td style="font-size:18px;padding-bottom:10px;padding-top:10px;" colspan"'. $div .'">Senior Consultants</td></tr><tr>';
                                while($row=mysqli_fetch_array($result)) {
                                   echo '<td ><img class="image_wrapper image_fl" src="images/profile/'.$row['employeeCode'] . '.jpg" alt="Image 1"  width="120px" height="140px" /><a href="employeeProfile.php?empID=' . $row['employeeCode'] . '" target="_blank" ><b>' . $row['employeeName'] .'<br />Scientist G(Rtd.),<br /> Senior Consultant</b></a></td>';
                                        if(($i%4)==0)
                                            echo '</tr><tr>';
                                       $i++;
                                   }

                                }
                        }
                        
                            $last = "";
                            $result = mysqli_query($conn,$sql1);
                            $i=1;
                        
                            if(mysqli_num_rows($result)>0) {                            
                            echo '<table><tr>';
                            $row=mysqli_fetch_array($result);
                            $last = $row['divisionName'];
                             echo '<td style="font-size:18px;padding-bottom:10px;" colspan="'. $div .'">' . $row['divisionName'] . '</td></tr><tr><td ><img class="image_wrapper image_fl"  width="140px" height="160px" src="images/profile/'.$row['employeeCode'] . '.jpg" alt="Image 1" /><a href="employeeProfile.php?empID=' . $row['employeeCode'] . '" target="_blank" ><b>' . $row['employeeName'] .'<br />' . $row['designation']. '</b></a></td>';
                             $i++;
                             while($row=mysqli_fetch_array($result)) {
                               if($last == $row['divisionName']) {
                                    echo '<td width="150px"><img class="image_wrapper image_fl" src="images/profile/'.$row['employeeCode'] . '.jpg" alt="Image 1" width="140px" height="160px" /><a href="employeeProfile.php?empID=' . $row['employeeCode'] . '" target="_blank" ><b>' . $row['employeeName'] .'<br />' . $row['designation']. '</b></a></td>';
                                    if(($i%$div)==0)
                                        echo '</tr><tr>';
                                   $i++;
                                   $last = $row['divisionName'];
                               }
                               else {
                                   echo '</tr><tr><td  style="font-size:18px;padding-bottom:10px;padding-top:10px;" colspan="'. $div .'">'. $row['divisionName'] . '</td></tr><tr>';
                                   $i = 1;
                                   echo '<td><img class="image_wrapper image_fl" src="images/profile/'.$row['employeeCode'] . '.jpg" alt="Image 1" width="140px" height="160px" /><a href="employeeProfile.php?empID=' . $row['employeeCode'] . '" target="_blank" ><b>' . $row['employeeName'] .'<br />' . $row['designation']. '</b></a></td>';
                                    if(($i%3)==0)
                                        echo '</tr><tr>';
                                   $i++;
                                   $last = $row['divisionName'];
                               }
                            }
                        }
                        if($type == 'admin') {
                            $sql = "SELECT * FROM employee WHERE categoryID=5 AND designationID = 23 AND employeeStatus=1 AND employeeName LIKE '%" . $str . "%' ORDER BY employeeCode";
                            $result = mysqli_query($conn,$sql);                           
                            $i=1;
                            if(mysqli_num_rows($result)>0) {
                                echo '</tr><tr><td style="font-size:18px;padding-bottom:10px;padding-top:10px;" colspan="'. $div .'">MTS</td></tr><tr>';
                                while($row=mysqli_fetch_array($result)) {
                                   echo '<td><img class="image_wrapper image_fl" src="images/profile/'.$row['employeeCode'] . '.jpg" alt="Image 1" width="140px" height="160px" /><a href="employeeProfile.php?empID=' . $row['employeeCode'] . '" target="_blank" ><b>' . $row['employeeName'] . '</b></a></td>';
                                        if(($i%3)==0)
                                            echo '</tr><tr>';
                                       $i++;
                                   }

                                }
                        }
                         
                        echo '</tr></table>';
      echo '</div>';                  
                      
?>