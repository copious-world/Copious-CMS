<?php

if ( isset($_GET["sess"]) ) {
	$sess = $_GET["sess"];
	$mailgroup = $_GET['mailgroup'];	
	$time = $_GET["when"];
}

global $db_connection;
global $g_sname_depth;
$g_sname_depth = '..';
include "../admin_header.php";

	$counter = 0;

	$u_group_q = "select count(*) from users_mail_groups where ( UID = '$userid') AND ( groupNumber = '$mailgroup')";
	$counter = db_query_value($u_group_q);

	if ( $counter <= 0 ) {
		$member_array = array( "empty" );
		$counter = 1;
	} else {
		////
		$u_group_q = "select group_list,group_id_list from users_mail_groups where ( UID = '$userid' ) AND ( groupNumber = '$mailgroup')";
		$q_result = @mysqli_query($db_connection,$u_group_q) or die (mysqli_error($db_connection));  //
		////
		if ( $row = @mysqli_fetch_row($q_result) ) {
			$member_array = split(",",$row[0]);
			$member_id_array = split(",",$row[1]);
			$counter = count($member_array);
		}
	}

?>


	if ( g_current_group_object  != null ) {
		g_current_group_object.members = new Array();
		g_current_group_object.member_ids = new Array();
<?php
	for ( $i = 0; $i < $counter; $i++ ) {
?>
		g_current_group_object.members.push("<?php echo $member_array[$i]; ?>");
		g_current_group_object.member_ids.push("<?php echo $member_id_array[$i]; ?>");
<?php
	}
?>
		updateGroupDisplay();
		fetch_group_cascade();
	}
