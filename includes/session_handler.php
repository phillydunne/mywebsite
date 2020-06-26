<?php

// require this file at the start of every page a user might see.

// start session / pick up session variables if already started.
//session_start();


// check if the session timeout has overrun
$inactive_limit = 600; // ?seconds
$formatted_time = date('Y-m-d H:i:s', $_SESSION["timeout"]);


if (isset($_SESSION["timeout"])) {
    
    //echo = "<p>The value of your timeout variable is: " . $formatted_time . "</p>";
    //echo "<p>Session id: " . session_id() . "</p>";

    $elapsed_time = time() - $_SESSION["timeout"];
    
    if ($elapsed_time > $inactive_limit) {
        PrivilegedUser::unAuthenticateUser($_SESSION["email"]);
        $output ="<p>Your session has expired</p>";
        header("Location: logout.php");
        die();
    
    } else {
    
        $time_remaining = $inactive_limit - $elapsed_time;
        // $output = "<p>You had " . $time_remaining . " remaining seconds left in your session.</p>";
        
        $_SESSION["timeout"]=time();

        $elapsed_time = time() - $_SESSION["timeout"];
        $time_remaining_updated = $inactive_limit - $elapsed_time;
        
        // $output = $output . "<p>Your session timeout has been updated, you now have " . $time_remaining_updated . " remaining seconds in this session.</p>";
    }
} else {
    $output = "<p>A timeout session variable is not set, please login.</p>";
    header("Location: logout.php");
    die();

    // set the timeout session
    //$_SESSION["timeout"]=time();
}


?>