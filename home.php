<?php
require_once ('./controller.php'); // will this call the controller again?
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
	<p><?php
		if (isset($_SESSION['username']))
		{
			echo $_SESSION['username'];
		}
		?>
	</p>
</body>
</html>