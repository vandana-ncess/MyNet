<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<?php
                            $sql = "SELECT * FROM oc_committee WHERE status=1";
                            $result = mysqli_query($conn,$sql);
                            if(mysqli_num_rows($result)) {
                                echo '<td id="tdCommittee"><select name ="ddlCommittee" id="ddlCommittee" >';
                                while($row=mysqli_fetch_array($result)) {
                                    echo '<option value=' .$row['committeeID'] . '>' . $row['committeeName'] . '</option>' ;
                                }
                                echo '</select>';
                            }
                        ?>
</html>