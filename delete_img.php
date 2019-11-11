<?php
session_start();
require ('./connection.php');
// echo $_POST['path'];
// echo $_POST['id'];

$user_id = $_POST['id'];
$img_path = $_POST['path'];

if (isset($user_id) && isset($img_path)) {
    if ($user_id == $_SESSION['user_id']) {
        $query = 'DELETE FROM images WHERE `path` = ?';
        $stmt = $conn->prepare($query);
        $stmt->execute([$img_path]);
        unset($stmt);
        // var_dump($user_id);
        // echo "test;
    } else {
        echo "Sorry can't delete image";
    }
}
header("location: editor.php");