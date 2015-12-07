<?php
session_start();

//add student to the database if they are new
$debug = false;
include('../CommonMethods.php');
$COMMON = new Common($debug);

$firstn = strtoupper($_POST["firstN"]);
$lastn = strtoupper($_POST["lastN"]);
$studid = strtoupper($_POST["studID"]);
$email = $_POST["email"];
$major = $_POST["major"];

$_SESSION["studID"] = $studid;

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

$sql = "select * from Proj2Students where `StudentID` = '$studid'";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
$row = mysql_fetch_row($rs);

if(empty($row)){
$sql = "insert into Proj2Students (`FirstName`,`LastName`,`StudentID`,`Email`,`Major`, `Status`) values ('$firstn','$lastn','$studid','$email','$major', 'N')";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
}

	
//remove once done with session
$_SESSION["firstN"] = $firstn;
$_SESSION["lastN"] = $lastn;
$_SESSION["email"] = $email;
$_SESSION["major"] = $major;

header('Location: 02StudHome.php');
?>