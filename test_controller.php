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
&emsp;1. <a href="CreateRole.php"> Creates new roles <br> </a>
&emsp;2. <a href="test_login.php"> Tests role and permission functionality <br> </a>
&emsp;3. <a href="Logout.php"> Placeholder logout page <br> </a>
&emsp;4. <a href="Login.php"> Tests login <br> </a>
&emsp;5. <a href="UserRegistration.php"> Registers new users <br> </a>
&emsp;6. <a href="test_classes.php"> Tests features of classes and objects <br> </a>

<h2><br>Out of Scope</h2>
<p>A list of pages out of scope for testing: </p>
&emsp;1. <a href="Form.php"> Tests form functionality </a>
</body>

<footer>
<?php
$lastUpdated = "08/06/2020 14:54:00";
echo "<br>" . "This page was last updated on " . $lastUpdated;
?>
</footer>
</html>