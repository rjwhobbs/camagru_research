<?php
// I still can't see how the main page calls this, 
// does it call again when clicking submit in the post form
session_start();
require ('./connection.php');
include ('./mail_verification_code.php');
$errors = array(); //Does this kind of declare really make it availabe to the files that require it?

/****************************
*	SIGN UP
****************************/

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit-signup']))
{
	//Maybe put some of this into functions
	$_SESSION['message'] = "";
	
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
	if ($result) 
	{
		$errors['username'] = 'Username already exits';
	}
	$stmt = NULL; // unset or NULL?
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
	$stmt = NULL; // is this neccessary? unset might be better
	$result = NULL;

	//Password checks
	if (empty($_POST['passwd']))
	{
		$errors['passwd'] = 'Password required';
	}
	else if (empty($_POST['confirm-passwd']))	
	{
		$errors['passwd'] = 'Confirm feild empty';
	}
	else if ($_POST['passwd'] != $_POST['confirm-passwd'])
	{
		$errors['passwd'] = 'Passwords don\'t match';
	}

	//Profile pic upload check (What if 2 users upload different images but with the same name, problem)
	// If image name exits maybe we can do a 'copy of' concatination to the image name. 
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
		$bytes = random_bytes(16);	
		$verification_code = bin2hex($bytes);	
		$passwd = password_hash($_POST['passwd'], PASSWORD_BCRYPT);
		try
		{
			$sql = 'INSERT INTO users (`username`, `passwd`, `email`, `verification` ,`profile-pic` ) VALUES (?, ?, ?, ?, ?)';
			$stmt = $conn->prepare($sql);
			$arr = array($username, $passwd, $email, $verification_code, $profile_pic_path);
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
		$_SESSION['username'] = $username;
		if (mail_verification_code($email, $verification_code, USER_VERIFY) === FALSE) // I need a button to send the mail again
		{
			$_SESSION['message'] = "Sorry, we were unable to send you the confirmation link,
									please confirm your name and password and click the resend button 
									or try again later.";
			header("location: signin.php");
			exit (); // Should I exit here?
		}
		else
		{
			$_SESSION['message'] = 'Registration successful. Please check your email and 
									click on the link provided to validate your account and signin.';
			header("location: signin.php");
			exit(); // Why is exit necessary here?
		}
	}
	else
	{
		$_SESSION['message'] = 'Registration failed';
	}
}

/****************************
*	SIGN IN
****************************/

else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit-signin']))
{
	$username = $_POST['username'];
	try
	{
		$sql = "SELECT * FROM `users` WHERE `username` = ?";
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
		$_SESSION['message'] = "Incorrect username or password, please try again."; //this needs to be in errors[]; // follow the flow of the site
	}
	if ($info['verified'] == 1) // ? Why can't i use === 
	{
		if (password_verify($_POST['passwd'], $info['passwd']))
		{
			$_SESSION['username'] = $username;
			$_SESSION['message'] = "Sign in successful";
			header("location: home.php");
			exit(); 
		}
		else
		{
			$_SESSION['message'] = "Incorrect username or password, please try again.";
		}
	}
	else
	{
		$_SESSION['message'] = "Sorry, your account has not been confirmed, 
								please check your email to confirm your account";
	}
}

/****************************
*	RESEND LINK
****************************/

