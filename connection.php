<?php
require ('./setup.php'); // does this make a new connection each time it's called?
try
{
	$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
}
catch (PDOExeption $e)
{
	echo $e->getMessage; // do I need to call die here if connection fails?
}
?>