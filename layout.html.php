<!DOCTYPE HTML>  
<html>
	<head>
		<title><?=$title?></title>
		<link rel="stylesheet" href="mystyle.css">
		<meta charset="utf-8">
	</head>
	<body>
		<header>
			<h1>Booking System</h1>
		</header>
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
		<main>
			<?=$output?>
		</main> 
		<footer>
			&copy; ACME INC 2020
		</footer>
	</body>
</html>