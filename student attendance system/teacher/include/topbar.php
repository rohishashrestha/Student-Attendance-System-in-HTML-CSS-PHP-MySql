<?php
    $query = "SELECT * FROM tblclassteacher WHERE Id = ".$_SESSION['userId']."";
    $rs = $conn->query($query);
    $num = $rs->num_rows;
    $rows = $rs->fetch_assoc();
    $fullName = $rows['firstName']." ".$rows['lastName'];
?>
<div class="topbar">
    <nav class="navbar">
        <div class="dropdown">
            <div class="profile">
                <a href="#">
                    <?php echo $fullName;?>
                    <img src="images/user.png" style="width:40px; border-radius:50%;"/>
                </a>
            </div>
            <div class="dropdown-content">
                <a href="logout.php">
                    <span class="material-icons">logout</span>
                     Logout 
                </a>
            </div>
        </div>
    </nav>
</div>