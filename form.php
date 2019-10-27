<?php
require_once ('./controller.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Sign In</title>
</head>
<body>
	<h1>Create an account</h1>
	<!-- Errors will come here -->
	<div>
		<li><?= $errors['username']?></li>
		<li><?= $errors['email']?></li>
		<li><?= $errors['passwd']?></li>
		<li><?= $errors['image']?></li>
	</div>
	<!-- Success comes here -->
	<div><?= $_SESSION['message'] ?></div>
	<form  action="form.php" method="POST" autocomplete="off" enctype="multipart/form-data">
		<span>Username:</span><input type="text" placeholder="username" name="username" /><br />
		<span>Email:</span><input type="text" placeholder="email address" name="email" /><br />
		<span>Password:</span><input type="password" placeholder="password" name="passwd" /><br />
		<span>Confirm password:</span><input type="password" placeholder="confirm" name="confirm-passwd" /><br />
		<label>Choose a profile pic</label><input type="file" name="profile-pic" accept="image/*" /><br />
		<input type="submit" name="submit-signup" value="Register" />
	</form>
	<h1>Sign in</h1>
	<form action="authenticate.php">
		<input type="submit" value="Sign in"/>
	</form>
</body>
</html>