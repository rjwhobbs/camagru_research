<?php
session_start();
require ('./valid_session_check.php');
require ('./connection.php');
// if (isset($_POST['img']) && isset($_POST['edited']))
// {
// 	$user_id = $_SESSION['user_id'];
// 	$edited = $_POST['edited'];

// 	$img = $_POST['img'];
// 	$img = str_replace('data:image/png;base64,', '', $img);
// 	$img = str_replace(' ', '+', $img);
// 	$data = base64_decode($img);
// 	$file = "images/".uniqid().".png";
// 	$success = file_put_contents($file, $data);

// 	if ($success === FALSE)
// 		echo "Couldn't upload";
// 	else
// 		echo "Successfully uploaded image.\n";
	
// 	$sql = 'INSERT INTO `images` (`path`, `user_id`, `edited` ) VALUES (?, ?, ?)';
// 	$stmt = $conn->prepare($sql);
// 	$stmt->execute([$file, $user_id, $edited]);
// 	unset($stmt);	
// }
if (isset($_POST['img']) && isset($_POST['edited']))
{
	//$photo = imagecreatefrompng("images/test.png");
	$img = $_POST['img'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);	
	$upload = imagecreatefromstring($data);

	$sticker = imagecreatefrompng("images/chocchipsmall.png");
	list($width, $height) = getimagesize("images/chocchipsmall.png");

	imagecopy($upload, $sticker, 0, 0, 0, 0, $width, $height);
	$file = "images/"."test".uniqid().".png";
	$success = imagepng($upload, $file);
	
	if ($success === FALSE)
		echo "Couldn't upload";
	else
		echo "Successfully uploaded image.\n";

	imagedestroy($upload);
}	
?>