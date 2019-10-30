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
	<h1>Sign Up</h1>
	<!-- Errors will come here -->
	<div>
		<?php if (count($errors) > 0): ?>
		<?php foreach ($errors as $error)?>
			<li><?php echo $error; ?></li> <!-- I'm thinking errors will need to be unset after this -->
		<?php endif ; ?>
	</div>
	<!-- Success comes here -->
	<div><?php  if (isset($_SESSION['message']))
				{
					echo $_SESSION['message'];
					unset($_SESSION['message']);
				}
	?></div>
	<form  action="form.php" method="POST" autocomplete="off" enctype="multipart/form-data">
		<span>Username:</span><input type="text" placeholder="username" name="username" required/><br />
		<span>Email:</span><input type="email" placeholder="email address" name="email" required/><br />
		<span>Password:</span><input type="password" placeholder="password" name="passwd" required/><br />
		<span>Confirm password:</span><input type="password" placeholder="confirm" name="confirm-passwd" required/><br />
		<label>Choose a profile pic</label><input type="file" name="profile-pic" accept="image/*" required/><br />
		<input type="submit" name="submit-signup" value="Register" />
	</form>
	<h1>Sign in</h1>
	<form action="signin.php">
		<input type="submit" value="Sign in"/>
	</form>
</body>
</html>