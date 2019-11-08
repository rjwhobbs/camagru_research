<?php
session_start();
require ('./controller.php');
require ('./header.php');
include ('./query_functions.php')
?>
<h1>This is Camagru.</h1>
<h2>Feed will come here.</h2>
<?php
	$images = get_images();
	$i = 0;
	$array_size = count($images);
	while ($i < $array_size)
	{?>
		<p></p>
		<img src=<?php echo $images[$i]['path']; ?>><br>
		<?php $i++; ?>
	<?php
	}
?>
<?php
require ('./footer.php');
?>