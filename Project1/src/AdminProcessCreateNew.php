<?php
session_start();

//Advisor information
$_SESSION["AdvF"] = $_POST["firstN"];
$_SESSION["AdvL"] = $_POST["lastN"];
$_SESSION["AdvUN"] = $_POST["UserN"];
$_SESSION["AdvPW"] = $_POST["PassW"];
$_SESSION["PassCon"] = false;
$_SESSION["AdvO"] = $_POST["Office"];

if($_POST["PassW"] == $_POST["ConfP"]){ //Confirm password matched, proceed
	header('Location: AdminCreateNew.php');
}
elseif($_POST["PassW"] != $_POST["ConfP"]){ //Did not match, return to create new advisor
	$_SESSION["PassCon"] = true;
	header('Location: AdminCreateNewAdv.php');
}

?>