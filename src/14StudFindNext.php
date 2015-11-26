<?php
session_start();
$debug = false;
include('../CommonMethods.php');
$COMMON = new Common($debug);



//Cache student major and ID
$localMaj = $_SESSION["major"];
$studID = $_SESSION["studID"];
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>View Appointment</title>
	<link rel='stylesheet' type='text/css' href='../css/standard.css'/>
	<h2>UMBC COEIT Engineering and Computer Science Advising</h2>
  </head>
  <body>
      <div id="login">
      <div id="form">
        <div class="top">
		<h1>Next Available Appointment</h1>
	    <div class="field">
    <?php
        $curtime = time();

        //Get all appointments that match major and have not reached enrollment capacity and sort by time
        $sql = "select * from Proj2Appointments where `EnrolledNum` < `Max` and (`Major` like '%$localMaj%' or `Major` = '')  and `Time` > '".date('Y-m-d H:i:s')."' order by `Time` ASC limit 30";
        $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
        $num_rows = mysql_num_rows($rs);
        
        if($num_rows > 0) { //Appointment exists, get advisor and date
            $row = mysql_fetch_row($rs);
            $advisorID = $row[2];
            $datephp = strtotime($row[1]);
        }

        //Retrieve the info of the advisor for the appointment
        $sql = "select * from Proj2Advisors where `id` = '$advisorID'";
        $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
        $row = mysql_fetch_row($rs);

        //Display advisor info
        $advisorName = $row[1] . " " . $row[2];
        echo "<label for='info'>";
		echo "Advisor: ", $advisorName, "<br>";
        echo "Appointment: ", date('l, F d, Y g:i A', $datephp), "<br>";
                
        //Added advisor office number when viewing appointment
        echo "Advisor Office: ", $row[5], "</label>";

      ?>
        </div>
		</div>
	   <div class="finishButton">
			<button onclick="location.href = '02StudHome.php'" class="button small go" >Return to Home</button>
	    </div>
		</form>
	<?php
		include ('footer.html');
	?>
  </body>
</html>
