<?php

session_start();

require_once __DIR__ . "/../../includes/user.php";
require_once __DIR__ . "/../../includes/database_connect.php";


// define variables and set to empty values
$firstnameErr = $lastnameErr = $emailErr = $passwordErr = $club_idErr = "";
$firstname = $lastname = $email = $password = $club_id = "";
$output=$title="";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["firstname"])) {
    $firstnameErr = "Firstname is required";
  } else {
    $firstname = test_input($_POST["firstname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$firstname)) {
      $firstnameErr = "Only letters and white space allowed";
    }
  }


  if (empty($_POST["lastname"])) {
    $lastnameErr = "Lastname is required";
  } else {
    $lastname = test_input($_POST["lastname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$lastname)) {
      $lastnameErr = "Only letters and white space allowed";
    }
  }


  
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


  if (empty($_POST["club_id"])) {
    $club_idErr = "Club id is required";
  } else {
    $club_id = test_input($_POST["club_id"]);
    // check if e-mail address is well-formed
    if (!preg_match("/^[0-9]*$/",$club_id)) {
      $club_id = "Only numbers allowed";
    }


  }


}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<div>
  <h1>User Registration</h1>
  <p>You can register as a user here, allowing you to then login. An admin will receive a notification and then assign you to the correct club and role</p>
  <a href="Login.php">Proceed to the login page</a>
</div>

<div>
  <p><span class="error"></span></p>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  

    Firstname: <input type="text" name="firstname" value="<?php echo $firstname;?>">
    <span class="error"><?php echo $firstnameErr;?></span>
    <br><br>

    Lastname: <input type="text" name="lastname" value="<?php echo $lastname;?>">
    <span class="error"><?php echo $lastnameErr;?></span>
    <br><br>

    Club id: <input type="text" name="club_id" value="<?php echo $club_id;?>">
    <span class="error"><?php echo $club_idErr;?></span>
    <br><br>

    E-mail: <input type="text" name="email" value="<?php echo $email;?>">
    <span class="error"><?php echo $emailErr;?></span>
    <br><br>

    Password: <input type="password" name="password" value="<?php echo $password;?>" id="password">
    <span class="error"><?php echo $passwordErr;?></span>
    <br><br>

    <input type="checkbox" onclick="myFunction()"> Show Password
    <br><br>

    <input type="submit" name="submit" value="Submit">  
  </form>
</div>

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty($firstnameErr) AND empty($lastnameErr) AND empty($emailErr) AND empty($passwordErr) AND empty($club_idErr)){

        $new_user = new User();

        try {
            $new_user_id = $new_user->addUser($firstname, $lastname, $email, password_hash($password, PASSWORD_DEFAULT), $club_id);
        }
        catch (Exception $e) 
        {
            echo $e -> getMessage();
            die();
        }


  }
}
$title="User Registration";
include __DIR__ . "/../../templates/layout_alt.html.php";

?>