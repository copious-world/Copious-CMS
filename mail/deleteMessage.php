<?php

global $db_connection;
global $g_sname_depth;
$g_sname_depth = '..';
include "../admin_header.php";


	$del_id_q = "delete from mail_links where ( UID = '$userid' ) AND ( MID = '$MID' )";
	db_query_exe($del_id_q);

	$now = datetime();

	$create_mail_q = "insert into mail_links_deleted ( UID, MID, grouplabel, deltime ) values ( $userid, $MID, '$grouplabel', '$now' )";
	db_query_exe($create_mail_q);

	$updatereport = "Message ($userid,$MID) has been deleted.";
	echo  $updatereport;

?>

