<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php

session_start();

require_once "role.php";
require_once "database_connect.php";


// define variables and set to empty values
$role_nameErr = $role_descErr = "";
$role_name = $role_desc = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["role_name"])) {
    $role_nameErr = "Role name is required";
  } else {
    $role_name = test_input($_POST["role_name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z]*$/",$role_name)) {
      $role_nameErr = "Only letters allowed, no whitespace";
    }
  }


  if (empty($_POST["role_desc"])) {
    $role_descErr = "Role description is required";
  } else {
    $role_desc = test_input($_POST["role_desc"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$role_desc)) {
      $role_descErr = "Only letters and white space allowed";
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

<h1>Role Creation</h1>
<p>You can create a new role here. The ability to associate permissions with a role is not yet implemented.</p>

<p><span class="error"></span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  

  Role Name: <input type="text" name="role_name" value="<?php echo $role_name;?>">
  <span class="error"><?php echo $role_nameErr;?></span>
  <br><br>

  Role Description: <input type="text" name="role_desc" value="<?php echo $role_desc;?>">
  <span class="error"><?php echo $role_descErr;?></span>
  <br><br>

  <input type="submit" name="submit" value="Submit">  
</form>




<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty($role_nameErr) AND empty($role_descErr)){

        try {
            echo "The role id associated with the new role is " .Role::addRole($role_name);

        }
        catch (Exception $e) 
        {
            echo $e -> getMessage();
            die();
        }


}}

?>