<?php



require_once "../admin_header_lite.php";
require_once('../identity.php');
require_once('../userfeatures.php');

global $db_connection;


///==============================================================================================================


$SERVICE = $_POST['SERVICE'];
$servicedir = $_POST['servicedir'];
$serviceid = $_POST['serviceid'];
$hasQuestionaire = $_POST['hasQuestionaire'];
$uid = $_POST['fiz'];

$acctypes = $_POST['accounttype']; // Should be an array...
if ( !is_array($acctypes) ) {
	$acctypes = array($acctypes);
}



require_once("../process_account_type.php");


foreach ( $acctypes as $acctype ) {
	add_form_for_user($uid,$serviceid,$acctype);
}

$accounttype_ids = map_acc_to_id($acctypes);

$forms = fetch_request_form($uid,$serviceid,$accounttype_ids);
/*
*/

///
/// ////

/// needs_form ... needed for the gathering of account type specific information...
/// needs_approval ... In the approval queue for this type of account... Requires an administrator or group manager to allow the account..
/// needs_pay ... This type of account has a fee associated with it.

/// If none of these are true then, this is just a registration...
/// Adding a user feature is the same as adding an authspecial record.

/// Each record is specific to a UID, since this reflects the state of account type processing for each user.
/// Prototypical accounts may be determined by UID = 0

/// deal_accounts - A list of pairs. Accounts that may be added with price deals for having this account type.


/*

///==============================================================================================================
/*
*/



/// REPLACE 1

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo $SERVICE; ?> New User</title>
</head>
<style type="text/css" media="screen"><!--

		#SymbolNameEntry {
			visibility: visible;
		}

		#IdNameEntry {
			visibility: hidden;
			position: absolute;
			top: 0px;
			left: 0px;
		}
		
		#AddressEntry {
			visibility: hidden;
			position: absolute;
			top: 0px;
			left: 0px;
		}

		#PhoneEntry {
			visibility: hidden;
			position: absolute;
			top: 0px;
			left: 0px;
		}
		
		
		#EmailEntry {
			visibility: hidden;
			position: absolute;
			top: 0px;
			left: 0px;
		}
		
		#Completion {
			visibility: hidden;
			position: absolute;
			top: 0px;
			left: 0px;
		}
		
		#tester {
			visibility: hidden;
		}


		.formEntry {
			border: 1px gray solid;
			width:500px;
			text-align:justify;
			padding:10px;
			background-color:#FEFEF5;
		}
		

 --></style>

<script language="javascript" type="text/javascript" src="/hosted/js/browserid.js"></script>
<script language="JavaScript" type="text/javascript" src="/hosted/js/dimensions.js"> </script>
<script language="JavaScript" type="text/javascript" src="/hosted/js/docjaxresponse.js"> </script>
<script language="JavaScript" type="text/javascript" src="/hosted/js/docjax.js"></script>
<script language="javascript" type="text/javascript" src="/hosted/js/jsresources.js"></script>
<script language="javascript" type="text/javascript" src="/hosted/copiousauth/secsource.js"></script>
<!--  ========================================== --->
<!-- Multilingual Keyboard -->
<script language="javascript" type="text/javascript" src="/hosted/js/cvt/util.js"></script>
<script language="javascript" type="text/javascript" src="/hosted/js/cvt/kbvariants.js"></script>
<!-- Multilingual Keyboard -->
<script language="javascript" type="text/javascript" src="/hosted/js/cvt/cvt.js"></script>
<script language="javascript" type="text/javascript" src="/hosted/js/cvt/cvtnonus.js"></script>
<script language="javascript" type="text/javascript" src="/hosted/js/cvt/cvtnon_e.js"></script>
<script language="javascript" type="text/javascript" src="/hosted/js/cvtinterface.js"></script>
<!--  ========================================== --->
<script language="javascript" type="text/javascript" >
var g_squeeze = 0;
if ( g_screenHeight >= 900 ) {
	g_squeeze = 0;
} else if ( g_screenHeight > 600 ) {
	g_squeeze = 1;
} else {
	g_squeeze = 2;
}


