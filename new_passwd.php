<?php
session_start();
require ('./controller.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Reset password</title>
</head>
<body>
	<div>
		<?php
			if (!empty($_SESSION['message']))
			{	
				echo $_SESSION['message'];
				unset($_SESSION['message']);
			}
		?>
	</div> 
	<form action="new_passwd.php" method="post">
		<span>Enter your email address:</span><input type="email" name="email" require><br> 
		<span>Enter your new password:</span><input type="password" name="passwd" require><br>
		<span>Confirm your new password:</span><input type="password" name="confirm-passwd" require><br>
		<input type="submit" name="Reset" value="Reset">
	</form>
</body>
</html>