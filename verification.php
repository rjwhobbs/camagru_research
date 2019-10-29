<?php
require_once ('./connection.php'); // Is this necessary
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
			header('location: home.php');
		}
		else
		{
			echo "Not validated";
		}

	}
	catch (PDOException $e)
	{
		echo $e->getMessage();
	}
}
?>