<?php

//This file contains a function which opens a connection to a database

function database_connect_pdo($dbname) {

	//Database connection
	$servername = "localhost";
	$dbusername = "root";

	//read in database credentials
	$dbpassword = fopen(__DIR__ . "/../configs/config.txt", "r") or die("unable to open file");
	$dbpassword = fread($dbpassword, filesize(__DIR__ . "/../configs/config.txt"));


	// Create connection
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $dbusername, $dbpassword);
			$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			return $conn; // if you move this into try the rest of the code wont be executed, so moving it all up.

	} catch (PDOException $e) {
		echo "Unable to connect to the database: " . 
		$e->getMessage() . ' in ' .
		$e->getFile() . ' : ' . $e->getLine();
		return FALSE;
	}





}

?>