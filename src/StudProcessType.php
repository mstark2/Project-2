<?php
session_start();
if ($_POST["type"] == "Group"){ //Advisor is Group, only need to select time
	header('Location: 08StudSelectTime.php');
}
elseif ($_POST["type"] == "Individual"){ //Need to select advisor first
	header('Location: 07StudSelectAdvisor.php');
}
?>