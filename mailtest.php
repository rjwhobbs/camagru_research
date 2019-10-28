<?php
echo "mailtest<br>";
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 1);
echo 'I am : ' . `whoami`;
$headers = "From: rhobbs@student.wethinkcode.co.za" . "\r\n";
$result = mail('rjw.hobbs@gmail.com','Testing 1 2 3','This is a test.', $headers);
echo '<hr>Result was: ' . ( $result === FALSE ? 'FALSE' : 'TRUE') . $result;
echo '<hr>';
echo phpinfo();
?>