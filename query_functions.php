<?php
function get_images()
{
	require ('./connection.php');
	$query = 'SELECT * FROM `images` ORDER BY `images`.`creation_date` DESC';
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$array = $stmt->fetchAll(PDO::FETCH_ASSOC); // error handling?
	unset($stmt); // is unsetting stmt here necessary, will closing the func unset it?
	return $array;
}

function get_image_author_name($id)
{
	if ($id > 0)
	{
		require ('./connection.php');
		$query = 'SELECT `username` FROM `users` WHERE `id` = ?';
		$stmt = $conn->prepare($query);
		$stmt->execute([$id]);
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		return $res['username'];
	}
	else
		return "";
}
?>