<?php
require ('./controller.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Forgot Password</title>
</head>
<body>
	<h1>Ah shame, you forgot your password.<br> 
		Don't worry it even happens to wizards like me.
	</h1>
	<p>Please enter your email address, check your email and click on the link provided.</p>
	<div>
		<?php 	
				if (!empty($_SESSION['message']))
				{	
					echo $_SESSION['message'];
					unset($_SESSION['message']);
				} 
		?>
	</div> 
	<form action="forgotpasswd.php" method="post">
		<input type="email" name="email" require><br>
		<input type="submit" name="reset-passwd" value="Send email">
	</form>
</body>
</html>