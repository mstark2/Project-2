<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Create New Admin</title>
    <script type="text/javascript">
    function saveValue(target){
	var stepVal = document.getElementById(target).value;
	alert("Value: " + stepVal);
    }
    </script>
    <link rel="stylesheet" type="text/css" href="../css/standard.css"/>
	<h2>UMBC COEIT Engineering and Computer Science Advising</h2>
  </head>
  <body>
    <div id="login">
      <div id="form">
        <div class="top">
		<h2>New Advisor has been created:</h2>

		<?php
            //Cache advisor info
			$first = $_SESSION["AdvF"];
			$last = $_SESSION["AdvL"];
			$user = $_SESSION["AdvUN"];
			$pass = $_SESSION["AdvPW"];
            $office = $_SESSION["AdvO"];

			include('../CommonMethods.php');
			$debug = false;
			$Common = new Common($debug);

            //Retrieve advisor based on username and name
            $sql = "SELECT * FROM `Proj2Advisors` WHERE `Username` = '$user' AND `FirstName` = '$first' AND  `LastName` = '$last'";
            $rs = $Common->executeQuery($sql, "Advising Appointments");
            $row = mysql_fetch_row($rs);
            if($row){ //A match was found, the advisor already exists
                echo("<h3>Advisor $first $last already exists</h3>");
            }
            else{ //Advisor doesn't exist yet, insert info
  			   $sql = "INSERT INTO `Proj2Advisors`(`FirstName`, `LastName`, `Username`, `Password`, `Office`) VALUES ('$first', '$last', '$user', '$pass', '$office')";
                echo ("<h3>$first $last<h3>");
                $rs = $Common->executeQuery($sql, "Advising Appointments");
            }
		?>
	</div>
	</div>
		<form method="link" action="AdminUI.php">
			<input type="submit" name="next" class="button small go" value="Return to Home">
		</form>
	<?php
		include ('footer.html');
	?>
	</div>
	</form>
  </body>
  
</html>
