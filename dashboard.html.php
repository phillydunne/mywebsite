<!DOCTYPE HTML>  
<html>
	<head>
		<title>Sandbox Page</title>
		<!-- <link rel="stylesheet" href="form.css" /> -->
		<meta charset="utf-8">
		<style>
			.error {color: #FF0000;}
		    .button {
		      border: none;
		      color: black;
		      padding: 15px 32px;
		      text-align: center;
		      text-decoration: none;
		      display: inline-block;
		      font-size: 16px;
		      margin: 4px 2px;
		      cursor: pointer;
		    }

		    .button1 {background-color: #4CAF50;} /* Green */
		    .button2 {background-color: #008CBA;} /* Blue */
		</style>
	<body>  
        <h2>What would you like to do?</h2>
        <form method=POST action='newquote.php'>
            <input type='submit' name='new_quote' value='Create a New Quote'>
        </form>
        <button class='button button1' onclick='myFunction()' id='button1'>Logout</button>

	</body>
