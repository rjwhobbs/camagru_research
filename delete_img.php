<?php
session_start(); // Should we also delete it from the folder
require ('./connection.php');
require ('./valid_session_check.php');
$user_id = $_POST['id'];
$img_path = $_POST['path'];
if (isset($user_id) && isset($img_path)) 
{
	if ($user_id == $_SESSION['user_id']) 
	{
		$img_path = trim($img_path);
        $query = "DELETE FROM `images` WHERE `path` = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$img_path]);
		unset($stmt);
		if ($img_path != "images/error.png")
			unlink($img_path);
	}
	else 
        echo "Sorry can't delete image";
}
header("location: editor.php");
?>