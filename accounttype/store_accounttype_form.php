<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<?php


global $db_connection;
include "../admin_heaer_lite.php";
require_once('../identity.php');
require_once('../userfeatures.php');



function account_type_req($uid) {
	$QQ = "SELECT ac.type_name, ac.id FROM authspecials au INNER JOIN accounttypes ac ON ( au.account_type_id = ac.id ) WHERE ( au.UID = $uid )";
	$obval = db_query_object($QQ);
	return(array($obval->type_name,$obval->id));
}


///==============================================================================================================


$SERVICE = $_POST['SERVICE'];
$servicedir = $_POST['servicedir'];
$serviceid = $_POST['serviceid'];
$hasQuestionaire = $_POST['hasQuestionaire'];
$uid = $_POST['fiz'];

if ( isset($_POST['account_type_id']) ) {
	$accounttype_ids = $_POST['account_type_id']; // Should be an array...
} else {
	list($acctypename,$accounttype_ids) = account_type_req($uid);
}

$workflowstep = $_POST['workflowstep'];

if ( !is_array($acctypes) ) {
	$acctypes = array($acctypes);
}

///==============================================================================================================


require_once('../process_account_type.php');



if ( isset($accounttype_ids) ) {
	$forms = fetch_request_form($uid,$serviceid,$accounttype_ids);
}


if ( isset($_POST['hasRealData']) ) {
	if ( $_POST['hasRealData'] == "yes" ) {
		store_useful_post_data($_POST,$serviceid,$uid,$accounttype_ids);
	}
}


$registered = false;
switch ( $workflowstep ) {
	case "approve": {
		add_to_approval_queue($serviceid,$uid,$accounttype_ids);
		break;
	}
	case "pay": {
		send_to_payment_queue($serviceid,$uid,$accounttype_ids);
		break;
	}
	case "registered": {
		$registered = true;
		if ( isset($_POST['querydata']) ) {
			$tablename = $_POST['tablename'];
			$field_list = $_POST['field_list'];

			$fieldarray = explode(",",$field_list);
			$vallist = "";
			$sep = "";
			foreach( $fieldarray as $field ) {
				$field = trim($field);
				$value = $_POST[$field];
				if ( str_word_count($value) > 0 ) $value = urlencode($value);
				$vallist .= $sep . "'$value'";
				$sep = ",";
			}

			$QQ = "insert into $tablename ($field_list) VALUE ($vallist)";
			db_query_exe($QQ);
			$vallist = "";
			$sep = "";
			foreach( $fieldarray as $field ) {
				$field = trim($field);
				$value = $_POST[$field];
				if ( str_word_count($value) > 0 ) $value = urlencode($value);
				$vallist .= $sep . "$field=$value";
				$sep = "&";
			}

			if ( isset($_POST['init_url']) ) {
				$url = $_POST['init_url'];
				file_get_contents("http://$webhost/" . $url . "?$vallist&fiz=$uid");
			}

		}
		break;
	}
}
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


///$form = 


?>
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
	<div>
		Registration process.
	</div>
<?php
if ( !$registered ) {

		/// Make a set of forms to fill out....
	$i = 0;
	foreach ( $forms as $authobj ) {
		$i++;
		$authobj->requirements = format_requirements_message($authobj);
	echo "<div class='requirementsStatment'>";
		echo $formobj->requirements;
	echo "</div>";
	
$div =<<<EODIV
	<div id="FORM_STEP_$i"  class="requirementsWorkflowStep" >
EODIV;
	
		if ( $formobj->needs_pay ) {
			echo '<form method="POST" action="../accounttype/store_accounttype_form.php" onsubmit="fetch_payment_message();" >';
			echo '<input type="hidden"  NAME="workflowstep" value="pay"  >';
			echo '<input type="submit"  NAME="continuer" value="next step: payment"  >';
		} else {
?>
<div >
You now may have access to your account. But, in order to access all the features of the account type that you have requested,
your account must be approved by our staff.
<br>
Once, your account is approved it will be registered.
</div>

<?php
		}

$div =<<<EODIV
		<input type="hidden"  NAME="SERVICE" value="$SERVICE"  > 
		<input type="hidden"  NAME="servicedir" value="$servicedir"  > 
		<input type="hidden"  NAME="serviceid" value="$serviceid"  > 
		<input type="hidden"  NAME="hasQuestionaire" value="$hasQuestionaire"  > 
		<input type="hidden"  NAME="fiz" value="$uid"  >
		</form></div>
EODIV;

		echo "$div\n\n";
		
	}

} else {

$UU = "UPDATE users SET registered = 1 WHERE ID = $uid";
db_query_exe($UU);

$UU = "UPDATE authspecials SET registered = 1 WHERE ( UID = $uid ) AND ( account_type_id = $accounttype_ids )";
db_query_exe($UU);


$div =<<<EODIV
	<div id="FORM_STEP_FINAL"  class="requirementsWorkflowStep" >
		You are now registered with the service, $SERVICE, for the account type: $acctypename
	</div>
EODIV;

		echo "$div\n\n";


}

?>
	<span style="font-size:10px">Copious Systems &copy; 2006-2008</span>

</body>
</html>
<script language="javascript" type="text/javascript" src="cvtinterfaceinit.js"></script>
