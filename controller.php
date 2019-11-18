<?php
require ('./connection.php');
include ('./mail_verification_code.php');
include ('./helpers.php');
include ('./query_functions.php');
include ('./mail_notif_function.php');
$errors = array(); 

/******************************
*	SIGN UP / LINKS TO FORM.PHP
*******************************/

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit-signup']))
{
	require ('./form_block.php');

	$_SESSION['message'] = "";
	$username = $_POST['username'];
	$email = $_POST['email'];
	if (!empty($_FILES['profile-pic']['name']))
		$profile_pic_path = 'images/'.$_FILES['profile-pic']['name'];

	//Username checks
	if (empty($username))
		$errors['username'] = 'Username required';
	else if (username_check($username) === FALSE)
		$errors['username'] = 'Username can only be English letters (with or without digits).';
	else if (strlen($username) < 3)
		$errors['username'] = 'Username too short';
	else if (strlen($username) > 50)
		$errors['username'] = 'Username too long';
	else
	{
		$query = 'SELECT `username` FROM `users` WHERE `username` = ?';
		$stmt = $conn->prepare($query);
		$stmt->execute([$username]);
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($result) 
			$errors['username'] = 'Username already exits';
		$stmt = NULL; // unset or NULL?
		$result = NULL;
	}		
	
	//email checks
	if (empty($email))
		$errors['email'] = 'Email required';
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
		$errors['email'] = 'Valid email required';
	else if (strlen($email) > 80)
		$errors['email'] = 'Email address is too long';
	else
	{
		$query = 'SELECT `email` FROM `users` WHERE `email` = ?';
		$stmt = $conn->prepare($query);
		$stmt->execute([$email]);
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($result)
			$errors['email'] = 'Email address already exits';
		$stmt = NULL; // is this neccessary? unset might be better
		$result = NULL;
		// Should we add unique constraint to DB aswell?
	}
		
	//Password checks
	if (empty($_POST['passwd']))
		$errors['passwd'] = 'Password required.';
	else if (empty($_POST['confirm-passwd']))	
		$errors['passwd'] = 'Confirm feild empty';
	else if (passwd_check($_POST['passwd']) === FALSE)
	{
		$errors['passwd'] = 'Password must only contain atleast one lower and upper case letter,<br>
								one number, and be longer than 9 characters.';
	}
	else if ($_POST['passwd'] != $_POST['confirm-passwd'])
		$errors['passwd'] = "Passwords don't match.";

	//Image checks . Please look at the helper function, image_check may need more protection
	if (!empty($_FILES['profile-pic']['name']))
	{
		if (image_check($_FILES['profile-pic']['type'], $_FILES['profile-pic']['tmp_name']) === FALSE) 
			$errors['image'] = 'Please only upload a valid image';	
		else if (copy($_FILES['profile-pic']['tmp_name'], $profile_pic_path) === FALSE)
			$errors['image'] = 'Image upload failed';
	}
	else
		$profile_pic_path = NULL;

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
			$_SESSION['message'] = 'Registration successful.';
		}
		catch (PDOExeption $e)
		{
			echo $e->getMessage();
			$_SESSION['message'] = 'Sorry, registration failed';
		}
		if (mail_verification_code($email, $verification_code, 'USER_VERIFY', $username ) === FALSE)
		{
			$_SESSION['message'] = "Sorry, we were unable to send you the confirmation link,
									please confirm your name and password and click the resend button 
									or try again later.";
			header("location: form.php");
			exit ();
		}
		else
		{
			$_SESSION['message'] = "Registration successful. Please check your email and<br>
									click on the link provided to validate your account and signin.<br>
									If you didn't receive an email please confrim your details and click resend.<br>";
			header("location: form.php");
			exit();
		}
	}
	else
		$_SESSION['message'] = 'Registration failed';
}

