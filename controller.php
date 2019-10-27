<?php
// I still can't see how the main page calls this, 
// does it call again when clicking submit in the post form
session_start();
require ('./connection.php');
$errors = array(); //Does this kind of declare really make it availabe to the files that require it? 
// $errors['username'] = ""; 
// $errors['email'] = ""; 
// $errors['passwd'] = "";
// $errors['image'] = "";
$_SESSION['message'] = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit-signup']))
{
	
	$username = $_POST['username'];
	$email = $_POST['email'];
	$profile_pic_path = 'images/'.$_FILES['profile-pic']['name'];
	//Username checks
	if (empty($username))
	{
		$errors['username'] = 'Username required';
	}
	$query = 'SELECT `username` FROM `users` WHERE `username` = ?';
	$stmt = $conn->prepare($query);
	$stmt->execute([$username]);
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($result) // is this a safe way to check for duplicate emails?
	{
		$errors['username'] = 'Username already exits';
	}
	$stmt = NULL;
	$result = NULL;
	
	//email checks
	if (empty($email))
	{
		$errors['email'] = 'Email required';
	}
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		$errors['email'] = 'Valid email required';
	}
	// Check duplicate emails
	// Should we add unique constraint to DB aswell?
	$query = 'SELECT `email` FROM `users` WHERE `email` = ?';
	$stmt = $conn->prepare($query);
	$stmt->execute([$email]);
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($result) // is this a safe way to check for duplicate emails?
	{
		$errors['email'] = 'Email address already exits';
	}
	$stmt = NULL; // is this neccessary?
	$result = NULL;

	//Password checks
	if (empty($_POST['passwd']))
	{
		$errors['passwd'] = 'Password required';
	}
	else if (empty($_POST['confirm-passwd']))	
	{
		$errors['passwd'] = 'Confirmfeild empty';
	}
	else if ($_POST['passwd'] != $_POST['confirm-passwd'])
	{
		$errors['passwd'] = 'Passwords don\'t match';
	}

	//Profile pic upload check (What if 2 users upload different images but with the same name, problem)
	if (preg_match("!image!", $_FILES['profile-pic']['type']) === FALSE) // This looks unreliable, let's try exif_image()
	{
		$errors['image'] = 'Please only upload a valid image';
	}
	else if (copy($_FILES['profile-pic']['tmp_name'], $profile_pic_path) === FALSE)
	{
		$errors['image'] = 'Image upload failed';
	}
	// $_SESSION['username'] = $username;
	// $_SESSION['profile-pic'] = $profile_pic_path;

	if (count($errors) === 0)
	{		
		$passwd = password_hash($_POST['passwd'], PASSWORD_BCRYPT);
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
			echo $e->getMessage();
			$_SESSION['message'] = 'Sorry, registration failed';
		}
		$_SESSION['message'] = 'Registration successful';
		$_SESSION['username'] = $username;
		header("location: home.php");
		exit();
	}
	else
	{
		$_SESSION['message'] = 'Registration failed';
	}
}
?>