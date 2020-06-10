<?php

// require this file at the start of every page a user might see.

// start session / pick up session variables if already started.
//session_start();


// check if the session timeout has overrun
$inactive_limit = 600; // ?seconds
$formatted_time = date('Y-m-d H:i:s', $_SESSION["timeout"]);


if (isset($_SESSION["timeout"])) {
    
    echo "<p>The value of your timeout variable is: " . $formatted_time . "</p>";
    //echo "<p>Session id: " . session_id() . "</p>";

    $elapsed_time = time() - $_SESSION["timeout"];
    
    if ($elapsed_time > $inactive_limit) {
        session_unset();
        //session_destroy(); // removing this temporarily
        //header("Location: logout.php");
        echo "<p>Your session has expired</p>";
        PriviligedUser::unAuthenticateUser($_SESSION["email"]);
    
    } else {
    
        $time_remaining = $inactive_limit - $elapsed_time;
        echo "remaining seconds in session: " . $time_remaining . "</p>";
        
        $_SESSION["timeout"]=time();

        $elapsed_time = time() - $_SESSION["timeout"];
        $time_remaining = $inactive_limit - $elapsed_time;
        
        echo "Your session timeout has been updated, you now have " . $time_remaining . " remaining seconds in this session.</p>";
    }
} else {
    echo "<p>A timeout session variable is not set, please login.</p>";
    header("Location: logout.php");

    // set the timeout session
    //$_SESSION["timeout"]=time();
}


?>