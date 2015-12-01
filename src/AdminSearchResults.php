<?php
session_start();
$debug = false;
include('../CommonMethods.php');
$COMMON = new Common($debug); 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Search Appointments</title>
    <script type="text/javascript">
    function saveValue(target){
	var stepVal = document.getElementById(target).value;
	alert("Value: " + stepVal);
    }
    </script>
	<link rel='stylesheet' type='text/css' href='../css/standard.css'/>
  </head>
  <body>
    <div id="login">
      <div id="form">
        <div class="top">
			<h1>Search results</h1>
			<div class="field">
			<p>Showing results for: </p>
			<?php
                //Cache necessary info
				$date = $_POST["date"];
				$times = $_POST["time"];
				$advisor = $_POST["advisor"];
				$studID = $_POST["studID"];
				$studLN = $_POST["studLN"];
				$filter = $_POST["filter"];

				$results = array(); //Will hold search results

				
				if($date == ''){ echo "Date: All"; } //No date specified
				else{ //Display specified date
					echo "Date: ",$date;
					$date = date('Y-m-d', strtotime($date));
				}
				echo "<br>";
				if(empty($times)){ echo "Time: All"; } //No times specified
				else{ //Display specified times
					$i = 0;
					echo "Time: ";
					foreach($times as $t){
						echo ++$i, ") ", date('g:i A', strtotime($t)), " ";
					}
				}
				echo "<br>";
				if($advisor == ''){ echo "Advisor: All appointments"; } //No type specified
				elseif($advisor == 'I'){ echo "Advisor: All individual appointments"; } //Only individual
				elseif($advisor == '0'){ echo "Advisor: All group appointments"; } //Only group
				else{ //Specific advisor
					$sql = "select * from Proj2Advisors where `id` = '$advisor'";
					$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
					while($row = mysql_fetch_row($rs)){
						echo "Advisor: ", $row[1], " ", $row[2];
					}
				}
				echo "<br>";
				if($studID == '' && $studLN == ''){	echo "Student: All"; } //No student specified by ID or last name
				else{ //Retrieve specified student
					$studLN = strtoupper($studLN);
					$studID = strtoupper($studID);
					$sql = "select `LastName`, `StudentID` from Proj2Students where `StudentID` = '$studID' or `LastName` = '$studLN'";
					$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
					$row = mysql_fetch_row($rs);
                    //Display student info
					$studLN = $row[0];
					$studID = $row[1];
					echo "Student: ", $studID, " ", $studLN;
				}
				echo "<br>";
				if($filter == ''){ echo "Filter: All appointments"; } //No filter specified
				elseif($filter == 0){ echo "Filter: Open appointments"; } //Show only open
				elseif($filter == 1){ echo "Filter: Closed appointments"; } //Show only closed
				?>
				<br><br><label>
				<?php
				if(empty($times)){ //No time specified
					if($advisor == 'I'){ //Individual advisor
						if($filter == 1){ //Closed appointments only
                            //Retrieve appointments that match specifications
							$sql = "select * from Proj2Appointments where `Time` like '%$date%' and 
								`AdvisorID` != 0 and 
								`EnrolledID` like '%$studID%' and 
								`EnrolledNum` >= 1 order by `Time` ASC";
						}
						else{ //Open appointments
                            //Retrieve appointments that match specifications
							$sql = "select * from Proj2Appointments where `Time` like '%$date%' and 
								`AdvisorID` != 0 and 
								`EnrolledID` like '%$studID%' and 
								`EnrolledNum` like '%$filter%' order by `Time` ASC";
						}
					}
					else{ //Group
						if($filter == 1){ //Closed appointments only
                            //Retrieve appointments that match specifications
							$sql = "select * from Proj2Appointments where `Time` like '%$date%' and 
								`AdvisorID` like '%$advisor%' and 
								`EnrolledID` like '%$studID%' and 
								`EnrolledNum` >= 1 order by `Time` ASC";
						}
						else{ //Open appointments
                            //Retrieve appointments that match specifications
							$sql = "select * from Proj2Appointments where `Time` like '%$date%' and 
								`AdvisorID` like '%$advisor%' and 
								`EnrolledID` like '%$studID%' and 
								`EnrolledNum` like '%$filter%' order by `Time` ASC";
						}
					}
					$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
					$row = mysql_fetch_row($rs);
					$rsA = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
					if($row){ //At least one matching appointment exists
						while($row = mysql_fetch_row($rsA)){ //For each matching appointment
							if($row[2] == 0){ //Advisor ID of 0 means group advisor
								$advName = "Group";
							}
							else{ //Individual, get advisor by ID
								$sql2 = "select * from Proj2Advisors where `id` = '$row[2]'";
								$rs2 = $COMMON->executeQuery($sql2, $_SERVER["SCRIPT_NAME"]);
								$row2 = mysql_fetch_row($rs2);
								$advName = $row2[1] ." ". $row2[2];
							}
                            //Description of appointment that was found
							$found = "Time: ". date('l, F d, Y g:i A', strtotime($row[1])). 
									"<br>Advisor: ". $advName. 
									"<br>Major: ". $row[3]. 
									"<br>Enrolled Students: ". $row[4]. 
									"<br>Number of enrolled student(s): ". $row[5]. 
									"<br>Maximum number of students allowed: ". $row[6]. "<br><br>";
                            //Add appointment to the list of search results
							array_push($results, $found);
						}
					}
				}
				else{
					if($advisor == 'I'){ //Individual
						foreach($times as $t){
							if($filter == 1){ //Closed appointments
								$sql = "select * from Proj2Appointments where `Time` like '%$date%' and `Time` like '%$t%' and 
									`AdvisorID` != 0 and 
									`EnrolledID` like '%$studID%' and
									`EnrolledNum` >= 1 order by `Time` ASC";
							}
							else{ //Open appointments
								$sql = "select * from Proj2Appointments where `Time` like '%$date%' and `Time` like '%$t%' and 
									`AdvisorID` != 0 and 
									`EnrolledID` like '%$studID%' and
									`EnrolledNum` like '%$filter%' order by `Time` ASC";
							}
							$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
							$row = mysql_fetch_row($rs);
							$rsA = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
							if($row){
								while($row = mysql_fetch_row($rsA)){
									if($row[2] == 0){ //Advisor ID is group
										$advName = "Group";
									}
									else{ //Get advisor by ID
										$sql2 = "select * from Proj2Advisors where `id` = '$row[2]'";
										$rs2 = $COMMON->executeQuery($sql2, $_SERVER["SCRIPT_NAME"]);
										$row2 = mysql_fetch_row($rs2);
										$advName = $row2[1] ." ". $row2[2];
									}
                                    //Describe found appointment
									$found = "Time: ". date('l, F d, Y g:i A', strtotime($row[1])). 
											"<br>Advisor: ". $advName. 
											"<br>Major: ". $row[3]. 
											"<br>Enrolled Students: ". $row[4]. 
											"<br>Number of enrolled student(s): ". $row[5]. 
											"<br>Maximum number of students allowed: ". $row[6]. "<br><br>";
                                    //Add appointment to list of search results
									array_push($results, $found);
								}
							}
						}
					}
					else{
						foreach($times as $t){ //For all specified times
							if ($filter == 1){ //Closed appointments
								$sql = "select * from Proj2Appointments where `Time` like '%$date%' and `Time` like '%$t%' and 
									`AdvisorID` like '%$advisor%' and 
									`EnrolledID` like '%$studID%' and 
									`EnrolledNum` >= 1 order by `Time` ASC";
							}
							else{ //Open appointments
								$sql = "select * from Proj2Appointments where `Time` like '%$date%' and `Time` like '%$t%' and 
									`AdvisorID` like '%$advisor%' and 
									`EnrolledID` like '%$studID%' and 
									`EnrolledNum` like '%$filter%' order by `Time` ASC";
							}
							$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
							$row = mysql_fetch_row($rs);
							$rsA = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
							if($row){
								while($row = mysql_fetch_row($rsA)){ //For each appointment
									if($row[2] == 0){ //ID is group
										$advName = "Group";
									}
									else{ //Get advisor by ID
										$sql2 = "select * from Proj2Advisors where `id` = '$row[2]'";
										$rs2 = $COMMON->executeQuery($sql2, $_SERVER["SCRIPT_NAME"]);
										$row2 = mysql_fetch_row($rs2);
										$advName = $row2[1] ." ". $row2[2];
									}
                                    //Describe found appointment
									$found = "Time: ". date('l, F d, Y g:i A', strtotime($row[1])). 
											"<br>Advisor: ". $advName. 
											"<br>Major: ". $row[3]. 
											"<br>Enrolled Students: ". $row[4]. 
											"<br>Number of enrolled student(s): ". $row[5]. 
											"<br>Maximum number of students allowed: ". $row[6]. "<br><br>";
                                    //Add appointment to list of search results
									array_push($results, $found);
								}
							}
						}
					}
				}
				if(empty($results)){
					echo "No results found.<br><br>";
				}
				else{ //There were results
					foreach($results as $r){
					echo $r;
					}
				}
				?>
				</label>
		<form method="link" action="AdminUI.php" name="home">
			<input type="submit" name="next" class="button large go" value="Return to Home">
		</form>
	</div>
	</div>
	</div>
	<div class="bottom">
		<p>If the Major category is followed by a blank, then it is open for all majors.</p>
	</div>
	<?php include('./workOrder/workButton.php'); ?>

	</div>
	</form>
	<?php
		include ('footer.html');
	?>
  </body>
  
</html>
