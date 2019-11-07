<?php
//require ('../connection.php');
$DB_USER = 'test_root' ;
$DB_PASSWORD = 's55oQsBuoDvyr2HB';
$DB_HOST = 'localhost';
$DB_NAME = 'research';
$DB_DSN = "mysql:host=$DB_HOST;dbname=$DB_NAME";
try
{
	$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
}
catch (PDOExeption $e)
{
	echo $e->getMessage; // do I need to call die here if connection fails?
}
if (isset($_POST['img']))
{
	//echo "You made it this far\n";
	//echo $_POST['img'];

	define('UPLOAD_DIR', 'img/');
	$img = $_POST['img'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	$file = UPLOAD_DIR . uniqid() . '.png';
	$success = file_put_contents($file, $data);
	
	$sql = 'INSERT INTO `images` (`author`, `pic`) VALUES (?, ?)';
	$stmt = $conn->prepare($sql);
	$stmt->execute(["test", $file]);
	unset($stmt);	
	echo "Success.\n";
}

?>