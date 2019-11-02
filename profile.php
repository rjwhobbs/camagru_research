<?php
require_once ('./controller.php'); // will this call the controller again?
require ('./valid_session_check.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Profile Page</title>
</head>
<body>
	<h1>Profile settings for <?= $_SESSION['username']?></h1>
	<span>Email notifications are <?= $_SESSION['notify']?></span>
	<?php
		if ($_SESSION['notify'] == "on")
			require 'turn_notif_off.html';
		else if ($_SESSION['notify'] == "off")
			require 'turn_notif_on.html'
	?>
	<br>
	<a href="signout.php"><input type="submit" value="Sign Out"></a>
</body>
</html>