<?php
    include '../includes/dbconn.php';
    include '../includes/session.php';

    $statusMsg='';

    $dateTaken = date("Y-m-d");
    $qurty=mysqli_query($conn,"select * from tblattendance  where classId = '$_SESSION[classId]' and dateTimeTaken='$dateTaken'");
    $count = mysqli_num_rows($qurty);

    if($count == 0){ //if Record does not exsit, insert the new record

        //insert the students record into the attendance table on page load
        $qus= "SELECT * FROM tblstudents";
        $rs = $conn->query($qus);
        while ($ros = $rs->fetch_assoc())
        {
            $qquery=mysqli_query($conn,"insert into tblattendance(regNo,classId,status,dateTimeTaken) 
            value('$ros[regNo]','$_SESSION[classId]','0','$dateTaken')");

        }
    }

// to save
    if(isset($_POST['save'])){
        $regNo=$_POST['regNo'];
        $check=$_POST['check'];
        $N = count($regNo);
        $status = "";
    
    
    //check if the attendance has not been taken i.e if no record has a status of 1
    $query=mysqli_query($conn,"select * from tblattendance  where classId = '$_SESSION[classId]' and dateTimeTaken='$dateTaken' and status = '1'");
    $count = mysqli_num_rows($query);
    
    if($count > 0){
        $statusMsg = "<div>Attendance has been taken for today!</div>";
    }
    else //update the status to 1 for the checkboxes checked
        {
            for($i = 0; $i < $N; $i++)
            {
                $regNo[$i]; 
                    if(isset($check[$i])) //the checked checkboxes
                    {
                        $qquery=mysqli_query($conn,"update tblattendance set status='1' where regNo = '$check[$i]'");
                        if ($qquery) {
    
                            $statusMsg = "<div>Attendance Taken Successfully!</div>";
                        }
                        else
                        {
                            $statusMsg = "<div>An error Occurred!</div>";
                        }
                      
                    }
            }
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
	<link href="../images/attendance.png" rel="icon">
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
                <h4>Take Attendance</h4>
                <div class="attendance">
                    <form method="post">
                        <div class="row">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>All Student in Class(Today's Date : <?php echo $todaysDate = date("Y-m-d");?>)</h6>
                                        <?php echo $statusMsg; ?>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table" style="width:100%; text-align:left; padding: 0 5px;">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Roll No</th>
                                                    <th>Registration No</th>
                                                    <th>Semester</th>
                                                    <th>Check</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php          
                                                $query = "SELECT * FROM tblstudents ORDER BY firstName ASC";
                                                $rs = $conn->query($query);
                                                $num = $rs->num_rows;
                                                $sn=0;
                                                $status="";
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
                                                        <td><input name='check[]' type='checkbox' value=".$rows['regNo']." class='form-control'></td>
                                                        </tr>";
                                                        echo "<input name='regNo[]' value=".$rows['regNo']." type='hidden' class='form-control'>";
                                                    }
                                                }
                                                else
                                                {
                                                    echo   
                                                    "<div class='alert' role='alert'>
                                                    No Record Found!
                                                    </div>";
                                                }
                                            
                                            ?>
                                            </tbody>
                                        </table>
                                        <br>
                                        <button type="submit" name="save">Take Attendance</button>
                                    </div>    
                                </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php include 'include/footer.php'; ?>
        </div>
    </div>
</section>

<script src="../js/jquery.js"></script>
</body>
</html>


