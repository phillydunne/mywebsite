<?php
session_start();

require_once "database_connect.php";
require_once "privilegeduser.php";
require_once "role.php";

//initalise
$title="";
$output="";

/*set once before calling session_handler. 
1. if you are on a page and come back quite a bit later, after your timeout session variable has expired, we dont want to reset your variable value to the current time. We want you to be logged out.

2. if you have just logged in, your timeout variable needs to be set for the first time.

*/

// do we need something here that will check if you are authenticated and authorised to see this page? I suppose the only things allowing us to maintain state right now are session variables, and the database. 

if (isset($_SESSION["email"])) {
    if (PrivilegedUser::isAuthenticated($_SESSION["email"])) {

    require_once "session_handler.php"; // returns output of the session text

    // Put in user specific content etc.

    //echo "<p>Welcome back! Here is all of the information that we have on you. </p>";

    $user = PrivilegedUser::getByUsername($_SESSION['email']);

    // This is the part that he wanted to put into the template
    // foreach($user as $key => $value) {
    //     if ($key != "password") {
    //         $output = $output . "<p>$key: $value</p>";
      
    //     }
    // }

    ob_start();

    include __DIR__ . "/../../templates/dashboard.html.php";

    $output = $output . ob_get_clean();


    } else {
        $output = "<h1>Permission Denied to this page. </h1>";
        header("Location: logout.php");
        //email session variable is set, but has not been authenticated - is this even possible? At the moment the email session variable is set just after successful authentication.
    }
} else {
    $output = "<h1>Permission Denied to this page. </h1>";
    header("Location: logout.php");
    //email session variable is not set - they have not been authenticated.
    // good to build in a way to check if the user is authenticated at all just in case.
}

$title="Dashboard";

// Now we have our $title and $output variables set and we can "submit" them to the standard html format template.
include __DIR__ . "/../../templates/layout.html.php";

?> 

<!-- Javascript to act on button click -->
