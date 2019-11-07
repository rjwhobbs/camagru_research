<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<h1>This is the header (place holder)</h1>
	<?php
		if (isset($_SESSION['user_id'])) 
		{	
		?>
			<a href="signout.php"><input type="submit" value="Sign Out"></a>
			<a href="profile.php"><input type="submit" value="Profile"></a> 
			<a href="editor.php"><input type="submit" value="Camara Editor"></a> 
		<?php 
		} 
		else 
		{	
		?>
			<a href="signin.php"><input type="submit" value="Sign In"></a>
			<a href="form.php"><input type="submit" value="Sign Up"></a>
		<?php 
		}	
	?>
	<a href="index.php"><input type="submit" value="Feed"></a>