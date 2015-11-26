<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Edit Appointment</title>
    <link rel='stylesheet' type='text/css' href='../css/standard.css'/>
	<h2>UMBC COEIT Engineering and Computer Science Advising</h2>
  </head>
  <body>
    <div id="login">
      <div id="form">
        <div class="top">
	<h1>Edit Appointments</h1>
	<h2>Select advising type</h2><br>

	<form method="post" action="AdminProcessEdit.php">
	<div class="nextButton">
        <!-- Select individual or group -->
		<input type="submit" name="next" class="button medium go" value="Individual">
		<input type="submit" name="next" class="button medium go" value="Group" style="float: right;">
	</div>
	</form>
        </div>
	<form method="link" action="AdminUI.php">
	<input type="submit" name="next" class="button small go" value="Return to Home">
	</form>
         
	</div>
	<?php
		include ('footer.html');
	?>
	</div>
  </body>
  
</html>
