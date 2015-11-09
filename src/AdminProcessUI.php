<?php
session_start();

//Go to page based on option selected
if($_POST["next"] == 'Schedule appointments'){
	header('Location: AdminScheduleApp.php');
}
elseif($_POST["next"] == 'Print schedule for a day'){
	header('Location: AdminPrintSchedule.php');
}
elseif($_POST["next"] == 'Edit appointments'){
	header('Location: AdminEditApp.php');
}
elseif($_POST["next"] == 'Search for an appointment'){
	header('Location: AdminSearchApp.php');
}
elseif($_POST["next"] == 'Create new Admin Account'){
	header('Location: AdminCreateNewAdv.php');
}

?>