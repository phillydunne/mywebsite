<?php

/*This file contains a function which opens a connection to a database, submits data, and closes the connection
	The method of connection is TBC - PDO or OOP with MariaDB
*/

function submit_form($name, $email, $gender, $comment, $website) {
	echo '<br><br>' . "Hi, my name is " . $name . '<br>';
	echo "please contact me on " . $email . '<br>';
	echo "other details: " . $gender . " " . $website . " " . $comment . '<br>';


	//Database connection
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "test";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}
	echo "Connected successfully";

	//$sql = "INSERT INTO person (name, gender, email) VALUES (`Mark Jones`,  `Male` , `m.jones@gmail.com`)";
	$sql = "INSERT INTO `person` (`name`, `gender`, `email`) VALUES ('$name', '$gender', '$email')";

	if($conn->query($sql) === TRUE) {
		echo "<br>New record created successfully!<br>";
		} else {
		echo "<br>Error: " . $conn->error;
		}
	

//function end
}

/*now lets replace this simple function with a submission to the person table of the test database
	then we can add in a check functionality to reject the submission if the email already exists on the table





*/

?>