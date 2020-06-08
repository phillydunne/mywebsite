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
 
        include 'database_connect.php';
        $dbname="test";
        $conn = database_connect($dbname);
        $sql = "SELECT * FROM users WHERE email = '$username'";
        $result = $conn->query($sql);

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
    // loops through the role array and checks if 
    public function hasPrivilege($perm) {
        foreach ($this->roles as $role) {
            if ($role->hasPerm($perm)) {
                return true;
            }
        }
        return false;
    }
}