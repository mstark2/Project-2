<?php
session_start();
//ini_set('display_errors','1');
//ini_set('display_startup_errors','1');
//error_reporting (E_ALL);

$debug = false;
include('../CommonMethods.php');
$COMMON = new Common($debug);
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Search for Appointment</title>
	<link rel='stylesheet' type='text/css' href='../css/standard.css'/>
	<h2>UMBC COEIT Engineering and Computer Science Advising</h2>
  </head>
  <body>
    <div id="login">
      <div id="form">
        <div class="top">
		<h1>Search Results</h1>
		<h3>Showing open appointments only</h3>
	    <div class="field">
			<p>Showing results for: </p>
			<?php
                //Get search info
				$date = $_POST["date"];
				$times = $_POST["time"];
				$advisor = $_POST["advisor"];
				$results = array();
				
                //Display date  that was searched for
				if($date == ''){ echo "Date: All"; } //No date specified
				else{ //Display date specified
					echo "Date: ",$date;
					$date = date('Y-m-d', strtotime($date));
				}
				echo "<br>";
                //Display times that were searched for
				if(empty($times)){ echo "Time: All"; } //No time specified
				else{ //Display times specified
					$i = 0;
					echo "Time: ";

					foreach($times as $t){
						echo ++$i, ") ", date('g:i A', strtotime($t)), " ";
					}
				}
				echo "<br>";
                //Display all advisors, all individual, all group, or specific advisor
				if($advisor == ''){ echo "Advisor: All appointments"; }
				elseif($advisor == 'I'){ echo "Advisor: All individual appointments"; }
				elseif($advisor == '0'){ echo "Advisor: All group appointments"; }
				else{
					$sql = "select * from Proj2Advisors where `id` = '$advisor'";
					$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
                    //Display advisor name
					while($row = mysql_fetch_row($rs)){
						echo "Advisor: ", $row[1], " ", $row[2];
					}
				}
				?>
				<br><br><label>
				<?php
				if(empty($times)){ //No time specified
					if($advisor == 'I'){ //Retrieve individual appointments
						$sql = "select * from Proj2Appointments where `Time` like '%$date%' and `Time` > '".date('Y-m-d H:i:s')."' and `AdvisorID` != 0 and `EnrolledNum` = 0 and `Major` like '%".$_SESSION['major']."%' order by `Time` ASC Limit 30";
					}
					else{ //Retrieve group appointments
						$sql = "select * from Proj2Appointments where `Time` like '%$date%' and `Time` > '".date('Y-m-d H:i:s')."' and `AdvisorID` like '%$advisor%' and `EnrolledNum` = 0 and `Major` like '%".$_SESSION['major']."%' order by `Time` ASC Limit 30";
						
					}
                    //moved executeQuery from if/else block
                    $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
					$row = mysql_fetch_row($rs);
					$rsA = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
					if($row){
						
						while($row = mysql_fetch_row($rsA)){
							if($row[2] == 0){ //Group advisor
								$advName = "Group";
							}
							else{ $advName = getAdvisorName($row); } //Individual advisor
							

                            //Add new search result to results array
							$found = 	"<tr><td>". date('l, F d, Y g:i A', strtotime($row[1]))."</td>".
									"<td>". $advName."</td>". 
									"<td>". getFullMajors($row). "</td></tr>".

							array_push($results, $found);
						}
					}
				
				else{ //Display available appointments for specified times
					if($advisor == 'I'){ //Individual advisor
						foreach($times as $t){ //Retrieve appointments for selected times
							$sql = "select * from Proj2Appointments where `Time` like '%$date%' and `Time` > '".date('Y-m-d H:i:s')."' and `Time` like '%$t%' and `AdvisorID` != 0 and `EnrolledNum` = 0 and `Major` like '%".$_SESSION['major']."%' order by `Time` ASC Limit 30";
							$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
							$row = mysql_fetch_row($rs);
							$rsA = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
							if($row){
								while($row = mysql_fetch_row($rsA)){
									if($row[2] == 0){ //Group advisor, no name
										$advName = "Group";
									}
									else{ $advName = getAdvisorName($row); } //Get individual advisor name

                            //Add new search result to results array 
							$found = 	"<tr><td>". date('l, F d, Y g:i A', strtotime($row[1]))."</td>".
									"<td>". $advName."</td>". 
									"<td>". $row[3]. "</td></tr>".
									array_push($results, $found);
								}
							}
						}
					}
					else{ //Group advisor
						foreach($times as $t){ //Retrieve appointments for selected times
							$sql = "select * from Proj2Appointments where `Time` like '%$date%' and `Time` > '".date('Y-m-d H:i:s')."' and `Time` like '%$t%' and `AdvisorID` like '%$advisor%' and `EnrolledNum` = 0 and `Major` like '%".$_SESSION['major']."%' order by `Time` ASC Limit 30";
							$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
							$row = mysql_fetch_row($rs);
							if($row){
								while($row = mysql_fetch_row($rs)){
									if($row[2] == 0){ //Group advisor, no name
										$advName = "Group";
									}
									else{ $advName = getAdvisorName($row); } //Get individual advisor name

							$found = 	"<tr><td>". date('l, F d, Y g:i A', strtotime($row[1]))."</td>".
									"<td>". $advName."</td>". 
									"<td>". getFullMajors($row) . "</td></tr>".
									array_push($results, $found);
								}
							}
						}
					}
				}
				if(empty($results)){
					echo "No results found.<br><br>";
				}
				else{ //There were some results
					echo("<table border='1'><th colspan='3'>Appointments Available</th>\n");
					echo("<tr><td width='60px'>Time:</td><td>Advisor</td><td>Major</td></tr>\n");

                    //Display each results
					foreach($results as $r){ echo($r."\n"); }

					echo("</table>");
				}
			?>
			</label>
        </div>
		<form action="02StudHome.php" method="link">
	    <div class="nextButton">
			<input type="submit" name="done" class="button large go" value="Done">
	    </div>
		</form>
		</div>
		<div class="bottom">
		<p>If the Major category is followed by a blank, then it is open for all majors.</p>
		</div>
	<?php
		include ('footer.html');
	?>
  </body>
</html>

<?php


// More code reduction by Lupoli - 9/1/15
// just getting the advisor's name
function getAdvisorName($row)
{
	global $debug; global $COMMON;
	$sql2 = "select * from Proj2Advisors where `id` = '$row[2]'";
	$rs2 = $COMMON->executeQuery($sql2, $_SERVER["SCRIPT_NAME"]);
	$row2 = mysql_fetch_row($rs2);
	return $row2[1] ." ". $row2[2];
}

//Convert from major abbreviation to fully spelled version for display
function getFullMajors($row)
{
	global $debug; global $COMMON;
    
    $str = ""; //Empty string to concatenate onto
    
    //Concatenate full version if abbreviation is in the row given
    if (strpos($row[3], 'CMSC') !== FALSE) {
        $str = $str . "Computer Science, ";
    }
    if (strpos($row[3], 'CMPE') !== FALSE) {
        $str = $str . "Computer Engineering, ";
    }
    if (strpos($row[3], 'MENG') !== FALSE) {
        $str = $str . "Mechanical Engineering, ";
    }
    if (strpos($row[3], 'CENG') !== FALSE) {
        $str = $str . "Chemical Engineering, ";
    }
    if (strpos($row[3], 'ENGR') !== FALSE) {
        $str = $str . "Engineering";
    }
    
	return $str; //Final result, could be empty
}

?>