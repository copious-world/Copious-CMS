<?

if ( isset($_POST) || isset(_$GET) ) exit(); // cli only

require_once("businesses/newdir.php");



function change_theme($servicename,$vars,$params) {
	global $hostdirstructure;

	///==========================================>  'appdir=$appdir&theme=$theme&newdataphp=true'
	$parlist = explode("&",$params);
	$locals = array();
	foreach( $parlist as $parpair ) {
		list($var,$val) = explode("=",$parpair);
		$locals[$var] = $val;
	}

	$theme = $locals['theme'];
	$preserve_data = $locals['newdataphp'];
	$appdir = $locals['appdir'];
	///
	prepare_business_theme($servicename,$theme,$preserve_data);
	$filename = $hostdirstructure . "$appdir/template_generators/pages.data";
	$formfilename = $hostdirstructure . "$appdir/form.txt";

	$page_data = file_get_contents($filename);
	foreach ( $vars as $var => $value ) {
		$key = "@" . $var;
		$page_data = str_replace($key,$value,$page_data);
	}
	
	file_put_contents($filename,$page_data);
}


change_theme($servicename,$vars,$parameters);



?>
