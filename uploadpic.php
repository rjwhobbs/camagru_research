<?php
session_start();
require ('./valid_session_check.php');
require ('./connection.php');
if (isset($_POST['img']) && !empty($_POST['sticker']))
{
	$img = $_POST['img'];
	$user_id = $_SESSION['user_id'];
	$sticker_choice = $_POST['sticker'];

	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);	
	$upload = imagecreatefromstring($data);

	$sticker = imagecreatefrompng("images/$sticker_choice");
	list($width, $height) = getimagesize("images/$sticker_choice");

	imagecopy($upload, $sticker, 0, 0, 0, 0, $width, $height);
	$file = "images/"."test".uniqid().".png";
	$success = imagepng($upload, $file);
	
	
	$sql = 'INSERT INTO `images` (`path`, `user_id`, `edited` ) VALUES (?, ?, ?)';
	$stmt = $conn->prepare($sql);
	$stmt->execute([$file, $user_id, 1]);
	unset($stmt);
	
	imagedestroy($upload);

	if ($success === FALSE)
		echo "Couldn't upload";
	else
		echo $sticker_choice."\n";
}
else
	echo "Something went wrong\n";	
?>