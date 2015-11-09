<?php
session_start();
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Exit Message</title>
    <link rel='stylesheet' type='text/css' href='../css/StudExit.css'/>
  </head>
  <body>
    <div id="login">
      <div id="form">
        <div class="top">
	    <div class="statusMessage">
	    <?php
			$_SESSION["resch"] = false;			
            
            //Display message based on the student's status after processing appointment
			if($_SESSION["status"] == "complete"){ //Completed sign up with no problems
				echo "You have completed your sign-up for an advising appointment.";
			}
			elseif($_SESSION["status"] == "none"){ //Does not have an appointment
				echo "You did not sign up for an advising appointment.";
			}
			if($_SESSION["status"] == "cancel"){ //Decided to cancel their previously scheduled appointment
				echo "You have cancelled your advising appointment.";
			}
			if($_SESSION["status"] == "resch"){ //Decided to reschedule their previous appointment
				echo "You have changed your advising appointment.";
			}
			if($_SESSION["status"] == "keep"){ //Decided not to change the appointment and just keep it
				echo "No changes have been made to your advising appointment.";
			}
		?>
        </div>
		<form action="02StudHome.php" method="post" name="complete">
	    <div class="returnButton">
			<input type="submit" name="return" class="button large go" value="Return to Home">
	    </div>
		</div>
		</form>
  </body>
</html>