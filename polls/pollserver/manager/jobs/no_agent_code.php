<?php


include '../../servicename.php';
try {
	include '../../../../database.php';
} catch (Exception $e) {
	echo 'Caught exception: ' .  $e->getMessage();
}

	require_once("logging.php"); // 
	require_once("payparameters.php"); //

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
	function noregister_transactionstored($txn_id) {
		global $db_connection;
		// IS THERE A TRANSACTION??
		$u_name_q = "select count(*) from classified_pay where ( transid = '";
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

	function noregister_store_transaction($txn_id,$posttime) {
		global $db_connection;
		//
		$u_name_q = "insert into classified_pay (ID,transid,entrytime) VALUES (0,'$txn_id','$posttime')";
		////
		$q_result = @mysqli_query($u_name_q) or die (mysqli_error($db_connection));  // 
	}
	
	function release_transaction($poster_email,$posttime) {
		global $db_connection;
		global $rightnow;
		//		
		$u_name_q = "update classified_request set processed = '0', nowtime = '$rightnow' where ( nowtime = '$posttime' ) AND (email_address = '$poster_email') AND ( processed = '10' )";
		////
		$q_result = @mysqli_query($u_name_q) or die (mysqli_error($db_connection));  // 
	}
	
	///   UID -- get the user number if this is a real agent. 
	//		  --  a spoofed agent may come this way.	
	$pnumber = 0;

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
	// HTTP ERROR
	echo "$errstr ($errno)";
} else {

	fputs ($fp, $header . $req);

	while (!feof($fp)) {
		//
		$res = fgets ($fp, 1024);
		//
		//
		if ( strcmp($res, "VERIFIED") == 0 ) {
			//
			if ( strcmp($payment_status,"Completed") == 0 ) {		
				//
				// Store this transaction as new if it is not already stored.
				if ( noregister_transactionstored($txn_id) ) {		//  This is a new transaction from the payment system.
					///
					noregister_store_transaction($txn_id,$item_number);	// classified_pay gets a new record, not to due with classified_sales
					//
					release_transaction($txn_id,$payer_email);			// same release transaction as agent_code.
					//
				} else {
					logErr($txn_id . " is a transaction that is already registered" );
				}
			}

		} else if (strcmp ($res, "INVALID") == 0) {
			logErr("INVALID " . $txn_id . " is an INVALID transaction" );
		}
	}
	fclose ($fp);
}
?>
