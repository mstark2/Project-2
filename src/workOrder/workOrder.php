<?php
session_start();
$debug = false;

ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting (E_ALL);

if(isset($_POST['description'])) // then stage 2, enter data into DB table
{
	if($debug) { echo("stage2"); }
	stage2($_POST);
}
else // they have not entered anything
{
	if($debug) { echo("stage1"); }
	stage1($_GET);
}


// **********************************************************************


function stage1($_GET)
{
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Work order</title>
    <script type="text/javascript">
    function saveValue(target){
	var stepVal = document.getElementById(target).value;
	alert("Value: " + stepVal);
    }
    </script>
	<link rel='stylesheet' type='text/css' href='../../css/standard.css'/>
  </head>
  <body>
    <div id="login">
	<h2>Work order form for <?php echo($_GET['url']); ?></h2>
    <div id="form">
    <div class="top">

	<form action="workOrder.php" method='post'>
	<h3 style="font-size: 20px; margin-bottom: 0px;">Description:</h3>
	<br><textarea name='description' id='description' rows="5" cols="400"></textarea><br>
	<h3 style="font-size: 20px; margin-bottom: 0px;">Priority:</h3>
	<br><input type="radio" name="priority" value="0" checked><r>None given</r><br>
			<input type="radio" name="priority" value="1"><class="radio"><r>1 (High)</r></radio><br>
			<input type="radio" name="priority" value="2"><r>2</r><br>
			<input type="radio" name="priority" value="3"><r>3</r><br><br>
	
	<input type="hidden" name="url" value='<?php echo($_GET["url"]); ?>'>

	<input type="submit" name="next" class="button medium go" value="Submit">
		<div>
	</form>
		</div>


     </div>
		<form method="link" action="">
			<input type="submit" name="home" class="button small" value="Cancel" onClick="window.close()">
		</form>
		<?php include('../footer.html');?>
     </div>
     </div>
  </body>
  
</html>

<?php
}


function stage2($_POST)
{
	global $debug;

	include('../../CommonMethods.php');
	$COMMON = new Common($debug);

      $sql = "insert into `work_orders` (`id`, `url`, `description`, `priority`, `author`, `time_entered`) values (null, '".$_POST['url']."', '".$_POST['description']."', '".$_POST['priority']."', '".$_SESSION['UserN']."', CURRENT_TIMESTAMP)";
      $rs = $COMMON->executeQuery($sql, $_SERVER['SCRIPT_NAME']);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Work order</title>
    <script type="text/javascript">
    function saveValue(target){
	var stepVal = document.getElementById(target).value;
	alert("Value: " + stepVal);
    }
    </script>
	<link rel='stylesheet' type='text/css' href='../../css/standard.css'/>
  </head>
  <body>
    <div id="login">
	Thank you. Work order entered.
	<form action="">
	<input type="submit" name="home" class="button medium" value="Close" onClick="window.close()">
	</form>
	</div>
     </div>
  </body>
  
</html>



<?php

	        $message =  "From: ".$_SESSION['userN']."\n\r Priority: ".$_POST['priority']."\n\r ".$_POST['description'];
                mail("slupoli@umbc.edu", "Work Order for COE Advising", $message);

}
?>
