<?php

//This file contains a function which opens a connection to a database

function database_connect($dbname) {

	//Database connection
	$servername = "localhost";
	$username = "root";

	//read in database credentials
	$dbpassword = fopen(__DIR__ . "/../configs/config.txt", "r") or die("unable to open file");
	$dbpassword = fread($dbpassword, filesize(__DIR__ . "/../configs/config.txt"));


	// Create connection
	$conn = new mysqli($servername, $username, $dbpassword, $dbname);

	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}
	// DEBUG echo "<br><br>Connected successfully";

	return $conn;

}

?>