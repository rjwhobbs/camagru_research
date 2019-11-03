<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
</head>
<body>
	<h1>This will be the header, place holder</h1>
	<!-- sign out and in needs to be dynamic -->
	<?php
		if (isset($_SESSION['user_id']))
			require ('./src_signout.html');
		else
			require ('./src_signin.html'); 
	?>
	<!-- <a href="signin.php"><input type="submit" value="Sign In"></a>
	<a href="signout.php"><input type="submit" value="Sign Out"></a> -->