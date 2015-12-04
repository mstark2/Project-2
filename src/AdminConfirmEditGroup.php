<?php
session_start();
$debug = false;

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Edit Group Appointment</title>
    <script type="text/javascript">
    function saveValue(target){
	var stepVal = document.getElementById(target).value;
	alert("Value: " + stepVal);
    }
    </script>
	<link rel='stylesheet' type='text/css' href='../css/standard.css'/>
	<h2>UMBC COEIT Engineering and Computer Science Advising</h2>
  </head>
  <body>
    <div id="login">
      <div id="form">
        <div class="top">
		<div class="field">
        <?php
            //cache delete and group
            $delete = $_SESSION["Delete"];
            $group = $_SESSION["GroupApp"];
            parse_str($group);

            include('../CommonMethods.php');
            $COMMON = new Common($debug);

            if($delete == true){ //User wants to delete
                echo("<h1>Removed Appointment</h1><br>");

                //Retrieve IDs of enrolled students in appointment
                $sql = "SELECT `EnrolledID` FROM `Proj2Appointments` WHERE `Time` = '$row[0]'
                  AND `AdvisorID` = '0' 
                  AND `Major` = '$row[1]' 
                  AND `EnrolledNum` = '$row[2]'
                  AND `Max` = '$row[3]'";
                $rs = $COMMON->executeQuery($sql, "Advising Appointments");

                //Display ID
                $stds = mysql_fetch_row($rs);
                echo($stds[0]);
                $stds = trim($stds[0]); // had some side white spaces sometimes
                $stds = split(" ", $stds);

                if($debug) { var_dump("\n<BR>EMAILS ARE: $stds \n<BR>"); }
		          // foreach($stds as $element) { echo("->".$element."\n"); }

                if($stds) { //Students exist
                    //Update each student
                  foreach($stds as $element){
                    $element = trim($element);
                    //Student's status is now canceled
                    $sql = "UPDATE `Proj2Students` SET `Status`='C' WHERE `StudentID` = '$element'";
                    $rs = $COMMON->executeQuery($sql, "Advising Appointments");
                    //Retrieve email of student
                    $sql = "SELECT `Email` FROM `Proj2Students` WHERE `StudentID` = '$element'";
                    $rs = $COMMON->executeQuery($sql, "Advising Appointments");
                    //Email student about cancelation of their appointment
                    $ros = mysql_fetch_row($rs);
                    $eml = $ros[0];
                    $message = "The following group appointment has been deleted by the adminstration of your advisor: " . "\r\n" .
                    "Time: $row[0]" . "\r\n" . 
                    "To schedule for a new appointment, please log back into the UMBC COEIT Engineering and Computer Science Advising webpage." . "\r\n" .
            "http://coeadvising.umbc.edu  -> COEIT Advising Scheduling \r\n Reminder, this is only accessible on campus."; 

                    mail($eml, "Your COE Advising Appointment Has Been Deleted", $message);
                  }
            }

            //Remove appointment
            $sql = "DELETE FROM `Proj2Appointments` WHERE `Time` = '$row[0]' 
              AND `AdvisorID` = '0' 
              AND `Major` = '$row[1]' 
              AND `EnrolledNum` = '$row[2]'
              AND `Max` = '$row[3]'";
            $rs = $COMMON->executeQuery($sql, "Advising Appointments");

            //Display info
            echo("Time: ". date('l, F d, Y g:i A', strtotime($row[0])). "<br>");
            echo("Majors included: ");

            if($row[1]){ echo("$row[1]<br>"); }
            else{ echo("Available to all majors<br>"); }

            echo("Number of students enrolled: $row[2]<br>");
            echo("Student limit: $row[3]");
            echo("<br><br>");
            echo("<form method=\"link\" action=\"AdminUI.php\">");
            echo("<input type=\"submit\" name=\"next\" class=\"button small go\" value=\"Return to Home\">");
            echo("</form>");
            echo("</div>");
            echo("<div class=\"bottom\">");
            if($stds[0]){
              echo "<p style='color:red'>Students have been notified of the cancellation.</p>";
            }
          }
          else{ //User doesn't want to delete, just edit
            echo("<h1>Changed Appointment</h1><br>");
			echo("<h2>Previous Appointment:</h2>");
            echo("Time: ". date('l, F d, Y g:i A', strtotime($row[0])). "<br>");
            echo("Majors included: ");
            if($row[1]){ //Display specific majors
              echo("$row[1]<br>"); 
            }
            else{ //No specific major
              echo("Available to all majors<br>"); 
            }
            //Display current number of enrolled students and the maximum amount that can be enrolled
            echo("Number of students enrolled: $row[2]<br>");
            echo("Student limit: $row[3]");
            echo("<h2>Updated Appointment:</h2>");
            $limit = $_POST["stepper"];
            echo("<b>Time: ". date('l, F d, Y g:i A', strtotime($row[0])). "</b><br>");
            echo("<b>Majors included: ");
            if($row[1]){ //Display specific majors
              echo("$row[1]</b><br>"); 
            }
            else{ //No specific major
              echo("Available to all majors</b><br>"); 
            }
            //Display current number of enrolled students and the maximum amount that can be enrolled
            echo("<b>Number of students enrolled: $row[2] </b><br>");
            echo("<b>Student limit: $limit</b>");

            //Update all info to new info
            $sql = "UPDATE `Proj2Appointments` SET `Max`='$limit' WHERE `Time` = '$row[0]' 
                    AND `AdvisorID` = '$0' AND `Major` = '$row[1]' 
                    AND `EnrolledNum` = '$row[2]' AND `Max` = '$row[3]'";
            $rs = $COMMON->executeQuery($sql, "Advising Appointments"); 

            echo("<br><br>");
            echo("<form method=\"link\" action=\"AdminUI.php\">");
            echo("<input type=\"submit\" name=\"next\" class=\"button small go\" value=\"Return to Home\">");
            echo("</form>");
          }
		  echo("</div>");
		  echo("</div>");
		  echo("</div>");
        ?>
	</form>
	<?php
		include ('footer.html');
	?>
  </body>
  
</html>
