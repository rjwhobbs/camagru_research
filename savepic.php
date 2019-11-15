<?php
session_start();
require ('./valid_session_check.php');
require ('./connection.php');
if (!empty($_POST['path']))
{
	$file = $_POST['path'];
	$user_id = $_SESSION['user_id'];
	$sql = 'INSERT INTO `images` (`path`, `user_id`) VALUES (?, ?)'; // remove edited from table creation!!!!!!!!
	$stmt = $conn->prepare($sql);
	$stmt->execute([$file, $user_id]);
	unset($stmt);

	echo "Image has been saved";
}
else
	echo "Sorry, we couldn't save the image";
?>