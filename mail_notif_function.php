<?php
function mail_like_notif($owner_email)
{
	$email_sender = "rhobbs@student.wethinkcode.co.za"; // DELETE ME LATER !!!!!!!!!!
	//$email_sender = "mikethetrooper@gmail.com"; // DELETE ME LATER !!!!!!!!!!
	$headers = "From: $email_sender" . "\r\n";
	$body = "Someone liked one of your pictures on Camagru.";
	mail($owner_email, 'Someone liked your picture', $body, $headers);
}

function mail_comment_notif($owner_email)
{
	$email_sender = "rhobbs@student.wethinkcode.co.za"; // DELETE ME LATER !!!!!!!!!!
	//$email_sender = "mikethetrooper@gmail.com"; // DELETE ME LATER !!!!!!!!!!
	$headers = "From: $email_sender" . "\r\n";
	$body = "Someone commented on one of your pictures on Camagru.";
	mail($owner_email, 'Someone commented on your picture', $body, $headers);
}
?>