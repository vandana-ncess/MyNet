<?php 
    session_start();
    if(!isset($_SESSION['user']))
        echo "<script>document.location='login.php';</script>";
   if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        // last request was more than 30 minutes ago
        session_unset();     // unset $_SESSION variable for the run-time 
        session_destroy();   // destroy session data in storage
        echo "<script>document.location='login.php';</script>";
    }
    else {
        $_SESSION['LAST_ACTIVITY'] = time();   
   }
    $conn = require_once('databaseconnection.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>NCESS Intranet</title>
<meta name="keywords" content="free css templates, web design, 2-column, html css" />
<meta name="description" content="Web Design is a 2-column website template (HTML/CSS) provided by templatemo.com" />
<link href="templatemo_style.css" rel="stylesheet" type="text/css" />
<!--////// CHOOSE ONE OF THE 3 PIROBOX STYLES  \\\\\\\-->
<link href="css_pirobox/white/style.css" media="screen" title="shadow" rel="stylesheet" type="text/css" />
<!--<link href="css_pirobox/white/style.css" media="screen" title="white" rel="stylesheet" type="text/css" />
<link href="css_pirobox/black/style.css" media="screen" title="black" rel="stylesheet" type="text/css" />-->
<!--////// END  \\\\\\\-->
 <link rel="shortcut icon" href="images/logo1.png" type="image/x-icon"/>

<!--////// INCLUDE THE JS AND PIROBOX OPTION IN YOUR HEADER  \\\\\\\-->
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/piroBox.1_2.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$().piroBox({
			my_speed: 600, //animation speed
			bg_alpha: 0.5, //background opacity
			radius: 4, //caption rounded corner
			scrollImage : false, // true == image follows the page, false == image remains in the same open position
			pirobox_next : 'piro_next', // Nav buttons -> piro_next == inside piroBox , piro_next_out == outside piroBox
			pirobox_prev : 'piro_prev',// Nav buttons -> piro_prev == inside piroBox , piro_prev_out == outside piroBox
			close_all : '.piro_close',// add class .piro_overlay(with comma)if you want overlay click close piroBox
			slideShow : 'slideshow', // just delete slideshow between '' if you don't want it.
			slideSpeed : 4 //slideshow duration in seconds(3 to 6 Recommended)
	});
});
</script>
<!--////// END  \\\\\\\-->
</head>
<body>

