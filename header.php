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
	<h1>This is Camagru</h1>
	<?php
		if (isset($_SESSION['user_id'])) // This could mirror validation.php
		{?>
			<a href="signout.php"><input type="submit" value="Sign Out"></a>
			<a href="profile.php"><input type="submit" value="Profile"></a> 
			<a href="editor.php"><input type="submit" value="Camera Editor"></a> 
		<?php 
		} 
		else 
		{?>
			<a href="signin.php"><input type="submit" value="Sign In"></a>
			<a href="form.php"><input type="submit" value="Sign Up"></a>
		<?php 
		}
	?>
	<a href="index.php"><input type="submit" value="Feed"></a>
	<?php
		if (isset($_SESSION['user_id']))
		{?>
			<br><span>Logged in as: <?php echo $_SESSION['username']?></span>
		<?php	
		}
	?>	