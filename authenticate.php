<?php
// This file still needs protecion after the require feild.
session_start();
require_once('./setup.php');
$_SESSION['message'] = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$username = $_POST['username'];
	try
	{
		$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT `passwd` FROM `users` WHERE `username` = ?";
		$stmt = $conn->prepare($sql);
		$stmt->execute([$username]);
		$info = $stmt->fetch(PDO::FETCH_ASSOC);
	}
	catch (PDOException $e)
	{
		echo $e->getMessage();
	}
	if ($info === FALSE)
	{
		$_SESSION['message'] = "Incorrect username or password, please try again."; 
	}
	else
	{
		if (password_verify($_POST['passwd'], $info['passwd']))
		{
			$_SESSION['message'] = "Sign in successful";
		}
		else
		{
			$_SESSION['message'] = "Incorrect username or password, please try again.";
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Sign in</title>
</head>
<body>
	<h1>Sign in</h1>
	<form action="authenticate.php" method="POST">
		<span>Username:</span><input type="text" placeholder="username" name="username" required/><br>
		<span>Password:</span><input type="text" placeholder="password" name="passwd" required/><br>
		<input type="submit" name="submit" value="Sign in">
	</form>
	<div><?= $_SESSION['message'] ?></div>
</body>
</html>