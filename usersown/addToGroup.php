<?php

if ( isset($_GET["sess"]) ) {
	$sess = $_GET["sess"];
	$mailgroup = $_GET['mailgroup'];
	$memberlist = $_GET['member'];
	$grouplabel = $_GET['grouplabel'];
	$time = $_GET["when"];
}

include 'servicename.php';

try {
	include '../database.php';
} catch (Exception $e) {
	echo 'Caught exception: ' .  $e->getMessage();
}
/*
*/
global $db_connection;
require_once('../user_from_session.php');
	
	function inlist($member, $memberlist) {
		$memhash = explode(",",$memberlist);
		return(in_array($member, $memhash));
	}

	function getuserid($membername) {
		$u_group_q = "select ID from users where ( username = '$membername' )";
		$userid = db_query_value($u_group_q);
		return($userid);
	}

	$updatereport = "";

	$u_group_q = "select count(*) from users_mail_groups where ( UID = '$userid') AND ( groupNumber = '$mailgroup')";
	$counter = db_query_value($u_group_q);

	if ( $counter <= 0 ) {
		// Create a new one.
		$create_group_q = "insert into users_mail_groups ( ID, UID, groupNumber, group_list ) values ( 0, $userid, $mailgroup, '$memberlist' )";
		db_query_exe($create_group_q);
		$updatereport = "Created new group members.";
	} else {
		$member = $memberlist;
		//
		$s_group_q = "select group_list from users_mail_groups where ( UID = $userid ) AND ( groupNumber = $mailgroup )";
		$memberlist = db_query_value($s_group_q);
		
		if ( !inlist($member, $memberlist) ) {
			$memberlist .= "," . $member;
			//
			$u_group_q = "update users_mail_groups set group_list = '$memberlist'";
			$u_group_q .= " where ( UID = '$userid') AND ( groupNumber = '$mailgroup')";
			//
			db_query_exe($u_group_q);
	
			
			$memid = getuserid($member);
			$d_blocking = "delete from mail_blocks where (blocked_id = '$memid') AND (uid = '$userid') AND ( grouplabel = '$grouplabel' )";
			db_query_exe($d_blocking);
			
			$updatereport = "Changed group members: " . $memberlist . " " . $memid;
			//
		} else {
			//
			$updatereport = "$member is already a member of group, $grouplabel.";
			//
		}
	}
	
	echo "User List Managed: " . $updatereport;

?>

