<?php

echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";

if ( isset($_GET["sess"]) ) {
	$sess = $_GET["sess"];
	$MID = $_GET['MID'];
	if ( isset($_GET["when"]) ) {
		$time = $_GET["when"];
	}
}

global $db_connection;
global $g_sname_depth;
$g_sname_depth = '..';
include "../admin_header.php";

	$u_group_q = "select count(*) from mail_group_messages where ( ID = '$MID')";
	$counter = db_query_value($u_group_q);

	if ( $counter <= 0 ) {
		echo "This message is lost. $MID";
	} else {
		$u_group_q = "select message from mail_group_messages where ( ID = '$MID')";
		$msg = db_query_value($u_group_q);

		if ( $msg != -1 ) {
			echo urldecode($msg);
		} else {
			echo "This message is lost.";
		}

		$u_group_q = "update mail_links set message_state = 1 where ( MID = '$MID') and ( UID = '$userid' )";
		db_query_exe($u_group_q);
	}

?>
