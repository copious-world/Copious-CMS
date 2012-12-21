<?php

	include "../admin_header.php";

	$char = $_GET['char'];
	$text = file_get_contents ("worddata/$char.txt");

	echo $text;

?>
