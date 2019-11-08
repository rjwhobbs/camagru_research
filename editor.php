<?php
session_start();
require ('./valid_session_check.php');
require ('./header.php');
?>
	<div class="navbar">
		<h1>Camagru Editor</h1>
	</div>
	<div class="top-container">
		<video id="video">Stream not available...</video><br>
		<button id="photo-button" class="btn btn-dark">
			Take Photo
		</button>
		<button id="save-button" class="btn btn-dark" style="display: none">
			Save Photo
		</button>
		<select id="sticker-menu">
			<option value="sticker1.png">Cookie1</option>
			<option value="sticker2.png">Cookie2</option>
			<option value="sticker3.png">Cookie3</option>
			<option value="sticker4.png">Cookie4</option>
		</select>
		<button id="clear-button" style="display: none">Clear </button>
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