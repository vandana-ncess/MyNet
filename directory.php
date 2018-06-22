<?php 
    session_start();
    if(!isset($_SESSION['user']))
        echo "<script>document.location='login.php';</script>";
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
    <body onload="loadDesignation()">

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
    <div id="templatemo_main"><span id="main_top"></span><span id="main_bottom"></span>
    	
        <div id="templatemo_sidebar">
        
        	<div id="templatemo_menu">
                <?php
                        $menuSql= "SELECT * FROM menu WHERE status=1";
                        $menuRes = mysqli_query($conn,$menuSql);
                        if(mysqli_num_rows($menuRes) > 0) {
                            echo '<ul>';
                            while ($menuData= mysqli_fetch_array($menuRes)) {
                                echo '<li><a href="'.$menuData['menuPage'] . '" target="_parent">' . $menuData['menu'] . '</a></li>';
                            }
                            echo '</ul>'; 
                        }
                    ?>   	   	
            </div>            
                      
            
            <div class="cleaner"></div>
        </div> <!-- end of sidebar -->
        
        <div id="templatemo_content">
        	<div class="content_box" >
                    <table width="100%"  align="left" cellpadding="0" cellspacing="0" class='directory'>
			<tr align="right">
                            <td colspan="6" width="100%" align="left" bgcolor="#4E49D4" height="25px;" style="color: white;"><strong>&nbsp;General Numbers</strong></td>
                			    
                        </tr>
			<tr>
                            <td colspan="2" align="right"  class="ht">NCESS, Thiruvananthapuram</td>
                            <td align="left" bgcolor="#CCCCCC" class="ht" >(+91)(471) 2511501</td>
                            <td colspan="2" align="right"   class="ht">FAX : </td>
                            <td align="left" bgcolor="#CCCCCC" class="ht" >(+91)(471) 2442280</td>
			</tr>
                        <tr align="right">
			    <td colspan="6" align="left" bgcolor="#4E49D4" height="25px;" style="color: white;"><strong>&nbsp;General Intercom Numbers</strong></td>
                        </tr>
                         <tr>
                             <td align="right"  class="ht" >Director</td>
			    <td align="left" bgcolor="#CCCCCC" class="ht" >1501</td>
                            <td align="right"  class="ht" >Director's Office</td>
                            <td align="left" bgcolor="#CCCCCC" width="90px" class="ht" >1502</td>
                            <td align="right" >Chief Manager </td>
                            <td bgcolor="#CCCCCC" >1526</td>
                            
			</tr>
                        <tr>
                             <td align="right"  class="ht" >CoP Office</td>
			    <td align="left" bgcolor="#CCCCCC" class="ht" >1704</td>
                            <td align="right"  class="ht" >Group Head, CoP</td>
                            <td align="left" bgcolor="#CCCCCC" width="90px" class="ht" >1701</td>
                            <td align="right" >Deputy Group Head,CoP </td>
                            <td bgcolor="#CCCCCC" >1702/1716</td>
                            
			</tr>
                        <tr>
                             <td align="right"  class="ht" >CrP Office</td>
			    <td align="left" bgcolor="#CCCCCC" class="ht" >1623</td>
                            <td align="right"  class="ht" >Group Head, CrP</td>
                            <td align="left" bgcolor="#CCCCCC" width="90px" class="ht" >1622</td>
                            <td align="right" >Deputy Group Head,CrP </td>
                            <td bgcolor="#CCCCCC" >1621</td>
                            
			</tr>
                        <tr>
                             <td align="right"  class="ht" >AtP Office</td>
			    <td align="left" bgcolor="#CCCCCC" class="ht" >1714</td>
                            <td align="right"  class="ht" >Group Head, AtP</td>
                            <td align="left" bgcolor="#CCCCCC" width="90px" class="ht" >1717/1709</td>
                            <td align="right" >Deputy Group Head,AtP </td>
                            <td bgcolor="#CCCCCC" >1611</td>
                            
			</tr>
                        <tr>
                             <td align="right"  class="ht" >HyP Office</td>
			    <td align="left" bgcolor="#CCCCCC" class="ht" >1616</td>
                            <td align="right"  class="ht" >Group Head, HyP</td>
                            <td align="left" bgcolor="#CCCCCC" width="90px" class="ht" >1617</td>
                            <td align="right" >Deputy Group Head,HyP </td>
                            <td bgcolor="#CCCCCC" >1601</td>
                            
			</tr>
                         <tr>
			    <td align="right">P & GA</td>
                            <td bgcolor="#CCCCCC">1527</td>
                             <td align="right">Finance & Accounts </td>
                            <td bgcolor="#CCCCCC">1520</td>
                             <td align="right">Purchase & Stores </td>
                            <td bgcolor="#CCCCCC">1531</td>
                             
			</tr>
                        <tr>
                            <td align="right"  class="ht">EA & M</td>
			    <td align="left" bgcolor="#CCCCCC" class="ht" >1508</td> 
                            <td align="right">Technical Cell </td>
                            <td bgcolor="#CCCCCC">1503</td>
                             <td align="right">XRD Lab </td>
                            <td bgcolor="#CCCCCC">1667/1668</td>
                        </tr>
                        <tr>
			    <td align="right">CRZ lab </td>
                            <td bgcolor="#CCCCCC">1709</td>
                           <td align="right">XRF Lab </td>
                            <td bgcolor="#CCCCCC">1670</td>
                            <td align="right">SEM-EDS lab </td>
                            <td bgcolor="#CCCCCC">1618</td>
			</tr>
                        <tr>
                            <td align="right">PSA Lab </td>
                            <td bgcolor="#CCCCCC">1660</td>
                            <td align="right">Modeling Laboratory </td>
                            <td bgcolor="#CCCCCC">1716</td>
                            <td align="right"  class="ht">Lab(Research Students)</td>
			    <td align="left" bgcolor="#CCCCCC">1710</td> 
                            
                        </tr>
                        <tr>
                              <td align="right">Reception </td>
                            <td bgcolor="#CCCCCC">1500</td>
                            <td align="right">Canteen </td>
                            <td bgcolor="#CCCCCC">1718</td>
                             <td align="right">Library </td>
                            <td bgcolor="#CCCCCC">1507</td>
			    
                         </tr>
                         <tr>
                          
                            <td align="right">Neyyar </td>
                            <td bgcolor="#CCCCCC">1673</td>
                             <td align="right">Pamba </td>
                            <td bgcolor="#CCCCCC">1672</td>
                             <td align="right">Nila </td>
                            <td bgcolor="#CCCCCC">1518</td>
			</tr>
                          <tr>
                            <td align="right">Security Gate (24X7) </td>
                            <td bgcolor="#CCCCCC">04712442270</td>
			    <td align="right"  class="ht">Security</td>
			    <td align="left" bgcolor="#CCCCCC" class="ht" >1720/ 1721</td> 
			    <td align="right">Co-op. Society </td>
                            <td bgcolor="#CCCCCC">1680</td>
                           
			</tr>
                         
                        <tr>
			    <td align="right"> </td>
                            <td bgcolor="#CCCCCC"></td>
                            <td align="right">Security Officer </td>
                            <td bgcolor="#CCCCCC">1720</td>
                            <td align="right"  class="ht">Electrician/Plumber</td>		
                            <td bgcolor="#CCCCCC" >1681/1508</td> 

                            <td></td>
                            <td></td>
			</tr>
                         
                         
                         <tr align="right">
			    <td colspan="6" align="left" bgcolor="#4E49D4" height="25px;" style="color: white;"></td>
                        </tr>
                        <tr align="right" height="20px;">
			    <td colspan="6" ></td>
                        </tr>
                        <tr align="right">
			    <td colspan="6" align="left" bgcolor="#424066" height="25px;" style="color: white;" >STAFF DIRECTORY</td>
                        </tr>
                        <tr>
                            <td  style="padding-top: 20px;">Division</td>
                            <td colspan="2"  style="padding-top: 20px;">
                                <select id="ddlDivision" name="ddlDivision"  style="width: 220px;"><option value="-1">All</option>
                                    <?php
                                        $sql = "SELECT divisionID,divisionName FROM division WHERE divisionStatus=1";
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
                            <td  style="padding-top: 20px;padding-left: 5px;">Category</td>
                            <td colspan="2"  style="padding-top: 20px;"><select id="ddlCategory" name="ddlCategory" onchange="loadDesignation()" style="width: 200px;" ><option value="0">All</option>
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
                        </tr>
                        <tr>
                            <td >Designation</td>
                            <td colspan="2">
                                <select id="ddlDesignation" name="ddlDesignation"  style="width: 220px;">
                                </select>
                            </td>
                            <td   style="padding-left: 5px;">Name</td><td colspan="3"><input type="text" name="txtEmployee" id="txtEmployee" style="width: 194px;" /> </td>
                        </tr>
                        <tr>
                            <td colspan="6" align="right" style="padding: 10px;"><input type="button" name="btnSearch" id="btnSearch" value="Search" onclick="loadDirectory()" /></td>
                        </tr>
                        <tr align="right">
			    <td colspan="6" align="left" bgcolor="#424066" height="25px;" style="color: white;" ></td>
                        </tr>
                        <tr>
                            <td colspan="6" ><div style="overflow-y:scroll;height: 200px;"> <table id ="tblDirectory" style="overflow-x:   scroll;overflow-y: auto;"></table></div></td>
                        </tr>
                     </table>
               
          </div>
        </div>
        
        <div class="cleaner"></div>    
    </div>
    
    <div id="templatemo_main_bottom">
    </div>

</div> <!-- end of wrapper -->
</div>

<div id="templatemo_footer_wrapper">
	<div id="templatemo_footer">
        Copyright © 2018 <a href="#">NCESS</a> | Contact Us : adm@ncess.gov.in | Ext : 1669 
        
    </div>
</div>
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
      function loadDirectory()
      {
          $catID = document.getElementById('ddlCategory').value;
          $desigID = document.getElementById('ddlDesignation').value;
          $divID = document.getElementById('ddlDivision').value;
          $empName = document.getElementById('txtEmployee').value;
          $str = "";
          if($catID>0)
              $str = $str + " AND A.categoryID=" + $catID;
          if($desigID>0)
               $str = $str + " AND A.designationID=" + $desigID;
          if($divID>=0)
              $str = $str + " AND A.divisionID =" + $divID;
          if($empName != '')
              $str = $str + " AND employeeName like '%" + $empName + "%'";
          if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("tblDirectory").innerHTML = this.responseText ;
                loadEmployee();
            }
        };
        xmlhttp.open("GET","getDirectory.php?type=all&str="+$str);
        xmlhttp.send();
      }
   </script>
</body>
</html>