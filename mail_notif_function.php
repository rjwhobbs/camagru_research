<?php
function mail_like_notif($owner_email, $user ,$liker)
{
	$email_sender = "rhobbs@student.wethinkcode.co.za"; // DELETE ME LATER !!!!!!!!!!
	//$email_sender = "mikethetrooper@gmail.com"; // DELETE ME LATER !!!!!!!!!!

	$headers = "From: $email_sender"."\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

	$body ='<h3>Hi '.$user.'</h3>';
	$body .= '<p>'.$liker." liked one of your pictures on Camagru.</p>";

	mail($owner_email, 'Someone liked your picture', $body, $headers);
}

function mail_comment_notif($owner_email, $user ,$commenter)
{
	$email_sender = "rhobbs@student.wethinkcode.co.za"; // DELETE ME LATER !!!!!!!!!!
	//$email_sender = "mikethetrooper@gmail.com"; // DELETE ME LATER !!!!!!!!!!
	$headers = "From: $email_sender"."\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

	$body ='<h3>Hi '.$user.'</h3>';
	$body .='<p>'.$commenter." commented on one of your pictures on Camagru.</p>";
	mail($owner_email, 'Someone commented on your picture', $body, $headers);
}
?>