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
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit-signup']))
{
	//var_dump($_FILES); die;
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
				try
				{
					$sql = "INSERT INTO users (username, passwd, email, `profile-pic` ) VALUES (?, ?, ?, ?)";
					$stmt = $conn->prepare($sql);
					$arr = array($username, $passwd, $email, $profile_pic_path);
					$stmt->execute($arr);
					//$vercode=hash('sha1', 'verified');
					$_SESSION['message'] = 'Registration successful.';
					//send email here
				}
				catch (PDOExeption $e)
				{
					echo $e;
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