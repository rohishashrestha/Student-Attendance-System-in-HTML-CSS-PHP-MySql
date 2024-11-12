<?php
    include '../includes/dbconn.php';
    include '../includes/session.php';

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
                <h4>View Class Attendance </h4>
                <div class="view-attendance">
                    <div class="card">
                        <div class="card-header">
                            <h6>View Class Attendance</h6>
                        </div>
                        <div class="card-body">
                            <form method="post">
                                <div class="input-list">
                                    <label>Select Date</label><br>
                                    <input type="date" class="form-control" name="dateTaken" id="exampleInputFirstName" placeholder=""><br>
                                </div>
                                <div class="input-list">
                                    <button type="submit" name="view">View Attendance</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card" style="margin-top: 30px;">
                        <div class="card-header">
                            <h6>Class Attendance</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table" style="width:100%; text-align:left;">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Roll No</th>
                                        <th>Registration No</th>
                                        <th>Semester</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(isset($_POST['view'])){

                                            $dateTaken =  $_POST['dateTaken'];
                      
                                            $query = "SELECT tblattendance.Id,tblattendance.status,tblattendance.dateTimeTaken,tblclass.className,
                                            tblstudents.firstName,tblstudents.lastName,tblstudents.rollNo,tblstudents.regNo,tblstudents.semester 
                                            FROM tblattendance 
                                            INNER JOIN tblclass ON tblclass.Id = tblattendance.classId
                                            INNER JOIN tblstudents ON tblstudents.regNo = tblattendance.regNo
                                            where tblattendance.dateTimeTaken = '$dateTaken' and tblattendance.classId = '$_SESSION[classId]' 
                                            ORDER BY firstName ASC";
                                            $rs = $conn->query($query);
                                            $num = $rs->num_rows;
                                            $sn=0;
                                            $status="";
                                            if($num > 0)
                                            { 
                                              while ($rows = $rs->fetch_assoc())
                                                {
                                                    if($rows['status'] == '1'){$status = "Present"; $colour="#00FF00"; $textcolor="#fff";}
                                                    else{$status = "Absent";$colour="#FF0000";$textcolor="#fff";}
                                                   $sn = $sn + 1;
                                                  echo"
                                                    <tr>
                                                      <td>".$sn."</td>
                                                       <td>".$rows['firstName']."</td>
                                                      <td>".$rows['lastName']."</td>
                                                      <td>".$rows['rollNo']."</td>
                                                      <td>".$rows['regNo']."</td>
                                                      <td>".$rows['semester']."</td>
                                                      <td style='background-color:".$colour."; color:".$textcolor.";'>".$status."</td>
                                                      <td>".$rows['dateTimeTaken']."</td>
                                                    </tr>";
                                                }
                                            }
                                            else
                                            {
                                                 echo   
                                                 "<div class='alert' role='alert'>
                                                  No Record Found!
                                                  </div>";
                                            }
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


