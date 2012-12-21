<?php

$dbspecific = "taxonomy";
include "../admin_header_lite.php";
global $db_connection;

/*
$query = $_POST['query'];

$whichdb = $_POST['DB'];
$taxoname = $_POST['taxo'];

*/

$query = "select HTML from cmn_menu_transition where id = 1";

$whichdb = "drupalcommunities";
$taxoname = "menus";



	add_db_connection($dbhost,$dbuser,$dbpass,$whichdb);
	$db_connection = switch_db_connection($whichdb);

	$HTML = db_query_value($query);
	if ( $HTML != -1 ) {
		$HTML = urlencode($HTML);
		$db_connection = switch_db_connection($dbspecific);
		
		if ( db_value_exists('name',$taxoname,'vocabulary') ) {
			$QQ = "update vocabulary set HTML = '$HTML'";
		} else {
			$QQ = "insert into vocabulary (id, name, description, help, hierarchy, multiple, relations, required, tags, weight,HTML)";
			$QQ .= " VALUES (0,'$taxoname','imported vocabulary','add help',1,1,1,1,1,'0.0','$HTML')";
		}
		db_query_exe($QQ);
	}

	echo "DONE OK";
?>
