<?php
require_once "User.php";
class PrivilegedUser extends User
{
    private $roles;

    public function __construct() {
        parent::__construct();
    }

    // override User method
    public static function getByUsername($username) {
 
        //include 'database_connect.php';
        $dbname="test";
        $conn = database_connect($dbname);
        $sql = "SELECT * FROM users WHERE email = '$username'";
        $result = $conn->query($sql);
        $conn->close();

        // DEBUG
	    echo "Vardump of result: " . var_dump($result) . "<br>";
	    if (empty($result)) {
	    	echo "<br>Variable 'result' is empty<br>";
	    } else {
	    	echo "<br>Variable 'result' is NOT empty<br>";
	    }


        $row = $result->fetch_assoc();
        $num_rows = $result->num_rows;

        // DEBUG var_dump($result);

        echo "<br> Number of rows: " . $num_rows . "<br>";

        /*$sth = $GLOBALS["DB"]->prepare($sql);
        $sth->execute(array(":username" => $username));
        $result = $sth->fetchAll();*/

        //AND (($result->num_rows) =1)

        // I Dont believe this will ever equate to false unless the sql fails to execute perhaps - if it returns zero rows it will still equate to true
        if (!empty($result)) {
            $privUser = new PrivilegedUser();
            $privUser->user_id = $row["user_id"];
            $privUser->firstname = $row["firstname"];
            $privUser->lastname = $row["lastname"];
            $privUser->email = $row["email"];
            $privUser->password = $row["password"]; 
            echo $privUser->user_id;
            $privUser->initRoles($privUser->user_id);
            return $privUser;
        } else {
            return false;
        }
    }


    // first find the roles associated with that user id
    // then populate roles with their associated permissions
    protected function initRoles($user_id) {
        $this->roles = array();
        $sql = "SELECT t1.role_id, t2.role_name FROM user_role as t1 JOIN roles as t2 ON t1.role_id = t2.role_id WHERE t1.user_id = '$user_id'";
        
        //include 'database_connect.php';
        $dbname="test";
        $conn = database_connect($dbname);

        $result = $conn->query($sql);
        $conn->close();

        $num_rows = $result->num_rows;
        // DEBUG var_dump($result);

        // DEBUG echo "<br> Number of rows (roles associated with user ids): " . $num_rows . "<br>";


        /*$sth = $GLOBALS["DB"]->prepare($sql);
        $sth->execute(array(":user_id" => $this->user_id));*/

        // checks which permissions are associated with each role returned in the sql query. It does this by looping through each row returned by the sql query, setting the key of the roles array to role_name of each row returned, and then calling the getRolePerms function of the Role class to populate the value. The value will be an ?array/object which contains a key (perm_desc) and a value (true), listing each permission associated with each role passed to it. ? a new role object is created each loop.

        while($row = $result->fetch_assoc()) {
            $this->roles[$row["role_name"]] = Role::getRolePerms($row["role_id"]);
        //var_dump($roles);
        }
    }

    // check if user has a specific privilege
    // loops through the roles array and checks if 
    public function hasPrivilege($perm) {
        foreach ($this->roles as $role) {
            if ($role->hasPerm($perm)) {
                return true;
            }
        }
        return false;
    }

    // function: authenticates a user - checks that the password they entered matches the password on record. If authenticated, their authenticated flag is set to true. Returns TRUE if the authenticated flag has been set to true, returns false if the authenticated flag has not been updated.

    public static function authenticateUser($email, $password) {
        // include 'database_connect.php';
        $dbname="test";
        $conn = database_connect($dbname);
        $sql = "SELECT password FROM users where `email` = '$email'";
        $result = $conn->query($sql);

        if(($result == TRUE) and ($result->num_rows == 1)) {
            echo "<br>Record read successfully and there is only one result!<br>";
      
            // fetches a result row as an associative array into the variable $row
            $row = $result-> fetch_assoc();
            $db_hashed_password = $row["password"];

          // temporary - hashes the password so that i can unit test it with manually entered data in the db
          // DEBUG echo "<p> The hashed version of your entered password is: " . password_hash($password, PASSWORD_DEFAULT) . "</p>";
          // DEBUG echo "<p> The hashed version of your stored password is: " . $db_hashed_password . "</p>";

            if(password_verify($password, $db_hashed_password)) {
                echo "<br> Password verified! Welcome back " . $email . "<br>";

                // update user authorised flag ? add check to see if there is more than one record returned?
                $sql = "UPDATE users SET authenticated=1 WHERE email = '$email'";
                
                if($conn->query($sql) === TRUE) {
                    echo "<br>User updated successfully!<br>";
                    return $conn->query($sql);
                    $conn->close();
                } else {
                    echo "<br>Error: " . $conn->error;
                    return FALSE;
                    $conn->close();
                }


            } else {

                echo "<br><p> Your password does not match the one on record :( </p><br>";
                $conn->close();
            }

        } else {
             echo "<br>Error: This email is not on record (or more than one password was returned for this email - unlikely)" . $conn->error;
             $conn->close();
        }

    }


/*    // function: STUB
    public static function timeoutUser($email, $password) {include 'database_connect.php';
        $dbname="test";
        $conn = database_connect($dbname);
        $sql = "SELECT password FROM users where `email` = '$email'";
        $result = $conn->query($sql);
        $conn->close();

        if(($result == TRUE) and ($result->num_rows == 1)) {
            echo "<br>Record read successfully and there is only one result!<br>";
        }
         
    }*/



}