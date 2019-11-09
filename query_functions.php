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

function verify_image_id($id)
{
	if ($id > 0)
	{
		require ('./connection.php');
		$query = 'SELECT `path` FROM `images` WHERE `id` = ?';
		$stmt = $conn->prepare($query);
		$stmt->execute([$id]);
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		if (!$res)
			return FALSE;
		else
			return TRUE;
	}
	else
		return FALSE;
}

function get_image_comments($image_id)
{
	require ('./connection.php');
	$query = 'SELECT * FROM `comments` WHERE `image_id` = ? ORDER BY `comments`.`creation_date` DESC ';
	$stmt = $conn->prepare($query);
	$stmt->execute([$image_id]);
	$array = $stmt->fetchAll(PDO::FETCH_ASSOC); // error handling?
	unset($stmt); // is unsetting stmt here necessary, will closing the func unset it?
	return $array;	
}

function get_comment_author($user_id) // So this function does the samething as the last one
{
	if ($user_id > 0)
	{
		require ('./connection.php');
		$query = 'SELECT `username` FROM `users` WHERE `id` = ?';
		$stmt = $conn->prepare($query);
		$stmt->execute([$user_id]);
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		return $res['username'];
	}
	else
		return "";
}
?>