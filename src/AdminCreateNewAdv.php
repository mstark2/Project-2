<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Create New Admin</title>
	<link rel='stylesheet' type='text/css' href='../css/standard.css'/>

     <script type="text/javascript">
    //   window.onload = function () {
    //       document.getElementById("PassW").onchange = validatePassword;
    //       document.getElementById("ConfP").onchange = validatePassword;
    //   }
    //   function validatePassword(){
    //     var pass2=document.getElementById("ConfP").value;
    //     var pass1=document.getElementById("PassW").value;
    //     if(pass1!=pass2)
    //         document.getElementById("ConfP").setCustomValidity("Passwords Don't Match");
    //     else
    //         document.getElementById("PassW").setCustomValidity('');  
    //     //empty string means no validation error
    //   }
    // </script>
  </head>
   <body>
    <div id="login">
      <div id="form">
        <div class="top">
		<h2>Create New Advisor Account</h2>
		<?php
      if($_SESSION["PassCon"] == true){ //Password confirm failed
        echo "<h3 style='color:red'>Passwords do not match!!</h3>";
      }
    ?>
		<form action="AdminProcessCreateNew.php" method="post" name="Create">
		  <!-- Info required for creating new advisor -->
            <div class="field">
	      		<label for="firstN">First Name</label>
	      		<input id="firstN" size="20" maxlength="50" type="text" name="firstN" required autofocus>
	    	</div>

	    	<div class="field">
	     		<label for="lastN">Last Name</label>
	      		<input id="lastN" size="20" maxlength="50" type="text" name="lastN" required>
	   	</div>	
        <!-- Administrator can now enter office number of new advisor -->
        <div class="field">
            <label for="Office">Office Number</label>
            <input id="Office" size="20" maxlength="8" type="text" pattern="[A-Za-z]{2,4}[0-9]{3}[A-Za-z]{0,1}" title="ENGR123" placeholder="ENGR123" name="Office" required>
        </div>
            
		<div class="field">
	     		<label for="UserN">Username</label>
	      		<input id="UserN" size="20" maxlength="50" type="text" name="UserN" required>
	   	</div>	 

		<div class="field">
	     		<label for="PassW">Password</label>
	      		<input id="PassW" size="20" maxlength="50" type="password" name="PassW" required>
	   	</div>	

		<div class="field">
	     		<label for="ConfP">Confirm Password</label>
	      		<input id="ConfP" size="20" maxlength="50" type="password" name="ConfP" required>
	   	</div>	
		<br>

            
		<div class="nextButton">
			<input type="submit" name="next" class="button large go" value="Submit">
	    </div>
		</form>
		<form method="link" action="AdminUI.php">
			<input type="submit" name="home" class="button large" value="Cancel">
		</form>

	</div>
	</div>
	</div>
	<?php
		include ('footer.html');
	?>
  </body>
</html>
