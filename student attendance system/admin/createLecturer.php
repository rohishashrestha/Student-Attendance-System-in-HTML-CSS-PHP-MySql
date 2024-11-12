<?php
    include '../includes/dbconn.php';
    include '../includes/session.php';

    $statusMsg = '';

    // to save
    if(isset($_POST['save'])){
        $firstName=$_POST['firstName'];
        $lastName=$_POST['lastName'];
        $emailAddress=$_POST['emailAddress'];
        $classId=$_POST['classId'];
        $dateCreated = date("Y-m-d");
       
        $query=mysqli_query($conn,"select * from tblclassteacher where emailAddress ='$emailAddress'");
        $ret=mysqli_fetch_array($query);
    
        $pass = "pass123";
        $pass_2 = md5($pass);
    
        if($ret > 0){ 
            $statusMsg = "<div>This Lecturer Already Exists!</div>";
        }
        else{
            $query=mysqli_query($conn,"INSERT into tblclassteacher(firstName,lastName,emailAddress,password,dateCreated,classId) 
            value('$firstName','$lastName','$emailAddress','$pass_2','$dateCreated','$classId')");
            if ($query) {
                if($query) {
                    $statusMsg = "<div>Created Successfully!</div>";
                }
                else{
                    $statusMsg = "<div>An error Occurred!</div>";
                }
            }
        }
    }
    // to delete
    if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "delete")
    {
        $Id= $_GET['Id'];

        $query = mysqli_query($conn,"DELETE FROM tblclassteacher WHERE Id='$Id'");

        if ($query == TRUE) {
            echo "<script type = \"text/javascript\">
            window.location = (\"createLecturer.php\")
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
                <h4>Manage Lecturer</h4>
                <div class="create-lecturer">
                    <div class="card">
                        <div class="card-header">
                            <h6>Create Class Lecturer</h6>
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
                                    <label>Email Address</label><br>
                                    <input type="email" class="form-control" name="emailAddress" placeholder="Email Address" required><br>
                                </div>
                                <div class="input-list">
                                    <label>Select Class</label><br>
                                    <?php
                                        $qry= "SELECT * FROM tblclass ";
                                        $result = $conn->query($qry);
                                        $num = $result->num_rows;		
                                        if ($num > 0){
                                            echo ' <select required name="classId" onchange="classArmDropdown(this.value)" class="form-control">';
                                            echo'<option value="">--Select Class--</option>';
                                            while ($rows = $result->fetch_assoc()){
                                            echo'<option value="'.$rows['Id'].'" >'.$rows['className'].'</option>';
                                                }
                                                echo '</select>';
                                        }
                                    ?> 
                                </div>
                                <div class="input-list">
                                    <button type="submit" name="save">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card" style="margin-top: 30px;">
                        <div class="card-header">
                            <h6>All Lecturers</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table" style="width:100%; text-align:left; padding: 0 5px;">
                                <thead class="thead-light">
                                <tr>
                                    <th>S.No</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email Address</th>
                                    <th>Class</th>
                                    <th>Date Created</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $query = "SELECT * FROM tblclassteacher ";
                                    $query1 = "SELECT tblclass.className FROM tblclassteacher
                                    INNER JOIN tblclass ON tblclass.Id = tblclassteacher.classId";
                                    $rs = $conn->query($query);
                                    $bs = $conn->query($query1);
                                    $num = $rs->num_rows;
                                    $sn=0;
                                    if($num > 0)
                                    { 
                                        while ($rows = $rs->fetch_assoc())
                                        {
                                            $row = $bs->fetch_assoc();
                                            $sn = $sn + 1;
                                            echo"
                                            <tr>
                                                <td>".$sn."</td>
                                                <td>".$rows['firstName']."</td>
                                                <td>".$rows['lastName']."</td>
                                                <td>".$rows['emailAddress']."</td>
                                                <td>".$row['className']."</td>
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


