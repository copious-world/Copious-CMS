<?php

require_once("pop.php");



function zip_files($path,$recipients) {
	$zipfile = "zip/" . $recipients . timestamp() . ".gz";
	system("gzip $zipfile $path");
	return($zipfile);
}


function zip_parts($mimer,$recipients) {
	$path = "zips/" . $recipients . "/";
	$filelist = output_files($path,$mimer);
	$stored_file = zip_files($path,$recipients);
	foreach ( $stored_file as $i => $fname ) {
		$partname = $path . $fname;
		unlink($partname);
	}
}

//////////////////////////////
//////////////////////////////

function message_to_local_db($subject, $message, $attachment, $recipients, $useName, $userID, $senddate, $emailsource ) {
	//
	$grouplabel = "everyone";	// Until a group label can be determined.
	//
	if ( strlen($attachment) > 0 ) {
		$hasAttach = true;
		$attachState = 1;
	} else {
		$hasAttach = false;
		$attachState = 0;
	}
	//
	//
	$subject = urlencode($subject); 
	$message = str_replace('\\"','"',$message);
	$message = urlencode($message);

	////
	// Create a new one.
	$create_mail_q = "insert into mail_group_messages ( ID, UID, grouplabel, recipients, subject, message, attached, isemail, whensend )";
	$create_mail_q .= " values ( 0, $userid, '$grouplabel', '$recipients', '$subject', '$message', $attachState, $emailsource, '$senddate' )";
	db_query_exe($create_mail_q);
	//
	$get_mail_q = "select ID from mail_group_messages where ( UID = '$userid' ) AND ( whensend = '$senddate') AND ( grouplabel = '$grouplabel')";
	$messageID = db_query_value($get_mail_q); //
	
	if ( $messageID > 0 ) {
		link_message($useName,$messageID,$grouplabel);
		if ( $hasAttach ) attach_message($messageID,$attachment);
	}
	//// //// ////
}


function find_internal_sender($email_from) {
	$u_group_q = "select id from users where email = '$email_from'";
	$id = db_query_value($u_group_q);
	if ( $id == -1 ) $id = 0;
	return($id);
}


function parse_attachments($message) {
	return(array($message,""));   /// TBD
}

////////////////////////////////////////////////////////////
function uploadPOP3( $userID, $useName ) {
	//
	//
	$u_group_q = "select emailserver, pop3user, emailpass from user_pop3_account where UID = $userID";
	$userobj = db_query_object($u_group_q);
	//
	if ( $userobj ) {
		$popobj = new pop();
		if ( $popobj->pop( $userobj->pop3user, $userobj->emailpass, $userobj->emailserver ) ) {
			$n = $popobj->connect();
			if ( $n > 0 ) {
				for ( $i = 0; $i < $n; $i++ ) {
					$email = $popobj->getmessage($i);
					///
					$subject = $email['subject'];
					if ( preg_match("/\{COPIOUS\}/", $subject) ) {
						$message = nl2br($email['body']);
						$recipient = $userID;
							///
						$senderid = find_internal_sender($email['from']);
						$senddate = $email['date'];
							///
						list($message,$attachment) = parse_attachments($message);
						message_to_local_db($subject, $message, $attachment, $recipient, $useName, $senderid, $senddate,1);
					}

				}
				return("EMAIL now in DB...");
			} else {
				return("Could not authorize this user for POP3 download...");
			}
	
			$popobj->disconnect();
		}
	}
}


?>

