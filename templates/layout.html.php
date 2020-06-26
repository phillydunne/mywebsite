<!DOCTYPE HTML>  
<html>
	<head>
		<title><?=$title?></title>
		<link rel="stylesheet" href="mystyle.css">
		<meta charset="utf-8">
	</head>
	<body>
		<!-- <header>  Having the header in there moved it all across to the left-->
			<h1>Booking System</h1>
			<ul class="navbar">
				<li class="navbar">
					<a class="navbar" href="dashboard.php">Dashboard</a>
				</li>
				<li class="navbar">
					<a class="navbar" href="booking.php">Booking</a>
				</li>
				<li class="navbar">
					<a class="navbar" href="logout.php">Logout</a>
				</li>
			</ul>
		<!-- </header> -->
		<main>
			<?=$output?>
		</main> 
		<footer>
			&copy; Philip Dunne 2020
		</footer>
	</body>
</html>