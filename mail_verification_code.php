<?php
function mail_verification_code($email, $code, $mode, $username)
{
	$email_sender = "rhobbs@student.wethinkcode.co.za"; // DELETE ME LATER !!!!!!!!!!
	//$email_sender = "mikethetrooper@gmail.com"; // DELETE ME LATER !!!!!!!!!!
	$headers = "From: $email_sender"."\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	if ($mode == "USER_VERIFY")
	{
		$body ='<h4>Welcome to camagru '.$username.'</h4>';
		$body .= '<p>Please confirm your account by clicking on the link below 
					or copying it into your browser address bar.<br>';
		$body .= 'http://localhost:8080/camagru_research/verification.php?vcode='.$code;
	}
	else if ($mode == "PASSWD_VERIFY")
		$body = 'http://localhost:8080/camagru_research/reset.php?vcode='.$code;
	if (mail($email, 'Email verification', $body, $headers) === FALSE)
		return FALSE;
	else
		return TRUE;
}
?>