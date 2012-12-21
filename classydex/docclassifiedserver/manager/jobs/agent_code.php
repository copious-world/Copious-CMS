<?php


include '../../servicename.php';
try {
	include '../../../../database.php';
} catch (Exception $e) {
	echo 'Caught exception: ' .  $e->getMessage();
}
		global $db_connection;
	
///		agent_code.php
//
//		RESET THE TIME OF THE TRANSACTION VARIABLE nowtime
//		This results in a transaction time to be picked up by processad.php
//		
//
	require_once("logging.php"); // 
	require_once("payparameters.php"); // 

	$mymail = $service_business_identifier;
////

	$rightnow = datetime();

	$add_title = "";
	$brief_description = "";
	$offered_price = "";
	$email_address = "";
	$contact_number = "";
	$full_description = "";
	$shipping_origination = "";
	$validation_msg = "";
	$section_number = "";


	//	 transactionstored
	//
	//	Check to see if the transaction is stored in the table, 'classified_sales'.
	//
	function transactionstored($txn_id) {
		global $db_connection;
		// IS THERE A TRANSACTION??
		$u_name_q = "select count(*) from classified_sales where ( transid = '";
		$u_name_q .= trim($txn_id);
		$u_name_q .= "')";
		////
		//		
		$q_result = @mysqli_query($u_name_q) or die (mysqli_error($db_connection));  // 
		//
		$row = @mysqli_fetch_row($q_result);
		//
		$counter = $row[0];

		if ( $counter <= 0 ) return(true);
		return(false);
	}


	// NOTE that the ad has been paid for.
	//
	function store_transaction($txn_id,$uid,$posttime) {
		global $db_connection;
		//
		$u_name_q = "update classified_sales set transid = '$txn_id', paid = '1' where ( entrytime = '$posttime' ) AND ( MID = '$uid' )";
		////
		$q_result = @mysqli_query($u_name_q) or die (mysqli_error($db_connection));  // 
	}
	
	
	// From processed = 10 to processed = 0.
	//
	function release_transaction($agent_email,$posttime) {
		global $db_connection;
		global $rightnow;
		//
		$u_name_q = "update classified_request set processed = '0', nowtime = '$rightnow' where ( nowtime = '$posttime' ) AND (email_address = '$agent_email') AND ( processed = '10' )";
		////
		$q_result = @mysqli_query($u_name_q) or die (mysqli_error($db_connection));  // 
	}


	//
	function notify_agent($email_address) {
		//
		global $db_connection;
		global $sender_email; 
		global $sender_phone; 
		global $sender_message; 
		//
		//
		$email_txt = "Once again, you should receive $25.00 for posting an Ad when the next payment event occurs.";

		$subject = "Copious Clasified Pays You.";
		$headers = 'From: classifieds@copious-systems.com' . "\r\n" . 'Reply-To: classifiedagent@copious-systems.com' . "\r\n";

		copious_mail($email_address,$subject,$email_txt,$headers);	
		
		return("Subject: $subject <br>$email_txt");
	}
	

	////
	//	mass_pay this can be activated only when the PAYPAL API is in use.
	//	
	function mass_pay($txn_id,$agent_email,$item_number) {
		
	}


	///   UID -- get the user number if this is a real agent. 
	//		  --  a spoofed agent may come this way.	
	$pnumber = 0;

	function check_user($member_agent) {
		global $db_connection;
		global $pnumber;
		//
		$isok = true;
		
		$u_name_q = "select count(*) from users where ( email = '";
		$u_name_q .= trim($member_agent);
		$u_name_q .= "')";
		
		//
		//$q_result = @mysqli_query($u_name_q);  //  or die (mysqli_error($db_connection))
		$q_result = @mysqli_query($u_name_q) or die (mysqli_error($db_connection));  // 
		//
		$row = @mysqli_fetch_row($q_result);
		//
		$counter = $row[0];

		if ( $counter <= 0 ) $isok = false;
		else {
			////
			$u_name_q = "select ID from users where ( email = '";
			$u_name_q .= trim($member_agent);
			$u_name_q .= "')";
			////
			$q_result = @mysqli_query($u_name_q) or die (mysqli_error($db_connection));  // 
			////
			$row = @mysqli_fetch_row($q_result);
			$pnumber = $row[0];
		}
		
		return $isok;
	}

	
	function validate_agent($member_agent,$email_address) {
		global $db_connection;
		global $validation_msg;
		global $index_name;
		
		$result = 0;
		if ( strcmp($member_agent,$email_address) != 0 ) {
			if ( check_user($member_agent) ) {
				$validation_msg = "Thank you for choosing $index_name for placing an employment ad and for getting help from $member_agent";
				$result = 1;
			} else {
				$validation_msg = "Sorry, $member_agent is not a registered agent for $index_name";
			}
		} else {
			$validation_msg = "Thank you for choosing $index_name for placing an employment ad.";
		}
		
		return($result);
	}


