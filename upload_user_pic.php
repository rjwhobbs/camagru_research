<?php
session_start();
require ('./valid_session_check.php');
require ('./connection.php');
include ('./helpers.php');
// var_dump ($_FILES);
// var_dump ($_POST);
//echo $_FILES['file'];
if (!empty($_FILES) && !empty($_POST['sticker']))
{
	$sticker_choice = $_POST['sticker'];
	$bytes = random_bytes(4);	
	$rand = bin2hex($bytes);
	$pic_path = "images/".$rand.uniqid().".png";

	if (image_check($_FILES['file']['type'], 
					$_FILES['file']['tmp_name']) === FALSE)
	{
		echo "images/error.png";
		exit ();
	} 

	copy($_FILES['file']['tmp_name'], $pic_path);
	$upload = imagecreatefromstring(file_get_contents($pic_path));
	// $upload = imagecreatefrompng($pic_path); // need to check type of pic

	$sticker_arr = preg_split('/:/', $sticker_choice, NULL, PREG_SPLIT_NO_EMPTY);
	$clean_arr = array_unique($sticker_arr);
	$clean_arr = sticker_array_validator($clean_arr);

	$mwidth = imagesx($upload);
	$mheight = imagesy($upload);

	if ($mheight < 500 || $mheight < 375 || $mwidth > 500 || $mheight > 375)
	{
		$nwidth = 500;
		$nheight = 375;

		$temp = imagecreatetruecolor($nwidth, $nheight);

		imagecopyresized($temp, $upload, 0, 0, 0, 0, 
							$nwidth, $nheight, $mwidth, $mheight);
		$mwidth = $nwidth;
		$mheight = $nheight;

		$upload = $temp;
	}

	$len = count($clean_arr);
	if ($len === FALSE)
		$len = 0;
	$i = 0;

	if ($sticker_choice != '')
	{
		while ($i < $len && $i < 4)
		{
			$sticker = imagecreatefrompng("images/".$clean_arr[$i]);
			list($width, $height) = getimagesize("images/".$clean_arr[$i]);
			if ($i == 0)
			{
				imagecopy($upload, $sticker, 0, 0, 0, 0, $width, $height);
			}
			else if ($i == 1)
			{
				$x = $mwidth - $width;
				imagecopy($upload, $sticker, $x, 0, 0, 0, $width, $height);
			}
			else if ($i == 2)
			{
				$y = $mheight - $height;
				imagecopy($upload, $sticker, 0, $y, 0, 0, $width, $height);
			}
			else if ($i == 3)
			{
				$x = $mwidth - $width;
				$y = $mheight - $height;
				imagecopy($upload, $sticker, $x, $y, 0, 0, $width, $height);
			}
			$i++;
		}
	}

	$success = imagepng($upload, $pic_path);
	echo trim($pic_path);
}
else
	echo "images/error.png";
?>
