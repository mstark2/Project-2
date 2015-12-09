<?php

/* Had to make sure sessions was enabled. Some help here:

https://wiki.umbc.edu/pages/viewpage.action?pageId=46563550

cd /afs/umbc.edu/public/web/sites/coeadvising/prod/php/session/

/usr/bin/fs sa /afs/umbc.edu/public/web/sites/coeadvising/prod/php/session/ web.coeadvising all


then edit .htaccess file here in the same directory

*/


session_start();

include('../CommonMethods.php');
$debug = false;
$Common = new Common($debug);

//Get username and password
$user = strtoupper($_POST["UserN"]);
$pass = strtoupper($_POST["PassW"]);

//Retrieve advisor based on username and password
$sql = "SELECT * FROM `Proj2Advisors` WHERE `Username` = '$user' AND `Password` = '$pass'";
$rs = $Common->executeQuery($sql, "Advising Appointments");
$row = mysql_fetch_row($rs);

$_SESSION["userID"] = $row[0]; //userID is advisor table's primary key
$userVal = false;



if($row){ //Found match, sign in succeeded
	if($debug) { echo("<br>".var_dump($_SESSION)."<- Session variables above<br>"); }
	else { header('Location: AdminUI.php'); }
}
else{ //No match, return to sign in
    $userVal = true;
	include('AdminSignIn.php'); 
}

?>