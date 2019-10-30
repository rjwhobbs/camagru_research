<?php
function username_check($username)
{
	if (preg_match("/^[a-zA-Z0-9]+$/", $username) === 0)
		return FALSE;
	if (ctype_digit($username) === TRUE)
		return FALSE;
	return TRUE;
}
?>