<?php
if(isset($_SESSION['user_id']) || isset($_SESSION['username']) || isset($_SESSION['notify']) || isset($_SESSION['user_email']))
{
	header("location: index.php");
	exit(); // Does this even happen?
}
?>