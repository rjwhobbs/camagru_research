<?php
session_start();
require_once('./setup.php');
$_SESSION['message'] = "";
try
{
	$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOExeption $e)
{
	echo $e->getMessage;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if ($_POST['passwd'] == $_POST['confirm-passwd'])
	{
		$username = $_POST['username'];
		$email = $_POST['email'];
		$passwd = password_hash($_POST['passwd'], PASSWORD_BCRYPT);
		$profile_pic_path = 'images/'.$_FILES['profile-pic']['name'];
		if (preg_match("!image!", $_FILES['profile-pic']['type']))
		{
			if (copy($_FILES['profile-pic']['tmp_name'], $profile_pic_path))
			{
				$_SESSION['username'] = $username;
				$_SESSION['profile-pic'] = $profile_pic_path;
				$sql = 'INSERT INTO `users` (`username`, `passwd`, `email`, `profile-pic` ) 
						VALUES (?, ?, ?, ?)';
				try
				{
					$stmt = $conn->prepare($sql);
					$stmt->execute([$username, $passwd, $email, $profile_pic_path]);
					$_SESSION['message'] = 'Registration successful.'; 
				}
				catch (PDOExeption $e)
				{
					$_SESSION['message'] = 'Sorry registration failed.';
				}
			}
			else
			{
				$_SESSION['message'] = 'File upload failed.';
			}
		}
		else
		{
			$_SESSION['message'] = 'Please only upload a valid image file.';
		}
	}
	else
	{
		$_SESSION['message'] = 'Passwords do not match';
	}
}

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
	<h1>Create an account</h1>
	<form action="form.php" method="POST" autocomplete="off" enctype="multipart/form-data">
		<div><?= $_SESSION['message'] ?></div>
		<span>Username:</span><input type="text" placeholder="username" name="username" required/><br />
		<span>Email:</span><input type="text" placeholder="email address" name="email" required/><br />
		<span>Password:</span><input type="password" placeholder="password" name="passwd" required/><br />
		<span>Confirm password:</span><input type="password" placeholder="confirm" name="confirm-passwd" required/><br />
		<label>Choose a profile pic</label><input type="file" name="profile-pic" accept="image/*" /><br />
		<input type="submit" name="submit" value="Register" />
	</form>
</body>
</html>