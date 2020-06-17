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

		<div>
			<table>
				<tr>
					<th>Field</th>
					<th>Value</th>
				</tr>
				<?php foreach($user as $key => $value) {
       				if ($key != "password") { ?>
				<tr>
					<td><?=$key?></td>
					<td><?=$value?></td>
				</tr>
				<?php } } ?>
			</table>
		</div>

		<div>
			<h3>What would you like to do next?</h3>
	        <form method=POST action='newquote.php'>
	            <input type='submit' name='new_quote' value='Create a New Quote'>
	        </form>
	        <button class='button button1' onclick='myFunction()' id='button1'>Logout</button>
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

	
