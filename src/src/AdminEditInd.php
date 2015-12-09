<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Edit Individual Appointment</title>
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
          <h2>Select which appointment you would like to change: </h2>
		  <p style='color:red'>Please note that individual appointments can only be removed from the schedule.</p>
		  <div class="field">
		  
          <?php
            $debug = false;
            include('../CommonMethods.php');
            $COMMON = new Common($debug);

            //Retrieve individual appointments
            $sql = "SELECT * FROM `Proj2Appointments` WHERE `AdvisorID` != '0' and `Time` > '".date('Y-m-d H:i:s')."' ORDER BY `Time`";
            $rs = $COMMON->executeQuery($sql, "Advising Appointments");
            $row = mysql_fetch_array($rs, MYSQL_NUM); 
			//first item in row
            if($row){
              echo("<form action=\"AdminConfirmEditInd.php\" method=\"post\" name=\"Confirm\">");
              

	          echo("<table border='1px'>\n<tr>");
	          echo("<tr><td width='320px'>Time</td><td>Majors</td><td>Enrolled</td></tr>\n");

              //Get advisor name from advisor ID
              $secsql = "SELECT `FirstName`, `LastName` FROM `Proj2Advisors` WHERE `id` = '$row[2]'";
              $secrs = $COMMON->executeQuery($secsql, "Advising Appointments");
              $secrow = mysql_fetch_row($secrs);

              if($row[4]){ //Student ID exists
                //Get student name from student ID
                $trdsql = "SELECT `FirstName`, `LastName` FROM `Proj2Students` WHERE `StudentID` = '$row[4]'";
                $trdrs = $COMMON->executeQuery($trdsql, "Advising Appointments");
                $trdrow = mysql_fetch_row($trdrs);
              }

              echo("<tr><td><label for='$row[0]'><input type=\"radio\" id='$row[0]' name=\"IndApp\" 
                required value=\"row[]=$row[1]&row[]=$secrow[0]&row[]=$secrow[1]&row[]=$row[3]&row[]=$row[4]\">");
              echo(date('l, F d, Y g:i A', strtotime($row[1])). "</label></td>");
              if($row[3]){ //Display specific majors
                echo("<td>$row[3]</td>"); 
              }
              else{ //No specific major
                echo("Available to all majors"); 
              }
              
              if($row[4]){ //Display student name
                echo("<td>$trdrow[0] $trdrow[1]</td>");
              }
              else{ //Nothing to display
                echo("<td>Empty</td>");
              }
			  echo("</tr>\n");

              
			  //rest of items in row
              while ($row = mysql_fetch_array($rs, MYSQL_NUM)) {
                  //Get advisor name from advisor ID
                $secsql = "SELECT `FirstName`, `LastName` FROM `Proj2Advisors` WHERE `id` = '$row[2]'";
                $secrs = $COMMON->executeQuery($secsql, "Advising Appointments");
                $secrow = mysql_fetch_row($secrs);

                if($row[4]){
                    //Get student name from student ID
                  $trdsql = "SELECT `FirstName`, `LastName` FROM `Proj2Students` WHERE `StudentID` = '$row[4]'";
                  $trdrs = $COMMON->executeQuery($trdsql, "Advising Appointments");
                  $trdrow = mysql_fetch_row($trdrs);
                }

                echo("<tr><td><label for='$row[0]'><input type=\"radio\" id='$row[0]' name=\"IndApp\" 
                  required value=\"row[]=$row[1]&row[]=$secrow[0]&row[]=$secrow[1]&row[]=$row[3]&row[]=$row[4]\">");
                echo(date('l, F d, Y g:i A', strtotime($row[1])). "</label></td>");
                if($row[3]){ //Display specific majors
                  echo("<td>$row[3]</td>"); 
                }
                else{ //No specific major
                  echo("Available to all majors"); 
                }

                

                if($row[4]){ //Display student name
                  echo("<td>$trdrow[0] $trdrow[1]</td>");
                }
                else{ //Nothing to display
                  echo("<td>Empty</td>");
                }
				echo("</tr>\n");
		
                
				
              }
              echo("</table>");
			  echo("<br>");
              echo("<div class=\"nextButton\">");
              echo("<input type=\"submit\" name=\"next\" class=\"button medium go\" value=\"Delete Appointment\">");
              echo("</div>");
			  echo("</form>");
			  
            }
            else{
              echo("<br><b>There are currently no individual appointments scheduled at the current moment.</b>");
              echo("<br><br>");
			  echo("</td</tr>");
              echo("<form method=\"link\" action=\"AdminUI.php\">");
              echo("<input type=\"submit\" name=\"next\" class=\"button medium\" value=\"Return to Home\">");
              echo("</form>");
            }
          ?>
		  
	</div>
	</div>
	<div class="bottom">
		<form method="link" action="AdminUI.php">
			<input type="submit" name="next" class="button small go" value="Cancel">
		</form>
	</div>
	<?php include('./workOrder/workButton.php'); ?>
	<?php include ('footer.html'); ?>
	</div>
	</div>

  </body>
  
</html>
