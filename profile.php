<?php
require_once ('./controller.php'); // will this call the controller again?
require ('./valid_session_check.php');
require ('./header.php');
?>
<h1>Profile settings for <?= $_SESSION['username']?></h1>
<span>Email notifications are <?= $_SESSION['notify']?></span>
<?php
	if ($_SESSION['notify'] == "on")
		require 'turn_notif_off.html';
	else if ($_SESSION['notify'] == "off")
		require 'turn_notif_on.html';
?>
<br>
<!-- <a href="signout.php"><input type="submit" value="Sign Out"></a> -->
<?php
require ('./footer.php');
?>
