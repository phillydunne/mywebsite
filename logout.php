<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<h1>Logout Page</h1>

<?php
session_start();
require_once "database_connect.php";
require_once "privilegeduser.php";


//initialise variables
$title=$output="";

if (isset($_SESSION["email"])) {
	if (PrivilegedUser::unAuthenticateUser($_SESSION["email"]) && session_destroy()) {
		echo "<p>Logout completed successfully. Have a nice day :)<p>";
	} else {
		echo "<p>WARNING: to logger, this user has not been logged out successfully - highest priority.</p>";
	}
} else {

}



?>

<br>Click here to proceed to the 
<a href="Login.php"> Login Page</a>

<?php

$title = "Logout";
include __DIR__ . "/../../templates/layout_alt.html.php";

?>