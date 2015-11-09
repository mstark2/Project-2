<?php
session_start();

//Go to page based on selection
if ($_POST["next"] == "Group"){ //Chose group
	$_SESSION["advisor"] = $_POST["next"];
	header('Location: AdminScheduleGroup.php');
}
elseif ($_POST["next"] == "Individual"){ //Chose individual
	header('Location: AdminScheduleInd.php');
}

?>