/**********************************
*	SIGN IN / SIGNIN.PHP / HOME.PHP
***********************************/

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
		$_SESSION['message'] = "Incorrect username or password, please try again."; //this needs to be in errors[]; 
	else if ($info['verified'] == 1) // ? Why can't i use === 
	{
		if (password_verify($_POST['passwd'], $info['passwd']))
		{
			$_SESSION['user_id'] = $info['id'];
			$_SESSION['username'] = $username;
			$_SESSION['notify'] = set_notification($info['notifications']);
			$_SESSION['user_email'] = $info['email'];
			unset($info);
			header("location: index.php");
			exit(); 
		}
		else
			$_SESSION['message'] = "Incorrect username or password, please try again.";
	}
	else if ($info['verified'] == 0)
	{
		$_SESSION['message'] = "Sorry, your account has not been confirmed, 
								please check your email to confirm your account";
	}
}

/***************************
*	RESEND LINK / SIGNIN.PHP
****************************/

else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['resend-link'])) //Do i need to unset POSTS
{
	$username = $_POST['username'];
	$email = $_POST['email'];
	if (empty($_POST['username']) || empty($_POST['email']) || empty(['passwd']) || empty(['confirm-passwd']))
	{
		$_SESSION['message'] = 'Please fill in all the feilds and try again';
		header('location: form.php');
		exit();
	}
	try
	{
		$sql = "SELECT * FROM `users` WHERE `username` = ?";
		$stmt = $conn->prepare($sql);
		$stmt->execute([$username]);
		$info = $stmt->fetch(PDO::FETCH_ASSOC);
		unset($stmt);
	}
	catch (PDOException $e)
	{
		echo $e->getMessage();
	}
	if ($info === FALSE)
		$_SESSION['message'] = "Please fill in all the feilds correctly and try again."; //this needs to be in errors[]; 
	else if ($info['verified'] == 1) // ? Why can't i use === 
	{
		if ($email != $info['email'])
		{
			$_SESSION['message'] = 'It seems you entered a different email address from the one you registered
									with,<br>please make sure to enter the one you registered with.';
		}
		else if ($_POST['passwd'] != $_POST['confirm-passwd'])
			$_SESSION['message'] = "Passwords don't match";
		else if (password_verify($_POST['passwd'], $info['passwd']))
		{
			$_SESSION['message'] = "You are already verified, please signin.";
			header("location: signin.php");
			exit(); 
		}
		else
			$_SESSION['message'] = "Incorrect username or password, please try again.";
	}
	else if ($info['verified'] == 0)
	{
		if ($_POST['passwd'] != $_POST['confirm-passwd'])
			$_SESSION['message'] = "Passwords don't match";
		else if (password_verify($_POST['passwd'], $info['passwd']))
		{
			$bytes = random_bytes(16);	
			$verification_code = bin2hex($bytes);
			$query = 'UPDATE `users` SET `verification` = ? WHERE `id` = ?';
			$stmt = $conn->prepare($query);
			$stmt->execute([$verification_code, $info['id']]);
			unset($stmt);
			if ($email != $info['email'])
			{
				$_SESSION['message'] = 'It seems you entered a different email from the one you registered
										with,<br>please make sure to enter the one you registered with.';
			}
			else if (mail_verification_code($info['email'], $verification_code, 'USER_VERIFY', $username) === FALSE)
			{
				$_SESSION['message'] = "Sorry, we were unable to send you the confirmation link,
										please confirm your details and click the resend button or try again later.";
			}
			else
			{
				$_SESSION['message'] = "Email has successfully been resent, 
										please check your email to confirm your account and then sign in.";
			}
		}
		else
			$_SESSION['message'] = "Incorrect username or password, please try again.";
	}
}

/****************************************************
*	REQUEST PASSWORD TO BE CHANGED / FORGOTPASSWD.PHP 
*****************************************************/

/*
Resetting a forgotten password is a bit verbose but here is how it works.
First, if the user forgot their password they click the forgot password link
from signin.php. They then enter their email on forgotpasswd.php, controller 
will send email with vcode if the email exits, email gets sent
with a get vcode. The user clicks the link that takes them to new_passwd.php. 
A session var gets set with the vcode on reset.php. New_passwd calls controller
which verifies the vcode stored in the session var with the email address,
if the results are true the users passwd gets changed to the new passwd entered 
in on new_passwd.php and the vcode gets set to NULL
*/

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
		mail_verification_code($res['email'], $verification_code, 'PASSWD_VERIFY', $res['username']);// Protect?
		unset($stmt);
		unset($verification_code); // Should have a message saying email sent
	}
	else
	{
		$_SESSION['message'] = 'This is an invalid email address, please try again.'; // I'm thinking I should remove this else, people can use this ouput to see if a user is on this site.
		header('location: forgotpasswd.php'); // Is this necessary here?
		exit();
	}
}

