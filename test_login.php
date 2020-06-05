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

// set test parameters
$set_permission = "view_dashboard";

//read in database credentials
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
        echo "<br> user " . $u->username . " has this permission: " . $set_permission;
    } else {
        echo "<br> user " . $u->username . " does not have permission " . $set_permission;
    }
} else {
    echo "The user object instance is not an object, it is likely a bool";
}

?>