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
                <h4>Students List</h4>
                <div class="view-student">
                    <div class="card">
                        <div class="card-header">
                            <h6>All Students in class</h6>
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