/************************************************
*	RESET PASSWORD / NEW_PASSWORD.PHP / RESET.PHP
*************************************************/

else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['verification']) && isset($_POST['Reset']))
{
	// I want to use an errors array here but it doesn't seem to be printing on the forgotpasswd page. Will try fix this.
	$bad_passwd = "";
	$error_check = FALSE;
	if (empty($_POST['email']) || empty($_POST['passwd']) || empty($_POST['confirm-passwd']))
		$error_check = TRUE;
	else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
		$error_check = TRUE;
	else if (passwd_check($_POST['passwd']) === FALSE)
	{
		$error_check = TRUE;
		$bad_passwd = "Password must only contain atleast one lower and upper case letter,<br>
		one number, and be longer than 9 characters.";
	}
	else if ($_POST['passwd'] !== $_POST['confirm-passwd']) // Still needs strong password checking
		$error_check = TRUE;
	else if ($error_check === FALSE) // Makes sure email and vcode match
	{
		$query = 'SELECT * FROM `users` WHERE `verification` = ? && `email` = ? '; // Also check if user is verified
		$stmt = $conn->prepare($query);
		$stmt->execute([$_SESSION['verification'], $_POST['email']]);
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		if (!$res)
			$error_check = TRUE;
		unset($stmt);
	}
	if ($error_check === TRUE)
	{
		unset($_SESSION['verification']);
		$_SESSION['message'] = "There was a problem reseting your password.<br>  
								Please make sure to fill in all the feilds correctly.<br> 
								Please enter your email address and try again.<br>".$bad_passwd;
		header('location: forgotpasswd.php');
	}
	else
	{
		$new_passwd = password_hash($_POST['passwd'], PASSWORD_BCRYPT);
		$query = 'UPDATE `users` SET `passwd` = ? , `verification` = ? WHERE `id` = ?';
		$stmt = $conn->prepare($query);
		$stmt->execute([$new_passwd, NULL, $res['id']]);
		unset($new_passwd);
		unset($stmt);
		unset($_SESSION['verification']);
		$_SESSION['message'] = "Your password has been reset, please sign in.";
		header('location: signin.php');
		exit();
	}
}

/************************************************
*	RESET PASSWORD / NEW_PASSWORD.PHP / RESET.PHP
*************************************************/
//This is incase a user trys to access this page without getting an email
// Can probably take this away once I sort out htaccess

else if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['verification']) && isset($_POST['Reset']))
{
	$_SESSION['message'] = "It seems you didn't ask for your password to be changed,<br> 
							please go back to the sign in page.";
}

/************************************************
*	UPDATING EMAIL / PROFILE.PHP
*************************************************/

else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_email']))
{
	$email = $_POST['new_email'];
	if (empty($email))
		$errors['email'] = 'Email required';
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
		$errors['email'] = 'Valid email required';
	else if (strlen($email) > 80)
		$errors['email'] = 'Email address is too long';
	else
	{
		$query = 'SELECT `email` FROM `users` WHERE `email` = ?';
		$stmt = $conn->prepare($query);
		$stmt->execute([$email]);
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($result)
		{
			$errors['email'] = 'Email address already exits';
			if ($result['email'] == $email)
			$errors['email'] = 'This is already your email address';
		}
		unset($stmt);
		unset($result);
	}
	
	if (empty($errors))
	{
		$id = $_SESSION['user_id'];
		$query = 'UPDATE `users` SET `email` = ? WHERE `id` = ?';
		$stmt = $conn->prepare($query);
		$stmt->execute([$email, $id]);
		$_SESSION['user_email'] = $email;
		unset($stmt);
	}
}

/************************************************
*	UPDATING USERNAME / PROFILE.PHP
*************************************************/

