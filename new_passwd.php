<?php
require ('./controller.php');
if (isset($_SESSION['ver']) && isset($_POST['Reset']))
{	
	echo "HERE";
}
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
	<form action="new_passwd.php" method="post">
		<input type="submit" name="Reset" value="Reset">
	</form>
</body>
</html>