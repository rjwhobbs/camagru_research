<?php
session_start();
require ('./valid_session_check.php');
require ('./header.php');
require ('./query_functions.php');
//require ('./connection.php');
?>
	<div class="navbar">
		<h1>Camagru Editor</h1>
	</div>
	<div class="top-container">
		<video id="video">Stream not available...</video><br>
		<button style="display: none" id="photo-button" class="btn btn-dark">
			Take Photo
		</button>
		<button id="save-button" class="btn btn-dark" style="display: none">
			Save Photo
		</button>
		<button id="clear-button" style="display: none">
			Try again
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
		<input type="radio" name="sticker-menu2" id="stickernone" value="nosticker">
			<label for="stickernone">No Sticker</label>
		<canvas id="canvas"></canvas>
	</div>
	<div class="bottom-container">
		<div id="photos"></div>
	</div>
	<div class="thumbnails">
		<?php
			$id = $_SESSION['user_id'];

			$thumbnails = get_image_path_by_id($id);
			
			$i = 0;
			if ($thumbnails !== FALSE)
				$len = count($thumbnails);
			else 
				$len = 0;
			if ($len > 0)
			{?>
				<p>Your photo history: </p><br>
			<?php
			}
			while ($i < $len)
			{?>
				<img src=<?php echo $thumbnails[$i]['path']?>>
				<form action="delete_img.php" method="POST" >
					<input type="hidden" name="path" value=<?php echo $thumbnails[$i]['path'];?>>
					<input type="hidden" name="id" value=<?php echo $id;?>>
					<button>Delete</button>
				</form>
				<?php $i++; ?>
			<?php	
			}
		?>
	</div>
	<script src="javascript/main.js"></script>
<?php
require ('./footer.php');
?>