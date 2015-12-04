<?php
session_start();

$debug = false;
include('../CommonMethods.php');
$COMMON = new Common($debug);

//Retrieve all students
$sql = "select * from Proj2Students";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

//Look through the results until we find our student
while($row = mysql_fetch_row($rs)){
	if($row[3] == $_SESSION["studID"]){ //the current student
		
    //Display info
		$_SESSION["firstN"] = $row[1];
		$_SESSION["lastN"] = $row[2];
		$_SESSION["email"] = $row[4];
		$_SESSION["major"] = $row[5];
	}
}

?>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Edit Student Information</title>
    <link rel='stylesheet' type='text/css' href='../css/standard.css'/>
	<h2>UMBC COEIT Engineering and Computer Science Advising</h2>
  </head>
  <body>
    <div id="login">
      <div id="form">
			<div class="top">
            <!--------------------------------------------------------
            Change first name, last name, student ID, email, or major 
            ----------------------------------------------------------->
			<h2>Edit Student Information<span class="login-create"></span></h2>
			<form action="StudProcessEdit.php" method="post" name="Edit">
			<div class="field">
				<label for="firstN">First Name</label>
				<input id="firstN" size="30" maxlength="50" type="text" name="firstN" required value=<?php echo $_SESSION["firstN"]?>>
			</div>
			<div class="field">
			  <label for="lastN">Last Name</label>
			  <input id="lastN" size="30" maxlength="50" type="text" name="lastN" required value=<?php echo $_SESSION["lastN"]?>>
			</div>
			<div class="field">
				<label for="studID">Student ID</label>
				<input id="studID" size="30" maxlength="7" type="text" pattern="[A-Za-z]{2}[0-9]{5}" title="AB12345" name="studID" disabled value=<?php echo $_SESSION["studID"]?>>
			</div>
			<div class="field">
				<label for="email">E-mail</label>
				<input id="email" size="30" maxlength="255" type="email" name="email" required value=<?php echo $_SESSION["email"]?>>
			</div>
			<div class="field">
				  <label for="major">Major</label>
				  <select id="major" name = "major">
                    <!-- Change major, shows which one was selected -->
					<option <?php if($row[5] == 'Computer Engineering'){echo("selected");}?>>Computer Engineering</option>
					<option <?php if($row[5] == 'Computer Science'){echo("selected");}?>>Computer Science</option>
					<option <?php if($row[5] == 'Mechanical Engineering'){echo("selected");}?>>Mechanical Engineering</option>
					<option <?php if($row[5] == 'Chemical Engineering '){echo("selected");}?>>Chemical Engineering</option>
<!-- someday
					<option <?php if($row[5] == 'Africana Studies'){echo("selected");}?>>Africana Studies</option>
					<option <?php if($row[5] == 'American Studies'){echo("selected");}?>>American Studies</option>
					<option <?php if($row[5] == 'Ancient Studies'){echo("selected");}?>>Ancient Studies</option>
					<option <?php if($row[5] == 'Anthropology'){echo("selected");}?>>Anthropology</option>
					<option <?php if($row[5] == 'Asian Studies'){echo("selected");}?>>Asian Studies</option>
					<option <?php if($row[5] == 'Biochemistry and Molecular Biology'){echo("selected");}?>>Biochemistry and Molecular Biology</option>
					<option <?php if($row[5] == 'Bioinformatics and Computational Biology'){echo("selected");}?>>Bioinformatics and Computational Biology</option>
					<option <?php if($row[5] == 'Biological Sciences'){echo("selected");}?>>Biological Sciences</option>
					<option <?php if($row[5] == 'Business Technology Administration'){echo("selected");}?>>Business Technology Administration</option>
					<option <?php if($row[5] == 'Chemistry'){echo("selected");}?>>Chemistry</option>
					<option <?php if($row[5] == 'Dance'){echo("selected");}?>>Dance</option>
					<option <?php if($row[5] == 'Economics'){echo("selected");}?>>Economics</option>
					<option <?php if($row[5] == 'Financial Economics'){echo("selected");}?>>Financial Economics</option>
					<option <?php if($row[5] == 'Emergency Health Services'){echo("selected");}?>>Emergency Health Services</option>
					<option <?php if($row[5] == 'English'){echo("selected");}?>>English</option>
					<option <?php if($row[5] == 'Environmental Science and Environmental Studies'){echo("selected");}?>>Environmental Science and Environmental Studies</option>
					<option <?php if($row[5] == 'Gender and Womens Studies'){echo("selected");}?>>Gender and Womens Studies</option>
					<option <?php if($row[5] == 'Geography'){echo("selected");}?>>Geography</option>
					<option <?php if($row[5] == 'Global Studies'){echo("selected");}?>>Global Studies</option>
					<option <?php if($row[5] == 'Health Administration and Policy'){echo("selected");}?>>Health Administration and Policy</option>
					<option <?php if($row[5] == 'History'){echo("selected");}?>>History</option>
					<option <?php if($row[5] == 'Information Systems'){echo("selected");}?>>Information Systems</option>
					<option <?php if($row[5] == 'Interdisciplinary Studies'){echo("selected");}?>>Interdisciplinary Studies</option>
					<option <?php if($row[5] == 'Management of Aging Services'){echo("selected");}?>>Management of Aging Services</option>
					<option <?php if($row[5] == 'Mathematics'){echo("selected");}?>>Mathematics</option>
					<option <?php if($row[5] == 'Statistics'){echo("selected");}?>>Statistics</option>
					<option <?php if($row[5] == 'Media and Communication Studies'){echo("selected");}?>>Media and Communication Studies</option>
					<option <?php if($row[5] == 'Modern Languages, Linguistics and Intercultural Communication'){echo("selected");}?>>Modern Languages, Linguistics and Intercultural Communication</option>
					<option <?php if($row[5] == 'Music'){echo("selected");}?>>Music</option>
					<option <?php if($row[5] == 'Philosophy'){echo("selected");}?>>Philosophy</option>
					<option <?php if($row[5] == 'Physics'){echo("selected");}?>>Physics</option>
					<option <?php if($row[5] == 'Political Sciences'){echo("selected");}?>>Political Science</option>
					<option <?php if($row[5] == 'Psychology'){echo("selected");}?>>Psychology</option>
					<option <?php if($row[5] == 'Social Work'){echo("selected");}?>>Social Work</option>
					<option <?php if($row[5] == 'Sociology'){echo("selected");}?>>Sociology</option>
					<option <?php if($row[5] == 'Theatre'){echo("selected");}?>>Theatre</option>
					<option <?php if($row[5] == 'Visual Arts'){echo("selected");}?>>Visual Arts</option>
					<option <?php if($row[5] == 'Undecided'){echo("selected");}?>>Undecided</option>
					<option <?php if($row[5] == 'Other'){echo("selected");}?>>Other</option>
-->
					</select>
			</div>
			<div class="nextButton">
				<input type="submit" name="save" class="button medium go" value="Save">
			</div>
			</div>
			<form method="link" action="02StudHome.php">
				<input type="submit" name="home" class="button small" value="Cancel">
			</form>
		</form>
	<?php
		include ('footer.html');
	?>
  </body>
  
</html>
