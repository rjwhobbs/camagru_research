<?php
session_start();
require ('./controller.php');
require ('./header.php');
//include ('./query_functions.php');
?>
<h1>This is Camagru.</h1>
<h2>Feed will come here.</h2>
<?php
	if (count($errors) > 0)
	{
		foreach ($errors as $error)
			echo $error.'<br>';
		unset($errors);
	}
	if (isset($_SESSION['message']))
	{
		echo $_SESSION['message'];
		unset($_SESSION['message']);
	}
	$images = get_images();
	$i = 0;
	$array_size = count($images);
	while ($i < $array_size)
	{?>
		<div class="indexfeed">
			<img src=<?php echo $images[$i]['path']; ?>><br>
			<button id=<?php echo $images[$i]['id']?> 
					value=<?php echo $images[$i]['path']; ?> 
					onclick="likeFunction(this)">
					<?php echo get_image_likes($images[$i]['path']); ?> 
					Like+</button>
			<!-- <span id="likesamount"></span> -->
			<p>Upload by <?php echo get_image_author_name($images[$i]['user_id']) ?></p>
			<form action="comment.php" method="post">
				<input type="hidden" name="image_src" value=<?php echo $images[$i]['path'] ?>>
				<input type="hidden" name="image_id" value=<?php echo $images[$i]['id'] ?>>
				<input type="submit" name="add_comment" value="View /Add Comments">
			</form><br>
		</div><br>
		<?php $i++; ?>
	<?php
	}
?>
<script src="javascript/helpers.js"></script>
<?php
require ('./footer.php');
?>