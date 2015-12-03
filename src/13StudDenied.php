<?php
session_start();
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Exit Message</title>
	<link rel='stylesheet' type='text/css' href='../css/standard.css'/>
	<h2>UMBC COEIT Engineering and Computer Science Advising</h2>
  </head>
  <body>
    <div id="login">
      <div id="form">
        <div class="top">
	    <div class="statusMessage">
			<r>Someone JUST took that appointment before you.<br> Please find another available appointment.</r>
        </div>
        <!-- Nothing to do but return to home page -->
		<form action="02StudHome.php" method="post" name="complete">
		</div>
	    <div class="returnButton">
			<input type="submit" name="return" class="button small go" value="Return to Home">
	    </div>
		</form>
	<?php
		include ('footer.html');
	?>
  </body>
</html>
