<div>
		<h3>Choose Your Day</h3>
		<form action="" method="POST">
			<input type="date" id="date" name="date" value="<?=$date?>">
			<!-- <input type="text" id="name" name="name" value=""> -->
			<input type="submit" name="submit" value="Submit">
			<span class="error"><?=$dateError?></span>
		</form>
</div>


<?php if ($alertFlag) { ?>
<script>
	alert(<?=$alert?>);
</script>
<?php } ?>

<div>
<table style="min-height: 400px; max-height: 400px; overflow: auto; display:inline-block;">
	<caption style="background-color:white;border:1px solid black;font-size:1.5em;font-weight:bold;padding:5px;"><?=$myClub->club_name?></caption>
	<tr>
		<th>Timeslot</th>
		<?php foreach ($myCourts as $court) { ?>
			<th>
			Court <?=$court["court_club_id"]?>
			</th>
		<?php } ?>
	</tr> <!-- End of Table Header -->
	
	<?php for ($t=$open_time; $t<=$close_time; $t+=$myClub->block_size) { ?> <!-- Populate the y axis -->

		<tr>
			<td><?=date("H:i",$t)?></td>
			<?php foreach ($myCourts as $court) { 
				$booked=$myBooking=false; 
				$cancel_booking_id=null;
				?>
				<!-- Each iteration in here should result in one output in a cell -->

				<?php foreach ($daysBookings as $booking) {
					// Loops through each booking entry to see if any match the court and timeslot
					if ($booking["court_id"]==$court["court_club_id"] && (strtotime($booking["start_time"])<=$t && strtotime($booking["end_time"])>$t)) { 
						$booked=true;
						if ($booking["user_id"]==$_SESSION["user_id"]) {
							$myBooking=true;
							$cancel_booking_id=$booking["booking_id"];
							$numBookings++;
						}
					} 
				} // End of foreach booking loop

				if ($booked && !$myBooking) { ?>
					<td>Booked</td>

					<?php } elseif ($booked && $myBooking) { ?>
					<td> 
						<form action="cancelbooking.php" method="post">
							<input type="hidden" name="booking_id" value="<?=$cancel_booking_id?>">
							<input type="hidden" name="start_time" value="<?=date("Y-m-d H:i:s",$t)?>">
							<input type="hidden" name="source_page" value="booking">
							<input type="submit" name="submit" value="Cancel">
						</form>
					</td>

					<?php } elseif ($alertFlag==1) { ?>
					<td>
					</td>
					<?php } else { ?>
					<td> 
						<form action="makebooking.php" method="post">
							<input type="hidden" name="court_id" value="<?=$court["court_club_id"]?>">
							<input type="hidden" name="start_time" value="<?=date("Y-m-d H:i:s",$t)?>">
							<input type="hidden" name="end_time" value="<?=date("Y-m-d H:i:s",($t+$myClub->block_size))?>">
							<input type="hidden" name="club_id" value="<?=$myClub->club_id?>">
							<input type="submit" name="submit" value="Book">
						</form>
					</td>	
					<?php } ?>

				<?php } ?> <!-- End of foreach court -->
			<?php } ?> <!-- End of for loop with $t -->

			</tr>
</table>
<br>
</div>