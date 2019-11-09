<?php
session_start();
require ('./valid_session_check.php'); // How about an if state to not require controller till post is made?
require ('./controller.php');
require ('./header.php');
if (!empty($_POST['image_src']) && !empty($_POST['image_id']))
{
	$_SESSION['image_src'] = $_POST['image_src']; // Do I need protection against every session var
	$_SESSION['image_id'] = $_POST['image_id'];
}
else if (!isset($_SESSION['image_src']) || !isset($_SESSION['image_id']))
{
	$_SESSION['message'] = "We couldn't load the comments page right now, please try again later.";
	header('location: index.php');
	exit();
}// Add image_src and image_id validation here // I should probably make own global var to store these
$comments_array = get_image_comments($_SESSION['image_id']);
$array_size = count($comments_array);
$i = 0;
?>
<br>
<br>
<h1>Add a comment, or don't.</h1>
<?php
if (count($errors) > 0)
{
	foreach ($errors as $error)
		echo $error.'<br>';
	unset($errors);
}
?>
<div class="indexfeed">
	<form action="comment.php" method="post">
		<img src=<?php echo $_SESSION['image_src'] ?>><br>
		<textarea rows="1" cols="100" name="comment" placeholder="Comment here..."></textarea>
		<input type="submit" name="add_comment" value="Add Comment"><br>
	</form>
	<?php
	while ($i < $array_size)
	{?>
		<p><?php echo $comments_array[$i]['comment']; ?></p>
		<?php $i++; ?>	
	<?php
	}
	?>
</div>

<?php
require ('./footer.php');
?>