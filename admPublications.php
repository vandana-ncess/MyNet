
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
<script type="text/javascript">
      function loadDesignation()
      {
          $catID = document.getElementById('ddlCategory').value;
          if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("ddlDesignation").innerHTML = this.responseText ;
                loadEmployee();
            }
        };
        xmlhttp.open("GET","getDesignation.php?catID="+$catID);
        xmlhttp.send();
      }
     
      function loadEmployee()
      {
          $catID = document.getElementById('ddlCategory').value;
          $desigID = document.getElementById('ddlDesignation').value;
          $divID = document.getElementById('ddlDivision').value;
          element = document.getElementById('ddlDivision');
          document.getElementById('txtDiv').value = element.options[element.selectedIndex].text;
          $str = "";
          if($catID>0)
              $str = $str + " AND categoryID=" + $catID;
          if($desigID>0)
               $str = $str + " AND designationID=" + $desigID;
          if($divID>=0)
              $str = $str + " AND divisionID =" + $divID;
          if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("ddlEmployee").innerHTML = this.responseText ;
            }
        };
        xmlhttp.open("GET","getEmployee.php?str="+$str);
        xmlhttp.send();
      }
   </script>
<!--////// END  \\\\\\\-->
</head>
    <body onload="loadDesignation()">

<div id="templatemo_body_wrapper">
<div id="templatemo_wrapper">
   
	<div id="tempaltemo_header">
            <?php if(isset($_SESSION['user'])) { ?><p align="right" style="padding-right: 50px;color:#fff;"><b><?php        echo 'Welcome ' . $_SESSION['user']; ?></b>&nbsp; <a href="adminlogout.php" style="color: #fff;">Logout</a></p>;<?php } ?>
    	<span id="header_icon"></span>
    	<div id="header_content">
        	<div id="site_title">
				    <p>Welcome to NCESS Intranet</p>         </div>
           
		 
		</div>
    </div><!-- end of header -->
    
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
            <form method="post" >
                <table class="tab">
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
                            <td colspan="5">
                                <p>In addition to specifying authors above, Kindly add the NCESS staffs, who are in the authors list from the below drop down list.</p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <fieldset>
                                    <legend>Filter Options</legend>
                                    <table>
                                        <tr>
                                            <td>Division</td><td>Category</td><td>Designation</td>
                                        </tr>
                                        <tr>
                                           <td ><input type="hidden" name="txtDiv" id='txtDiv' /><select id="ddlDivision" name="ddlDivision" onchange="loadEmployee()" style="width: 200px;">
                                            <option value="-1">All</option>
                                            <?php
                                                $sql = "SELECT divisionID,divisionName FROM division WHERE divisionStatus=1  AND divisionName<>''";
                                                $result = mysqli_query($conn,$sql);
                                                if(mysqli_num_rows($result) > 0)
                                                {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        echo "<option value=" . $row['divisionID'] . ">" . $row['divisionName'] . "</option>";
                                                    }
                                                }
                                            ?>
                                            </select>
                                            </td>

                                           <td  width="200px"><select id="ddlCategory" name="ddlCategory" onchange="loadDesignation()" style="width: 200px;" ><option value="0">All</option>
                                                    <?php
                                                        $sql = "SELECT categoryID,categoryName FROM category WHERE categoryStatus=1";
                                                        $result = mysqli_query($conn,$sql);
                                                        if(mysqli_num_rows($result) > 0)
                                                        {
                                                            while ($row = mysqli_fetch_array($result)) {
                                                                echo "<option value=" . $row['categoryID'] . ">" . $row['categoryName'] . "</option>";
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </td>
                                            <td ><select id="ddlDesignation" name="ddlDesignation" onchange="loadEmployee()" style="width: 200px;">

                                                </select>
                                            </td> 
                                        </tr>
                                        <tr>
                                            <td>Select Authors</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><select id="ddlEmployee" name="ddlEmployee" style="width: 400px;"  ><option value="0"></option>
                                            </select></td>
                                            <td><input type="button" name="btnAdd" value="Add Author" onclick="addAuthors()" /> </td>
                                        </tr>
                                    </table>
                                </fieldset></td>
                        </tr>
                        <tr>
                            <td colspan="5"><table id="tblAuthors" ></table> </td>
                        </tr>
                        <tr>
                            <td colspan="5" align="right"><input type="submit" name="btnSave" id="btnSave" value="Save" /></td>
                        </tr>
                              

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
                $authorIDs = $_POST['txtAuthID'];
                $ids = "";
                $jou = $_POST['txtTitle']. "; " . $_POST['txtJournal'].  ";";
                if($_POST['txtIssue'] != '')
                    $jou = $jou. $_POST['txtIssue'] . ";";
                if($_POST['txtPage']!='')
                    $jou = $jou.  " pp-" .$_POST['txtPage']. ";";
                if($_POST['txtDOI']!='')
                    $jou = $jou.  " DOI : " .$_POST['txtDOI']. ";";
                for($i = 0; $i < sizeof($authorIDs); $i++)
                    $ids = $ids . $authorIDs[$i] . ",";
                $sql = "INSERT INTO research_publications(year,authors,authorIDs,researchArea,journal,approvalStatus) VALUES(' " . $_POST['ddlYear'] . "','" . $_POST['txtAuthor']. 
                        "','". $ids . "','" . $_POST['ddlArea'] . "','" . $jou .   "','Approved');";
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
            </form>    
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
      function addAuthors()
      {
          $tab = document.getElementById('tblAuthors');
               
                if($tab.rows.length == 0) {
                    var row = $tab.insertRow(0);
                    row.style.backgroundColor = "green";
                    row.style.color = "white";
                    row.style.height = "25px";
                    var cell1 = row.insertCell(0);
                    var cell3 = row.insertCell(1);
                    cell1.innerHTML="Author";
                    cell3.innerHTML="Remove";
                }
                var row = $tab.insertRow($tab.rows.length);
                    var cell1 = row.insertCell(0);
                    var cell3 = row.insertCell(1); 
                    ddl = document.getElementById('ddlEmployee');
                    cell1.innerHTML=ddl.options[ddl.selectedIndex].text ;
                    cell3.innerHTML="<img src='images/erase.png' onclick='deleteAuthor(this)' style='cursor:pointer;' /><input type='hidden' name='txtAuthID[]' value='" + 
                            ddl.value + "' />";
      }
      function deleteAuthor($id) {
          /*     if($id > 0) {
                
                    if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                    } else {
                        // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            alert(this.responseText) ;document.location='admPublications.php';
                        }
                    };
                    xmlhttp.open("GET","delete.php?id="+$id+"&table=investigator");
                    xmlhttp.send();
                }
                else
                {*/
                    $ind = $id.parentNode.parentNode.rowIndex;
                    document.getElementById('tblAuthors').deleteRow($ind);
              //  }
        }   
      
        </script>
    </body>
</html>