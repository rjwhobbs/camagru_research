<?php
session_start();
require ('./valid_session_check.php'); // How about an if state to not require controller till post is made?
require ('./controller.php');
require ('./header.php');
if (!empty($_POST['image']))
	$_SESSION['image'] = $_POST['image'];
?>
<br>
<br>
<h1>Add a comment, or don't.</h1>
<div class="indexfeed">
	<form action="comment.php" method="post">
		<img src=<?php echo $_SESSION['image'] ?>><br>
		<input type="submit" name="add_comment" value="Add Comment">
		<textarea rows="1" cols="100" name="comment" placeholder="Comment here..."></textarea><br>
	</form>
</div>
<?php
require ('./footer.php');
?>