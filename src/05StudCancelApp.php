<?php
session_start();
$debug = false;
include('../CommonMethods.php');
$COMMON = new Common($debug);
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Cancel Appointment</title>
    <link rel='stylesheet' type='text/css' href='../css/standard.css'/>
	<h2>UMBC COEIT Engineering and Computer Science Advising</h2>
  </head>
  <body>
    <div id="login">
      <div id="form">
        <div class="top">
		<h1>Cancel Appointment</h1>
	    <div class="field">
	    <?php
      //Get student info
			$studid = $_SESSION["studID"];

			$sql = "select * from Proj2Appointments where `StudentID` = '$studid";
			$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			$row = mysql_fetch_row($rs);

			$firstn = $row[1]; //$_SESSION["firstN"];
			$lastn = $row[2]; //$_SESSION["lastN"];
			$email = $row[4]; //$_SESSION["email"];
			$major = $row[5]; //$_SESSION["major"];
			
      //Retrieve current appointment
			$sql = "select * from Proj2Appointments where `EnrolledID` like '%$studid%'";
			$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			$row = mysql_fetch_row($rs);
			$oldAdvisorID = $row[2];
			$oldDatephp = strtotime($row[1]);				
				
			if($oldAdvisorID != 0){ //Individual appointment, get advisor
				$sql2 = "select * from Proj2Advisors where `id` = '$oldAdvisorID'";
				$rs2 = $COMMON->executeQuery($sql2, $_SERVER["SCRIPT_NAME"]);
				$row2 = mysql_fetch_row($rs2);					
				$oldAdvisorName = $row2[1] . " " . $row2[2];
			}
			else{$oldAdvisorName = "Group";} //Advisor is just group
			
      //Display appointment info
			echo "<h2>Current Appointment</h2>";
			echo "<label for='info'>";
			echo "Advisor: ", $oldAdvisorName, "<br>";
			echo "Appointment: ", date('l, F d, Y g:i A', $oldDatephp), "</label><br>";
		?>		
        </div>
	    <div class="finishButton">
      <!-- Cancel or Keep appointment -->
			<form action = "StudProcessCancel.php" method = "post" name = "Cancel">
			<input type="submit" name="cancel" class="button medium go" value="Cancel">
			<input type="submit" name="cancel" class="button medium go" value="Keep" style="float: right;">
			</form>
	    </div>
		</div>
		<div class="bottom">
			<p style="font-size: 13px; color: red;">Click "Cancel" to cancel appointment. Click "Keep" to keep appointment.</p>
		</div>
		</form>
	<?php
		include ('footer.html');
	?>
  </body>
</html>
