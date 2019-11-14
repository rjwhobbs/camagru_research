<?php
session_start();
require ('./valid_session_check.php');
require ('./connection.php');
//$errors = array(); // maybe declare arrays in each if in controller, of if not set in controller check
if (!empty($_POST['check-confirm']) && !empty($_POST['confirm-passwd']) && !empty($_POST['delete']))
{
	$user_id = $_SESSION['user_id'];
	$check_id = $_POST['delete'];
	if ($user_id === $check_id)
	{
		

		$query = "DELETE FROM `users` WHERE `users`.`id` = ?";
		$stmt = $conn->prepare($query);
		$stmt->execute([$user_id]);
		header('location: signout.php');
		exit();
	}	
}
else
{
	$_SESSION['message'] = "All feilds must be filled in.";
	header('location: profile.php');
	exit();
}
?>