else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['resend-link']))
{
	$username = $_POST['username'];
	try
	{
		$sql = "SELECT * FROM `users` WHERE `username` = ?";
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
		$_SESSION['message'] = "Please fill in the feilds and try again."; //this needs to be in errors[]; // follow the flow of the site
	}
	if ($info['verified'] == 1) // ? Why can't i use === 
	{
		if (password_verify($_POST['passwd'], $info['passwd']))
		{
			$_SESSION['username'] = $username;
			$_SESSION['message'] = "You are already a user, please signin.";
			header("location: signin.php");
			exit(); 
		}
		else
		{
			$_SESSION['message'] = "Incorrect username or password, please try again.";
		}
	}
	else if ($info['verified'] == 0)
	{
		if (password_verify($_POST['passwd'], $info['passwd']))
		{
			$bytes = random_bytes(16);	
			$verification_code = bin2hex($bytes);
			$query = 'UPDATE `users` SET `verification` = ? WHERE `id` = ?';
			$stmt = $conn->prepare($query);
			$stmt->execute([$verification_code, $info['id']]);
			unset($stmt);
			if (mail_verification_code($info['email'], $verification_code, USER_VERIFY) === FALSE)
			{
				$_SESSION['message'] = "Sorry, we were unable to send you the confirmation link,
										please confirm your name and password and click the resend button or try again later.";
				header("location: signin.php");
				exit (); // Should I exit here?
			}
			else
			{
				$_SESSION['message'] = "Email has successfully been resent, 
										please check your email to confirm your account and then sign in.";
				header("location: signin.php");
				exit(); 
			}
		}
		else
		{
			$_SESSION['message'] = "Incorrect username or password, please try again.";
		}
	}
}

/**********************************
*	REQUEST PASSWORD TO BE CHANGED
***********************************/

else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reset-passwd']))
{
	$email = $_POST['email'];
	$query = 'SELECT * FROM `users` WHERE `email` = ?';
	$stmt = $conn->prepare($query);
	$stmt->execute([$email]);
	$res = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($res && $res['verified'] == 1)
	{
		unset($stmt);
		$bytes = random_bytes(32);	
		$verification_code = bin2hex($bytes);
		$query = 'UPDATE `users` SET `verification` = ? WHERE `id` = ?';
		$stmt = $conn->prepare($query);
		$stmt->execute([$verification_code, $res['id']]);
		mail_verification_code($res['email'], $verification_code, PASSWD_VERIFY);
		unset($stmt);
		unset($verification_code);
	}
	else
	{
		$_SESSION['message'] = 'This is an invalid email address, please try again.'; // I'm thinking I should remove this else, people can use this ouput to see if a user is on this site.
		header('location: forgotpasswd.php'); // Is this necessary here?
		exit();
	}
}

/*********************************************
*	RESET PASSWORD / LINKS TO NEW_PASSWORD.PHP
**********************************************/

else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['verification']) && isset($_POST['Reset']))
{
	// I want to use an errors array here but it doesn't seem to be printing on the forgotpasswd page. Will try fix this.
	$error_check = FALSE;
	if (empty($_POST['email']) || empty($_POST['passwd']) || empty($_POST['confirm-passwd']))
	{
		$error_check = TRUE;
	}
	else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
	{
		$error_check = TRUE;
	}
	else if ($_POST['passwd'] !== $_POST['confirm-passwd']) // Still needs strong password checking
	{
		$error_check = TRUE;
	}
	else if ($error_check === FALSE)
	{
		$query = 'SELECT * FROM `users` WHERE `verification` = ? && `email` = ? '; // Also check if user is verified
		$stmt = $conn->prepare($query);
		$stmt->execute([$_SESSION['verification'], $_POST['email']]);
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		if (!$res)
		{
			$error_check = TRUE;
		}
		unset($stmt);
	}
	if ($error_check === TRUE)
	{
		unset($_SESSION['verification']);
		$_SESSION['message'] = "There was a problem reseting your password.<br>  
								Please make sure to fill in all the feilds correctly.<br> 
								Please enter your email address and try again.";
		header('location: forgotpasswd.php');
	}
	else
	{
		$new_passwd = password_hash($_POST['passwd'], PASSWORD_BCRYPT);
		$query = 'UPDATE `users` SET `passwd` = ? , `verification` = ? WHERE `id` = ?';
		$stmt = $conn->prepare($query);
		$stmt->execute([$new_passwd, NULL, $res['id']]);
	}
}
?>