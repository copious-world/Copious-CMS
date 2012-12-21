<?php


function prepare_business_theme($servicename,$theme = 'basic',$preserve_data = false) {
	global $hostdirstructure;

	$dir = $hostdirstructure . $servicename;
	if ( !file_exists($dir) ) {
		mkdir($dir,0777);
		mkdir($hostdirstructure . $servicename . "/template_generators",0777);
	}

	$basictheme = "/srv/www/lighttpd/hosted/themes/$theme/";
	$curdir = "/srv/www/lighttpd/hosted/$servicename/";

	$cpsource = $basictheme ."/*.*";
	shell_exec("cp $cpsource $curdir");

	/// ------------ template_generators
	$basictheme = "/srv/www/lighttpd/hosted/themes/$theme/template_generators";
	$curdir = "/srv/www/lighttpd/hosted/" . $servicename . "/template_generators";
	///

	$cpsource = $basictheme ."/*.*";
	shell_exec("cp $cpsource $curdir");

}

?>
