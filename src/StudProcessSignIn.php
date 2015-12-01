<?php
session_start();
$debug = false;
include('../CommonMethods.php');
$COMMON = new Common($debug);

$firstn = strtoupper($_POST["firstN"]);
$lastn = strtoupper($_POST["lastN"]);
$studID = strtoupper($_POST["studID"]);
$email = $_POST["email"];
$major = $_POST["major"];

$sql = "select * from Proj2Students where `StudentID` = '$studID'";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
$row = mysql_fetch_row($rs);

if (empty($row)){
    $sql = "insert into Proj2Students (`FirstName`,`LastName`,`StudentID`,`Email`,`Major`) values ('$firstn','$lastn','$studID','$email','$major')";
    $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
}



$_SESSION["firstN"] = strtoupper($_POST["firstN"]);
$_SESSION["lastN"] = strtoupper($_POST["lastN"]);
$_SESSION["studID"] = strtoupper($_POST["studID"]);
$_SESSION["email"] = $_POST["email"];
$_SESSION["major"] = $_POST["major"];

header('Location: 02StudHome.php');
?>