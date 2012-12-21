<?php

	global $db_connection;
	$db_connection = 0;
	$db_select = 0;

	global $db_connection;
	require_once('admin_header_lite.php');

	$service = $_GET['service'];
	$session = $_GET['sess'];
	///

	$QQ = "select data,uid from authsession where (id = '$session') and (active = 1) and (dataready = 1)";
	$obj = db_query_object($QQ);

///
	if ( $obj != null ) {
		if ( $obj->data != -1 ) {
			$uid = $obj->uid;
			$data = $obj->data;
			$data = str_replace("W","",$data);
			$QQ = "select urlstr from userpages where (uid = '$uid') and (pagekey = '$data') and (service = '$service')";
			$data = db_query_value($QQ);
			echo $data;
		} else echo "NOK";
	}  else echo "NULLOK $session";
///

?>
