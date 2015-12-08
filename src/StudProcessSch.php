<?php
session_start();
$debug = false;
include('../CommonMethods.php');
$COMMON = new Common($debug);

if($_POST["finish"] == 'Cancel') {
    $status = "none";
} else {
	$studid = $_SESSION["userID"];
    
    $sql = "select * from Proj2Students where `StudentID` = '$studid'";
    $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
    $row = mysql_fetch_row($rs);
    
    //used to be assigned to session vars
	$firstn = $row[1];
	$lastn = $row[2];
	$email = $row[4];
	$major = $row[5];
	$advisor = $_POST["advID"];


	$apptime = $_POST["appTime"];

    //this should'nt be needed. Student added in StudProcessSignIn.php
	/* if(empty($row)){
		$sql = "insert into Proj2Students (`FirstName`,`LastName`,`StudentID`,`Email`,`Major`) values ('$firstn','$lastn','$studid','$email','$major')";
		$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	} */
    
    
	// ************************ Lupoli 9-1-2015
	// we have to check to make sure someone did not steal that spot just before them!! (deadlock)
	// if the spot was taken, need to stop and reset
	if( isStillAvailable($apptime, $advisor) ) { // then good, take that spot
	} else { // spot was taken, tell them to pick another
		if($debug == false) {
			header('Location: 13StudDenied.php');
			return;
		}
	}


	//Regular new schedule
	if($_POST["finish"] == 'Submit'){
		if($advisor == 'Group') { // student scheduled for a group session
			$sql = "select * from Proj2Appointments where `Time` = '$apptime' and `AdvisorID` = 0";
			$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			$row = mysql_fetch_row($rs);
			$groupids = $row[4];
            
            //One more student enrolled for the appointment
			$sql = "update `Proj2Appointments` set `EnrolledNum` = EnrolledNum+1, `EnrolledID` = '$groupids $studid' where `Time` = '$apptime' and `AdvisorID` = 0";
		}
		else { // student scheduled for an individual session
			$sql = "update `Proj2Appointments` set `EnrolledNum` = EnrolledNum+1, `EnrolledID` = '$studid' where `AdvisorID` = '$advisor' and `Time` = '$apptime'";
		}
        //executeQuery moved from if/else block
        $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		
	    //Completed appointment signup
        $status = "complete";
	}
	elseif($_POST["finish"] == 'Reschedule'){
		//Retrieve old appointment
		$sql = "select * from Proj2Appointments where `EnrolledID` like '%$studid%'";
		$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		$row = mysql_fetch_row($rs);
		$oldAdvisorID = $row[2];
		$oldAppTime = $row[1];
		$newIDs = str_replace($studid, "", $row[4]);
		
        //One less student enrolled for the appointment
		$sql = "update `Proj2Appointments` set `EnrolledNum` = EnrolledNum-1, `EnrolledID` = '$newIDs' where `AdvisorID` = '$oldAdvisorID' and `Time` = '$oldAppTime'";
		$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		
		//Schedule new appointment
		if($advisor == 'Group'){ //group appointment
			$sql = "select * from Proj2Appointments where `Time` = '$apptime' and `AdvisorID` = 0";
			$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			$row = mysql_fetch_row($rs);
			$groupids = $row[4];
            //One more student enrolled
			$sql = "update `Proj2Appointments` set `EnrolledNum` = EnrolledNum+1, `EnrolledID` = '$groupids $studid' where `Time` = '$apptime' and `AdvisorID` = 0";
		}
		else{ //individual appointment
            //One student enrolled
			$sql = "update `Proj2Appointments` set `EnrolledNum` = EnrolledNum+1, `EnrolledID` = '$studid' where `Time` = '$apptime' and `AdvisorID` = '$advisor'";
			
		}
        //executeQuery moved from if/else block
        $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

        $status = "resch";
	}

	//Update student status to nothing
	$sql = "update `Proj2Students` set `Status` = '' where `StudentID` = '$studid'";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

}
if($debug == false) { include('12StudExit.php'); }



function isStillAvailable($apptime, $advisor) {
	// advisor could be "Group"
	global $debug; global $COMMON;
	$sql = "";

	if($advisor == "Group") { 
        $sql = "select `EnrolledNum`, `Max` from `Proj2Appointments` where `Time` = '$apptime' and `AdvisorID` = 0";
    } else { // then specific
	   $sql = "select `EnrolledNum`, `Max` from `Proj2Appointments` where `Time` = '$apptime' and `AdvisorID` = '$advisor'";
    }
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	$row = mysql_fetch_row($rs);

	// if max [1] =< EnrolledNum[0], then the spot was indeed taken
	if($row[1] > $row[0]) { // then all good
		if($debug) { echo("spot available\n<br>"); }
		return true; 
	} else { // spot was taken
		if($debug) {
            echo("spot NOT available\n<br>");
        }	
		return false; 
	}
}

?>


