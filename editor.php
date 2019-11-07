<?php
session_start();
require ('./valid_session_check.php');
require ('./header.php');
?>
<!-- <!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body> -->
	<div class="navbar">
		<h1>Camagru Editor</h1>
	</div>
	<div class="top-container">
		<video id="video">Stream not available...</video><br>
		<button id="photo-button" class="btn btn-dark">
			Take Photo
		</button>
		<button id="save-button" class="btn btn-dark">
			Save Photo
		</button>
		<select id="sticker-menu">
			<option value="sticker1">Cookie1</option>
			<option value="sticker2">Cookie2</option>
			<option value="sticker3">Cookie3</option>
			<option value="sticker4">Cookie4</option>
		</select>
		<button id="clear-button">Clear </button>
		<canvas id="canvas"></canvas>
	</div>
	<div class="bottom-container">
		<div id="photos"></div>
	</div>
	<div class="stickers">
		<img id="sticker1" src="./images/ChocChip.png" width="100px" height="80px" >
		<img id="sticker2" src="./images/chocshortbread.png" width="100px" height="80px">
		<img id="sticker3" src="./images/peanut.png" width="100px" height="80px">
		<img id="sticker4" src="./images/shortbread.png" width="100px" height="80px">
	</div>
	<script src="javascript/main.js"></script>
	<P id="test"></P>
</body>
</html>