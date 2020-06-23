<?php

// Database testing
$output=$title="";
include "database_connect_pdo.php";
$db_name="test";
$conn=database_connect_pdo($db_name);
// echo gettype($conn);
// echo var_dump($conn);
if ($conn==FALSE) {
	die(); // The program will not rung beyond this point.
}

//var_dump($conn);

$club_id='1'; // this would be taken from the user profile. can use it with quotes or without.

try {
	$stmt=$conn->prepare("SELECT * FROM `clubs`");
	
	// $stmt=$conn->prepare("SELECT * FROM `clubs` WHERE `club_id`=:club_id");
	// $stmt->bindParam(':club_id',$club_id);
	$stmt->execute();
	//echo "<br>Vardump of stmt: " . var_dump($stmt) . "<br>";

	//$result=$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$result=$stmt->fetchAll(PDO::FETCH_ASSOC); // The problem was with this statement. I was just setting the fetch mode, not actually fetching anything. I was not putting the result of teh execution into an array. The second issue was that i didnt read throught the array correctly. 

	// Timeslot testing
	$myTimeSecs=strtotime("08:00");
	//$myTimeSecs=1592812800; //This is probably 8am today (22nd June).
	$myTime=date("H:i",$myTimeSecs);

	
	ob_start();
	include __DIR__ . "/../../templates/sandbox.html.php";
	$output=ob_get_clean();

	$title="Database Query Test";
	include __DIR__ . "/../../templates/layout.html.php";


} catch (PDOException $e) {
	echo "Error retrieving data from the database: " . 
	$e->getMessage() . ' in ' .
	$e->getFile() . ' : ' . $e->getLine();
	die();
}






?>

 <!-- Javascript timer testing: this should really be in a .html.php file -->

<!-- <p>A script on this page runs this clock:</p>
<p id="demo"></p>

<script>
	var myVar = setInterval(myTimer,1000);

	function myTimer() {
		var d = new Date();
		document.getElementById("demo").innerHTML = d.toLocaleTimeString();
	}
	
	
</script>
 -->


