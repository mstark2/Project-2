<?php
session_start();
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Exit Message</title>
    <link rel='stylesheet' type='text/css' href='../css/standard.css'/>
	<h2>UMBC COEIT Engineering and Computer Science Advising</h2>
  </head>
  <body>
    <div id="login">
      <div id="form">
        <div class="top">
	    <div class="statusMessage">
	    <?php
			$_SESSION["resch"] = false;
            
            //Get student info
			$studid = $_SESSION["userID"];

			$sql = "select * from Proj2Students where `StudentID` like '%$studID%'";
			$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			$row = mysql_fetch_row($rs);
            
			//$status = $row[6];
            
            //Display message based on the student's status after processing appointment
			if($status == "complete"){ //Completed sign up with no problems
				echo "<r>You have completed your sign-up for an advising appointment.</r>";
			}
			elseif($status == "none"){ //Does not have an appointment
				echo "<r>You did not sign up for an advising appointment.</r>";
			}
			if($status == "cancel"){ //Decided to cancel their previously scheduled appointment
				echo "<r>You have cancelled your advising appointment.</r>";
			}
			if($status == "resch"){ //Decided to reschedule their previous appointment
				echo "<r>You have changed your advising appointment.</r>";
			}
			if($status == "keep"){ //Decided not to change the appointment and just keep it
				echo "<r>No changes have been made to your advising appointment.</r>";
			}
		?>
        </div>
		<br>
		<form action="02StudHome.php" method="post" name="complete">
		</div>
	    <div class="returnButton">
			<input type="submit" name="return" class="button small go" value="Return to Home">
	    </div>
		</form>
	<?php
		include ('footer.html');
	?>	
  </body>
</html>
