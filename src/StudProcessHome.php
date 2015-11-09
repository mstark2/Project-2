<?php
session_start();

if($_POST["selection"] == 'Signup'){ //Sign up for new appointment
	header('Location: 03StudSelectType.php');
}
elseif($_POST["selection"] == 'View'){ //View current appointment
	header('Location: 04StudViewApp.php');
}
elseif($_POST["selection"] == 'Find'){ //Find next available appointment
	header('Location: 14StudFindNext.php');
}
elseif($_POST["selection"] == 'Reschedule'){ //Reschedule current appointment
	$_SESSION["resch"] = true;
	header('Location: 03StudSelectType.php');
}
elseif($_POST["selection"] == 'Cancel'){ //Cancel current appointment
	header('Location: 05StudCancelApp.php');
}
elseif($_POST["selection"] == 'Search'){ //Search for new appointment
	header('Location: 09StudSearchApp.php');
}
elseif($_POST["selection"] == 'Edit'){ //Edit current appointment
	header('Location: 06StudEditInfo.php');
}

?>