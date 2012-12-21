<?php

function nonblocked_emails($externemails,$blocked_members) {
	$n = count($blocked_members);
	if ( $n > 0 ) {
		$blockids = "";
		for ( $i = 0; $i < $n; $i++ ) {
			$blockids .= $blocked_members[$i] . ",";
		}
		
		$blockids = rtrim($blockids);
		$u_group_q = "select email from users where ID in ( $blockids )";
		//
		$email_list = db_query_list($u_group_q);
		
		$externemails_array = split(",",$externemails);
		$externemails = "";
		$sep = "";
		$n = count($externemails_array);
		for ( $i = 0; $i < $n; $i++ ) {
			$email = $externemails_array[$i];
			if ( !in_array($email,$email_list) ) {  // Not an e-mail of a blocked member...
				$externemails .= $sep . $email;
				$sep = ",";
			}
		}
	}
	return($externemails);
}


function get_blocking_members($userid,$grouplabel) {
	$fetch_id_q = "select uid from mail_blocks where (blocked_id = '$userid') AND (grouplabel = '$grouplabel')";
	$blocked_members = db_query_list($fetch_id_q);
	return($blocked_members);
}


function standardemail($message) {
	$message = urldecode($message);
	$message = str_replace("<br>","\n",$message);
	$message .= ".\n.\nThis message sent to you via http://www.copious-systems.com/mail\n";
	return($message);
}

function send_user_mail_update($uname,$e_mail) {
	//
	$mailmsg = "Here is the link to: <a href=\"http://www.copious-systems.com/mail/\" target=\"_blank\">Click for the mail page.</a>";
	//
	copious_db_mail($e_mail,"You have new copious mail from user, $uname.",$mailmsg);
}

function link_message($member,$messageID,$grouplabel) {
	global $db_connection;

	$fetch_id_q = "select ID, email, wants_notify from users where ID = '$member'";
	$q_result = @mysqli_query($db_connection,$fetch_id_q) or die (mysqli_error($db_connection));  //
	//
	//
	if ( $row = @mysqli_fetch_row($q_result) ) {
		//
		$linkuserid = $row[0];
		$e_mail = $row[1];
		$wants_notify = $row[2];
		$create_mail_q = "insert into mail_links ( UID, MID, grouplabel ) values ( $linkuserid, $messageID, '$grouplabel' )";
		db_query_exe($create_mail_q);

		if ( $wants_notify == 1 ) {
			send_user_mail_update($member,$e_mail);
		}
	}
}

function attach_message($messageID,$attachment) {
	$create_mail_q = "insert into mail_attach ( ID, MID, attachment )";
	$create_mail_q .= " values ( 0, $messageID, '$attachment' )";
	db_query_exe($create_mail_q);
}


////  Sends the email to some other service that's out there...
function copious_db_mail($externemails,$subject_data,$message_data,$attachment = "",$decode_subject = false) {
	if ( $decode_subject ) {
		$subject_data = urldecode($subject_data);
	}

	///  DOT DOT DOT
}


?>