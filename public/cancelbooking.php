<?php
session_start();
require_once __DIR__ . "/../../includes/database_connect_pdo.php";

//variables


$db_name="test";
$conn=database_connect_pdo($db_name);

if ($conn==FALSE) {
	die(); // The program will not run beyond this point.
}

try {
	$stmt=$conn->prepare("UPDATE `bookings` SET `cancelled`=1 WHERE `booking_id`=:booking_id");
	$stmt->bindParam(':booking_id', $_POST['booking_id']);
	$stmt->execute();
	$conn = NULL;
	
	if ($_POST["source_page"]=="booking") {
		header("Location: booking.php?date=". date("Y-m-d",strtotime($_POST['start_time'])));
	} else {
		header("Location: " . $_POST["source_page"] . ".php");
	}
	
	// left out the die() for now as it might interfere with the try catch.

} catch (PDOException $e) {
	echo "Error retrieving data from the database: " . 
	$e->getMessage() . ' in ' .
	$e->getFile() . ' : ' . $e->getLine();
	die();
}


?>

