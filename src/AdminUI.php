<?php 
session_start();
$debug = false;

if($debug) { echo("Session variables-> ".var_dump($_SESSION)); }

include('../CommonMethods.php');
$COMMON = new Common($debug);
$_SESSION["PassCon"] = false;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Admin Home</title>
	<link rel='stylesheet' type='text/css' href='../css/standard.css'/>
	<h2>UMBC COEIT Engineering and Computer Science Advising</h2>
  </head>
  <body>
    <div id="login">
      <div id="form">
        <div class="top">
	<h2> Hello 
	<?php

	if(!isset($_SESSION["userID"])) // someone landed this page by accident
	{
		return;
	}		

        $id = $_SESSION["userID"];
        //Retrieve the advisor based on id
		$sql = "SELECT `firstName` FROM `Proj2Advisors` WHERE `id` = '$id'";

        //Get username and password
		$User = $row[3];
		$Pass = $row[4];

		$rs = $COMMON->executeQuery($sql, $_SERVER["AdminUI"]);
		$row = mysql_fetch_row($rs);
		echo $row[0];
	?>
	</h2>
	<br>
	
	<form action="AdminProcessUI.php" method="post" name="UI">
        <!-- Options for admin -->
		<input type="submit" name="next" class="button medium selection" value="Schedule appointments"><br>
		<input type="submit" name="next" class="button medium selection" value="Print schedule for a day"><br>
		<input type="submit" name="next" class="button medium selection" value="Edit appointments"><br>
		<input type="submit" name="next" class="button medium selection" value="Search for an appointment"><br>
		<input type="submit" name="next" class="button medium selection" value="Create new Admin Account"><br>
	
	</form>
	<br>

          
        </div>
        <div class="bottom">
          
	<form method="link" action="Logout.php">
		<input type="submit" name="next" class="button small go" value="Log Out">
	</form>
	<?php include('./workOrder/workButton.php'); ?>
        </div>
	<?php
		include ('footer.html');
	?>
	</div>


</body>
  
</html>
