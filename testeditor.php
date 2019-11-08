<?php
//header('Content-Type: image/png');
$photo = imagecreatefrompng("images/test.png");

// $new_width = $width * 0.2;
// $new_height = $height * 0.2;

$sticker = imagecreatefrompng("images/chocchipsmall.png");
list($width, $height) = getimagesize("images/chocchipsmall.png");

//make canvas

//$canvas = imagecreatetruecolor($new_width, $new_height);

//imagecopyresampled($canvas, $sticker, 0, 0, 0, 0, 
					//$new_width, $new_height, $width, $height);	

//imagepng($sticker);
//$new_sticker = imagescale($sticker, $new_width, $new_height);
imagecopy($photo, $sticker, 0, 0, 0, 0, $width, $height);

$file = "images/"."test".uniqid().".png";
$success = imagepng($photo, $file);

if ($success === FALSE)
	echo "Couldn't upload";
else
	echo "Successfully uploaded image.\n";

imagedestroy($photo);
?>