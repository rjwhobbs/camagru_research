<?php
session_start();
require ('./valid_session_check.php');
require ('./connection.php');
include ('./query_functions.php');
if (isset($_POST['likes']) && isset($_POST['image_path']) && isset($_POST['image_id']))
{
	//maybe some sanitization?
	$image_id = $_POST['image_id'];
	$image_path = $_POST['image_path'];
	$user_id = $_SESSION['user_id'];

	$query = "SELECT * FROM `images` WHERE `path` = ?";
	$stmt = $conn->prepare($query);
	$stmt->execute([$image_path]);
	$res = $stmt->fetch(PDO::FETCH_ASSOC);
	unset($stmt);
	if ($res)
	{
		$likes = $res['likes'];
		$likes += 1;
		if ($image_id == $res['id'])
		{
			$query = "SELECT `liked` FROM `likes` WHERE `image_id` = ? 
						&& `user_id` = ?";
			$stmt = $conn->prepare($query);
			$stmt->execute([$image_id, $user_id]);
			$res = $stmt->fetch(PDO::FETCH_ASSOC);
			unset($stmt);
			if (!$res)
			{
				$query = "UPDATE `images` SET `likes` = ? 
							WHERE `id` = ?";
				$stmt = $conn->prepare($query);
				$stmt->execute([$likes, $image_id]);
				unset($stmt);
				
			}
			//else print likes
		}
		//else print out amount of likes 
	}
	//else print out amount of likes
}
else
	echo "Something went wrong with likes";
?>