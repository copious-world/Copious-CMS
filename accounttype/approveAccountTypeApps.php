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
	$approvals = $_POST['approvalUser'];

	$group_approvals = array();
	foreach ( $approvals as $approved ) {
		list($uid,$acid) = explode(",",$approved);
		if ( !isset($group_approvals[$acid]) ) {
			$group_approvals[$acid] = array();
		}
		$group_approvals[$acid][] = $uid;
	}

	foreach ( $group_approvals as $acid => $userlist ) {
		$ulisttxt = implode(",",$userlist);
		$QQ = "update authspecials set needs_approval = 0 where uid in ($ulisttxt) and ( serviceid = '$serviceid' )";
		db_query_exe($QQ);
	}

?>
