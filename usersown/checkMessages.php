<?php

global $db_connection;
global $g_sname_depth;
$g_sname_depth = '..';
include "../admin_header.php";

	$u_group_q = "select count(*) from mail_links where ( UID = '$userid') AND ( message_state = '0' )";
	$mcount = db_query_value($u_group_q);
	//

	if ( $mcount <= 0 ) {
		echo "&nbsps;"
	} else if ( $mstate > 1 ) {
		echo "You have $mcount unread messages.";
	}

?>
