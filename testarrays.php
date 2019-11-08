<?php
require ('./connection.php');

$query = 'SELECT * FROM `images`';
$stmt = $conn->prepare($query);
$stmt->execute();
$info = $stmt->fetchAll(PDO::FETCH_ASSOC);
unset($stmt);

$array_size = count($info);
$i = 0;

while ($i < $array_size)
{
	$query = 'SELECT `username` FROM `users` WHERE `id` = ?';
	$stmt = $conn->prepare($query);
	$stmt->execute([$info[$i]['user_id']]);
	$res = $stmt->fetch(PDO::FETCH_ASSOC);
	echo $res['username'].'<br>';
	$i++;
}
echo "Success";
?>