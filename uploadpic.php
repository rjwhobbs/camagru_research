<?php
require ('./connection.php');
if (isset($_POST['img']) && isset($_POST['edited']))
{
	$edited = $_POST['edited'];

	define('UPLOAD_DIR', 'images/');
	$img = $_POST['img'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	$file = UPLOAD_DIR . uniqid() . '.png';
	$success = file_put_contents($file, $data);

	if ($success === FALSE)
		echo "Couldn't upload";
	else
		echo "Successfully uploaded image.\n";
	
	$sql = 'INSERT INTO `images` (`path`, `user_id`, `edited` ) VALUES (?, ?, ?)';
	$stmt = $conn->prepare($sql);
	$stmt->execute([$file, 1, $edited]);
	unset($stmt);	
}

?>