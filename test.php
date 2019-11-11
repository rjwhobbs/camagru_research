<?php
require ('./controller.php');
$array = get_image_comments(6);
echo $array[0]['comment'];

?>