<?php
session_start();

//Advisor information
$first = $_POST["firstN"];
$last = $_POST["lastN"];
$user = $_POST["UserN"];
$pass = $_POST["PassW"];
$_SESSION["PassCon"] = false;
$office = $_POST["Office"];

if($_POST["PassW"] == $_POST["ConfP"]){ //Confirm password matched, proceed
	include('AdminCreateNew.php');
}
elseif($_POST["PassW"] != $_POST["ConfP"]){ //Did not match, return to create new advisor
	$_SESSION["PassCon"] = true;
	header('Location: AdminCreateNewAdv.php');
}

?>