<?php

	// This one is called from 

include '../servicename.php';
try {
	include '../../../database.php';
} catch (Exception $e) {
	echo 'Caught exception: ' .  $e->getMessage();
}
	
	
	$sender_email = ""; 
	$sender_phone = ""; 
	$sender_message = ""; 


	function input_lister_row() {
		$text = implode(file("lister_row.txt"));
		return($text);
	}


	function input_detail_display() {
		$text = implode(file("detail_display.txt"));
		return($text);
	}


	function input_email_format() {
		$text = implode(file("response_email_format.txt"));
		return($text);
	}


	function replace_in_txt_form($txt,$value,$key) {
		$copikey = "$" . $key . "$";
		return(str_replace($copikey,$value,$txt));
	}
	

	global $db_connection;

//
// RETURN PREASSEMBLED ROWS...
//

	// create_ad_description
	// returns $addurl
	//
	function record_email_response($report_id,$request_id) {
		global $db_connection;
		//
		global $sender_email; 
		global $sender_phone; 
		global $sender_message;
		//
		$nowtime = datetime();
		////
		$section_maker = "insert into classified_response ";
		$section_maker .= "(ID,report_id,request_id,sender_email,sender_phone,sender_message,entrydate)";
		$section_maker .= " VALUES (0,$report_id,$request_id,'";
		$section_maker .= $sender_email . "','";
		$section_maker .= fixtext($sender_phone) . "','";
		$section_maker .= fixtext($sender_message) . "','";
		$section_maker .= $nowtime . "')";

		$q_result = @mysqli_query($section_maker) or die (mysqli_error($db_connection));  //
		//
		return(true );
	}
	

	//
	function notify_ad_poster($report_id,$request_id,$email_address) {
		global $db_connection;
		//
		global $sender_email; 
		global $sender_phone; 
		global $sender_message; 
		//
		$email_txt = input_email_format();
		//
		$email_txt = replace_in_txt_form($email_txt,$report_id,'report_id');
		$email_txt = replace_in_txt_form($email_txt,$request_id,'request_id');
		$email_txt = replace_in_txt_form($email_txt,$sender_email,'sender_email');
		$email_txt = replace_in_txt_form($email_txt,$sender_phone,'sender_phone');
		$email_txt = replace_in_txt_form($email_txt,$sender_message,'sender_message');

		$subject = "Copious Clasified Relays a reply.";
		$headers = 'From: classifieds@copious-systems.com' . "\r\n" . 'Reply-To: classifiedhelp@copious-systems.com' . "\r\n";

		mail($email_address,$subject,$email_txt,$headers);	
		
		return("Suject: $subject <br>$email_txt");
	}
	


	function ad_repsonse_time($report_id,$request_id) {
		global $db_connection;
		//
		$content = true;
		//
		$section_q = "select * from classified_request where ( ID = '";
		$section_q .= $request_id;
		$section_q .= "' ) AND ( processed = '1' )";
		//
		$q_result = @mysqli_query($section_q) or die (mysqli_error($db_connection));  // 
		//
		////	
		$row = @mysqli_fetch_array($q_result);
		if ( $row ) {
			//
			$email_address = urldecode($row['email_address']);
			//
			record_email_response($report_id,$request_id);
			//
			$content = notify_ad_poster($report_id,$request_id,$email_address);
			//
			$q_result = @mysqli_query($section_q) or die (mysqli_error($db_connection));  // 
		}		
		
		return "Your e-mail has been sent.<br> <br> $content";
	}


	////////////////////////////////////////////////////////////
	$requestid = $_GET['reportid'];
	
	$sender_email = $_GET['sender_email']; 
	$sender_phone = $_GET['sender_phone']; 
	$sender_message = $_GET['sender_message']; 
	
	error_reporting(E_ALL);
	
	$section_q = "select ID from classified_reports where ( refnumber = '$requestid' )";
	$q_result = @mysqli_query($section_q) or die (mysqli_error($db_connection));  // 
	//
	////	
	$row = @mysqli_fetch_array($q_result);
	$reportid = 0;
	if ( $row ) {
		$reportid = $row['ID'];
	}
	//
	////
	$reportText = ad_repsonse_time($reportid,$requestid);
	/**/
	
	echo "$reportText";
?>
