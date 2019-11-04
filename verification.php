<?php
session_start();
require ('./connection.php'); // Is this necessary
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['vcode']))
{
	try
	{
		$query = 'SELECT * FROM `users` WHERE verification = ?';
		$stmt = $conn->prepare($query);
		$stmt->execute([$_GET['vcode']]);
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($res)
		{
			unset($stmt);
			$query = 'UPDATE `users` SET `verified` = ? , `verification` = ? WHERE `id` = ?';
			$stmt = $conn->prepare($query);
			$stmt->execute([1, NULL, $res['id']]);
			unset($stmt);
			unset($res);
			$_SESSION['message'] = 'You have successfully verified your account, please signin.'; // Why is this not showing?
			header('location: signin.php');
		}
		else
		{
			header('location: form.php');
		}

	}
	catch (PDOException $e)
	{
		echo $e->getMessage();
	}
}
?>