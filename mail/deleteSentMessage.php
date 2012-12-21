<?php

global $db_connection;
global $g_sname_depth;
$g_sname_depth = '..';
include "../admin_header.php";

	$del_id_q = "delete from mail_links where ( MID = '$MID' )";	// Delete messages that control usre sent from all queues of all recipients...
	db_query_exe($del_id_q);

	$eraseOwner = "update mail_group_messages set UID = 0 where ID = '$MID'";  // Make the message inaccessible to all but administrator
	db_query_exe($eraseOwner);
	echo "Message ($userid,$MID) has been deleted.";

?>

