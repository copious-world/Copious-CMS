<?php

	global $replacers;

	$curdir = "/srv/www/lighttpd/hosted/themes";

	$vartypes = $curdir . "/themevars.txt";
	$varlist = file($vartypes);

	$varlist_form = array();
	foreach ( $varlist as $vardescr ) {
		list($varkey,$descr) = explode(':',$vardescr);
		$vname = "vars[" . substr($varkey,1,strlen($varkey)) . "]";
		if ( strstr($descr," Not settable" ) ) {
			$replacer = $replacers[$varkey];
$input =<<<EOL
	<span style="font-weight:bold;">$varkey</span></td><td class="vardescr">$replacer</td><td><input type='hidden' value='$replacer'  name="$vname" >
EOL;
		} else if ( strstr($descr," Upload") ) {
$input =<<<EOL
	<span style="font-weight:bold;">$varkey</span></td><td><input type='file' name="$vname"></td><td class="vardescr" >$descr
EOL;
		} else {
$input =<<<EOL
	<span style="font-weight:bold;">$varkey</span></td><td><input type='text' name="$vname"></td><td class="vardescr" >$descr
EOL;
		}
		$varlist_form[] = $input;
	}


$themediver =<<<EOTHEMER
</td></tr>
<tr><td class="themerow" >
EOTHEMER;

	$themelist = implode($themediver,$varlist_form);

?>

<table class="themdisplay">
<tr><td class="themerow" >
<?php echo $themelist; ?>
</td></tr>
</table>
