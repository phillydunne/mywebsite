		<div>
			<p>Welcome back <?=$user->firstname . " " . $user->lastname . "!" ?>
			</p>
		</div>

		<div>
			<p>Make a New Booking?</p>
	        <form method=POST action='booking.php'>
	            <input type='submit' name='new_quote' value='New Booking'>
	        </form>
	        <!-- <button class='button button1' onclick='myFunction()' id='button1'><a href="booking.php" style="display: block"></a></button> -->
	    </div>

	    <div>
	    	<p>Your Future Bookings</p>
	    	<br>
	    	<table style="min-height: 200px; max-height: 200px; overflow: auto; display: inline-block;">
	    		<tr>	
	    			<th>Start Time</th>
	    			<th>Court</th>
	    			<th>Durn (mins)</th>
	    			<th>Club</th>
	    			<th>Cancel</th>
	    		</tr>
	    		<?php 
	    		if ($emptyFlag) { ?>
	    			<tr>
	    				<td colspan="5">No upcoming bookings</td>
	    			</tr>
	    		<?php } else { 
		    		foreach ($myBookings as $booking) { ?>
		    		<tr>
		    			<td><?=date("d/m H:i", strtotime($booking["start_time"]))?></td>
		    			<td><?=$booking["court_id"]?></td>
		    			<td><?=(strtotime($booking["end_time"])-strtotime($booking["start_time"]))/60?></td>
		    			<td><?=$booking["club_name"]?></td>
		    			<td>
							<form action="cancelbooking.php" method="post">
								<input type="hidden" name="booking_id" value="<?=$booking["booking_id"]?>">
								<input type="hidden" name="start_time" value="<?=$booking["start_time"]?>">
								<input type="hidden" name="source_page" value="dashboard">
								<input type="submit" name="submit" value="Cancel">
							</form>
		    			</td>
		    		</tr>
	    			<?php } // End of my bookings loop
	    		} ?> <!-- End of emptyFlag statement --> 
	    	</table>
	    </div>



		<script>
		function myFunction() {
  			window.location.href = "logout.php";
		}
		</script>
        
<!--        		Seconds remaining: <p id="timer"></p>
       	<script>
       			var tLimit=600; //has to be the same as the php value. Wonder how you can do that?

       			var myVar = setInterval(countDown(tLimit,1000);

       			function countDown() {
       				for (t=tLimit, t=0, t--) {
       					document.getElementById("timer").innerHTML = t;
       				}	
       			}
       			


				function myTimer() {
				var d = new Date();
				document.getElementById("demo").innerHTML = d.toLocaleTimeString();
	}

       	</script> -->

	</body>

	
