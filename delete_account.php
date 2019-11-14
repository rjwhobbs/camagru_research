<?php
session_start();
require ('./valid_session_check.php');
require ('./connection.php');
//$errors = array(); // maybe declare arrays in each if in controller, of if not set in controller check
if (!empty($_POST['check-confirm']) && !empty($_POST['confirm-passwd']) && !empty($_POST['delete']))
{
	$error_checker = FALSE;
	$user_id = $_SESSION['user_id'];
	$check_id = $_POST['delete'];
	$passwd = $_POST['confirm-passwd'];
	if ($user_id === $check_id)
	{
		$query = "SELECT `passwd` FROM `users` WHERE `id` = ?";
		$stmt = $conn->prepare($query);
		$stmt->execute([$user_id]);
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($res)
		{
			if (password_verify($passwd, $res['passwd'])) // Need to check if this will work if the tables are empty
			{
				$query = "DELETE FROM `users` WHERE `users`.`id` = ?";
				$stmt = $conn->prepare($query);
				$stmt->execute([$user_id]);
				unset($stmt);

				$query = "DELETE FROM `images` WHERE `user_id` = ?";
				$stmt = $conn->prepare($query);
				$stmt->execute([$user_id]);
				unset($stmt);

				$query = "DELETE FROM `comments` WHERE `user_id` = ?";
				$stmt = $conn->prepare($query);
				$stmt->execute([$user_id]);
				unset($stmt);

				$query = "DELETE FROM `likes` WHERE `user_id` = ?"; //likes will stay counted but database will be cleaned up
				$stmt = $conn->prepare($query);
				$stmt->execute([$user_id]);
				unset($stmt);

				header('location: signout.php');
				exit();
			}
			else
				$error_checker = TRUE;
		}
		else
			$error_checker = TRUE;

		if ($error_checker)
		{
			$_SESSION['message'] = "You entered incorrect details, account not deleted.";
			header('location: profile.php');
			exit();
		}	
	}	
}
else
{
	$_SESSION['message'] = "All feilds must be filled in.";
	header('location: profile.php');
	exit();
}
?>