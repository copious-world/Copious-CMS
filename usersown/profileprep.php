<?php


///Read in the book feature set from the existing theme for the business page.

global $g_current_theme;
global $user;


$uid = $user->ID;

$QQ = "SELECT user_form FROM userprofiles WHERE ( uid = $uid ) AND ( serviceid = '$serviceid' )";
$fileform = db_query_value($QQ);


if ( ( $fileform == -1 ) || ( strlen($fileform) == 0 ) ) {
	$fileform = file_get_contents("form.txt");
	$fileform = str_replace("@theme_var_USERNAME",$username,$fileform);
	$fileform = str_replace("@busnessname",$bus_appdir,$fileform);
} else {
	$fileform = (urldecode($fileform));
	$fileform = str_replace('\\"','"',$fileform);   /// Temporary fix for magic quotes. Final fix is: do this on save.
}

echo $fileform;



?>
