<?php
require('./setup.php');
try
{
	$conn = new PDO('mysql:host='.$DB_HOST, $DB_USER, $DB_PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo "Connected<br>";
	$sql = "CREATE DATABASE IF NOT EXISTS `$DB_NAME`";
	$conn->exec($sql);
	echo "Database created<br>";
}
catch (PDOException $e) 
{
	echo $e->getMessage();
}

$conn = NULL;

try
{
	$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$createdb = "CREATE TABLE IF NOT EXISTS $DB_NAME.`users` 
				( `id` INT NOT NULL AUTO_INCREMENT , 
				`username` VARCHAR(50) NOT NULL , 
				`passwd` VARCHAR(255) NOT NULL , 
				`email` VARCHAR(80) NOT NULL ,
				`verified` BOOLEAN NOT NULL DEFAULT FALSE, 
				`verification` VARCHAR(255) DEFAULT NULL,
				`profile-pic` VARCHAR(255) DEFAULT NULL,
				`notifications` BOOLEAN NOT NULL DEFAULT TRUE , 
				PRIMARY KEY (`id`)) ENGINE = InnoDB ";
	$stmt = $conn->prepare($createdb);
	$stmt->execute();
	unset($stmt);
	$createtab = "CREATE TABLE IF NOT EXISTS $DB_NAME.`images` 
				(`id` INT NOT NULL AUTO_INCREMENT, 
				`path` TEXT NOT NULL,
				`user_id` INT NOT NULL, 
				`creation_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
				`likes` INT DEFAULT NULL,  
				PRIMARY KEY (`id`)) ENGINE = InnoDB";
	$stmt = $conn->prepare($createtab);
	$stmt->execute();
	unset($stmt);
	$createtab = "CREATE TABLE IF NOT EXISTS $DB_NAME.`comments`
				(`id` INT NOT NULL AUTO_INCREMENT,
				`comment` TEXT NOT NULL,
				`image_id` INT NOT NULL,
				`user_id` INT NOT NULL,
				`creation_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`)) ENGINE = InnoDB"; 
	$stmt = $conn->prepare($createtab);
	$stmt->execute();
	unset($stmt);
	$createtab = "CREATE TABLE IF NOT EXISTS $DB_NAME.`likes`
				(`id` INT NOT NULL AUTO_INCREMENT,
				`user_id` INT NOT NULL,
				`image_id` INT NOT NULL,
				`liked` BOOLEAN NOT NULL DEFAULT FALSE,
				PRIMARY KEY (`id`)) ENGINE = InnoDB";
	$stmt = $conn->prepare($createtab);
	$stmt->execute();
	unset($stmt);
	echo "Tables created<br>";
}
catch (PDOException $e) 
{
	echo $e->getMessage();
}
$conn = NULL; //NULL or unset?
?>