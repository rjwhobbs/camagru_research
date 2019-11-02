<?php
require_once ('./controller.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Sign in</title>
</head>
<body>
	<h1>Sign in</h1>
	<div>
		<?php 	
				if (isset ($_SESSION['message']))
				{	
					echo $_SESSION['message'];
					unset($_SESSION['message']);
				} 
		?>
	</div> <!-- This will need to be unset later , probably here-->
	<form action="signin.php" method="POST">
		<span>Username:</span><input type="text" placeholder="username" name="username" required/><br>
		<span>Password:</span><input type="password" placeholder="password" name="passwd" required/><br>
		<input type="submit" name="submit-signin" value="Sign in">
		<a href="forgotpasswd.php"><input type="submit" value="Forgot your password?"></a>
		<input type="submit" name="resend-link" value="Resend link">
	</form>
	<a href="signout.php"><input type="submit" value="Sign Out"></a>
</body>
</html>