<?php

// require this file at the start of every page a user might see.

// start session / pick up session variables if already started.
session_start();

// set the timeout session
$_SESSION["timeout"]=time();
$_SESSION["email"]=time();


// check if the session timeout has overrun
$inactive_time = 600; // ?seconds 
if (isset($_SESSION["timeout"])) {
    $time_delta = time() - $_SESSION["timeout"];
    if ($time_delta > $inactive_time) {
        session_destroy();
        header("Location: / logout.php");
    }
}


?>