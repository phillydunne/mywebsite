<?php
session_start();

require_once "database_connect.php";
require_once "privilegeduser.php";
require_once "role.php";

/*set once before calling session_handler. 
1. if you are on a page and come back quite a bit later, after your timeout session variable has expired, we dont want to reset your variable value to the current time. We want you to be logged out.

2. if you have just logged in, your timeout variable needs to be set for the first time.

*/

// do we need soemthing here that will check if you are authenticated and authorised to see this page? I suppose the only things allowing us to maintain state right now are session variables, and the database. 

if (isset($_SESSION["email"])) {
    if (PrivilegedUser::isAuthenticated($_SESSION["email"])) {

        // this checks timeout
/*        if (!isset($_SESSION["timeout"])) {
            $_SESSION["timeout"]=time();
            // this assumes that PHP wont just get rid of this session variable value because you havent use the system for a while for example.  
        }*/

    require_once "session_handler.php";

    echo "
    <!DOCTYPE HTML>  
    <html>
    <head>
    <style>
    <!--.error {color: #FF0000;}-->
    .button {
      border: none;
      color: black;
      padding: 15px 32px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin: 4px 2px;
      cursor: pointer;
    }

    .button1 {background-color: #4CAF50;} /* Green */
    .button2 {background-color: #008CBA;} /* Blue */
    </style>
    </head>
    <body>  
    <h1>Dashboard</h1>
    </body>
    ";

    // Put in user specific content etc.

    echo "<p>Welcome back! Here is all of the information that we have on you. </p>
    ";

    $user = PrivilegedUser::getByUsername($_SESSION['email']);

    foreach($user as $key => $value) {
        if ($key != "password") {
            echo "$key: $value<br>";
      
        }
    }

    // Next actions for the user
    echo "
        <h2>What would you like to do?</h2>
        <form method=POST action='newquote.php'>
            <input type='submit' name='new_quote' value='Create a New Quote'>
        </form>
        <button class='button button1' onclick='myFunction()' id='button1'>Logout</button>
    ";



    } else {
        echo "<h1>Permission Denied to this page. </h1>";
        //email session variable is set, but has not been authenticated - is this even possible? At the moment the email session variable is set just after successful authentication.
    }
} else {
    echo "<h1>Permission Denied to this page. </h1>";
    //email session variable is not set - they have not been authenticated.
    // good to build in a way to check if the user is authenticated at all just in case.
}

?> 

<!-- Javascript to act on button click password -->
<script>
function myFunction() {
  window.location.href = "logout.php";
}
</script>