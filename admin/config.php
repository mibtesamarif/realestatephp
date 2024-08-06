<?php

	// $con = mysqli_connect("localhost","root","","realestatephp");
	// if (mysqli_connect_errno())
	// {
	// 	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	// }
	$server = "mysql:host=localhost;dbname=realestatephp";
	$user = "root";
	$pass = "";

	try {
		$pdo = new PDO($server, $user, $pass);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		echo "Connection failed: " . $e->getMessage();
		exit;
	}
	
?>
