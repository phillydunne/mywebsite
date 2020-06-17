<!DOCTYPE HTML>  
<html>
	<head>
		<title><?=$title?></title>
		<link rel="stylesheet" href="mystyle.css">
		<meta charset="utf-8">
	</head>
	<body>
		<header>
			<h1>My Booking System</h1>
		</header>
		<ul>
			<li>
				<a href="dashboard.php">Dashboard</a>
			</li>
			<li>
				<a href="booking.php">Booking</a>
			</li>
			<li>
				<a href="logout.php">Logout</a>
			</li>
		</ul>
		<main>
			<?=$output?>
		</main> 
		<footer>
			&copy; ACME INC 2020
		</footer>
	</body>
</html>