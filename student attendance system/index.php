<?php
    include 'includes/dbconn.php';
    session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<title>SAMS dashboard</title>
	<link href="images/student.png" rel="icon">
	<!----css3---->
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/globalstyle.css">
	<!--google fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
	<!--google material icon-->
	<link href="https://fonts.googleapis.com/css2?family=Material+Icons"rel="stylesheet">
</head>

<body>
<div class="login">
    <div class="container">
        <div class="login-body">
            <div class="card">
                <div class="login-form">
                    <h5>STUDENT ATTENDANCE SYSTEM</h5>
                        <div class="text-center">
                            <img src="images/student.png" style="width:80px;height:80px">
                            
                            <h1>Login Panel</h1>
                        </div>
                        <form class="user" method="Post" action="">
                            <select name="userType" class="form-control" required>
                                <option value="">-- Select User Roles --</option>
                                <option value="Administrator">Administrator</option>
                                <option value="Lecturer">Lecturer</option>
                            </select><br>
                            <input type="text" name="username" placeholder="Enter Email Address" class="form-control" required><br>
                            <input type="password" name="password" placeholder="Enter Password" class="form-control" required><br>
                            <button type="submit" class="btn" name="login">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    if(isset($_POST['login'])){
        $userType = $_POST['userType'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password = md5($password);

        if($userType == "Administrator"){
            $query = "SELECT * FROM tbladmin WHERE emailAddress = '$username' AND password = '$password'";
            $rs = $conn->query($query);
            $num = $rs->num_rows;
            $rows = $rs->fetch_assoc();

            if($num > 0){
                $_SESSION['userId'] = $rows['Id'];
                $_SESSION['firstName'] = $rows['firstName'];
                $_SESSION['lastName'] = $rows['lastName'];
                $_SESSION['emailAddress'] = $rows['emailAddress'];

                echo "<script type = \"text/javascript\">
                    window.location = (\"Admin/index.php\")
                    </script>";
            }
            else{
                echo "<div class='alert' role='alert'>
                Invalid Username/Password!
                </div>";
            }
        }
        elseif($userType == "Lecturer"){
            $query = "SELECT * FROM tblclassteacher WHERE emailAddress = '$username' AND password = '$password'";
            $rs = $conn->query($query);
            $num = $rs->num_rows;
            $rows = $rs->fetch_assoc();
      
            if($num > 0){
      
              $_SESSION['userId'] = $rows['Id'];
              $_SESSION['firstName'] = $rows['firstName'];
              $_SESSION['lastName'] = $rows['lastName'];
              $_SESSION['emailAddress'] = $rows['emailAddress'];
              $_SESSION['classId'] = $rows['classId'];
      
              echo "<script type = \"text/javascript\">
              window.location = (\"teacher/index.php\")
              </script>";
            }
            else{
              echo "<div class='alert alert-danger' role='alert'>
              Invalid Username/Password!
              </div>";
            }
        }
        else{
            echo "<div class='' role='alert'>
            Invalid Username/Password!
            </div>";
        }
    }
?>

<script src="js/jquery.js"></script>
</body>
</html>


