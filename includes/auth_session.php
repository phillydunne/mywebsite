<?php

function auth_session($set_perm) {



	// 1 of 3: AUTHENTICATION
	if (isset($_SESSION["email"])) {
	    if (PrivilegedUser::isAuthenticated($_SESSION["email"])) {

	    	// PROCEED TO EXECUTE THIS PAGE

	    } else {
	    	header("Location: logout.php");
	    	die();
	    	// Email is set but is empty for example.
	    }
	} else {

		header("Location: logout.php");
		die();
		// Email session variable is not set.
	}  




	// 2 of 3: AUTHORISATION
	$u = PrivilegedUser::getByUsername($_SESSION["email"]);

	  if(gettype($u)=="object") {

	    if ($u->hasPrivilege($set_perm)) {
	        // Continue to execute this page
	    } else {
	      echo "<br> user " . $u->email . " does not have permission " . $set_perm;
	      header("Location: logout.php");
	      die();
	    }

	  } else {
		echo "The user object instance is not an object, it is likely a bool - the getByUsername function call returned a bool";
		header("Location: logout.php");
		die();
		// should add in error handling here.
	}



	 

	// 3 of 3: SESSION TIMEOUT CHECK
	$inactive_limit = 600; // ?seconds
	$formatted_time = date('Y-m-d H:i:s', $_SESSION["timeout"]);

	if (isset($_SESSION["timeout"])) {
	    
	    //echo = "<p>The value of your timeout variable is: " . $formatted_time . "</p>";
	    //echo "<p>Session id: " . session_id() . "</p>";

	    $elapsed_time = time() - $_SESSION["timeout"];
	    
	    if ($elapsed_time > $inactive_limit) {
	        PrivilegedUser::unAuthenticateUser($_SESSION["email"]);
	        $output ="<p>Your session has expired</p>";
	        header("Location: logout.php");
	        die();
	    
	    } else {
	    
	        $time_remaining = $inactive_limit - $elapsed_time;
	        // $output = "<p>You had " . $time_remaining . " remaining seconds left in your session.</p>";
	        
	        $_SESSION["timeout"]=time();

	        $elapsed_time = time() - $_SESSION["timeout"];
	        $time_remaining_updated = $inactive_limit - $elapsed_time;
	        
	        // $output = $output . "<p>Your session timeout has been updated, you now have " . $time_remaining_updated . " remaining seconds in this session.</p>";
	    }
	} else {
	    $output = "<p>A timeout session variable is not set, please login.</p>";
	    header("Location: logout.php");
	    die();

	} // END of SESSION HANDLER


	
}

?>