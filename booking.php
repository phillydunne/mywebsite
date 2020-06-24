<?php
session_start();

require_once "database_connect_pdo.php";
require_once "database_connect.php";
require_once "club.php";
require_once "privilegeduser.php";
require_once "role.php";
require_once "auth_session.php";


//initalise
$page_permission="make_booking";

// AUTHENTICATION, AUTHORISATION & SESSION TIMEOUT 
auth_session($page_permission);


// NOW WE CAN EXECUTE PAGE LOGIC
// Declare empty variables
$output=$title="";
$dateError="";
$offset=0;

// Declare and initialise non-empty variables
$date=date("Y-m-d"); //Need to check out timezone.
$start_time=strtotime($date);
$end_time=$start_time+(60*60*24);
//echo $start_time . "<br>" . $end_time;

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

if (!isset($_GET["date"])) {
	//DEBUG echo "In GET not set.<br>";


	if ($_SERVER["REQUEST_METHOD"]=="POST") { // this will be TRUE if someone changes the date and clicks submit.
		if (!isset($_POST["date"])) {
			// Do nothing
		} elseif (empty($_POST["date"])) {
			$dateError = "date is required";
		} else { 
			$date=test_input($_POST["date"]);
			//DEBUG echo "In POST set and posted date assigned to date variable, value: " . $date . "<br>";
			$start_time=strtotime($date);
			$end_time=$start_time+(60*60*24); 
			// if(!checkdate(date("m",$_POST["date"]),date("d",$_POST["date"]),date("y",$_POST["date"]))) {
			// 	$dateError = "a valid date is required";
			// }
		}
	} else {
		// This should never really run anymore as you cant come to this page without posting from another page.
		// If there has not yet been a POST which posts to this page this will run.
		//DEBUG echo "In no POST posted, so lets set a date<br>";
		$date=date("Y-m-d"); //Set the date today. Need to check out timezone.
		$start_time=strtotime($date);
		$end_time=$start_time+(60*60*24); // Add a day's worth of seconds.
	}

} else {
	//DEBUG echo "In GET set and date stored in date variable.<br>";
	$date=$_GET["date"];
	$start_time=strtotime($date);
	$end_time=$start_time+(60*60*24);
	//may need to add in check date here
}

//determine offset in seconds - this will be applied to the start time and end time configured for the club.
$offset=$start_time-strtotime("today"); // This will be positive for future dates.
// DEBUG echo "The offset in days is: " . $offset/(60*60*24);

// Initiatlise database connection
$db_name="test";
$conn=database_connect_pdo($db_name);


if ($conn==FALSE) {
	die(); // The program will not run beyond this point.
}

//var_dump($conn);

$club_id=$_SESSION["club_id"];

try {
	// PART 1: Retrieve Club information and put it in a Club object
	$stmt=$conn->prepare("SELECT * FROM `clubs` WHERE `club_id`=:club_id");
	$stmt->bindParam(':club_id', $club_id);
	$stmt->execute();
	$stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Club');
	$myClub=$stmt->fetch(); // you cant fetchAll when using FETCH_CLASS. Even if it only returned one object, it will still return an array rather than an object.

	// PART 2: Retrieve court information and put it in an array
	$stmt2=$conn->prepare("SELECT * FROM `courts` WHERE `club_id`=:club_id");
	$stmt2->bindParam(':club_id', $club_id);
	$stmt2->execute();
	$myCourts=$stmt2->fetchAll(PDO::FETCH_ASSOC);



	// PART 3: Retrieve bookings and put them in an associative array
	//convert the booking window into human readable to query the database
	$start_time=date("Y-m-d H:i:s",$start_time);
	$end_time=date("Y-m-d H:i:s",$end_time);

	$stmt3=$conn->prepare("SELECT * FROM `bookings` WHERE `club_id`=:club_id AND `start_time`> :start_time AND `end_time` < :end_time");

	$stmt3->bindParam(':club_id', $club_id);
	$stmt3->bindParam(':start_time', $start_time);
	$stmt3->bindParam(':end_time', $end_time);
	$stmt3->execute();
	$myBookings=$stmt3->fetchAll(PDO::FETCH_ASSOC);


	//echo var_dump($myBookings);


	// PREP: Set any additional variables that are required
	$open_time=strtotime($myClub->open_time) + $offset; //converts to epoch time for manipulation
	$close_time=strtotime($myClub->close_time) + $offset;
	// $open_time=date("H:i",$open_time); // converts back to human readable time, NB: with todays date we will need to manipulate this to be another day's date if that is the day we are displaying.

	// echo $open_time . "<br>" . $close_time . "<br>" . $myClub->block_size;

	$booked=FALSE;


	// PART 4 : Print it all
	// NB: Ensure that the open time and close time are using values of epoch time that relate to the day that is being queried.
	ob_start();
	include __DIR__ . "/../../templates/booking.html.php";
	$output=ob_get_clean();

	$title="Bookings";
	include __DIR__ . "/../../templates/layout.html.php";


} catch (PDOException $e) {
	echo "Error retrieving data from the database: " . 
	$e->getMessage() . ' in ' .
	$e->getFile() . ' : ' . $e->getLine();
	die();
}


?>

<script>    
    if(typeof window.history.pushState == 'function') {
        window.history.pushState({}, "Hide", '<?php echo $_SERVER['PHP_SELF'];?>');
    }
</script>


