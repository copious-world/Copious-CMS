<?php

if ( isset($_GET["sess"]) ) {
	$sess = $_GET["sess"];
	$mailgroup = $_GET['mailgroup'];
	$memberlist = $_GET['memberlist'];
}

global $db_connection;
global $g_sname_depth;
$g_sname_depth = '..';
nclude "../admin_header.php";


	$updatereport = "";

	$u_group_q = "select count(*) from users_mail_groups where ( UID = '$userid') AND ( groupNumber = '$mailgroup')";
	$counter = db_query_value($u_group_q);

	$idarray = (array)getuserid_list($memberlist);

	$memberlist = implode(",",$idarray['username']);
	$idlist = implode(",",$idarray['id']);

	if ( $counter <= 0 ) {
		// Create a new one.
		$create_group_q = "insert into users_mail_groups ( ID, UID, groupNumber, group_list, group_id_list ) values ( 0, $userid, $mailgroup, '$memberlist', '$idlist' )";
		db_query_exe($create_group_q);
		$updatereport = "Created new group members.";
		//
	} else {
		//
		$u_group_q = "update users_mail_groups set group_list = '$memberlist', group_id_list = '$idlist' where ( UID = '$userid') AND ( groupNumber = '$mailgroup')";
		db_query_exe($u_group_q);
		$updatereport = "Changed group members.";
	}
	
	echo "User List Managed: "  . $updatereport;

?>

