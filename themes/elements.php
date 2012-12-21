<?php

	global $g_current_theme;

	if ( !file_exists($g_current_theme . "/form.txt") ) {
		$g_current_theme = "basic";
	}

	$themedata = file_get_contents("../themes/$g_current_theme/form.txt");

	echo $themedata;

?>