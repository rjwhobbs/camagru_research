<?php

function mail_verification_code($email, $code, $mode, $username)
{
	$email_sender = "pmalope@student.wethinkcode.co.za"; // DELETE ME LATER !!!!!!!!!!
	$headers = "From: $email_sender" . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	if ($mode == "USER_VERIFY") {
		$link = '<h4>Welcome to camagru: '. $username .'</h4>';
		$link .= '<p>Please confirm your account by clicking on the link below:<br>'.'http://localhost:8080/camagru/verification.php?vcode='.$code.'</p>';
	}
	else if ($mode == "PASSWD_VERIFY")
		$link = 'http://localhost:8080/camagru_research/reset.php?vcode='.$code;
	if (mail($email, 'Email verification', $link, $headers) === FALSE)
		return FALSE;
	else
		return TRUE;
}
?>