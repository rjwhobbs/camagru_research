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
		<div class="indexfeed">
			<img src=<?php echo $images[$i]['path']; ?>><br>
			<p>Upload by <?php echo get_image_author_name($images[$i]['user_id']) ?></p>
			<form action="comment.php" method="post">
				<input type="hidden" name="image" value=<?php echo $images[$i]['path'] ?>>
				<input type="submit" name="add_comment" value="Comment">
			</form><br>
		</div><br>
		<?php $i++; ?>
	<?php
	}
?>
<?php
require ('./footer.php');
?>