<div id="templatemo_body_wrapper">
<div id="templatemo_wrapper">
   
	<div id="tempaltemo_header">
            <?php if(isset($_SESSION['user'])) { ?><p align="right" style="padding-right: 50px;color:#fff;"><b><?php        echo 'Welcome ' . $_SESSION['user']; ?></b>&nbsp; <a href="logout.php" style="color: #fff;">Logout</a></p>;<?php } ?>
    	<span id="header_icon"></span>
    	<div id="header_content">
        	<div id="site_title">
				    <p>Welcome to NCESS Family</p>         </div>
           
		 
		</div>
    </div> <!-- end of header -->
    
    <div id="templatemo_main_top"></div>
    <div id="templatemo_main"><span id="main_top"  style="height: 164px;"></span><span id="main_bottom" style="height: 164px;"></span>
        <div id="templatemo_sidebar">
            <div id="templatemo_menu" style="min-height: 275px;">
               <?php
                        if($_SESSION['user'] == 'admin')
                            $sql ="SELECT * FROM adminmenu WHERE status =1 " ;
                        else 
                            $sql ="SELECT * FROM adminmenu A JOIN adminmenu_privileges B ON A.menuID = B.menuID  AND ". $_SESSION['loggedUserID'] . " = users WHERE A.status =1 " ;
                         $result = mysqli_query($conn,$sql);
                        if(mysqli_num_rows($result)>0) {
                            echo "<ul>";
                            while($row = mysqli_fetch_array($result)) {
                                        echo "<li><a href='". $row['page'] . "' target='_parent'>".$row['menu']. "</a></li>";
                            }
                            echo '</ul>';
                        }
                
                   ?>    	
            </div> <!-- end of templatemo_menu 
        
        	<div class="sidebar_box">
            	<div class="sb_title">Staff Login</div>
                <div class="sb_content">
                	<div id="login_form">
                        <form method="post" action="#">
                        	<p><span>User Name:</span>
                            <input type="text" id="username" name="username" class="login_input" />
                            </p>
                            <p><span>Password:</span>
                            <input type="password" id="password" name="password" class="login_input" />
                            </p>
                            <input type="submit" name="submit" id="login_submit" value=" " />
                        </form>
					</div>                  
                </div>
                <div class="sb_bottom"></div>            
            </div>-->
          
        </div> <!-- end of sidebar -->
        
        <div id="templatemo_content">
            
                <table class="tab"><form method="post" >
                        <tr>
                            <td style="width:350px;"><span class="mandatory">* </span>Year</td>
                        <td><select name="ddlYear" id="ddlYear"  style="width:100px;height:25px;" required>
                                        
                                        <?php 
                                            $curr_yr = date('Y');
                                            for($i=$curr_yr;$i>=1979;$i--) {
                                                echo "<option value='" . $i . "'>" . $i. "</option>";
                                            }
                                        ?>

                                    </select>
                        </td>
                            <td align="right"><span class="mandatory">* </span>Research Area</td> <td colspan="2"><select name="ddlArea" required id="ddlArea" style="height: 25px;">
                                        
                                        <option value="Crustal Processes Group">Crustal Processes Group</option>
                                        <option value="Coastal Processes Group">Coastal Processes Group</option>
                                        <option value="Atmospheric Processes Group">Atmospheric Processes Group</option>

                                        <option value="Hydrological Processes Group">Hydrological Processes Group</option>
                                    </select>
                        </td>
                        
                    </tr>
                        <tr>
                            <td><span class="mandatory">* </span>Author(s)</td><td colspan="4"><input type="text" name="txtAuthor" id="txtAuthor" style="width:480px;" required /></td>
                            
                        </tr>
                        <tr>
                            <td><span class="mandatory">* </span>Title</td> <td colspan="4"><input type="text" id="txtTitle" name="txtTitle" style="width:480px;" required /></td>
                        </tr>
                        <tr>
                            <td><span class="mandatory">* </span>Journal Name</td><td colspan="2"><input type="text" id="txtJounal" name="txtJournal" required  style="width:266px;"  /></td><td style="padding-left: 20px;">Issue</td><td ><input type="text" id="txtIssue" name="txtIssue" style="width:112px;" /></td>
                        </tr>
                        <tr>
                            <td>DOI</td><td colspan="2"><input type="text" id="txtDOI" name="txtDOI"  style="width:266px;"   /></td><td style="padding-left: 20px;">Page No(s)</td><td><input type="text" id="txtPage" name="txtPage" style="width:112px;"  /></td>
                        </tr>
                        <tr>
                            <td colspan="5" align="right"><input type="submit" name="btnSave" id="btnSave" value="Save" /></td>
                        </tr>
                                </form>

                    <?php
                        $sql="SELECT * FROM research_publications where approvalStatus='Pending'";
                        $result = mysqli_query($conn,$sql);
                        if(mysqli_num_rows($result)) {
                            $i=1;
                            echo '<tr>
                        <td colspan="5" bgcolor="blue" height="25px;" style="color: white;" >Research Publications Awaiting Approval</td>
                    </tr><tr><td colspan="5"> <form  method="post" onsubmit="setSelected()">
                    <table id="tblPublications"><thead bgcolor="#424066" height="30px" style="color:white;"><tr><th><input type="checkbox" name="chkAll" id="chkAll" onchange="checkAll()" />Select</th><th >Year</th><th >Research Area</th>
                    <th style="width:300px;">Journal</th><th >Authors</th>
                    </tr></thead><tbody>';
                            while($row=mysqli_fetch_array($result)) {
                                echo '<tr>'
                                . '<td align="center">'
                                        . '<input type="checkbox" name="chkSelect[]" id="chkAll'.$i.'" /><input type="hidden" name="txtSelect[]" id="txtSelect'.$i.'" /></td>'
                                . '<td>'. $row['year'] . '<input type="hidden" name="txtID[]" value="'. $row['publicationsID'] .'"/></td><td>' . $row['researchArea'] .'</td><td>' . $row['journal'] .'</td><td>' . $row['authors'] . '</td></tr>';
                                $i++;
                            } 
                            echo "<tr><td colspan='5' align='right'><input type='submit' name='btnApprove' id='btnApprove' value='Approve' /></td></tr></tbody></table></form></td></tr>";
                        }
                    ?>
                    <?php
            if(isset($_POST['btnSave'])) {
                $sql = "INSERT INTO research_publications(year,authors,researchArea,journal,approvalStatus) VALUES(' " . $_POST['ddlYear'] . "','" . $_POST['txtAuthor']. 
                        "','" . $_POST['ddlArea'] . "','" . $_POST['txtTitle']. "; " . $_POST['txtJournal'].  ";" . $_POST['txtIssue'].  "; pp-" . 
                        $_POST['txtPage']. "; DOI : " . $_POST['txtDOI']  .  "','Approved');";
                $result = mysqli_query($conn,$sql);
                 if($result)
                    echo "Submitted Publication!";
                else {
                    echo "Failed to save!";
                 }
            }
            else if(isset ($_POST['btnApprove'])) {
                $selected = $_POST['txtSelect'];
                            $id = $_POST['txtID'];
                            for($i=0;$i<sizeof($selected);$i++) {
                                if($selected[$i]) { 
                                   $sql = "UPDATE research_publications SET approvalStatus='Approved'";
                                   $result = mysqli_query($conn,$sql);
                                }
                               
                            }
                             if($result)
                    echo "Approved!";
                else {
                    echo "Failed to approve!";
                 }
            }
          ?>   
                 </table>    
               
        </div>
        
        <div class="cleaner"></div>    
    </div>
    
    <div id="templatemo_main_bottom" >
    </div>

</div> <!-- end of wrapper -->
</div>

<div id="templatemo_footer_wrapper">
	<div id="templatemo_footer">
       Copyright © 2018 <a href="#">NCESS</a> | Contact Us : adm@ncess.gov.in | Ext : 1669 
        
    </div>
</div>
    <script type="text/javascript">
        function checkAll() {
          $checked = document.getElementById('chkAll').checked;
          $tbl = document.getElementById('tblPublications');
          for (var i = 1; i<$tbl.rows.length ; i++) {
              chk = $tbl.rows[i].cells[0].children[0];
                chk.checked = $checked;
         }
      }
      function setSelected() {
          $tbl = document.getElementById('tblPublications'); 
          for($i = 1 ; $i <= $tbl.rows.length; $i++)
		{
			chk = $tbl.rows[$i].cells[0].children[0];
                        
			if(chk.checked)
				document.getElementById('txtSelect' + $i).value = 1;
			else
				document.getElementById('txtSelect' + $i ).value = 0;	
		}
      }
        </script>
</html>