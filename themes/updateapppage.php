<?php

$themedir = $_POST['theme_dir'];
$appdir = $_POST['appdir'];
$pubaction = $_POST['publishaction'];

$element_entries = $_POST['element_entries'];
$element_entries = explode(',',$element_entries);

$formform = file_get_contents("$themedir/pre_form.txt");
$templatetxt = file_get_contents("$themedir/template_generators/index_template.html");

$theme_vars = $_POST['theme_vars'];

$varstates = "<input id=\"theme_vars\" name=\"theme_vars\" type=\"hidden\" value=\"$theme_vars\">";

$formform = str_replace('@area_display_states',$varstates,$formform);

$theme_vars = str_replace("{ ",'{ "',$theme_vars);
$theme_vars = str_replace(":",'":',$theme_vars);
$theme_vars = str_replace(", ",', "',$theme_vars);

$theme_vars_states = json_decode($theme_vars);
$display = $_POST['display'];

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
	} else {
		$val = "unselected element";
	}

	$formform = str_replace($txtkey,$val,$formform);
	$templatetxt = str_replace($txtkey,$val,$templatetxt);

}
// 
echo "The following has been stored as your basic entry page form $pubaction . <br>";
echo $formform;

$formout = "../$appdir/form.txt";
if ( file_exists($formout) ) {
	unlink($formout);
}
$templateout = "../$appdir/template_generators/index_template.html";
if ( file_exists($templateout) ) {
	unlink($templateout);
}

file_put_contents($formout,$formform);
file_put_contents($templateout,$templatetxt);
/// TEMPLATE PARTS NOW REWRITTEN...

$pubsrc = ""; // Get preexisting publication source..
$partout = "../$appdir/template_generators/section_instatiations.php";
if ( $pubaction == "make default" ) {
	// rewrite the pages.data file components for loading.

	if ( file_exists($partout) ) {
		unlink($partout);
	}
$parttxt = "<?php\n";

	foreach ( $element_entries as $varkey ) {
		$val = $_POST[$varkey];
		$varpart = substr($varkey,4);;
		$vname = "$" . $varpart;
		$parttxt .= "$vname =<<<EOVALUE\n";
		$parttxt .= "$val\n";
		$parttxt .= "EOVALUE;\n";

		$vname = "$" . $varpart . "_src";
		$seondarysrc = "$vname = \"$pubsrc\";";
		$parttxt .= "$seondarysrc\n";
	}

$parttxt .= "?>\n";
echo "<br>$partout";

	file_put_contents($partout,$parttxt);
	/// Topic sections rewritten.

} else if ( $pubaction == "new version" ) {
	// put the elements into the book entries for the book owned by this user.
	// Don't do anything to the sections_instantiation file.. Just post to the publication source...
	$update_report = array();
	foreach ( $element_entries as $varkey ) {
		$val = $_POST[$varkey];
		$varpart = substr($varkey,4);
		$pushval = urlencode($val);
		$key = crypt("updatepppage.php","xx");  // USE OTHER METHOD 
		$update_report[] = file_get_contents("http://$webhost/hosted/themes/to_themevar_manager.php?key=$key&var=$varpart&contents=$pushval&appdir=$appdir");
	}

	var_dump($update_report);
}

?>
