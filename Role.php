<?php
class Role
{
    protected $permissions;
    public $role_name;

    protected function __construct() {
        $this->permissions = array();
    }

    // returns a role object with associated permissions (the keys) and true (the value) stored in an array called permissions = array("perm_desc_1"->"true"...) 
    public static function getRolePerms($role_id) {
        $role = new Role();
        $sql = "SELECT t2.perm_desc FROM role_perm as t1
                JOIN permissions as t2 ON t1.perm_id = t2.perm_id
                WHERE t1.role_id = '$role_id'";
        
        //include 'database_connect.php';
        $dbname="test";
        $conn = database_connect($dbname);

        $result = $conn->query($sql);

        /*$sth = $GLOBALS["DB"]->prepare($sql);
        $sth->execute(array(":role_id" => $role_id));*/

        while($row = $result->fetch_assoc()) {
            $role->permissions[$row["perm_desc"]] = true;
        }
        return $role;
    }


    // a function to create a new role, returns the role_id of the newly created role.
    public static function addRole($role_name) {
        //$this->role_name = $role_name; // ?necessary
        include 'database_connect.php'; 
        $dbname="test";
        $conn = database_connect($dbname);

        // check if the role already exists
        $sql = "SELECT role_name FROM roles where role_name = '$role_name'";

        $result = $conn->query($sql);

        if(($result->num_rows)>=1) {
            echo "This role already exists";
        die();
        } else { // otherwise, insert the new role
        $sql = "INSERT INTO roles (role_name) VALUES ('$role_name')";

        if($conn->query($sql) === TRUE) {
          echo "<br>New role created successfully!<br>";
          } else {
          echo "<br>Error: " . $conn->error;
          }

        // return the role_id associated with the new role
        $sql = "SELECT role_id from roles WHERE role_name = '$role_name'";

        $result = $conn->query($sql);

        // $row is an associative array with the key being a column name, and the value being the value of the field related to that column name and that row returned.

        $row = $result->fetch_assoc();

        if ($result->num_rows > 1) {
            echo "something has gone wrong, more than one role_id has been returned for a given role_name";
            die();
        } else {
            return $row["role_id"];
        }

        


        $conn->close(); 

        }

    }

    // check if a permission is set
    public function hasPerm($permission) {
        return isset($this->permissions[$permission]);
    }
}