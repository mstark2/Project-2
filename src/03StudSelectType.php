<?php
session_start();
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Select Advising Type</title>
	<link rel='stylesheet' type='text/css' href='../css/standard.css'/>
  </head>
  <body>
    <div id="login">
      <div id="form">
        <div class="top">
		<h1>Schedule Appointment</h1>
		<h2>What kind of advising appointment would you like?</h2><br>
	<form action="StudProcessType.php" method="post" name="SelectType">
	<div class="nextButton">
        <!-- Select individual or group appointment -->
		<input type="submit" name="type" class="button medium go" value="Individual">
		<input type="submit" name="type" class="button medium go" value="Group" style="float: right;">
	    </div>
		</div>
		</form>


<br>
<br>
		<div>
        <!-- Cancel and return home -->
		<form method="link" action="02StudHome.php">
		<input type="submit" name="home" class="button small" value="Cancel">
		</form>
		</div>
  	<?php
		include ('footer.html');
	?>
  </body>
</html>