else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_username']))
{
	$username = $_POST['new_username'];
	if (empty($username))
		$errors['username'] = 'Username required';
	else if (username_check($username) === FALSE)
		$errors['username'] = 'Username can only be English letters (with or without digits).';
	else if (strlen($username) < 3)
		$errors['username'] = 'Username too short';
	else if (strlen($username) > 50)
		$errors['username'] = 'Username too long';
	else
	{
		$query = 'SELECT `username` FROM `users` WHERE `username` = ?';
		$stmt = $conn->prepare($query);
		$stmt->execute([$username]);
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($result)
		{ 
			$errors['username'] = 'Username already exits';
			if ($result['username'] == $username)
				$errors['username'] = 'This is already your username';
		}
		$stmt = NULL; // unset or NULL?
		$result = NULL;
	}			
	
	if (empty($errors))
	{	
		$id = $_SESSION['user_id'];
		$query = 'UPDATE `users` SET `username` = ? WHERE `id` = ?';
		$stmt = $conn->prepare($query);
		$stmt->execute([$username, $id]);
		$_SESSION['username'] = $username;
		unset($stmt);
	}
}

/************************************************
*	UPDATE PASSWORD FROM PROFILE / PROFILE.PHP
*************************************************/


else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_passwd']))
{
	//var_dump($_POST); die;
	if (empty($_POST['old_passwd']) || empty($_POST['new_passwd']) || empty($_POST['confirm_new_passwd']))
		$errors['passwd'] = "Feilds can't be empty.";
	else if (passwd_check($_POST['new_passwd']) === FALSE)
	{
		$errors['passwd'] = 'Password must only contain atleast one lower and upper case letter,<br>
								one number, and be longer than 9 characters.';
	}
	else if ($_POST['new_passwd'] != $_POST['confirm_new_passwd'])
		$errors['passwd'] = "Passwords don't match.";
	
	if (empty($errors))
	{
		$new_passwd = password_hash($_POST['new_passwd'], PASSWORD_BCRYPT);
		$id = $_SESSION['user_id'];
		$sql = "SELECT `passwd` FROM `users` WHERE `id` = ?";
		$stmt = $conn->prepare($sql);
		$stmt->execute([$id]);
		$info = $stmt->fetch(PDO::FETCH_ASSOC);
		unset($stmt);
		if (!$info)
			$errors['passwd'] = "We where unable to change your password, please try again later";
		else if (password_verify($_POST['old_passwd'], $info['passwd']))
		{
			$query = 'UPDATE `users` SET `passwd` = ? WHERE `id` = ?';
			$stmt = $conn->prepare($query);
			$stmt->execute([$new_passwd, $id]);
			unset($stmt);	
			$_SESSION['message'] = "Password has been updated";
		}
	}
}

/************************************************
*	COMMENT ADDER / COMMENT.PHP
*************************************************/

else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_comment']) && isset($_POST['comment']) && !empty($_SESSION['image_id']))
{
	$comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
	$image_id = filter_var($_SESSION['image_id'], FILTER_SANITIZE_NUMBER_INT); // user has access to this var;
	$user_id = $_SESSION['user_id'];
	$comment = trim($comment); // Will this leak like in c?
	
	if (empty($comment))
		$errors['comment'] = "Comments can't be empty.";
	if (verify_image_id($image_id) === FALSE)
		$errors['image'] = "Your comment could not be processed at this time, please try again later.";

	if (count($errors) === 0)
	{
		$comment = wordwrap($comment, 50, '<br />', TRUE);
		$len = strlen($comment);
		$query = "INSERT INTO `comments` (`comment`, `image_id`, `user_id`) VALUES (?, ?, ?)";
		$stmt = $conn->prepare($query);
		$stmt->bindParam(1, $comment, PDO::PARAM_STR, $len);
		$stmt->bindParam(2, $image_id, PDO::PARAM_INT);
		$stmt->bindParam(3, $user_id, PDO::PARAM_INT);
		$stmt->execute();

		$image_owner_id = get_image_owner_id($image_id);
		if ($_SESSION['user_id'] == $image_owner_id)
			$commenter = "You";
		else
			$commenter = $_SESSION['username'];

		$notif = get_owner_notif($image_owner_id);
		if ($notif)
		{
			$image_owner_email = get_image_author_email($image_owner_id);
			if ($image_owner_email)
			{
				$image_owner = get_image_author_name($image_owner_id);
				mail_comment_notif($image_owner_email, $image_owner, $commenter);
			}
		}
	}
	else
	{
		header('location: comment.php');
		exit();
	}
}
?>