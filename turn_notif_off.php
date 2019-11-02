<?php
require ('./controller.php');
require ('./valid_session_check.php'); 

$query = 'UPDATE `users` SET `notifications` = ? WHERE `id` = ?';
$stmt = $conn->prepare($query);
$stmt->execute([0, $_SESSION['user_id']]); //Let's think how to do error handling here;
unset($stmt);
$_SESSION['notify'] = "off";
header('location: profile.php');
exit();
?>