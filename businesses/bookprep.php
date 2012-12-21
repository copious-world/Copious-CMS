<?php


///Read in the book feature set from the existing theme for the business page.

global $g_current_theme;

$l_caller = "businesses/inuse.php";
if ( $g_caller == crypt($l_caller,$g_caller_salt) ) {
/*
global $g_current_theme;
$g_current_theme = $g_business_object->theme;

///
	include("../themes/elements.php");
///
*/
	$dir = $g_business_object->servicename;
	$fileform = file_get_contents("../$dir/form.txt");
	echo $fileform;
} else {
	echo "Invalid calling context";
}


?>