// =======  TYPICAL PAYPAL RESPONSE CODE =========

// read post from PayPal system and add 'cmd'
// Get the list of keys from this array...
//
reset($_POST);
//
$req = 'cmd=_notify-validate';  // Start of the var settings.
//
foreach ($_POST as $key => $value) {
	//
	$req .= "&" . $key . "=" . urlencode($value);
	//
}

reset($_POST);


// post back to PayPal system to validate
//
$header .= "POST $post_URL HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen ($req) . "\r\n\r\n";
//

$fp = fsockopen ($processor_server, $port, $errno, $errstr, 30);

// assign posted variables to local variables
// note: additional IPN variables also available -- see IPN documentation
////
////
//
$item_name = $_POST['item_name'];		// classy_$section#
$item_number = $_POST['item_number'];	// the time stamp of the item...
$invoice = $_POST['invoice'];
$payment_status = $_POST['payment_status'];
$payment_gross = $_POST['payment_gross'];
$txn_id = $_POST['txn_id'];
/////
//
$receiver_email = $_POST['receiver_email'];			// The processing paypal account.
//
$payer_email = $_POST['payer_email'];  // This should be the poster. And, in the "agent_code.php" module is not the agent.
////
$agent_email = $_POST['custom'];		// The agent email.


if ( !$fp ) {
	// HTTP ERROR  --- DID NOT GET THE SOCKET
	echo "$errstr ($errno)";
} else {

////  Actually send the header back to paypal at this particular point
	fputs ($fp, $header . $req);
////

	// This is the response to the paypal post.

	while ( !feof($fp  )) {
		$res = fgets ($fp, 1024);
//

		if ( strcmp($res, "VERIFIED") == 0 ) {
		
			if ( strcmp($payment_status,"Completed") == 0 ) {
				////
				if ( strcmp($receiver_email,$mymail) == 0 ) {   // This has to be paying the classified service.
						//
						// Store this transaction as new if it is not already stored.
					if ( transactionstored($txn_id) ) {		//  This is a new transaction from the payment system.
							//// ----------------------------
						if ( check_user($agent_email) ) {	// $pnumber this is set if the agent is OK. 
							// process payment - this is new transaction information.
							//
							store_transaction($txn_id,$pnumber,$item_number);	// updates classified_sales
							release_transaction($agent_email,$item_number);		// change the state number, processed set to 0, $item_number is time.
							notify_agent($agent_email);							// Just a curtisy message.
							/////			mass_pay($txn_id,$agent_email,$item_number);			// for update.
						} else {
							logErr($agent_email . " Not a registered user... <br>" );
						}
					} else {
						logErr($txn_id . " Alread stored... <br>" );
					}

				} else{
					// log for manual investigation
					logErr( "ERROR>> " . $receiver_email . " != " . $mymail . "<br>" );

				}
			}

		} else if (strcmp ($res, "INVALID") == 0) {
			// log for manual investigation
			logErr( "INVALID>> " . $receiver_email . "<br>" );
		}
	}
	fclose ($fp);
}
?>
