<?php
session_start();

require_once "database_connect.php";
require_once "privilegeduser.php";
require_once "role.php";
require_once "auth_session.php";

//initalise
$title=$output="";
$page_permission="make_booking";

// AUTHENTICATION, AUTHORISATION & SESSION TIMEOUT 
auth_session($page_permission);

// NOW WE CAN EXECUTE PAGE LOGIC
$user = PrivilegedUser::getByUsername($_SESSION['email']);

ob_start();
include __DIR__ . "/../../templates/dashboard.html.php";
$output = $output . ob_get_clean();

$title="Dashboard";
include __DIR__ . "/../../templates/layout.html.php";

?>