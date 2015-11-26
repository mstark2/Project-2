<?php
session_start();
$debug = false;

//Set session advisor
if(isset($_POST["advisor"])){
	$_SESSION["advisor"] = $_POST["advisor"];
}

//Cache advisor and major
$localAdvisor = $_SESSION["advisor"];
$localMaj = $_SESSION["major"];

include('../CommonMethods.php');
$COMMON = new Common($debug);

//Retrieve the chosen advisor
$sql = "select * from Proj2Advisors where `id` = '$localAdvisor'";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
$row = mysql_fetch_row($rs);
$advisorName = $row[1]." ".$row[2];
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Select Appointment</title>
	<link rel='stylesheet' type='text/css' href='../css/standard.css'/>
	<h2>UMBC COEIT Engineering and Computer Science Advising</h2>

  </head>
  <body>
    <div id="login">
      <div id="form">
        <div class="top">
		<h1>Select Appointment Time</h1>
	    <div class="field">
		<form action = "10StudConfirmSch.php" method = "post" name = "SelectTime">
	    <?php

// http://php.net/manual/en/function.time.php fpr SQL statements below
// Comparing timestamps, could not remember. 

			$curtime = time();

			if ($_SESSION["advisor"] != "Group")  // for individual conferences only
			{ 
                //Retrieve available individual appointments for  major with chosen advisor
				$sql = "select * from Proj2Appointments where `EnrolledNum` = 0 and (`Major` like '%$localMaj%' or `Major` = '') and `Time` > '".date('Y-m-d H:i:s')."' and `AdvisorID` = ".$_POST['advisor']." order by `Time` ASC limit 30";
				echo "<h2>Individual Advising</h2><br>";
				echo "<label for='prompt'>Select appointment with ",$advisorName, " (maximum 30 minutes long):</label><br>";
			}
			else // for group conferences
			{
				$temp = "";
				if($localAdvisor != "Group") { $temp = "`AdvisorID` = '$localAdvisor' and "; }
                
                //Retrieve available group appointments for major
				$sql = "select * from Proj2Appointments where $temp `EnrolledNum` < `Max` and `Max` > 1 and (`Major` like '%$localMaj%' or `Major` = '')  and `Time` > '".date('Y-m-d H:i:s')."' order by `Time` ASC limit 30";
				
				echo "<h2>Group Advising</h2><br>";
				echo "<label for='prompt'>Select appointment:</label><br>";
			}
            //moved executeQuery outside if/else blocks
            $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

            //Display all available appointments
			while($row = mysql_fetch_row($rs)){
				$datephp = strtotime($row[1]);
				echo "<label for='",$row[0],"'>";
				echo "<input id='",$row[0],"' type='radio' name='appTime' required value='", $row[1], "'>", date('l, F d, Y g:i A', $datephp) ,"</label><br>\n";
			}
		?>
        </div>
	    <div class="nextButton">
			<input type="submit" name="next" class="button medium go" value="Next">
	    </div>
		</form>
	</div>
		<div class="field">
			<div class="bottom">
				<p style="color:red; font-size: 15px;">If there are no more open appointments, contact your advisor or click <a href='02StudHome.php'>here</a> to start over.</p>
			</div>
			<!-- Cancel and return home -->
			<form method="link" action="02StudHome.php">
				<input type="submit" name="home" class="button small" value="Cancel">
			</form>
		</div>
	</div>
	<?php
		include ('footer.html');
	?>
	</div>
  </body>
</html>
