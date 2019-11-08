<?php
session_start();
require_once ('./controller.php');
require ('./form_block.php');
require ('./header.php');
?>
<h1>Sign Up</h1>
<div><?php  
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
?></div>
<form  action="form.php" method="POST" autocomplete="off" enctype="multipart/form-data">
	<span>Username:</span><input type="text" placeholder="username" name="username" required/><br />
	<span>Email:</span><input type="email" placeholder="email address" name="email" required/><br />
	<span>Password:</span><input type="password" placeholder="password" name="passwd" required/><br />
	<span>Confirm password:</span><input type="password" placeholder="confirm" name="confirm-passwd" required/><br />
	<label>Choose a profile pic (optional):</label><input type="file" name="profile-pic" accept="image/*" /><br /> 
	<input type="submit" name="submit-signup" value="Register" />
	<input type="submit" name="resend-link" value="Resend link">
</form>
<?php
require ('./footer.php')
?>