<?php
function get_images()
{
	require ('./connection.php');
	$query = 'SELECT * FROM `images` ORDER BY `images`.`creation_date` DESC';
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$array = $stmt->fetchAll(PDO::FETCH_ASSOC);
	unset($stmt);
	return $array;
}

// function get_author_name($id)
// {
// 	require ('./connection.php');
// 	$query = ''
// }
?>