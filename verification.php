<?php
require_once ('./connection.php');
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['vcode']))
{
	try
	{
		$query = 'SELECT `username` FROM `users` WHERE verification = ?';
		$stmt = $conn->prepare($query);
		$stmt->execute([$_GET['vcode']]);
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		if($res)
		{
			echo "Validation search works";
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