<?php
session_start();

$_SESSION["firstN"] = strtoupper($_POST["firstN"]);
$_SESSION["lastN"] = strtoupper($_POST["lastN"]);
$_SESSION["studID"] = strtoupper($_POST["studID"]);
$_SESSION["email"] = $_POST["email"];
$_SESSION["major"] = $_POST["major"];


//add student to the database if they are new
$debug = false;
include('../CommonMethods.php');
$COMMON = new Common($debug);
$studid = $_SESSION["studID"];
$firstn = $_SESSION["firstN"];
$lastn = $_SESSION["lastN"];
$email = $_SESSION["email"];
$major = $_SESSION["major"];

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

header('Location: 02StudHome.php');
?>