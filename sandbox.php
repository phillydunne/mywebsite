<?php

// Database testing
/*include "database_connect_pdo.php";
$db_name="test";
$pdo=database_connect_pdo($db_name);*/



?>

 <!-- Javascript timer testing: this should really be in a .html.php file -->

<p>A script on this page runs this clock:</p>
<p id="demo"></p>

<script>
	var myVar = setInterval(myTimer,1000);

	function myTimer() {
		var d = new Date();
		document.getElementById("demo").innerHTML = d.toLocaleTimeString();
	}
	
	
</script>



