<?php
    include 'includes/dbconn.php';
    $firstName = 'Admin';
    $emailAddress = 'admin@mail.com';
    $password = 'password123';
    $pass_1 = md5($password);

    $query = "INSERT INTO tbladmin(firstName,lastName,emailAddress,password) 
    VALUES('$firstName','','$emailAddress','$pass_1')";
?>
<!-- 482c811da5d5b4bc6d497ffa98491e38 -->