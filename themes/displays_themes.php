<?php
	global $g_current_theme;

	$curdir = "/srv/www/lighttpd/hosted/themes";
	$d = dir($curdir);

	$dirlist = array();

	//$selector_form = "<input type='checkbox' name='optionselector[@index]' onclick='select_theme(\"@themename\");'></td><td class=\"themelister\" >";

	$selector_form = "<input type='submit' name='themename' class='themeselector' value=\"@themename\">";


	$i =0;
	while ( false !== ($entry = $d->read()) ) {
		if ( ( $entry[0] != '.' ) && ( $entry[0] != '..' )  ) {
			$filename = $curdir . "/" . $entry;
			if ( is_dir($filename) ) {
			
				$infofile = $filename . "/info.txt";
				$descr = "";
				if ( file_exists($infofile) ) {
					$filedata = file($infofile);
					$decr = $filedata[1];
				}

				$selector = str_replace('@themename',$entry,$selector_form);
				if ( $g_current_theme == $entry ) {
					$selector = str_replace('themeselector','currentthemeselector',$selector);
				}
				$dirlist[] = $selector . "<br>" . $decr;
			} 
		} 
	}
	$d->close();


$themediver =<<<EOTHEMER
</td></tr>
<tr><td class="themerow" >
EOTHEMER;

	$themelist = implode($themediver,$dirlist);

?>

<table class="themdisplay">
<tr><td class="themerow" >
<?php echo $themelist; ?>
</td></tr>
</table>
