<?php 
    session_start();
    if(!isset($_SESSION['user']))
        echo "<script>document.location='index.php';</script>";
   if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        // last request was more than 30 minutes ago
        session_unset();     // unset $_SESSION variable for the run-time 
        session_destroy();   // destroy session data in storage
        echo "<script>document.location='index.php';</script>";
    }
    else {
        $_SESSION['LAST_ACTIVITY'] = time();   
   }
    $conn = require_once('databaseconnection.php'); 
    if(isset($_GET['search'])) 
        $search = iconv('utf-8', 'ascii//TRANSLIT',$_GET['search']);
    else {
        $search = '';
}
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

 

</head>
    <body <?php if($search == '') echo ' onload=loadPublications("")'; else echo ' onload=loadPublications("' . $search. '")'; ?>>

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
                                //($menuData['menuPage'] == substr($_SERVER['REQUEST_URI'],strpos($_SERVER['REQUEST_URI'],'/',2)+1))
                                echo '<li><a href="'.$menuData['menuPage'] . '" target="_parent">' . $menuData['menu'] . '</a></li>';
                            }
                            echo '</ul>'; 
                        }
                    ?>    	  	
            </div> 
           
           
            
            <div class="cleaner"></div>
        </div> <!-- end of sidebar -->
        
        <div id="templatemo_content">
            <div  style="padding-bottom:  10px;">
                <form method="post" action="">
                <table  class="tab">
                    <tr>
                        <td> Search By Year </td>
                        <td  style="padding-left: 20px;"> Search By Author </td>
                        <td style="padding-left: 20px;"> Search By Journal </td>
                    </tr>
                    <tr>
                        <td >
                            <select name="ddlYear" id="ddlYear"  style="width:100px;height:25px;">
                                <option value="-1">Select Year</option>
                                <?php 
                                    $curr_yr = date('Y');
                                    for($i=$curr_yr;$i>=1979;$i--) {
                                        echo "<option value='" . $i . "'>" . $i. "</option>";
                                    }
                                ?>
                               
                            </select>
                        </td>
                        <td style="padding-left: 20px;">
                            <input type="text" name="txtAuthor" id="txtAuthor" style="width:200px;" />
                        </td>
                        <td style="padding-left: 20px;" colspan="2">
                            <input type="text" name="txtJournal" id="txtJournal" style="width:220px" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"> Search By Research Area </td>
                        <td style="padding-left: 20px;"> Search By Keywords </td>
                    </tr>
                    <tr>
                        <td colspan="2" >
                            <select name="ddlArea" id="ddlArea" style="width:330px;height: 25px;">
                                <option value="" >Select Research Group</option>
                                <option value="Crustal Processes Group">Crustal Processes Group</option>
                                <option value="Coastal Processes Group">Coastal Processes Group</option>
                                <option value="Atmospheric Processes Group">Atmospheric Processes Group</option>
                                
                                <option value="Hydrological Processes Group">Hydrological Processes Group</option>
                            </select>
                        </td>
                        <td  style="padding-left: 20px;">
                            <input type="text" name="txtKey" id="txtKey" />
                        </td>
                       
                        <td>
                            <input type="button" name="btnSearch" id="btnSearch" value="Search" style="border-radius: 12px;width: 70px;" onclick="loadPublications('');" />
                        </td>
                        
                    </tr>
                    <tr>
                        <td colspan="4"> <input type="button" name="btnAdd" id="btnAdd" value="Add Publications" style="border-radius: 20px;cursor: pointer;" onclick="window.open('profile.php');" />
</td>
                    </tr>
                    <tr>
                        <td colspan="4" align="right" style="color: green;font-weight: bold;">
                            <?php 
                                $sql = "SELECT COUNT(*) as pub_total FROM research_publications WHERE approvalStatus='Approved'";
                                $result = mysqli_query($conn,$sql);
                                $row = mysqli_fetch_array($result);
                                echo 'No. of Research Publications : ' . $row['pub_total'];
                                        
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="padding-top: 10px;"> <img src ="images/templatemo_horizontal_divider.jpg" width="100%" /></td>
                    </tr>
                     <tr>
                        <td colspan="4">  <div id="divPub"  style="overflow-y: scroll;height: 550px;" /></td>
                    </tr>
                </table>
               
                </form>
               
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
        function loadPublications($str)
        {
            if($str == '') {
                if(document.getElementById('ddlYear').value > 0)
                    $str = $str + " WHERE A.year = '" + document.getElementById('ddlYear').value + "'";

                if(document.getElementById('txtAuthor').value != '')
                    $str = ($str == '')? ($str + " WHERE authors like '%" + document.getElementById('txtAuthor').value + "%'"):($str + " AND authors like '%" + document.getElementById('txtAuthor').value + "%'");
                if(document.getElementById('txtJournal').value != '')
                    $str = ($str == '')?($str + " WHERE journal like '%" + document.getElementById('txtJournal').value + "%'"):($str + " AND journal like '%" + document.getElementById('txtJournal').value + "%'");
                if(document.getElementById('ddlArea').value != '')
                    $str = ($str == '')?($str + " WHERE researchArea like '%" + document.getElementById('ddlArea').value + "%'"):($str + " AND researchArea like '%" + document.getElementById('ddlArea').value + "%'");
                if(document.getElementById('txtKey').value != '')
                    $str = ($str == '')?($str + " WHERE journal like '%" + document.getElementById('txtKey').value + "%'"):($str + " AND journal like '%" + document.getElementById('txtKey').value + "%'");
            }
            else {
                $str = " WHERE CONCAT_WS(' ',journal,authors,researchArea,year) LIKE '%" + $str + "%'"; 
            }
            if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            } 
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("divPub").innerHTML = this.responseText ;

                }
            };
            var uri = "getPublications.php?str="+ $str;
            var res = encodeURI(uri);
            xmlhttp.open("GET",res);
            xmlhttp.send();
        }
        
    </script>
    </body>
</html>