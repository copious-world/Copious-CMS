<?php

if ( isset($_GET["sess"]) ) {
	$sess = $_GET["sess"];
	$grouplabel = $_GET['grouplabel'];
	$time = $_GET["when"];
}

global $db_connection;
global $g_sname_depth;
$g_sname_depth = '..';
include "../admin_header.php";


$u_group_q = "select count(*) from mail_links_deleted where ( UID = '$userid') AND ( grouplabel = '$grouplabel')";
$counter = db_query_value($u_group_q);

if ( $counter <= 0 ) {
	$ID_array = array( "-1" );
	$Subject_array = array("{ tag: 'M', time: '00:00:00', attachment: 'NONE', sender_name: 'UNKOWN', sender_id: -1, subject: 'no messages' }");
	$counter = 1;
} else {

	$u_group_q = "select MID from mail_links_deleted where ( UID = '$userid') AND ( grouplabel = '$grouplabel')";
	//
	$q_result = @mysqli_query($db_connection,$u_group_q) or die (mysqli_error($db_connection));  //
	////
	$qlist = "";
	$sep = "";
	while ( $row = @mysqli_fetch_row($q_result) ) {
		$MID = $row[0];
		$qlist .= $sep . $MID;
		$sep = ",";
	}

/////// ( ID, UID, grouplabel, recipients, subject, message, attached, isemail, whensend )
	$get_mail_q = "select ID, UID, whensend, subject, attached, isemail from mail_group_messages where ( ID in ($qlist) ) ORDER BY whensend DESC";
	$q_result = @mysqli_query($db_connection,$get_mail_q) or die (mysqli_error($db_connection));  //

	$counter = 0;
	$ID_list = "";
	$Subject_list = "";
	$sep = "";
	$Subject_array = array();

	while ( $row = @mysqli_fetch_row($q_result) ) {
		$messageID = $row[0];
		$senderID = $row[1];
		$username = getusername($senderID);
		//
		$messageTime = $row[2];
		$messageSubject = $row[3];
		//
		$attached = $row[4];
		$isemail = $row[5];
		
		$messageTag = "M";
		if ( $isemail ) {
			$messageTag = "E";
		}

		$counter++;

		$attachment = "NONE";
		if ( $attached == 1 ) {
			$attachment = fetchAttachment($messageID);
		}

		$ID_list .= $sep .  $messageID;
		$messageSubject = urldecode($messageSubject);

$Subject_list = "{  tag: '$messageTag', time: '$messageTime', attachment: '$attachment', sender_name: '$username', sender_id: $senderID, subject: '$messageSubject' }";

		$Subject_array[] = $Subject_list;
		$sep = ",";
	}
	$ID_array = split(",",$ID_list);

}

?>


	if ( g_current_group_object  != null ) {
		g_current_group_object.deleted_mail_ids = new Array();
		g_current_group_object.mail_deleted_descr = new Array();
<?php
	for ( $i = 0; $i < $counter; $i++ ) {
?>
		g_current_group_object.deleted_mail_ids.push(<?php echo $ID_array[$i]; ?>);
		g_current_group_object.mail_deleted_descr.push(<?php echo $Subject_array[$i]; ?>);
<?php
	}
?>
		generate_delete_mailGroupReaderSpan();
	}
