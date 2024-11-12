<?php
    include '../includes/dbconn.php';
    include '../includes/session.php';

    $statusMsg = '';

//-- to-save --//
if(isset($_POST['save'])){
    
    $className=$_POST['className'];
   
    $query=mysqli_query($conn,"select * from tblclass where className ='$className'");
    $ret=mysqli_fetch_array($query);

    if($ret > 0){ 

        $statusMsg = "<div class='alert'>This Class Already Exists!</div>";
    }
    else{

        $query=mysqli_query($conn,"insert into tblclass(className) value('$className')");

        if ($query) {
            
            $statusMsg = "<div>Created Successfully!</div>";
        }
        else
        {
            $statusMsg = "<div>An error Occurred!</div>";
        }
    }
}
// --- to-delete ----//    

    if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "delete")
    {
        $Id= $_GET['Id'];

        $query = mysqli_query($conn,"DELETE FROM tblclass WHERE Id='$Id'");

        if ($query == TRUE) {

                echo "<script type = \"text/javascript\">
                window.location = (\"createClass.php\")
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
                <h4>Manage Class</h4>
                <div class="create-class">
                    <div class="card">
                        <div class="card-header">
                            <h6>Create Class</h6>
                            <?php echo $statusMsg; ?>  
                        </div>
                        <div class="card-body">
                            <form method="post">
                                <label>Class Name</label><br>
                                <input type="text" class="form-control" name="className" placeholder="Class Name" required><br>
                                <button type="submit" name="save">Save</button>
                            </form>
                        </div>
                    </div>
                    <div class="card" style="margin-top: 30px;">
                        <div class="card-header">
                            <h6>All Classes</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table" style="width:100%; text-align:left;">
                                <thead class="thead-light">
                                    <tr>
                                        <th>S.No</th>
                                        <th>Class Name</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $query = "SELECT * FROM tblclass ORDER BY className ASC";
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
                                                    <td>".$rows['className']."</td>
                                                    <td><a href='?action=delete&Id=".$rows['Id']."'><i class='material-icons text-danger'>delete</i></a></td>
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


