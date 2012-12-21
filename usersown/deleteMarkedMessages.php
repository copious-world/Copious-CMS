<?php

global $db_connection;
global $g_sname_depth;
$g_sname_depth = '..';
include "../admin_header.php";


//// KILL ALL THE MESSAGES

	$QQ = "delete from mail_links_deleted where ( uid = '$userid' ) and ( grouplabel = '$grouplabel')";
	db_query_exe($QQ);

if ( $userid > 0 ) {
	echo "All Marked Messages Deleted";
} else {
	echo "No Account Access";
}




?>

