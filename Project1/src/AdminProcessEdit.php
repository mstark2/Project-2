<?php
session_start();

//Go to page based on chosen appointment type
if ($_POST["next"] == "Group"){ //Group was chosen
	$_SESSION["advisor"] = $_POST["next"];
	header('Location: AdminEditGroup.php');
}
elseif ($_POST["next"] == "Individual"){ //Individual was chosen
	header('Location: AdminEditInd.php');
}

?>