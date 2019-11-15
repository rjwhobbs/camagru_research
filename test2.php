<?php
function valid_sticker_check($sticker)
{
	if (!empty($sticker))
	{
		if ($sticker != "sticker1.png" && $sticker != "sticker2.png" &&
			$sticker != "sticker3.png"	&& $sticker != "sticker4.png")
		{	
			return FALSE;
		}
	}
	else
	{
		return FALSE;
	}
	return TRUE;
}

function sticker_array_validator($testarr)
{
	$i = 0;
	$len = count($testarr);
	if ($len === FALSE)
		$len = 0; 
	while ($i <= $len)
	{
		if (valid_sticker_check($testarr[$i]) === FALSE)
		{
			unset($testarr[$i]);
			$testarr = array_values($testarr);
			$i--;
			$len--;
		}
		$i++;
	}
	return $testarr;
}
$str = "junk:sticker1.png:junk:sticker2.png:sticker2.png:sticker3.png:sticker4.png";
//$str = "cheese";
$arr = preg_split('/:/', $str, NULL, PREG_SPLIT_NO_EMPTY);

$new_arr = array_unique($arr);
$new_arr = sticker_array_validator($new_arr);

$len = count($new_arr);
$i = 0;
$png = "images/1600aa425dce2b2f2cbfa.png";
$img = imagecreatefrompng($png);

$mwidth = imagesx($img);
$mheight = imagesy($img);
var_dump($new_arr);
while ($i < $len && $i < 4)
{

	$sticker = imagecreatefrompng("images/".$new_arr[$i]);
	list($width, $height) = getimagesize("images/".$new_arr[$i]);
	if ($i == 0)
	{
		imagecopy($img, $sticker, 0, 0, 0, 0, $width, $height);
	}
	else if ($i == 1)
	{
		$x = $mwidth - $width;
		imagecopy($img, $sticker, $x, 0, 0, 0, $width, $height);
	}
	else if ($i == 2)
	{
		$y = $mheight - $height;
		imagecopy($img, $sticker, 0, $y, 0, 0, $width, $height);
	}
	else if ($i == 3)
	{
		$x = $mwidth - $width;
		$y = $mheight - $height;
		imagecopy($img, $sticker, $x, $y, 0, 0, $width, $height);
	}
	$i++;
}
$file = "images/"."LoopTest".uniqid().".png";
$success = imagepng($img, $file);
//imagepng($upload);
?>