var basiclocus = self.location;

basiclocus = new String(basiclocus.toString());

if ( basiclocus.substring(0,5) == "https" ) {
	securelocus = basiclocus;
	basiclocus = "http" + basiclocus.slice(5);
} else {
	securelocus = "https" + basiclocus.slice(4);
}

var homevars = { secure: securelocus, basic: basiclocus };
		
		
if ( g_squeeze == 0 ) {
	document.writeln('<LINK REL="stylesheet" TYPE="text/css" HREF="/hosted/css/stylesheet.css" TITLE="Style">');
} else if ( g_squeeze == 1 ) {
	document.writeln('<LINK REL="stylesheet" TYPE="text/css" HREF="/hosted/css/stylesheet700.css" TITLE="Style">');
} else {
	document.writeln('<LINK REL="stylesheet" TYPE="text/css" HREF="/hosted/css/stylesheet600.css" TITLE="Style">');
}
</script>
<!--  ========================================== --->
<body>


<?php

		/// Make a set of forms to fill out....
$i = 0;

foreach ( $forms as $authobj ) {

	$report = format_requirements_message($authobj);
echo "<div clas='requirementsStatment'>";
	echo $report;
echo "</div>";

$div =<<<EODIV
<div id="FORM_STEP_$i" >
EODIV;

	if ( $authobj->needs_approval ) {
		echo '<form method="POST" action="../accounttype/store_accounttype_form.php" onsubmit="fetch_approval_message();" target="approval">';
		echo '<input type="hidden"  NAME="workflowstep" value="approve"  >';
	} else if ( $authobj->needs_pay ) {
		echo '<form method="POST" action="../accounttype/store_accounttype_form.php" onsubmit="fetch_payment_message();" target="payer">';
		echo '<input type="hidden"  NAME="workflowstep" value="pay"  >';
		echo $payment_button;
	} else {
		echo '<form method="POST" action="../accounttype/store_accounttype_form.php" onsubmit="fetch_done_message();" target="registered">';
		echo '<input type="hidden"  NAME="workflowstep" value="registered"  >';
	}

	echo $div;
	$i++;
	if ( strlen( $authobj->form ) ) {
		echo $authobj->form;
	} else {
		echo "<br>No new information required.<br>";
	}

$div =<<<EODIV
	<input type="submit"  NAME="sumbitaccounttype" value="save accounttype information"  > 
	<input type="hidden"  NAME="account_type_id" value="$accounttype_ids"  > 
	<input type="hidden"  NAME="hasRealData" value="yes"  > 
	<input type="hidden"  NAME="SERVICE" value="$SERVICE"  > 
	<input type="hidden"  NAME="servicedir" value="$servicedir"  > 
	<input type="hidden"  NAME="serviceid" value="$serviceid"  > 
	<input type="hidden"  NAME="hasQuestionaire" value="$hasQuestionaire"  > 
	<input type="hidden"  NAME="fiz" value="$uid"  >
	</form></div>
EODIV;

echo "$div\n\n";
}

?>

	<span style="font-size:10px">Copious Systems &copy; 2006-2008</span>

</body>
</html>
<script language="javascript" type="text/javascript" src="cvtinterfaceinit.js"></script>
<script language="JavaScript">
	////
	function check_required_fields() {
		//////
		if ( document.userdata.nu_firstname.value == "" ) {
			alert("Please enter a value for field, First Name.")
			return false
		}
		if ( document.userdata.nu_lastname.value == "" ) {
			alert("Please enter a value for field, Last Name.")
			return false
		}
		if ( document.userdata.nu_country.value == "" ) {
			alert("Please enter a value for field, Country Name.")
			return false
		}
		if ( document.userdata.nu_email.value == "" ) {
			alert("Please enter a value for field, E-mail.")
			return false
		}
		return true;
	}

	function submitScript() {
		var first_test = check_required_fields();
		first_test = first_test;
		return first_test
	}
	///
</script>
