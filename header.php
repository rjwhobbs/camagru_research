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
	<h1>This is the header (place holder)</h1>
	<?php
		if (isset($_SESSION['user_id']))
			require ('./src_signout.html');
		else
			require ('./src_signin.html'); 
	?>
	<a href="profile.php"><input type="submit" value="Profile"></a>
	<a href="index.php"><input type="submit" value="Feed"></a>