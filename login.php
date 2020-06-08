<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php
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
//echo "<h2>Submit Data to the Database function:</h2>";

// include a function which connects to the database and returns the database connection ?object
include 'database_connect.php';

// define the target database. The database server, database username and database password and specified in the function.
$dbname="test";

//Ensure this executes after the validation block. This first If checks if the page has been submitted first - basically it checks if the submit event has taken place. Without this you would have to say If (variable <> Empty) AND if variableErr ="".




if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty($emailErr) AND empty($passwordErr) ) {
    //debugger: echo "Inner If: The POST method has been invoked, and there are no errors - you can put your code in here now";

    $conn = database_connect($dbname);
    
    $sql = "SELECT password FROM users where `email` = '$email'";

    $result = $conn->query($sql);

    echo "<br> Number of rows returned:" . $result -> num_rows;

    //echo "result value is :" . $result . " <br>"; 

    //if($result->num_rows == 1) {
    if(($result == TRUE) and ($result->num_rows == 1)) {
      echo "<br>Record read successfully and there is only one result!<br>";
      
      // fetches a result row as an associative array into the variable $row
      $row = $result-> fetch_assoc();

      // assigns the hashed password returned from the database to a variable
      $db_hashed_password = $row["password"];
      
      // temporary - hashes the password so that i can unit test it with manually entered data in the db
      echo "<p> The hashed version of your entered password is: " . password_hash($password, PASSWORD_DEFAULT) . "</p>";
      echo "<p> The hashed version of your stored password is: " . $db_hashed_password . "</p>";

      // verifies the password entered by the user against the password retrieved from the database
      if(password_verify($password, $db_hashed_password)) {
        echo "<br> Password verified! Welcome back " . $email . "<br>";
      } else {

        echo "<br><p> Your password does not match the one on record :( </p><br>";
      }

     } else {
     echo "<br>Error: This email is not on record (or more than one password was returned for this email - unlikely)" . $conn->error;
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