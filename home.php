<?php
session_start();
require_once ('./controller.php'); // will this call the controller again?
require ('./valid_session_check.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Home</title>
</head>
<body>
	<h1>Welcome</h1>
	<p>This page is only to test if a user has successfully logged in.<b>
		This will eventually be a profile page or pages directed to<br>
		here will direct to index.php.
	</p>
	<p>Hi <?php echo $_SESSION['username']; ?>, welcome to Camagru.</p>
	<a href="signout.php"><input type="submit" value="Sign Out"></a>
	<a href="profile.php"><input type="submit" value="Go to profile"></a>
</body>
</html>