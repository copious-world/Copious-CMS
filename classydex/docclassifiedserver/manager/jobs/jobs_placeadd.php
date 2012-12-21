<?php


include '../../servicename.php';
try {
	include '../../../../database.php';
} catch (Exception $e) {
	echo 'Caught exception: ' .  $e->getMessage();
}
	
	require_once("logging.php"); // 
	require_once("payparameters.php"); // 

	$paybutton_form = "";
////////////	
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
	function account_sale($uid,$agent_email,$poster_email,$nowtime) {
		global $db_connection;
		global $section_number;

		$create_sale_q = "insert into classified_sales ( ID, MID, entrytime, paid, section, transid, agent_email, poster_email )";
		$create_sale_q .= " values ";
		$create_sale_q .= "( 0, $uid, '$nowtime', 0 , '$section_number', 'none', '$agent_email', '$poster_email' )";
		
		$q_result = @mysqli_query($create_sale_q) or die (mysqli_error($db_connection));  // 
	}



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
		//a
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
		
		$result = false;
		if ( strcmp($member_agent,$email_address) != 0 ) {  // The agent and the poster cannot be the same.
			if ( check_user($member_agent) ) {				// The user needs to be registered within the system to be an agent.
				//
				$validation_msg = "Thank you for choosing $index_name for placing an employment ad and for getting help from $member_agent";
				$result = true;
				//
			} else {
				$validation_msg = "Sorry, $member_agent is not a registered agent for $index_name";
			}
		} else {
			$validation_msg = "Thank you for choosing $index_name for placing an employment ad.";
		}
		
		return($result);
	}

	function add_advert_request($section_number,$email_address,$agent_email_address) {
		global $db_connection;
		//	
		global $add_title;
		global $brief_description;
		global $offered_price;
		global $contact_number;
		global $full_description;
		global $shipping_origination;

		$add_title = fixtext($add_title);
		$brief_description = fixtext($brief_description);
		$offered_price = fixtext($offered_price);
		$contact_number = fixtext($contact_number);
		$full_description = urlencode($full_description);
		$shipping_origination = urlencode($shipping_origination);
		$nowtime = datetime();

		//
		$section_maker = "insert into classified_request ";
		$section_maker .= "(ID,processed,section_number,add_title,brief_description,offered_price,email_address,agent_email_address,contact_number,full_description,shipping_origination,nowtime)";
		$section_maker .= " VALUES (0,10,'";
		$section_maker .= $section_number . "','";
		$section_maker .= $add_title . "','";
		$section_maker .= $brief_description . "','";
		$section_maker .= $offered_price . "','";
		$section_maker .= $email_address . "','";		// Receives the user email for approval.
		$section_maker .= $agent_email_address . "','";		// If present, edits ad, and identified in notification.
		$section_maker .= $contact_number . "','";
		$section_maker .= $full_description . "','";
		$section_maker .= $shipping_origination . "','";
		$section_maker .= $nowtime . "')";

		$q_result = @mysqli_query($section_maker) or die (mysqli_error($db_connection));  // 
		
		return($nowtime);
	}
	
	function mail_employer($email,$agent_mail,$linkurl) {
		global $db_connection;
		global $paybutton_form;
		
		$email_txt =   "Thank you for placing an ad on ClassyDex and using the services of $agent_mail\n";
		$email_txt .=  "Your ad will appear after you pay.\n";
		$email_txt .=  "Please click the link to begin the payment process.\n\n";
		$email_txt .=  $linkurl;
		$email_txt .=  "\n\nAfter paying, the ad placement agent you hired will receive an e-mail notification for finalizing your ad placement.\n";
		$email_txt .=  "There will be a short delay (up to 30 minutes) while your payment is accepted and our servers cycle.\n";
		$email_txt .=  "(Please note, if you are paying by e-check, there may be a four day delay imposed by the payment service.)\n ";
		$email_txt .=  "Thank you.";

		$subject = "Copious Clasified has received your classified ad request.";
		$headers = 'From: classifieds@copious-systems.com' . "\r\n" . 'Reply-To: classifiedsales@copious-systems.com' . "\r\n";

		copious_mail($email,$subject,$email_txt,$headers);

	}
	
	
	//
	///   setup_sales_link
	//
	//		adfinalize.php --> this link is sent in email right now.

	function setup_sales_link($email_address,$member_agent,$nowtime) {
		global $db_connection;

		global $paybutton_form;
		global $webdirectory;
		
		$button_storage = urlencode($paybutton_form);

		$mailtime = urlencode($nowtime); // The datetime is being included in the sales link.
		//		LINK STORED IN EMAIL
		$linkurl = $webdirectory . "/adfinalize.php?w=$mailtime&email=$email_address&agent=$member_agent"; 
		
		// KEEP A RECORD OF THIS TRANSACTION...	
		$create_presale_q = "insert into classified_pre_sales ( ID, entrytime, agent_email, poster_email, button_form )";
		$create_presale_q .= " values ";
		$create_presale_q .= "( 0, '$nowtime', '$member_agent', '$email_address', '$button_storage' )";
		
		$q_result = @mysqli_query($create_presale_q) or die (mysqli_error($db_connection));  // 

		mail_employer($email_address,$member_agent,$linkurl);
		//
	}


		
	////////////////////////////////////////////////////////////
	
	$section_number = $_POST['section'];
	
	$add_title = $_POST['add_title'];
	$brief_description = $_POST['brief_description']; // Second line.
	$offered_price = $_POST['offered_price']; // End first line
	$email_address = $_POST['email_address']; // Poster Identification, the one paying for the ad.
	$contact_number = $_POST['contact_number'];
	$full_description = $_POST['full_description'];
	$shipping_origination = $_POST['shipping_origination'];
	$member_agent = $_POST['member_agent'];	// User Identification
	
	error_reporting(E_ALL);

	$addprice = $default_price;
	$rebate_section = 0;
	if ( strlen($member_agent) > 0 ) {
		if ( validate_agent($member_agent,$email_address) ) { // IS THIS A REAL AGENT?
			////
			//
			$nowtime = add_advert_request($section_number,$email_address,$member_agent);  // AGENT $member_agent is the manager of the ad.
			//
			$rebate_section = 1;
			$addprice = $agent_price;
			//
			// $pnumber is the User ID of the agent.
			// $email_address is the poster and the recipient of ad responses
			// Make a link back to the agent from the poster email address.
			// Use time, email and User ID to establish a key to the record.

			//
			account_sale($pnumber,$member_agent,$email_address,$nowtime);

//		<!-- ===========================  -->
//			START OF BUTTON CODE TO APPEAR IN ADFINALIZE.php adfinalize.php
//		<!-- ===========================  -->

			$paybutton_form .= "<form action='$payservice' method='post'>\n";
			$paybutton_form .= "<input type='hidden' name='cmd' value='_xclick'>\n";
			$paybutton_form .= "<input type='hidden' name='business' value='$service_business_identifier' >\n";
			$paybutton_form .= "<input type='hidden' name='item_name' value='classydex_$section_number' >\n";
			$paybutton_form .= "<input type='hidden' name='item_number' value='$nowtime' >\n";
			$paybutton_form .= "<input type='hidden' name='page_style' value='Primary'>\n";
			$paybutton_form .= "<input type='hidden' name='shipping' value='0'>\n";
			$paybutton_form .= "<input type='hidden' name='handling' value='0'>\n";
			$paybutton_form .= "<input type='hidden' name='no_shipping' value='1'>\n";
			$paybutton_form .= "<input type='hidden' name='no_note' value='1' >\n";
			$paybutton_form .= "<input type='hidden' name='amount' value='$addprice' >\n";
//		<!-- ===========================  -->
			$paybutton_form .= "<input type='hidden' name='return' value='$webdirectory/thanks.php'>\n";
			$paybutton_form .= "<input type='hidden' name='cancel_return' value='$webdirectory/cancel.html'>\n";
//		<!-- ===========================  -->
			$paybutton_form .= "<input type='hidden' name='notify_url' value='$webdirectory/agent_code.php'>\n";
			$paybutton_form .= "<input type='hidden' name='custom' value='$member_agent'>\n";
//		<!-- ===========================  -->		
			$paybutton_form .= "<input type='hidden' name='currency_code' value='USD'>\n";
			$paybutton_form .= "<input type='hidden' name='tax' value='0'>\n";
			$paybutton_form .= "<BR>\n";
			$paybutton_form .= "<span style='background-color:#fcf3b0;' >\n";
			$paybutton_form .= "		Amount:&nbsp; $40.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n";
			$paybutton_form .= "					<input type='image' src='$webdirectory/pay.png' border='0' name='submit' alt='Classified Ad Placement.'>\n";
			$paybutton_form .= "</span>\n";
			$paybutton_form .= "		</form>\n";	

//		<!-- ===========================  -->
//			END OF BUTTON CODE TO APPEAR IN ADFINALIZE.php adfinalize.php
//		<!-- ===========================  -->

			// The link with above button code is emailed to the poster prior to actual ad placement.
			// 
			setup_sales_link($email_address,$member_agent,$nowtime);
		}
	}

	if ( $rebate_section == 0 ) {
		// There is no rebate; so, charge the full price and 
		$nowtime = add_advert_request($section_number,$email_address,$email_address); // POSTER $email_address is the manager of the ad.
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<title>Employement Ad Payment Processing.</title>
	</head>
	<script language="JavaScript">
	////
	function check_required_fields() {
		if ( document.passwordentry.nu_username.value == "" ) {
			alert("Please enter a value for field, User Name.")
			return false
		}
		if ( document.passwordentry.nu_pass1.value == "" ) {
			alert("Both password fields require the same password.")
			return false
		}
		if ( document.passwordentry.nu_pass2.value == "" ) {
			alert("Both password fields require the same password.")
			return false
		}

		return true;
	}

	function check_same_passwords() {
		var p1 = document.passwordentry.nu_pass1.value;
		var p2 = document.passwordentry.nu_pass2.value;
		if ( p1 == p2 ) {
			return(true);
		} else {
			document.passwordentry.nu_pass1.value = "";
			document.passwordentry.nu_pass2.value = "";
			alert("Please be sure that the passwords fields are the same.");
			return false;
		}	
	}

	function submitScript()
	{
		var first_test = check_required_fields();
		
		if ( first_test ) {
			first_test = check_same_passwords();
		}
		
		return first_test
	}
	
	function getMemberAgent() {
		var obj = document.getElementById("agentMail");
		var txt = obj.value;
		if ( txt.length > 0 ) {
			agentSelectionResponse();
		} else {
			alert("Please enter an e-mail address for the agent.");
		}
	}
	
	function fetch_agent_setup() {
		var obj = document.getElementById("agent_form");
		if ( obj.style.visibility == "visible" ) {
			obj.style.visibility = "hidden";
		} else {
			obj.style.visibility = "visible";
		}
	}
	
	function agentSelectionResponse() {
	
		var obj = document.getElementById("agentMail");
		var txt = obj.value;

		var agentobj = document.getElementById("member_agent");
		agentobj.value = txt;
	
		obj = document.getElementById("agent_accessible");
		obj.style.visibility = "hidden";
		
	}
	
	///
	</script>
	<body>
	
	<?php echo $validation_msg; ?>
	<br>
	You're ad price for notice of employment is <b><?php echo $addprice; ?></b>
	
	<br>
<?php 

	if ( $rebate_section == 1 ) {
?>
<span style="color:navy;background-color:#E5E5FF;font-weight:bold;" >
<br>
Dear agent, an e-mail is being sent to the employer who will pay for your services.
<br>
</span>
Thank you.		

<?php 

	} else {
?>
	Please use the payment service provided by this button to pay for the ad.
	<br>
	After paying, you will receive an e-mail notification for finalizing your ad placement.
	<br>
	There will be a short delay (up to 30 minutes) while your payment is accepted and our servers cycle.
	<br>
	(Please note, if you are paying by e-check, there may be a four day delay imposed by the payment service.)
	<br> 
	Thank you.
<br>
		<form action="<?php echo $payservice; ?>" method="post" >
		<input type="hidden" name="cmd" value="_xclick">
		<input type="hidden" name="business" value="<?php echo $service_business_identifier; ?>" >
		<input type="hidden" name="item_name" value="classydex_<?php echo $section_number; ?>" >
		<input type="hidden" name="item_number" value="<?php echo $nowtime; ?>" >
		<input type="hidden" name="page_style" value="Primary">
		<input type="hidden" name="shipping" value="0">
		<input type="hidden" name="handling" value="0">
		<input type="hidden" name="no_shipping" value="1">
		<input type="hidden" name="no_note" value="1">
		<input type="hidden" name="amount" value="<?php echo $addprice; ?>">
<!-- ===========================  -->
		<input type="hidden" name="notify_url" value="<?php echo $webdirectory; ?>/no_agent_code.php">
		<input type="hidden" name="email" value="<?php echo $email_address; ?>">
		<input type="hidden" name="custom" value="<?php echo $email_address; ?>">
<!-- ===========================  -->
		<input type="hidden" name="return" value="<?php echo $webdirectory; ?>/thanks.php">
		<input type="hidden" name="cancel_return" value="<?php echo $webdirectory; ?>/cancel.html">
<!-- ===========================  -->
		<input type="hidden" name="currency_code" value="USD">
		<input type="hidden" name="tax" value="0">
<BR>
<span style="background-color:#fcf3b0;" >
		Amount:&nbsp; $50.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="image" src="<?php echo $webdirectory; ?>/pay.png" border="0" name="submit" alt="Classified Ad Placement.">
</span>
		</form>	
	<?php
	}

?>
	</body>
</html>

