		<div>
			<h3>Choose Your Day</h3>
			<form action="" method="POST">
				<input type="date" id="date" name="date" value="<?=$date?>">
				<!-- <input type="text" id="name" name="name" value=""> -->
				<input type="submit" name="submit" value="Submit">
				<span class="error"><?=$dateError?></span>
			</form>
		</div>


 		<div>
			<table>
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
							$booked=FALSE; ?>
							<!-- Each iteration in here should result in one output in a cell -->

							<?php foreach ($myBookings as $booking) {
								// Loops through each booking entry to see if any match the court and timeslot
								if ($booking["court_id"]==$court["court_club_id"] && (strtotime($booking["start_time"])<=$t && strtotime($booking["end_time"])>$t)) { 
									$booked=TRUE;
									} 
								} // End of foreach booking

							if ($booked) { ?>
								<td>Booked</td>
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