<?php
function mail_verification_code($email, $code)
{
	$headers = "From: rhobbs@student.wethinkcode.co.za" . "\r\n";
	$link = 'http://localhost:8080/camagru_research/home.php?vcode='.$code;
	mail('xaxa@mailinator.com', 'test', $link, $headers);
}
?>