<?php
global $g_current_theme;
global $g_business_object;

unset($g_business_object);



$l_caller = "businesses/inuse.php";
if ( $g_caller == crypt($l_caller,$g_caller_salt) ) {

	$qq = "SELECT count(*) FROM serivcesource WHERE ( servicename = '$bus_appdir' )";
	$n = db_query_value($qq);

	if ( $n <= 0 ) exit();

	$qq = "SELECT * FROM serivcesource WHERE ( servicename = '$bus_appdir' )";
	$var = db_query_rows($qq);

	$g_business_object = (object)$var;

$output = "";

$output .=<<<EOTABLE
<div style="text-align:left">
<table widht = "50%">
EOTABLE;

$g_current_theme = 'basic';

	foreach( $var as $key => $value ) {
		if ( $key == "theme" ) $g_current_theme = $value;
$output .=<<<EOTABLE
<tr>
<td style="width:30%;font-weight:bold;font-size:1.1em;border:1px solid darkgreen;" >$key</td>
<td style="width:60%;font-weight:bold;font-size:1.05em;border:1px solid darkgreen;color:darkred" >$value</td>
</tr>
EOTABLE;
	}

$output .=<<<EOTABLE
</table>
</div>
EOTABLE;


echo $output;
}


?>
