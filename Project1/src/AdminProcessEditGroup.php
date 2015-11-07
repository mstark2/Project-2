<?php
session_start();

$_SESSION["GroupApp"] = $_POST["GroupApp"];
$_SESSION["Delete"] = false;

//Go to page based on selection
if ($_POST["next"] == "Delete Appointment"){ //Wants to delete, go to confirm
	$_SESSION["Delete"] = true;
	$_SESSION["advisor"] = $_POST["next"];
	header('Location: AdminConfirmEditGroup.php');
}
elseif ($_POST["next"] == "Edit Appointment"){ //Wants to edit, proceed
	header('Location: AdminProceedEditGroup.php');
}

?>