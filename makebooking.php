<?php
require_once "database_connect_pdo.php";

//variables
$user_id=2; // set to this for now - will replace with session variable


$db_name="test";
$conn=database_connect_pdo($db_name);

if ($conn==FALSE) {
	die(); // The program will not run beyond this point.
}

try {
	$stmt=$conn->prepare("INSERT INTO `bookings`(`club_id`, `court_id`, `start_time`, `end_time`, `user_id`, `time_created`) VALUES (:club_id, :court_id, :start_time, :end_time, :user_id, CURRENT_TIMESTAMP)");
	$stmt->bindParam(':club_id', $_POST['club_id']);
	$stmt->bindParam(':court_id', $_POST['court_id']);
	$stmt->bindParam(':start_time', $_POST['start_time']);
	$stmt->bindParam(':end_time', $_POST['end_time']);
	$stmt->bindParam(':user_id', $user_id);
	$stmt->execute();
	$conn = NULL;
	header("Location: booking.php?date=". date("Y-m-d",strtotime($_POST['start_time'])));


} catch (PDOException $e) {
	echo "Error retrieving data from the database: " . 
	$e->getMessage() . ' in ' .
	$e->getFile() . ' : ' . $e->getLine();
	die();
}


?>

