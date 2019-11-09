<?php
session_start();
require ('./valid_session_check.php'); // How about an if state to not require controller till post is made?
require ('./controller.php');
require ('./header.php');
if (empty($_POST['image']))
{
	header('location: index.php');
	exit();
}
else
	$image_src = $_POST['image'];
?>
<br>
<br>
<h1>Add a comment, or don't.</h1>
<div class="indexfeed">
	<form action="comment.php" id="commentform">
		<img src=<?php echo $image_src ?>><br>
		<input type="submit" name="add_comment" value="Add Comment">
	</form>
	<textarea rows="4" cols="50" name="comment" form="commentform" placeholder="Comment here..."></textarea><br>
</div>
<?php
require ('./footer.php');
?>