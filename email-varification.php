<?php
session_start();
echo "Welcome <br />";
echo $_GET['vercode']."<br />";
echo $_SESSION['message'];
?>