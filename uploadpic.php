<?php
session_start();
require ('./valid_session_check.php');
require ('./connection.php');
if (isset($_POST['img']) && !empty($_POST['sticker']))
{
	$img = $_POST['img'];
	$user_id = $_SESSION['user_id'];
	$sticker_choice = $_POST['sticker'];
	$bytes = random_bytes(4);	
	$rand = bin2hex($bytes);

	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);	
	$upload = imagecreatefromstring($data);

	if ($sticker_choice != 'nosticker')
	{
		$sticker = imagecreatefrompng("images/$sticker_choice");
		list($width, $height) = getimagesize("images/$sticker_choice");
		imagecopy($upload, $sticker, 0, 0, 0, 0, $width, $height);
	}

	$file = "images/".$rand.uniqid().".png";
	$success = imagepng($upload, $file);
		
	// $sql = 'INSERT INTO `images` (`path`, `user_id`) VALUES (?, ?)'; // remove edited from table creation!!!!!!!!
	// $stmt = $conn->prepare($sql);
	// $stmt->execute([$file, $user_id]);
	// unset($stmt);
	
	imagedestroy($upload);

	if ($success === FALSE)
		echo "Couldn't upload";
	else
		echo $file;
}
else
	echo "Something went wrong\n";	// add ifs to js incase something goes wrong eg if response text is......
?>