<?php
session_start();
$debug = false;
include('../CommonMethods.php');
$COMMON = new Common($debug);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
	<link rel='stylesheet' type='text/css' href='../css/standard.css'/>
	<h2>UMBC COEIT Engineering and Computer Science Advising</h2>
  </head>
  <body>
    <div id="login">
      <div id="form">
        <div class="top">
		<h2>Appointments Created</h2><br>
		<?php
            //Cache info
			$date = $_POST["Date"];
			$times = $_POST["time"];
			$majors = $_POST["major"];
			$repeatDays = $_POST["repeat"];
			$repeatWeek = $_POST["stepper"];
			$meetingRoom = $_POST["meetingRoom"];
			
			//one week with given start date (Ex. Thur - Wed) ['Thursday']=>[########]
			$d0 = $date;
			$d1 = '+1 day ' . $date;
			$d2 = '+2 day ' . $date;
			$d3 = '+3 day ' . $date;
			$d4 = '+4 day ' . $date;
			$d5 = '+5 day ' . $date;
			$d6 = '+6 day ' . $date;
			$oneweek = array(date('l', strtotime($d0)) => strtotime($d0),
							date('l', strtotime($d1)) => strtotime($d1),
							date('l', strtotime($d2)) => strtotime($d2),
							date('l', strtotime($d3)) => strtotime($d3),
							date('l', strtotime($d4)) => strtotime($d4),
							date('l', strtotime($d5)) => strtotime($d5),
							date('l', strtotime($d6)) => strtotime($d6)); 
			
			//initialize the first wk
			$dates = array();
			array_push($dates, date('Y-m-d',strtotime($date)));
			if(!empty($repeatDays)){
				foreach($repeatDays as $day){
					if($day != date("l", strtotime($date))){
						array_push($dates, date('Y-m-d',$oneweek[$day]));
					}
				}
			}
			//repeat weeks based on initial wk
			$countDates = count($dates);
			for($i=0; $i < $repeatWeek; $i++){
				for($j=0; $j < $countDates; $j++){
					$newDateStr = "+1 week " . $dates[$j + ($i * $countDates)];
					$newDate = date('Y-m-d',strtotime($newDateStr));
					array_push($dates, $newDate);
				}
			}
			
			//pair dates and times to make datetime things YYYY-MM-DD hh:mm:ss
			$datetimes = array();
			foreach($dates as $aDate){
				foreach($times as $time){
					$newDatetime = $aDate . " " . $time;
					array_push($datetimes, $newDatetime);
				}
			}
			
			//major stuff
			$majorDB = "";
			$majorPrint = "All";
			if(!empty($majors)){
				$majorPrint = "";
				foreach($majors as $m){
					$majorDB .= $m . " ";
					$majorPrint .= $m . ", ";
				}
				$majorPrint = substr($majorPrint, 0, -2);
			}
			
			// room stuff
            $id = $_SESSION["userID"];
            $sql = "select * from `Proj2Advisors` where `id` = '$id'";
            $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
            $row = mysql_fetch_row($rs);
            
            $User = $row[3];
            $Pass = $row[4];
            
            $office = $row[5];
            $roomPrint = "";
						
            if(!empty($meetingRoom)){
                $roomPrint = $meetingRoom;
            } else {
				$meetingRoom = $office;
                $roomPrint = $office;
            }
			
			
			//get advisor id
			///$sql = "select `id` from `Proj2Advisors` where `Username` = '$User' and `Password` = '$Pass'";
			//$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			//$row = mysql_fetch_row($rs);
			$id = $row[0];
			
			//make sure app doesn't exist
			//insert new app to DB
			//print app
			foreach($datetimes as $dt){
				$sql = "SELECT * from `Proj2Appointments` where `Time` = '$dt' and `AdvisorID` = '$id'";
				$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
				$row = mysql_fetch_row($rs);
				echo date('l, F d, Y g:i A', strtotime($dt)), " <br> Majors: ", $majorPrint, " <br> Meeting Room: ", $roomPrint;
				if($row){
					echo "<br><span style='color:red'>!!</span>";
				}
				else{
					$sql = "insert into Proj2Appointments (`Time`, `AdvisorID`, `Major`, `Max`, `Room`) values ('$dt', '$id', '$majorDB',1,'$meetingRoom')";
					$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
				}
				echo "<br><br>";
			}
		?>
		<br>
	</div>
	<div class="bottom">
		<p><span style="color:red">!!</span> indicates that this appointment already exists. A repeat appointment was not made.</p>
		<form method="link" action="AdminUI.php">
			<input type="submit" name="next" class="button small go" value="Return to Home">
		</form>
	</div>
	<?php
		include ('footer.html');
	?>
	</div>
	</div>
	</form>
  </body>
  
</html>
