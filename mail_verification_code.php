<?php
function mail_verification_code($email, $code)
{
	$headers = "From: rhobbs@student.wethinkcode.co.za" . "\r\n";
	$link = 'http://localhost:8080/camagru_research/verification.php?vcode='.$code;
	if (mail($email, 'Email verification', $link, $headers) === FALSE)
	{
		return FALSE;
	}
	else
	{
		return TRUE;
	}
}
?>