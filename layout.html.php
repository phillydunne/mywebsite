<!DOCTYPE HTML>  
<html>
	<head>
		<title><?=$title?></title>
		<!-- <link rel="stylesheet" href="form.css" /> -->
		<meta charset="utf-8">
	</head>
	<body>
		<header>
			<h1>My Booking System</h1>
		</header>
		<nav>
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
		</nav>
		<main>
			<?=$output?>
		</main> 
		<footer>
			&copy; ACME INC 2020
		</footer>
	</body>
</html>