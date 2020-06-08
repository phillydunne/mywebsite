<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php
require_once "Role.php";
require_once "PrivilegedUser.php";

// connect to database...
// ...
/*include 'database_connect.php';
$dbname="test";
$conn = database_connect($dbname);*/


session_start();

// Session testing
print_r("session : " . session_id() . "<br>");

//session_regenerate_id();

//print_r("session 2: " . session_id() . "<br>");

$_SESSION["timeout"]=time();

$inactive_time = 600; // ?seconds 
if (isset($_SESSION["timeout"])) {
	$time_delta = time() - $_SESSION["timeout"];
	if ($time_delta > $inactive_time) {
		session_destroy();
		header("Location: / logout.php");
	}
}

// Session testing part 2 - how many times have you been logged in
if (!isset($_SESSION["visits"])) {
	$_SESSION["visits"] = 1;
} else {
	echo "<br><br>you have visited this page " . $_SESSION["visits"]++ . " times!<br><br>";
}

//session_unset();


//$_SESSION["loggedin"]=

// set test parameters
$set_permission = "view_dashboard";

//read in user credentials
$set_email = fopen("test_config.txt", "r") or die("unable to open test_config.txt");
$set_email = fread($set_email, filesize("test_config.txt"));


echo "<h1>Testing the Role and Priviliged User Classes</h1>";

// Returns an object of type privileged user
$u = PrivilegedUser::getByUsername("$set_email");

/*if (isset($_SESSION["loggedin"])) {
    //$u = PrivilegedUser::getByUsername($_SESSION["loggedin"]);
    $u = PrivilegedUser::getByUsername($set_email);
}*/

// DEBUG var_dump($u);
// DEBUG echo "The variable u is of type (we want it to be an object): " . gettype($u);
if(gettype($u)=="object") {
    if ($u->hasPrivilege($set_permission)) {
        echo "<br> user " . $u->email . " has this permission: " . $set_permission;
    } else {
        echo "<br> user " . $u->email . " does not have permission " . $set_permission;
    }
} else {
    echo "The user object instance is not an object, it is likely a bool - the getByUsername function call returned a bool";
}

?>