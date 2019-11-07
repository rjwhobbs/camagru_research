<?php
$photo = imagecreatefrompng("images/test.png");
$block = imagecreatetruecolor(100, 100);

imagecopy($photo, $block, 0, 0, 0, 0, 100, 100);
header('Content-Type: image/png');

imagepng($photo);
imagedestroy($photo);
?>