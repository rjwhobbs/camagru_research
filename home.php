<?php
require_once ('./controller.php'); // will this call the controller again?
if(!isset($_SESSION['username']) && !isset($_SESSION['ver_user'])) // Some extra protection against unsigned in users // How safe is this, can the user some how create their own session var.
{
	header("location: form.php");
	exit();
}
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
	<p>Hi <?php echo $_SESSION['username']; ?>, welcome to Camagru.</p>
</body>
</html>