<?php
session_start();

require_once __DIR__ . "/../includes/database_connect.php";
require_once __DIR__ . "/../includes/database_connect_pdo.php";
require_once __DIR__ . "/../includes/privilegeduser.php";
require_once __DIR__ . "/../includes/role.php";
require_once __DIR__ . "/../includes/auth_session.php";

//initalise
$title=$output="";
$page_permission="make_booking";
$emptyFlag=0;

// AUTHENTICATION, AUTHORISATION & SESSION TIMEOUT 
auth_session($page_permission);

// NOW WE CAN EXECUTE PAGE LOGIC
$user = PrivilegedUser::getByUsername($_SESSION['email']);
//var_dump($user);

// get the bookings for the user
$db_name="test";
$conn=database_connect_pdo($db_name);
$stmt=$conn->prepare("SELECT t1.booking_id, t1.start_time, t1.end_time, t1.club_id, t1.court_id, t2.club_name FROM bookings as t1 JOIN clubs as t2 ON t1.club_id = t2.club_id WHERE t1.user_id = :user_id AND t1.start_time > :start_time AND t1.cancelled=0 ORDER BY t1.start_time ASC");
$current_time=date("Y-m-d H:i:s");
$stmt->bindParam(':user_id',$_SESSION["user_id"]);
$stmt->bindParam(':start_time',$current_time);
$stmt->execute();
$myBookings=$stmt->fetchAll(PDO::FETCH_ASSOC);
if (empty($myBookings)) {
	$emptyFlag=1;
}

ob_start();
include __DIR__ . "/../templates/dashboard.html.php";
$output = $output . ob_get_clean();

$title="Dashboard";
include __DIR__ . "/../templates/layout.html.php";

?>