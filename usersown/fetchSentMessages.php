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


function fetchAttachment($messageID) {
	$select_attach_q = "select attachment from mail_attach where ( MID = '$messageID' )";		
	$attachment = db_query_value($select_attach_q);
	if ( $attachment == -1 ) {
		$attachment = "NONE";
	}
	return($attachment);
}

$u_group_q = "select count(*) from mail_group_messages where ( UID = '$userid') AND ( grouplabel = '$grouplabel')";
$counter = db_query_value($u_group_q);

if ( $counter <= 0 ) {
	$ID_array = array( "-1" );
	$Subject_array = array("{ tag: 'M', time: '00:00:00', attachment: 'NONE', users: ['n/a'], user_ids: [-1], subject: 'No messages' } ");
	$counter = 1;
} else {

	//		

	$get_mail_q = "select ID, recipients, whensend, subject, attached, isemail from mail_group_messages where ( UID = '";
	$get_mail_q .= $userid . "') AND ( grouplabel = '$grouplabel') ORDER BY whensend DESC";


	$q_result = @mysqli_query($db_connection,$get_mail_q) or die (mysqli_error($db_connection));  //
	////

	$counter = 0;
	$ID_list = "";
	$Subject_list = "";
	$sep = "";
	$Subject_array = array();

	while ( $row = @mysqli_fetch_row($q_result) ) {
	
		$messageID = $row[0];
		$recipients = $row[1];
		$username_list = getusername_list($recipients);
		$messageTime = $row[2];
		$messageSubject = $row[3];
		//
		$attached = $row[4];
		$isemail = $row[5];
		
		$messageTag = "M";
		if ( $isemail == 1 ) {
			$messageTag = "E";
		}

		$counter++;

		$attachment = "NONE";
		if ( $attached == 1 ) {
			$attachment = fetchAttachment($messageID);
		}

		$ID_list .= $sep .  $messageID;
		$messageSubject = urldecode($messageSubject);

		$username_list = str_replace(",","','",$username_list);
		$username_list = "'" . $username_list . "'";

			/////
$Subject_list = "{ tag: '$messageTag', time: '$messageTime', attachment: '$attachment', users: [$username_list], user_ids: [$recipients], subject: '$messageSubject' }";

		$Subject_array[] = $Subject_list;
		$sep = ",";

	}

	$ID_array = split(",",$ID_list);


}

?>


	if ( g_current_group_object  != null ) {

		g_current_group_object.out_mail_ids = new Array();
		g_current_group_object.mail_out_descr = new Array();
<?php
	for ( $i = 0; $i < $counter; $i++ ) {
?>
		g_current_group_object.out_mail_ids.push(<?php echo $ID_array[$i]; ?>);
		g_current_group_object.mail_out_descr.push(<?php echo $Subject_array[$i]; ?>);
<?php
	}
?>
		generate_sent_mailGroupReaderSpan();
		fetch_group_cascade();

	}

