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
		//trim($img_path);
		// var_dump ($_SESSION);
		// var_dump ($_POST); die;
        $query = "DELETE FROM `images` WHERE `path` = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$img_path]);
        unset($stmt);
	}
	else 
        echo "Sorry can't delete image";
}
//var_dump($_POST); die;
header("location: editor.php");
?>