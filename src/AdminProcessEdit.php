<?php
session_start();

//Go to page based on chosen appointment type
if ($_POST["next"] == "Group"){ //Group was chosen
	header('Location: AdminEditGroup.php');
}
elseif ($_POST["next"] == "Individual"){ //Individual was chosen
	header('Location: AdminEditInd.php');
}

?>