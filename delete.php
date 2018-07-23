<?php 
    $conn = require_once('databaseconnection.php');
    $id = $_GET['id'];
    $table = $_GET['table'];
    switch ($table) {
    case 'privileges':
        $sql = "UPDATE adminmenu_privileges SET status=0 WHERE privilegeID=" . $id;
        break;
    case 'topics':
        $sql = "UPDATE discussion_topics SET status=0 WHERE topicID=" . $id;
        break;
    case 'mainproject':
        $sql = "UPDATE main_projects SET status=0 WHERE mainPjctID=" . $id;
        break;
    case 'subproject':
        $sql = "UPDATE projects SET status=0 WHERE projectID=" . $id;
        break;
    case 'employee':
        $sql = "UPDATE employee SET employeeStatus=0 WHERE employeeCode=" . $id;
        break;
    case 'investigator':
        $sql = "DELETE FROM project_investigators WHERE projInvID=" . $id;
        break;
    case 'news':
        $sql = "UPDATE events SET status=0 WHERE eventID=" . $id;
        break;
    case 'notice':
        $sql = "UPDATE noticeboard SET status=0 WHERE id=" . $id;
        break;
    case 'esf':
        if($_GET['mode']=='delete')
            $sql = "DELETE FROM esf WHERE id=" . $id;
        else
            $sql = "UPDATE esf SET status=0 WHERE id=" . $id;
        break;
    case 'tour':
        $sql = "DELETE FROM employee_tour WHERE tourID=" . $id;
        break;
     case 'leave':
        $sql = "DELETE FROM employee_leave WHERE leaveID=" . $id;
        break;
    case 'privileges':
        $sql = "DELETE FROM adminmenu_privileges WHERE privilegeID=" . $id;
        break;
    case 'menu':
        $sql = "UPDATE homemenu SET status=0 WHERE menuID=" . $id;
        break;
    default:
        break;
} 
$result = mysqli_query($conn,$sql);
if($result)
    echo 'Deleted Successfully!';
else 
    echo $sql;
?>
