<?php
session_start();
require ('./valid_session_check.php'); // STILL NEEDS THUMBNAILS OF PREVIOUSLY TAKEN IMAGES !!!!!!
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
		<button id="clear-button" style="display: none">
			Clear 
		</button>

		<br>
		<input type="radio" name="sticker-menu2" id="sticker1" value="sticker1.png">
			<label for="sticker1"><img  src="./images/ChocChip.png" width="100px" height="80px" ></label>
		<input type="radio" name="sticker-menu2" id="sticker2" value="sticker2.png">
			<label for="sticker2"><img  src="./images/chocshortbread.png" width="100px" height="80px"></label>
		<input type="radio" name="sticker-menu2" id="sticker3" value="sticker3.png">
			<label for="sticker3"><img  src="./images/peanut.png" width="100px" height="80px"></label>
		<input type="radio" name="sticker-menu2" id="sticker4" value="sticker4.png">
			<label for="sticker4"><img src="./images/shortbread.png" width="100px" height="80px"></label>

		<canvas id="canvas"></canvas>
	</div>
	<div class="bottom-container">
		<div id="photos"></div>
	</div>
	<div class="thumbnails">
	
	</div>
	<script src="javascript/main.js"></script>
</body>
</html>