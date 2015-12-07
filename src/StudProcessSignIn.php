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

$sql = "select * from Proj2Students where `StudentID` = '$studid'";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
$row = mysql_fetch_row($rs);

if(empty($row)){
$sql = "insert into Proj2Students (`FirstName`,`LastName`,`StudentID`,`Email`,`Major`) values ('$firstn','$lastn','$studid','$email','$major')";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
}

//remove once done with session
$_SESSION["firstN"] = $firstn;
$_SESSION["lastN"] = $lastn;
$_SESSION["studID"] = $studid;
$_SESSION["email"] = $email;
$_SESSION["major"] = $major;

header('Location: 02StudHome.php');
?>