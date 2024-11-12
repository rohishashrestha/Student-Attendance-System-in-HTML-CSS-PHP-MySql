<?php
    include '../includes/dbconn.php';
    include '../includes/session.php';

    $statusMsg='';

    // to save
    if(isset($_POST['save'])){
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $rollNo = $_POST['rollNo'];
        $regNo = $_POST['regNo'];
        $semester = 'IV';
        $dateCreated = date("Y-m-d");

        $query = mysqli_query($conn, "select * from tblstudents where regNo = '$regNo'");
        $ret = mysqli_fetch_array($query);


        if($ret > 0){
            $statusMsg = "<div>This Student Already Exists!</div>";
        }
        else {
            $query = mysqli_query($conn, "insert into tblstudents(firstName,lastName,rollNo,regNo,semester,dateCreated) 
            value('$firstName','$lastName','$rollNo','$regNo','$semester','$dateCreated')");

            if($query){
                $statusMsg = "<div>Created Successfully!</div>";
            }
            else {
                $statusMsg = "<div>An Error Occured!</div>";

            }
        }
    }

    // to delete
    if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "delete")
    {
        $Id= $_GET['Id'];

        $query = mysqli_query($conn,"DELETE FROM tblstudents WHERE Id='$Id'");

        if ($query == TRUE) {
            echo "<script type = \"text/javascript\">
            window.location = (\"createStudent.php\")
            </script>";  
        }
        else{

            $statusMsg = "<div>An error Occurred!</div>"; 
        }
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<title>SAMS dashboard</title>
	<link href="../images/student.png" rel="icon">
	<!----css3---->
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="../css/globalstyle.css">
	<!--google fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>
<section class="dashboard">
    <div class="dashboard-body">
        <div class="body-left">
            <?php include 'include/sidebar.php';?>
        </div>

        <div class="body-right">
            <?php include 'include/topbar.php'; ?>

            <div class="main-content">
                <h4>Manage Students</h4>
                <div class="create-student">
                    <div class="card">
                        <div class="card-header">
                            <h6>Create Students</h6>
                             <?php echo $statusMsg; ?> 
                        </div>
                        <div class="card-body">
                            <form method="post">
                                <div class="input-list">
                                    <label>First Name</label><br>
                                    <input type="text" class="form-control" name="firstName" placeholder="First Name" required><br>
                                </div>
                                <div class="input-list">
                                    <label>Last Name</label><br>
                                    <input type="text" class="form-control" name="lastName" placeholder="Last Name" required><br>
                                </div>
                                <div class="input-list">
                                    <label>Roll Number</label><br>
                                    <input type="text" class="form-control" name="rollNo" placeholder="Roll Number" maxlength="6" required><br>
                                </div>
                                <div class="input-list">
                                    <label>Registration Number</label><br>
                                    <input type="text" class="form-control" name="regNo" placeholder="Registration Number" pattern="[0-9]{3}-[0-9]{1}-[0-9]{1}-[0-9]{5}-[0-9]{4}" required><br>
                                </div>
                                <div class="input-list">
                                    <button type="submit" name="save">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card" style="margin-top: 30px;">
                        <div class="card-header">
                            <h6>All Students</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table" style="width:100%; text-align:left; padding: 0 5px;">
                                <thead class="thead-light">
                                <tr>
                                    <th>S.No</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Roll No</th>
                                    <th>Registration No</th>
                                    <th>Semester</th>
                                    <th>Date Created</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $query = "SELECT * FROM tblstudents ORDER BY firstName ASC";
                                    $rs = $conn->query($query);
                                    $num = $rs->num_rows;
                                    $sn=0;
                                    if($num > 0)
                                    { 
                                        while ($rows = $rs->fetch_assoc())
                                        {
                                            $sn = $sn + 1;
                                            echo"
                                            <tr>
                                                <td>".$sn."</td>
                                                <td>".$rows['firstName']."</td>
                                                <td>".$rows['lastName']."</td>
                                                <td>".$rows['rollNo']."</td>
                                                <td>".$rows['regNo']."</td>
                                                <td>".$rows['semester']."</td>
                                                <td>".$rows['dateCreated']."</td>
                                                <td><a href='?action=delete&Id=".$rows['Id']."'><i class='material-icons text-danger'>delete</i></a></td>
                                            </tr>";
                                        }
                                    }
                                    else
                                    {
                                        echo   
                                        "<div class='alert alert-danger' role='alert'>
                                            No Record Found!
                                            </div>";
                                    }
                                      
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'include/footer.php'; ?>
        </div>
    </div>
</section>

<script src="../js/jquery.js"></script>
</body>
</html>


