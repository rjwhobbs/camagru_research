<?php
require_once ('./controller.php'); // will this call the controller again?
require ('./valid_session_check.php');
require ('./header.php');
?>
<h1>Profile settings for <?= $_SESSION['username']?></h1>
<?php
	if (count($errors) > 0)
	{
		echo $errors['email'].'<br>';
		unset($errors);
	}
?><br>
<span>Email notifications are <?= $_SESSION['notify']?></span>
<?php
	if ($_SESSION['notify'] == "on")
		require 'turn_notif_off.html';
	else if ($_SESSION['notify'] == "off")
		require 'turn_notif_on.html';
?><br>
	<form action="profile.php" method="post">
		<span>Your email address: <?= $_SESSION['user_email'].' ' ?></span>
			<input type="email" placeholder="update email address" name="new_email">
				<input type="submit" name="update_email" value="Update">
	</form>
<?php
require ('./footer.php');
?>
