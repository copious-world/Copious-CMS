<?php

include '../servicename.php';

try {
	include '../database.php';
} catch (Exception $e) {
	echo 'Caught exception: ' .  $e->getMessage();
}
/*
*/
global $db_connection;
require_once('../user_from_session.php');


	$serviceid = $_POST['serviceid'];

	$ulisttxt = implode(",",$userlist);
	$QQ = "update authspecials set registed = 0 where id in (select id from authspecials where (needs_form = 0) AND (needs_approval = 0) AND (needs_pay = 0) AND ( serviceid = '$serviceid' )))";
	db_query_exe($QQ);


?>
