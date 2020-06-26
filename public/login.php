<?php

require_once __DIR__ . "/../../includes/privilegeduser.php";
require_once __DIR__ . "/../../includes/role.php";
require_once __DIR__ . "/../../includes/database_connect.php";


// require_once "privilegeduser.php";
// require_once "role.php";
// require_once "database_connect.php";

// define variables and set to empty values
$title="";
$output="";

$emailErr = $passwordErr = "";
$email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }
    
  if (empty($_POST["password"])) {
    $passwordErr = "Password is required";
  } else {
    $password = test_input($_POST["password"]);
  }

}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>



<!--Here is the HTML -->

<h1>Login Page</h1>
<!--<p><span class="error"></span></p>-->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  

  E-mail: <input type="text" name="email" value="<?php echo $email;?>">
  <span class="error"><?php echo $emailErr;?></span>
  <br><br>

  Password: <input type="password" name="password" value="<?php echo $password;?>" id="password">
  <span class="error"><?php echo $passwordErr;?></span>
  <br><br>

  <input type="checkbox" onclick="myFunction()"> Show Password

  <input type="submit" name="submit" value="Submit">  
</form>

<div>
  <a href="userregistration.php">New user? Register here.</a>
</div>



<script>
function myFunction() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>



<?php 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty($emailErr) AND empty($passwordErr) ) {

    // attempt to authenticate the user, returns true if user authentication flag has been updated, false if not.
    if (PrivilegedUser::authenticateUser($email, $password)==TRUE) {
      
      // start the session
      session_start();

      // set session variable to the current time
      $_SESSION["timeout"]=time(); // Important that this is as soon as possible after authentication. 

      // check if the user has a specific privilege and then take action.
      $set_permission = "view_dashboard"; // this is the permissin required to proceed for example 
      $u = PrivilegedUser::getByUsername("$email");

      if(gettype($u)=="object") {
      // set the user id and club_id session variable now that we have it
        $_SESSION["email"]=$u->email;
        $_SESSION["user_id"]=$u->user_id;
        $_SESSION["club_id"]=$u->club_id;
        $_SESSION["max_bookings"]=$u->getConfig("max_bookings"); // Probably not an ideal place to store this - should we be loading user information into a session variable?


        if ($u->hasPrivilege($set_permission)) {
          echo "<br> user " . $u->email . " has this permission: " . $set_permission;
            header("Location: dashboard.php");
            die();
        } else {
          echo "However you have not yet been assigned a role by an admin. Please contact contact@bookings.com if you do not have access withing 24 hours";
        }

      } else {
    echo "The user object instance is not an object, it is likely a bool - the getByUsername function call returned a bool";
    header("Location: logout.php");
}


    } else { 
      echo "<br>Authentication failed :(<br>"; 
    }


  } else {
    //DEBUG echo "Inner Else: The POST method has been invoked, BUT there are errors";
    }
  } else {
    // NOTHING HAS BEEN POSTED YET
  }


$title = "Login";
include __DIR__ . "/../../templates/layout_alt.html.php";

?>