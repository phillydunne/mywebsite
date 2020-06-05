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
        $row = $result->fetch_assoc();
        $num_rows = $result->num_rows;
        // DEBUG var_dump($result);

        echo "<br> Number of rows: " . $num_rows . "<br>";

        /*$sth = $GLOBALS["DB"]->prepare($sql);
        $sth->execute(array(":username" => $username));
        $result = $sth->fetchAll();*/

        //AND (($result->num_rows) =1)

        if (!empty($result)) {
            $privUser = new PrivilegedUser();
            $privUser->user_id = $row["user_id"]; //$result[0]["user_id"];
            $privUser->username = $username;
            $privUser->password = $row["password"]; // $result[0]["password"];
            $privUser->email_addr = $row["email"]; // $result[0]["email_addr"];
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

        while($row = $result->fetch_assoc()) {
            $this->roles[$row["role_name"]] = Role::getRolePerms($row["role_id"]);
        //var_dump($roles);
        }
    }

    // check if user has a specific privilege
    public function hasPrivilege($perm) {
        foreach ($this->roles as $role) {
            if ($role->hasPerm($perm)) {
                return true;
            }
        }
        return false;
    }
}