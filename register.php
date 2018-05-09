 <?php
    $conn = require_once('databaseconnection.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Ncess Intranet</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-dark">
  <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">Register an Account</div>
      <div class="card-body">
          <form method="post" action="" onsubmit="validatForm(event)">
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="txtEmpCode">Employee Code</label>
                <input class="form-control" id="txtEmpCode" name="txtEmpCode" type="text" placeholder="Enter Employee Code" required>
              </div>
              <div class="col-md-6">
                <label for="txtUser">User name</label>
                <input class="form-control" name="txtUser" id="txtUser" type="text" placeholder="Enter User name" onchange="checkAvailability()" required><label id="lblUser"  />
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="txtEmail">Email address</label>
            <input class="form-control" name="txtEmail" id="txtEmail" type="email" placeholder="Enter email" onchange="validateEmail()" required>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="txtPswd">Password</label>
                <input class="form-control" name="txtPswd" id="txtPswd" type="password" placeholder="Password" onchange="validatePassword()" required>
              </div>
              <div class="col-md-6">
                <label for="txtRePswd">Confirm password</label>
                <input class="form-control" name="txtRePswd" id="txtRePswd" type="password" placeholder="Confirm password" onchange="validatePassword()" required>
              </div>
            </div>
          </div>
            <input type="submit" name="btnRegister" class="btn btn-primary btn-block" value="Register" />
            <?php
                if(isset($_POST['btnRegister']))
                {
                    $sql = "SELECT * FROM employee WHERE employeeCode='" . $_POST['txtEmpCode'] . "'";
                    $result = mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result) == 0 )
                    {
                        echo "<span style='color:red;'>Employee Code doest not exist!Please Contact System Administrator!</span>";
                        exit();
                    }
                    else {
                        $row = mysqli_fetch_array($result);
                        if($row['username']!='') {
                            echo "<span style='color:red;'>Already registered for this Employee code!Please Contact System Administrator!</span>";
                            exit();
                        }
                    }
                    $sql="INSERT INTO ncess_users VALUES('" . $_POST['txtUser'] . "','" . $_POST['txtPswd'] . "','Employee',1)";
                    $result = mysqli_query($conn,$sql);
                    if($result){
                        $sql = "UPDATE employee SET username='" . $_POST['txtUser'] . "', emailID='" . $_POST['txtEmail'] . "' WHERE employeeCode=" . $_POST['txtEmpCode'];
                        $result = mysqli_query($conn,$sql);                    

                        if($result) 
                            echo '<script>alert("Registration successful!Please Login!");document.location="index.php";</script>';
                        else 
                            echo "<span style='color:red;'>Registration failed!</span>";
                    }
                    else 
                            echo "<span style='color:red;'>Registration failed!</span>";
                }
            ?>
        </form>
        <div class="text-center">
          
        </div>
      </div>
    </div>
  </div>
    <script type="text/javascript">
        function checkAvailability() {
            $user = document.getElementById('txtUser').value;
            if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("lblUser").innerHTML = this.responseText;
                    
                }
            };
            xmlhttp.open("GET","checkUserAvailability.php?user="+$user);
            xmlhttp.send();
        }
        function validateEmail()
        {
            var x = document.getElementById('txtEmail').value;
            var atpos = x.indexOf("@");
            var dotpos = x.lastIndexOf(".");
            if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
                alert("Not a valid e-mail address");
                return false;
            }
            else
                return true;
        }
        function validatePassword()
        {
            $pswd = document.getElementById('txtPswd').value;
            $repswd = document.getElementById('txtRePswd').value;
            if($pswd != '' && $repswd != '')
            {
                if($pswd == $repswd)
                    return true;
                else {
                   alert("Passwords do not match!");
                   return false; 
               }
            }
        }
        function validatForm(e) {
            if(document.getElementById("lblUser").innerHTML!='')
                e.preventDefault();
            if(!validateEmail())
               e.preventDefault();
            if(!validatePassword())
                e.preventDefault();
        }
        
    </script>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>
