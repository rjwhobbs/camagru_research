<?php
header('Content-Type: image/png');
$photo = imagecreatefrompng("images/test.png");
list($width, $height) = getimagesize("images/ChocChip.png");

$new_width = $width * 0.2;
$new_height = $height * 0.2;

$sticker = imagecreatefrompng("images/ChocChip.png");

//make canvas

//$canvas = imagecreatetruecolor($new_width, $new_height);

//imagecopyresampled($canvas, $sticker, 0, 0, 0, 0, 
					//$new_width, $new_height, $width, $height);	

//imagepng($sticker);
$new_sticker = imagescale($sticker, $new_width, $new_height);
imagecopy($photo, $new_sticker, 0, 0, 0, 0, $new_width, $new_height);
imagepng($photo);
imagedestroy($photo);
?>