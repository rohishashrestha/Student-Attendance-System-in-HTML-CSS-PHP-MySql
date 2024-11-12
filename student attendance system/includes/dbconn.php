<?php
	$host = "localhost";
	$user = "root";
	$pass = "";
	$db = "sas";
	
	// to connect database
	$conn = new mysqli($host, $user, $pass, $db); 
	if($conn->connect_error){
		echo "Failed To Connect to database:" . $conn->connect_error;
	}
?>
