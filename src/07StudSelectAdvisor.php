<?php
session_start();
$debug = false;
include('../CommonMethods.php');
$COMMON = new Common($debug);
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Select Advisor</title>
	<link rel='stylesheet' type='text/css' href='../css/standard.css'/>
	<h2>UMBC COEIT Engineering and Computer Science Advising</h2>
  </head>
  <body>
    <div id="login">
      <div id="form">
        <div class="top">
		<h1>Individual Advising</h1>
		<h2>Select Advisor</h2>
	    <div class="field">
        <!-- Continue on to selecting time once advisor is selected -->
		<form action="08StudSelectTime.php" method="post" name="SelectAdvisor">
	    <?php
            //Display available advisors
			$sql = "select * from Proj2Advisors";
			$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			while($row = mysql_fetch_row($rs)){
				echo "<label for='",$row[0],"'><input id='",$row[0],"' type='radio' name='advisor' required value='", $row[0],"'>", $row[1]," ", $row[2],"</label><br>";
			}
		?>
        </div>
	    <div class="nextButton">
			<input type="submit" name="next" class="button large go" value="Next">
	    </div>
		</div>
		</form>
		<div>
        <!-- Cancel and return home -->
		<form method="link" action="02StudHome.php">
		<input type="submit" name="home" class="button large" value="Cancel">
		</form>
		</div>
	<?php
		include ('footer.html');
	?>
  </body>
</html>
