<?php


include '../../servicename.php';
try {
	include '../../../../database.php';
} catch (Exception $e) {
	echo 'Caught exception: ' .  $e->getMessage();
}

	global $db_connection;
	
	//
	//	adfinalize.php
	//
	//	This is sent in email from jobs_placeadd.php
	//	The button that this prints on the user browser is made in jobs_placeadd.php
	//		BUT, the the button sets up a PAY that uses IPN, instant payment notification,
	//		where IPN calls agent_code.php
	//
	
	require_once("logging.php"); // 
	require_once("payparameters.php"); // 


	/// This is the only DATABASE action in this module.
	// GET the button form text from the pre_sales table.
	//

	$paybutton_form = "";

	function get_sales_link($email_address,$member_agent,$nowtime) {
		global $db_connection;
		global $paybutton_form;
		
		
		$fetch_presale_q = "select button_form FROM classified_pre_sales ";
		$fetch_presale_q .= "where ( entrytime = '$nowtime' ) AND ( poster_email = '$email_address' ) AND ( agent_email = '$member_agent' ) ";
		
		$q_result = @mysqli_query($fetch_presale_q) or die (mysqli_error($db_connection));  // 
		$row = @mysqli_fetch_row($q_result);
		//
		$paybutton_form = $row[0];
		//
		
		return(urldecode($paybutton_form));
	}
	
	//////////////////
	//
	$nowtime = $_GET['w'];
	$poster_email = $_GET['email'];
	$agent_email = $_GET['agent'];
	
	
	$nowtime = urldecode($nowtime);
	
	/*
	*/
	$display_form = $nowtime . "<br>";
	$display_form .= $poster_email . "<br>";
	$display_form .= $agent_email . "<br><br>";

	$display_form .=  get_sales_link($poster_email,$agent_email,$nowtime);
	

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
	<br> 
<br>

<?php
	echo $display_form;
?>

	</body>
</html>
