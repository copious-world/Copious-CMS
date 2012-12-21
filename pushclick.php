<?php
 
	global $db_connection;
	global $dbhost;
	global $dbuser;
	global $dbpass;
	global $dbspecific;

	$db_connection = 0;
	$db_select = 0;

	require_once "admin_header_lite.php";


	$session = $_GET['sid'];
	$data = $_GET['data'];
	///
	$QQ = "select count(*) from authsession where (id = '$session') and (active = 1)";

	$qc = db_query_value($QQ);
	if ( $qc > 0 ) {
		$QQ = "update authsession set dataready = 1, data = '$data' where id = '$session'";
		db_query_exe($QQ);
		echo "OK";
	} else {
		echo "NOK";
	}

	///

?>
