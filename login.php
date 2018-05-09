<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>NCESS Intranet Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="form" id="form">
        <form method="POST" action="">  
        <div class="field email">
            <div class="icon"></div>
            <input type="text" name="txtUser" id="email" class="input" placeholder="Username" autocomplete="off"/>
        </div>
        <div class="field password">
            <div class="icon"></div>
            <input class="input" id="password" name="txtPswd" type="password" placeholder="Password"/>
        </div>
        <input type="submit" class="button" name="btnLogin" id="submit" value='LOGIN' >
            <div class="side-top-bottom"></div>
            <div class="side-left-right"></div>
           <?php
    if(isset($_POST['btnLogin']))
    {
        $conn  = require_once('databaseconnection.php');
        $sql = "SELECT * FROM ncess_users WHERE username='" . $_POST['txtUser']. "' AND password='" . $_POST['txtPswd'] . "'";
            $result=mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)>0)
            {
                $_SESSION['user'] = $_POST['txtUser'];
                if($_SESSION['user'] != 'admin') {
                    $sql = "SELECT * FROM employee WHERE username = '" . $_SESSION['user'] . "'";
                    $result =mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result)>0)
                    {
                        $ro = mysqli_fetch_array($result);
                        $_SESSION['loggedUserID'] = $ro['employeeCode'];
                    }
                }
                else
                     $_SESSION['loggedUserID'] =0;
                $_SESSION['LAST_ACTIVITY'] = time();
                echo '<script>document.location="adminHome.php";</script>';
            }
            else { echo "<p style='color:red;'>Incorrect Username/Password</p>";}
    }
    ?>
        </form>
    </div>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
    <script  src="js/index.js"></script>
    
</body>
</html>
