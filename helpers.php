<?php
function username_check($username)
{
	if (preg_match("/^[a-zA-Z0-9]+$/", $username) === 0)
		return FALSE;
	if (ctype_digit($username) === TRUE)
		return FALSE;
	return TRUE;
}

function passwd_check($passwd)
{
	if (strlen($passwd) < 9)
		return FALSE;
	else if (preg_match('/[a-z]/', $passwd) === 0)
		return FALSE;
	else if (preg_match('/[A-Z]/', $passwd) === 0)
		return FALSE;
	else if (preg_match('/[0-9]/', $passwd) === 0)
		return FALSE;
	else if (preg_match("/^[a-zA-Z0-9]+$/", $passwd) === 0) // No special chars or spaces
		return FALSE;
	return TRUE;
}

function image_check($file, $file_path)
{
	if (preg_match('/image/', $file) === FALSE)
		return FALSE;
	else if (exif_imagetype($file_path) < 1)
		return FALSE;
	return TRUE;
}

function set_notification($value)
{
	if ($value)
		return "on";
	return "off";
}
?>

