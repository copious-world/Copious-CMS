<?php


include '../../servicename.php';
try {
	include '../../../../database.php';
} catch (Exception $e) {
	echo 'Caught exception: ' .  $e->getMessage();
}
	
	$index_name = "Copious Classifieds";
	$mymail = "rleddy@svn.net";
	
	$add_title = "";
	$brief_description = "";
	$offered_price = "";
	$email_address = "";
	$contact_number = "";
	$full_description = "";
	$shipping_origination = "";
	$validation_msg = "";
	$section_number = "";
	
	////
	////
	function partition_transaction() {
		global $db_connection;
		
		$u_name_q = "update classified_sales set paid = '5' where ( paid = '1' )";
		
		$q_result = @mysqli_query($u_name_q) or die (mysqli_error($db_connection));  // 

	}


	////
	function user_email($uid) {
		global $db_connection;
		////
		$u_name_q = "select email from users where ( ID = '$uid' )";
		$q_result = @mysqli_query($u_name_q) or die (mysqli_error($db_connection));  // 
		////
		$row = @mysqli_fetch_row($q_result);
		$email = $row[0];
		
		return $email;
	}


	//
	function notify_agent($email_address) {
		global $db_connection;
		//
		//
		//
		$email_txt = "Your payments are now being processed for delivery as soon as an operator can complete the transaction.";

		$subject = "Copious Clasified Pays You.";
		$headers = 'From: classifieds@copious-systems.com' . "\r\n" . 'Reply-To: classifiedagent@copious-systems.com' . "\r\n";

		mail($email_address,$subject,$email_txt,$headers);	
	}
	


	function notify_business($paylist) {
		global $db_connection;
		//
		$email_address = "classifieds@copious-systems.com";
		//
		//
		$email_txt = "Payments.\n";
		$email_txt .= $paylist;

		$subject = "Paylist";
		$headers = 'From: classifieds@copious-systems.com' . "\r\n" . 'Reply-To: classifiedagent@copious-systems.com' . "\r\n";

		mail($email_address,$subject,$email_txt,$headers);	
	}


	function gather_payments() {
		global $db_connection;
	
		// Make sure that there are any payments to process.
		
		$u_name_q = "select count(*) from classified_sales where ( paid = '5' )";
		$q_result = @mysqli_query($u_name_q) or die (mysqli_error($db_connection));  // 
		//
		$row = @mysqli_fetch_row($q_result);
		//
		$counter = $row[0];

		if ( $counter > 0 ) {
			$u_name_q = "select MID, entrytime, agent_email, poster_email from classified_sales where ( paid = '5' )";
			$q_result = @mysqli_query($u_name_q) or die (mysqli_error($db_connection));  // 
			////
			
			$paytxt = "";

			////
			while ( $row = @mysqli_fetch_row($q_result) ) {
				// MID, entrytime, agent_email, poster_email
				
				$MID = $row[0];
				$entrytime = $row[1];
				$agent_email = $row[2];
				$poster_email = $row[3];

				notify_agent($agent_email);
				
				$paytxt .= $agent_email; $paytxt .= "\t";
				$paytxt .= "25.00\t";
				$paytxt .= "USD\t";
				$paytxt .= "$MID\t";
				$paytxt .= "$entrytime for $poster_email\n";
				
				
			}
			////
			
			
		}
		
		return($paytxt);
	}


	// ==================================   THREE STEP PROCESS =====================

	partition_transaction();		// Separate the paid transactions from the rest of the transactions.
	$paylist = gather_payments();	// Create the tab delimited data.
	////
	notify_business($paylist);		

?>
