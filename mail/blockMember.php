<?php

if ( isset($_GET["sess"]) ) {
	$sess = $_GET["sess"];
	$grouplabel = $_GET['mailgroup'];
	$memid = $_GET['wbc'];
}

global $db_connection;
global $g_sname_depth;
$g_sname_depth = '..';
include "../admin_header.php";

	////
	$i_blocking = "insert into mail_blocks (ID,uid,blocked_id,grouplabel) VALUES (0, $userid, $memid,'$grouplabel')";
	db_query_exe($i_blocking);
	echo "The current sender has been blocked.";
?>

