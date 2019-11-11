<?php
session_start();
require ('./valid_session_check.php');
require ('./connection.php');
if (isset($_POST['likes']))
{
	echo $_POST['likes'];
	echo $_POST['image_path']; 
	echo $_POST['image_id'];
}
?>