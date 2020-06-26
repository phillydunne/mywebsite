<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  
<!--this page is used to open other pages for (in time automated) testing purposes -->

<h1>Test Links<br></h1>
<h2>In Scope</h2>
<p>A list of pages to be tested: </p>
&emsp;1. <a href="Login.php"> Tests login -> dashboard -> logout. Expected results to be documented separately.<br> </a>
&emsp;2. <a href="dashboard.php"> Dashboard. expected result: Permission denied (unless you still have a session open) <br> </a>
&emsp;3. <a href="Logout.php"> Logout page. expected result: "Logout Page Click here to proceed to the login page". When going directly to this page it shouldnt tell you that you have been logged out successfully. <br> </a>
</body>
&emsp;4. <a href="CreateRole.php"> Creates new roles <br> </a>
&emsp;5. <a href="UserRegistration.php"> Registers new users <br> </a>
&emsp;6. <a href="test_classes.php"> Tests features of classes and objects <br> </a>

<h2><br>Out of Scope</h2>
<p>A list of pages out of scope for testing: </p>
&emsp;1. <a href="Form.php"> Tests form functionality <br></a>
&emsp;2. <a href="test_login.php"> Tests role and permission 
	functionality <br> </a>


<footer>
<?php
$lastUpdated = "06/10/2020 14:52:00"; // American notation. also time() thinks we are an hour behind the actual time in Ireland.
$convertedTime =  strtotime($lastUpdated);
// DEBUG echo "<br>Time value:" . time() . "<br>";
// DEBUG echo "Last updated value:" . $convertedTime . "<br>";
echo "<br><i>" . "This page was last updated on $lastUpdated, " . round(((time() - $convertedTime)/(60*60)))   . " hours ago</i>";
?>
</footer>
</html>