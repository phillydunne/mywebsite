<?php

/*This file contains a function which opens a connection to a database, submits data, and closes the connection
	The method of connection is TBC - PDO or OOP with MariaDB
*/

function submit_form($name, $email, $gender, $comment, $website) {
	echo "Hi, my name is " . $name<br>;
	echo "please contact me on " . $email<br>;
	echo "other details " . $gender . " " . $website . " " . $comment;
}


>?>