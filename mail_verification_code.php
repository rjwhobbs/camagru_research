<?php

function mail_verification_code($email, $code, $mode)
{
	$email_sender = "pmalope@student.wethinkcode.co.za"; // DELETE ME LATER !!!!!!!!!!
	$headers = "From: $email_sender" . "\r\n";
	if ($mode == "USER_VERIFY")
		$link = 'Welcome to camagru please use the link below to confirm your account'.'<br>'.'http://localhost:8080/camagru/verification.php?vcode='.$code;
	else if ($mode == "PASSWD_VERIFY")
		$link = 'http://localhost:8080/camagru_research/reset.php?vcode='.$code;
	if (mail($email, 'Email verification', $link, $headers) === FALSE)
		return FALSE;
	else
		return TRUE;
}
?>