<?php
session_start(); // Should we also delete it from the folder
require ('./connection.php');
require ('./valid_session_check.php');
if (!empty($_POST['deletepath'])) 
{
	$path = trim($_POST['deletepath']);
	unlink($path);
}
?>