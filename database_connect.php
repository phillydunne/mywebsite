<?php

//This file contains a function which opens a connection to a database

function database_connect($dbname) {

	//Database connection
	$servername = "localhost";
	$username = "root";

	//read in database credentials
	$dbpassword = fopen("config.txt", "r") or die("unable to open file");
	$dbpassword = fread($dbpassword, filesize("config.txt"));


	// Create connection
	$conn = new mysqli($servername, $username, $dbpassword, $dbname);

	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}
	echo "<br><br>Connected successfully";

	return $conn;

}

?>