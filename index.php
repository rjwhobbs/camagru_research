<?php
session_start();
require ('./controller.php');
require ('./header.php');
include ('./query_functions.php');
?>
<h1>This is Camagru.</h1>
<h2>Feed will come here.</h2>
<?php
	$images = get_images();
	$i = 0;
	$array_size = count($images);
	while ($i < $array_size)
	{?>
		<img src=<?php echo $images[$i]['path']; ?>><br>
		<p>Upload by <?php echo get_image_author_name($images[$i]['user_id']) ?></p>
		<form action="index.php" id="commentform">
  			<input type="submit" name="add_comment" value="Comment">
		</form>
		<textarea rows="4" cols="50" name="comment" form="commentform" placeholder="Comment here"></textarea><br>
		<?php $i++; ?>
	<?php
	}
?>
<?php
require ('./footer.php');
?>