<?php

if ( isset($_POST["sess"]) ) {
	$sess = $_POST["sess"];
	$uploadaction = $_POST['doupload'];
	$dtime = $_POST['attachfilekey'];
}

global $db_connection;
global $g_sname_depth;
$g_sname_depth = '..';
include "../admin_header.php";

	$upstate = ( strlen($uploadaction) > 1 );

	if ( $upstate ) {
		$ftmp = $_FILES['uploaderFile']['tmp_name'];
		$oname = $_FILES['uploaderFile']['name'];
	} else {
		$oname = $_POST['uploaderFile'];
	}
	////

	list($stemname, $extstrl) = explode(".", $oname);
	$fname = 'zips/'. $stemname . "_" . $userid . "_" . $dtime . "." . $extstrl;

	if ( $upstate ) {
		if( move_uploaded_file($ftmp, $fname) ){
			echo $fname;
		} else {
			echo "failed";
		}
	} else {
		echo $fname;
	}

?>
