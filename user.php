<?php
class User
{
    // Represents a user account

	private $firstname;
	private $lastname;
	private $email;
	private $password;
	private $authenticated;


    public function __construct() {
        // DEBUG echo "In a constructor! ";
        $this->firstname=NULL;
        $this->lastname=NULL;
        $this->email=NULL;
        $this->password=NULL;
        $this->authenticated=FALSE;
    }

    // Add a new user account and return the user id if successful
    public function addUser($firstname, $lastname, $email, $hashed_password) {

   	$log_level = "";

    $this->firstname=$firstname;
    $this->lastname=$lastname;
    $this->email=$email;
    $this->password=$hashed_password;

	$dbname="test";
	$conn = database_connect($dbname);

	//check if the user exists already
    $sql = "SELECT email FROM users WHERE email = '$email'";
    
    // DEBUG
    if ($log_level == "DEBUG") {
   	    echo "<br> this is the email we are checking for: " . $email . "<br>";
   	}

    $result = $conn->query($sql);

    // DEBUG
    if ($log_level == "DEBUG") {
    	echo "Vardump of result: " . var_dump($result) . "<br>";
	    if (empty($result)) {
	    	echo "<br>Variable 'result' is empty<br>";
	    } else {
	    	echo "<br>Variable 'result' is NOT empty<br>";
	    }
	}


    if(($result->num_rows)>=1) {
    	echo "This Email is Already Registered";
        $conn->close();
    	die();
    } else {
    	$sql = "INSERT INTO users (email, password, firstname, lastname) VALUES ('$email', '$hashed_password', '$firstname', '$lastname')";

	    if($conn->query($sql) === TRUE) {
	      echo "<br>New user created successfully!<br>";
          $conn->close();
	      } else {
	      echo "<br>Error: " . $conn->error;
          $conn->close();
	      }
    }


/*    $sql = "INSERT INTO users (email, password, firstname, lastname) VALUES ('$email', '$hashed_password', '$firstname', '$lastname')";

    if($conn->query($sql) === TRUE) {
      echo "<br>New user created successfully!<br>";
      } else {
      echo "<br>Error: " . $conn->error;
      }

    $conn->close(); */

    }

}
?>