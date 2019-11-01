<?php

function mail_verification_code($email, $code, $mode)
{
	$email_sender = "rhobbs@student.wethinkcode.co.za"; // DELETE ME LATER !!!!!!!!!! 
	//$email_sender = "mikethetrooper@gmail.com"; // DELETE ME LATER !!!!!!!!!!  
	$headers = "From: $email_sender" . "\r\n";
	if ($mode == "USER_VERIFY")
		$link = 'http://localhost:8080/camagru_research/verification.php?vcode='.$code;
	else if ($mode == "PASSWD_VERIFY")
		$link = 'http://localhost:8080/camagru_research/reset.php?vcode='.$code;
	if (mail($email, 'Email verification', $link, $headers) === FALSE)
		return FALSE;
	else
		return TRUE;
}
?>