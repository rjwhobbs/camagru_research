<?php
if(!isset($_SESSION['user_id']) && !isset($_SESSION['username']) && !isset($_SESSION['notify']))
{
	header("location: form.php");
	exit(); // Does this even happen?
}
?>