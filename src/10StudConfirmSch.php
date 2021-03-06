<?php
session_start();
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Confirm Appointment</title>
	<link rel='stylesheet' type='text/css' href='../css/standard.css'/>  </head>
	<h2>UMBC COEIT Engineering and Computer Science Advising</h2>
  <body>
	<div id="login">
      <div id="form">
        <div class="top">
		<h1>Confirm Appointment</h1>
	    <div class="field">
        <!-- Process if they confirm -->
		<form action = "StudProcessSch.php" method = "post" name = "SelectTime">
	    <?php
			$debug = false;
			include('../CommonMethods.php');
			$COMMON = new Common($debug);
			
            $studid = $_SESSION["userID"];

			$sql = "select * from Proj2Students where `StudentID` = '$studid'";
			$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			$row = mysql_fetch_row($rs);

            //used to be assigned to session vars
			$firstn = $row[1];
			$lastn = $row[2];
			$email = $row[4];
			$major = $row[5];
			
			
			
			if($_SESSION["resch"] == true){ //Student wants to reschedule
                //Retrieve student's current appointment based on student ID
				$sql = "select * from Proj2Appointments where `EnrolledID` like '%$studid%'";
				$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
				$row = mysql_fetch_row($rs);
				$oldAdvisorID = $row[2];
				$oldDatephp = strtotime($row[1]);
				
				if($oldAdvisorID != 0){ //Advisor has a name, retrieve it
					$sql2 = "select * from Proj2Advisors where `id` = '$oldAdvisorID'";
					$rs2 = $COMMON->executeQuery($sql2, $_SERVER["SCRIPT_NAME"]);
					$row2 = mysql_fetch_row($rs2);
					$oldAdvisorName = $row2[1] . " " . $row2[2];
				}
				else{$oldAdvisorName = "Group";} //Advisor is just group
				
                //Display old appoitment info
				echo "<h2>Previous Appointment</h2>";
				echo "<label for='info'>";
				echo "Advisor: ", $oldAdvisorName, "<br>";
				echo "Appointment: ", date('l, F d, Y g:i A', $oldDatephp), "</label><br>";
			}
			
            //Retrieve current advisor info
			$currentAdvisorName;
			$currentAdvisorID = $_POST["advID"];
			$currentDatephp = $_POST["appTime"];

			if($currentAdvisorID != 0){ //Advisor has a name, retreive it
				$sql2 = "select * from Proj2Advisors where `id` = '$currentAdvisorID'";
				$rs2 = $COMMON->executeQuery($sql2, $_SERVER["SCRIPT_NAME"]);
				$row2 = mysql_fetch_row($rs2);
				$currentAdvisorName = $row2[1] . " " . $row2[2];
			}
			else{$currentAdvisorName = "Group";} //Advisor is just group
			
            //Display current appointment info
			echo "<h2>Current Appointment</h2>";
			echo "<label for='newinfo'>";
			echo "Advisor: ",$currentAdvisorName,"<br>";
			echo "Appointment: ",date('l, F d, Y g:i A', strtotime($currentDatephp)),"</label>";
			
		?>
        </div>
	    <div class="nextButton">
		<?php
            echo "<input type='hidden' value='", $currentAdvisorID, "' name='advID'>";
            echo "<input type='hidden' value='", $currentDatephp, "' name='appTime'>";
			if($_SESSION["resch"] == true){
				echo "<input type='submit' name='finish' class='button medium go' value='Reschedule'>";
			}
			else{
				echo "<input type='submit' name='finish' class='button medium go' value='Submit'>";
			}
		?>
	    </div>
		</div>
			<input type="submit" name="finish" class="button small go" value="Cancel">
		</form>
	<?php
		include ('footer.html');
	?>
  </body>
</html>
