<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Print Schedule</title>
    <script type="text/javascript">
    function saveValue(target){
	var stepVal = document.getElementById(target).value;
	alert("Value: " + stepVal);
    }
    </script>
    <link rel="stylesheet" type="text/css" href="../css/standard.css"/>
  </head>
  <body>
    <div id="login">
      <div id="form">
        <div class="top">
		      <h1>Print Schedule</h1>
          <form action="AdminPrintResults.php" method="post" name="Confirm">
	         <div class="field">
	     	     <label for="date">Date</label>
                 <!-- Input date of appointments to print -->
             <input id="date" type="date" name="date" placeholder="mm/dd/yyyy" style="height:25px" required autofocus> 
	         </div>

	         <div class="field">
        		<label for="Type">Type of Appointment</label>
            <select id="type" name = "type" style="height:25px">
                <!-- Choose type of appointments to print -->
					<option>Both</option>
        			<option>Individual</option>
        			<option>Group</option>
        		</select>
	         </div>

	         <br>

    	    <div class="nextButton">
    			<input type="submit" name="next" class="button medium go" value="Next">
        </form>
		
	</div>
	</div>
		<form method="link" action="AdminUI.php">
		<input type="submit" name="home" class="button small" style="margin-bottom: 10px" value="Cancel">
		</form>
	<?php include('./workOrder/workButton.php'); ?>
	<?php
		include ('footer.html');
	?>
  </body>
</html>
