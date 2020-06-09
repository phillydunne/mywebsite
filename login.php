<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php

require_once "privilegeduser.php";
require_once "role.php";
require_once "database_connect.php";

// define variables and set to empty values
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






<!-- Javascript to show/hide password -->
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
//Outputs the form values back to the user
/*echo "<h2>Your Input:</h2>";

if (!empty($email)) {
  echo 'Email: ' . $email;
  echo "<br>";
}
  
if (!empty($password)) {
  echo 'Password: Not Displayed';
  echo "<br>";
}

echo '<br><br>'*/
?>


<!-- Submit the values to another page for processing if there are no errors -->
<?php 
//Ensure this executes after the validation block. This first If checks if the page has been submitted first - basically it checks if the submit event has taken place. Without this you would have to say If (variable <> Empty) AND if variableErr ="".


if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty($emailErr) AND empty($passwordErr) ) {

    // attempt to authenticate the user, returns true if user authentication flag has been updated, false if not.
    if (PrivilegedUser::authenticateUser($email, $password)==TRUE) {
      echo "<br>User " . $email . " has been authenticated!<br>";
      
      // set timeout session variable to the current time
      $_SESSION["timeout"]=time();
      
      // check if the user has a specific privilege and then take action.
      $set_permission = "all_permissions";
      $u = PrivilegedUser::getByUsername("$email");
      if(gettype($u)=="object") {
        if ($u->hasPrivilege($set_permission)) {
          echo "<br> user " . $u->email . " has this permission: " . $set_permission;
            header("Location: dashboard.php");
        } else {
          echo "<br> user " . $u->email . " does not have permission " . $set_permission;
        }

      } else {
    echo "The user object instance is not an object, it is likely a bool - the getByUsername function call returned a bool";
}


    } else { 
      echo "<br>Authentication failed :(<br>"; 
    }


  } else {
    //DEBUG echo "Inner Else: The POST method has been invoked, BUT there are errors";
    }
  } else {
    //DEBUG echo "Outer Else: The POST method has NOT invoked";

  }



?>


</body>
</html>