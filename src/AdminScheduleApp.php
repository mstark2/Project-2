<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Schedule Appointment</title>
	<link rel='stylesheet' type='text/css' href='../css/standard.css'/>
	<h2>UMBC COEIT Engineering and Computer Science Advising</h2>
  </head>
  <body>
    <div id="login">
      <div id="form">
        <div class="top">
	<h1>Schedule Appointments</h1>
	<h2>Select advising type</h2><br>
	
	<form method="post" action="AdminProcessSchedule.php">
	<div class="nextButton">
        <!-- Choose individual or group -->
		<input type="submit" name="next" class="button medium go" value="Individual">
		<input type="submit" name="next" class="button medium go" value="Group" style="float: right;">
	</div>
	</form>
        </div>
	</div>
		</form>
		<form method="link" action="AdminUI.php">
		<input type="submit" name="home" class="button small go" style="margin-bottom: 10px" value="Cancel">
		</form>
	<?php
		include ('footer.html');
	?>	
   	</div>

	</div>
  </body>
  
</html>
