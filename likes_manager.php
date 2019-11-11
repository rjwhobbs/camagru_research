<?php
session_start();
require ('./valid_session_check.php');
require ('./connection.php');
//include ('./query_functions.php');
if (isset($_POST['likes']) && isset($_POST['image_path']) && isset($_POST['image_id']))
{
	echo "HERE";
}
else
	echo "Something went wrong with likes";
?>