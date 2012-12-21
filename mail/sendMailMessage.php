<?php
	//
	$application = "Copious Mail";

if ( isset($_GET["sess"]) ) {
	$sess = $_GET["sess"];

	$grouplabel = $_GET['grouplabel'];
	$recipients = $_GET['recipients'];
	$subject = $_GET['subject'];
	$message = $_GET['message'];
	$externemails = $_GET['externemails'];
	$extraEmails = ( strlen($externemails) > 0 );
	$attachment = $_GET['attachment'];   // The name of a  file....
}

global $db_connection;
global $g_sname_depth;
$g_sname_depth = '..';
include "../admin_header.php";


if ( strlen($attachment) > 0 ) {
	$hasAttach = true;
	$attachState = 1;
} else {
	$hasAttach = false;
	$attachState = 0;
}
//
$emailsource = 0;
//
//
$subject = urlencode($subject); 
$message = str_replace('\\"','"',$message);
$message = urlencode($message);

$senddate = datetime();

$recipients_array = getuserid_list($recipients);
$recipients = implode(",",$recipients_array['id']);

////
// Create a new one.
$create_mail_q = "insert into mail_group_messages ( ID, UID, grouplabel, recipients, subject, externalmail, message, attached, isemail, whensend )";
$create_mail_q .= " values ( 0, $userid, '$grouplabel', '$recipients', '$subject', '$externemails', '$message', $attachState, $emailsource, '$senddate' )";
//
db_query_exe($create_mail_q);

$get_mail_q = "select ID from mail_group_messages where ( UID = '$userid' ) AND ( whensend = '$senddate') AND ( grouplabel = '$grouplabel')";
$messageID = db_query_value($get_mail_q); //

if ( $messageID > 0 ) {
////
	$blocked_members = get_blocking_members($userid,$grouplabel);
	$N_blocks = count($blocked_members);

	$member_array = split(",",$recipients);
	$counter = count($member_array);

	for ( $i = 0; $i < $counter; $i++ ) {
		$member = $member_array[$i];

		if ( strlen($member) > 0 ) {
			$makelink = true;
			if ( $N_blocks > 0 ) {
				if ( in_array($member,$blocked_members) ) $makelink = false;
			}
			if ( $makelink ) {
				link_message($member,$messageID,$grouplabel);
				if ( $hasAttach ) attach_message($messageID,$attachment);
			}
		}
	}

	if ( $extraEmails ) {
		$externemails = urldecode($externemails);
		$externemails = nonblocked_emails($externemails,$blocked_members);
		if ( strlen($externemails) > 0 ) {
			copious_db_mail($externemails,$subject,standardemail($message),$attachment);
		}
	}

	if ( $N_blocks == 0 ) {
		$updatereport = "Message has been sent.";
	} else {
		if ( $N_blocks == 1 ) {
			$updatereport = "Message has been sent. But 1 member blocks it for group $grouplabel";
		} else {
			$updatereport = "Message has been sent. But $N_blocks members block it for group $grouplabel";
		}
	}
////
	unset($blocked_members);	
} else {
	$updatereport = "Bad Link to New Message";
}

echo  $updatereport . $recipients;

?>

