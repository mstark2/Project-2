<?php
session_start();

//Cache new student info
$firstn = strtoupper($_POST["firstN"]);
$lastn = strtoupper($_POST["lastN"]);
$studid = $_SESSION["userID"];
$email = $_POST["email"];
$major = $_POST["major"];

//make sure the abbreviation is added to the DB 
if($major == "Computer Science"){
	$major = "CMSC";
}
else if($major == "Computer Engineering"){
	$major = "CMPE";
}
else if($major == "Mechanical Engineering"){
	$major = "MENG";
}
else if($major == "Chemical Engineering"){
	$major = "CENG";
}
else if($major == "Engineering Undecided"){
	$major = "ENGR";
}

$debug = false;
include('../CommonMethods.php');
$COMMON = new Common($debug);

$sql = "select * from Proj2Students where `StudentID` = '$studid'";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
$row = mysql_fetch_row($rs);


if(!empty($row)){ //Student actually exists, set info to new info
	$sql = "update `Proj2Students` set `FirstName` = '$firstn', `LastName` = '$lastn', `Email` = '$email', `Major` = '$major' where `StudentID` = '$studid'";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
}

header('Location: 02StudHome.php');
?>