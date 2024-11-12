<?php
    include '../includes/dbconn.php';
    include '../includes/session.php';

    $query=mysqli_query($conn,"select * from tblclassteacher 
    inner join tblclass ON tblclass.Id = tblclassteacher.classId
    where classId = '$_SESSION[classId]'");
    $rwws=mysqli_fetch_array($query);
    $class = $rwws['className'];

    $dateTaken = date("Y-m-d");
        
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
                <h4>Dashboard</h4>
                <div class="card-display">
                    <div class="dcard d1">
                        <h5>Students</h5>
                        <ul class="dlist">
                            <li class="dleft">
                                <?php
                                    $query = mysqli_query($conn,"SELECT * from tblstudents");                       
                                    $students = mysqli_num_rows($query);

                                    echo $students;
                                ?>
                            </li>
                            <li class="dright text-right"><i class="material-icons">supervisor_account</i></li>
                        </ul>
                    </div>
                    <div class="dcard d2">
                        <h5>Subject</h5>
                        <ul class="dlist">
                            <li class="dleft" style="font-size: 16px; font-weight: 500;">
                                <?php 
                                    echo $class; 
                                ?>
                            </li>
                        </ul>
                    </div>
                    <div class="dcard d3">
                        <h5>Semester</h5>
                        <ul class="dlist">
                            <li class="dleft">4<sup>th</sup> Semester </li>
                        </ul>
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


