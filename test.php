<?php
$host		= 'localhost';
$user		= 'test_root';
$passwd		= 's55oQsBuoDvyr2HB'; // Pushing passwords to a public repo is a bad idea.
$db			= 'research';
$dsn		= "mysql:host=$host;dbname=$db"; 
//$query = '%This%';

try
{
	$conn = new PDO($dsn, $user, $passwd);
	$conn->setAttribute(PDO::ATTR_ERRMODE, 	
						PDO::ERRMODE_EXCEPTION);
	echo "Connected<br>";
	$sql = 'SELECT `passwd` FROM `users` WHERE `username` = ?';
	$stmt = $conn->prepare($sql); 
	$stmt->execute(['gg']);
	$info = $stmt->fetch(PDO::FETCH_ASSOC); 
	echo $info['passwd'].'<br>';
}
catch (PDOException $e)
{
	echo $e->getMessage();
}