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
	<div><?= $_SESSION['message'] ?></div> <!-- This will need to be unset later , probably here-->
	<form action="signin.php" method="POST">
		<span>Username:</span><input type="text" placeholder="username" name="username" required/><br>
		<span>Password:</span><input type="text" placeholder="password" name="passwd" required/><br>
		<input type="submit" name="submit-signin" value="Sign in">
	</form>
</body>
</html>