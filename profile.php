<?php
session_start();
require ('./valid_session_check.php');
require ('./controller.php'); // will this call the controller again?
require ('./header.php');
?>
<h1>Profile settings for <?= $_SESSION['username']?></h1>
<?php
	if (count($errors) > 0)
	{
		foreach ($errors as $error)
			echo $error.'<br>';
		unset($errors);
	}
	if (!empty($_SESSION['message']))
	{
		echo $_SESSION['message'].'<br>';
		unset($_SESSION['message']);
	}
?><br>
<!--Buttons will be better here, not time to change all -->
<form action="profile.php" method="post"> 
	<span>Your username: <?= $_SESSION['username'].' ' ?></span><br>
		<input type="text" placeholder="update username" name="new_username">
			<input type="submit" name="update_username" value="Update"><br>
	<span>Your email address: <?= $_SESSION['user_email'].' ' ?></span><br>
		<input type="email" placeholder="update email address" name="new_email">
			<input type="submit" name="update_email" value="Update"><br>
	<span>Change Password:</span><br>
		<input type="password" placeholder="old password" name="old_passwd"><br>
		<input type="password" placeholder="new password" name="new_passwd"><br>
		<input type="password" placeholder="confirm" name="confirm_new_passwd"><br>
			<input type="submit" name="update_passwd" value="Change password">
</form><br>
<span>Email notifications are <?= $_SESSION['notify']?></span><br>
<?php
	if ($_SESSION['notify'] == "on")
		require 'turn_notif_off.html';
	else if ($_SESSION['notify'] == "off")
		require 'turn_notif_on.html';
?><br>
<?php
require ('./footer.php');
?>
