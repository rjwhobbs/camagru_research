<?php
require ('./controller.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Reset password</title>
</head>
<body>
	<?php if (count($reset_errors) > 0): ?>
	<?php foreach ($reset_errors as $error)?>
		<li><?php echo $error; ?></li> <!-- I'm thinking errors will need to be unset after this -->
	<?php unset($reset_errors)?>
	<?php endif ; ?>
	<form action="new_passwd.php" method="post">
		<span>Enter your email address:</span><input type="email" name="email" ><br> <!-- PLEASE ADD REQUIRE FOR EXTRA LEVEL -->
		<span>Enter your new password:</span><input type="password" name="passwd" ><br>
		<span>Confirm your new password:</span><input type="password" name="confirm-passwd" ><br>
		<input type="submit" name="Reset" value="Reset">
	</form>
</body>
</html>