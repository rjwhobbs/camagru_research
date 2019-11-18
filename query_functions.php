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
	$query = 'SELECT * FROM `comments` WHERE `image_id` = ? ORDER BY `comments`.`creation_date` DESC';
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

function get_image_author_from_path($path)
{
	if (!empty($path))
	{
		require ('./connection.php');
		$query = "SELECT `user_id` FROM `images` WHERE `path` = ?";
		$stmt = $conn->prepare($query);
		$stmt->execute([$path]);
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		if (!$res)
			return "Unkown";
		else
			return get_image_author_name($res['user_id']);
	}
	else
		return "Unknown";
}

function get_image_path_by_id($user_id)
{
	if ($user_id > 0)
	{
		require ('./connection.php');
		$query = 'SELECT * FROM `images` WHERE `user_id` = ? ORDER BY `images`.`creation_date` DESC';
		$stmt = $conn->prepare($query);
		$stmt->execute([$user_id]);
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if ($res)
			return $res;
		else
			return FALSE;
	}
	else
		return FALSE;
}

function get_image_likes($image_path)
{
	
	require ('./connection.php');
	$query = 'SELECT `likes` FROM `images` WHERE `path` = ?';
	$stmt = $conn->prepare($query);
	$stmt->execute([$image_path]);
	$res = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($res)
	{
		if ($res['likes'] == NULL)
			return 0;		
		return $res['likes'];
	}
	else
		return 0;
}

function get_image_author_email($id)
{
	if ($id > 0)
	{
		require ('./connection.php');
		$query = 'SELECT `email` FROM `users` WHERE `id` = ?';
		$stmt = $conn->prepare($query);
		$stmt->execute([$id]);
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		//var_dump($id); die;
		return $res['email'];
	}
	else
		return "";
}

function get_image_owner_id($image_id)
{
	if (!empty($image_id))
	{
		require ('./connection.php');
		$query = "SELECT `user_id` FROM `images` WHERE `id` = ?";
		$stmt = $conn->prepare($query);
		$stmt->execute([$image_id]);
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		if (!$res)
			return "";
		else
			return $res['user_id'];
	}
	else
		return "";
}

function get_owner_notif($user_id)
{
	if ($user_id > 0)
	{
		require ('./connection.php');
		$query = "SELECT * FROM `users` WHERE `id` = ?";
		$stmt = $conn->prepare($query);
		$stmt->execute([$user_id]);
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		if($res)
			return $res['notifications'];
		else 
			return 0;
	}
	else
		return 0;
}
?>