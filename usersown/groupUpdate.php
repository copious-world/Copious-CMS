<?php

if ( isset($_GET["sess"]) ) {
	$sess = $_GET["sess"];
	$recordID = $_GET['recordID'];
}

global $db_connection;
global $g_sname_depth;
$g_sname_depth = '..';
include "../admin_header.php";


if ( $userid > 0 ) {
	$section_q = "update mail_groups set ";

	$sep = "";
	for ( $i = 2; $i <= 16; $i++ ) {
		$groupnum = 'group' . $i;
		if ( isset($_GET[$groupnum]) ) {
			$groupname = $_GET[$groupnum];
		} else $groupname = "";
		//
		$section_q .= $sep . "  $groupnum = '$groupname' ";
		$sep = ",";
	}
	$section_q .= " where ( ID = '$recordID')";

	db_query_exe($section_q);
	//
	echo "Group Update Done";
} else {
	echo "Invalid Session ID";
}

?>
