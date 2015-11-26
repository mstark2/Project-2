<?php
session_start();
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting (E_ALL);
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Student Advising Home</title>
	<link rel='stylesheet' type='text/css' href='../css/standard.css'/>
	<h2>UMBC COEIT Engineering and Computer Science Advising</h2>
  </head>
  <body>
    <div id="login">
      <div id="form">
        <div class="top">
		<h2>Hello 
		<?php
			echo $_SESSION["firstN"];
		?>
        </h2>
		<br>
	    <div class="selections">
		<form action="StudProcessHome.php" method="post" name="Home">
	    <?php
			$debug = false;
			include('../CommonMethods.php');
			$COMMON = new Common($debug);
			
			$_SESSION["studExist"] = false;
			$adminCancel = false;
			$noApp = false;
			$studid = $_SESSION["studID"];

            //Get the student's row from the table based on the ID
			$sql = "select * from Proj2Students where `StudentID` = '$studid'";
			$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			$row = mysql_fetch_row($rs);
			
            //Check the status of the student if they exist
			if (!empty($row)){
				$_SESSION["studExist"] = true;
				if($row[6] == 'C'){ //Student's status is Canceled
					$adminCancel = true;
				}
				if($row[6] == 'N'){ //Student's status is No appointment
					$noApp = true;
				}
			}
            
            //Student doesn't exist, administrator canceled the appointment, or student just doesn't have an appointment yet
			if ($_SESSION["studExist"] == false || $adminCancel == true || $noApp == true){
				if($adminCancel == true){
					echo "<p style='color:red'>The advisor has cancelled your appointment! Please schedule a new appointment.</p>";
				}
				echo "<button type='submit' name='selection' class='button medium selection' value='Signup'>Signup for an appointment</button><br>";
                echo "<button type='submit' name = 'selection' class='button medium selection' value='Find'>Find next available appointment</button><br>";
			}
			else{ //Student already has an appointment, show extra options
				echo "<button type='submit' name='selection' class='button medium selection' value='View'>View my appointment</button><br>";
				echo "<button type='submit' name='selection' class='button medium selection' value='Reschedule'>Reschedule my appointment</button><br>";
				echo "<button type='submit' name='selection' class='button medium selection' value='Cancel'>Cancel my appointment</button><br>";
			}
			echo "<button type='submit' name='selection' class='button medium selection' value='Search'>Search for appointment</button><br>";
			echo "<button type='submit' name='selection' class='button medium selection' value='Edit'>Edit student information</button><br>";
		?>
		</form>
        </div>
		</div>
		<form action="Logout.php" method="post" name="Logout">
		<div class="logoutButton">
			<input type="submit" name="logout" class="button small go" value="Logout">
		</div>
		</form>
	<?php
		include ('footer.html');
	?>
  </body>
</html>
