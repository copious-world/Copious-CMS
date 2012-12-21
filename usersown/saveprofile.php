<?php

function check_user_profile($uid,$serviceid) {
	$QQ = "SELECT count(*) FROM userprofiles WHERE ( uid = $uid ) AND ( serviceid = '$serviceid' )";
	$n = db_query_value($QQ);
	return($n != 0);
}


include "../admin_header.php";

$uid = $user->ID;

$themedir = "usersown";
$appdir = "usersown";

$element_entries = $_POST['element_entries'];
$element_entries = explode(',',$element_entries);

if ( !check_user_profile($uid,$serviceid) ) {
	$report = file_get_contents("http://$webhost/hosted/boot_db/user_default_profile.php?sess=$sessionid&uid=$uid");
}


$QQ = "SELECT pre_html FROM userprofiles WHERE ( uid = $uid ) AND ( serviceid = '$serviceid' )";
$templatetxt = db_query_value($QQ);
if ( strlen(trim($templatetxt)) == 0 ) {
	$templatetxt = file_get_contents("../$themedir/profile_template.html");
	$UU = "UPDATE userprofiles SET pre_html = '$templatetxt' WHERE ( uid = $uid ) AND ( serviceid = '$serviceid' )";
	db_query_exe($UU);
} else {
	$templatetxt = urldecode($templatetxt);
}

$QQ = "SELECT pre_form FROM userprofiles WHERE ( uid = $uid ) AND ( serviceid = '$serviceid' )";
$formform = db_query_value($QQ);
if ( strlen(trim($formform)) == 0 ) {
	$formform = file_get_contents("../$themedir/pre_form.txt");
	$UU = "UPDATE userprofiles SET pre_form = '$formform' WHERE ( uid = $uid ) AND ( serviceid = '$serviceid' )";
	db_query_exe($UU);
} else {
	$formform = urldecode($formform);
}


$theme_vars = $_POST['theme_vars'];

$varstates = "<input id=\"theme_vars\" name=\"theme_vars\" type=\"hidden\" value=\"$theme_vars\">";

$formform = str_replace('@area_display_states',$varstates,$formform);

$theme_vars = str_replace("{ ",'{ "',$theme_vars);
$theme_vars = str_replace(":",'":',$theme_vars);
$theme_vars = str_replace(", ",', "',$theme_vars);

$theme_vars_states = json_decode($theme_vars);
$display = $_POST['display'];
var_dump($display);

$i = 0;
foreach ( $theme_vars_states as $var => $state ) {
	$i++;
	$checkmark = ( $state == 1 ) ? "checked" : "";

	$checked = "@checked_" . $i;
	$formform = str_replace($checked,$checkmark,$formform);
	$txtkey = "@" . $var;

	if ( isset($display[$var]) ) {
		if ( in_array($var,$element_entries) ) {
			$val = $_POST[$var];
		} else {
			$val = urldecode($display[$var]);
		} 
		$formform = str_replace($txtkey,$val,$formform); // Default value of form
		$templatetxt = str_replace($txtkey,$val,$templatetxt); // HTML display substitutions
	} else {
		$templatetxt = str_replace($txtkey,"",$templatetxt); // HTML display substitutions
	}

}
// 


// Put into the user profile...
$formform = urlencode($formform);
$html = urlencode($templatetxt);


$UU = "UPDATE userprofiles SET user_form = '$formform', HTML = '$html' WHERE ( uid = $uid ) AND ( serviceid = '$serviceid' )";
db_query_exe($UU);


/// TEMPLATE PARTS NOW REWRITTEN...
echo "PROFILE SAVED";

?>

