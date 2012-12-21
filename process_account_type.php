<?php

///
/// ////

global $payment_button;
$payment_button = "";

/// needs_form ... needed for the gathering of account type specific information...
/// needs_approval ... In the approval queue for this type of account... Requires an administrator or group manager to allow the account..
/// needs_pay ... This type of account has a fee associated with it.

/// If none of these are true then, this is just a registration...
/// Adding a user feature is the same as adding an authspecial record.

/// Each record is specific to a UID, since this reflects the state of account type processing for each user.
/// Prototypical accounts may be determined by UID = 0

/// deal_accounts - A list of pairs. Accounts that may be added with price deals for having this account type.


function format_attainments_message($authobj,$srcobj) {
	$requires = "The following steps have been accomplished:";

	if ( !($authobj->needs_form) ) {
		$requires .= "<div class='reqTitle'>";
		$requires .= "Your information has been received";
		$requires .= "</div>";
	}

	if ( !($authobj->needs_approval) && ( $srcobj->needs_approval ) ) {
		$requires .= "<div class='reqTitle'>";
		$requires .= "Approval received for this account type";
		$requires .= "</div>";
	}

	if ( !($authobj->needs_pay) && ( $srcobj->needs_pay ) ) {
		$requires .= "<div class='reqTitle'>";
		$requires .= "Your payment has been received.";
		$requires .= "</div>";
	} 

	return($requires);
}



function format_requirements_message($authobj,$srcobj) {
	$requires = "This type of account requires the following:";
	
	if ( $authobj->needs_form && $srcobj->needs_form ) {
		$requires .= "<div class='reqTitle'>";
		$requires .= "More information";
		$requires .= "</div>";
	}
	
	if ( $authobj->needs_approval && $srcobj->needs_approval ) {
		$requires .= "<div class='reqTitle'>";
		$requires .= "Approval by the administrator for this account type";
		$requires .= "</div>";
	}
	
	if ( $authobj->needs_pay && $srcobj->needs_pay ) {
		$requires .= "<div class='reqTitle'>";
		$requires .= "Is accessible after a you pay a fee.";
		$requires .= "</div>";
	} 
	
	return($requires);
}


function fetch_authorization_state_forms($authobj) {
	if ( $authobj->needs_form ) {
		emit_requirements_form($objlist);
	} else if ( $authobj->needs_approval ) {
		format_state_message(t("Your request is being forwarded to an approval queue for examination by an administrator for this account type."));
		to_approval_queue($objlist);
	} else if ( $authobj->needs_pay ) {
		$price = $authobj->price;
		format_state_message(t("This account type requires a fee of $price."));
		emit_payment_form($authobj);
	}
}


///ID, UID, serviceid, account_type_id, needs_form, needs_approval, needs_pay, form, approval, price, registered, deal_accounts
function fetch_service_form($serviceid) {  /// The form data needed to select an account type for this service
	///
	$qq = "select * from serivcesource where ( id = $serviceid )"; // Get the prototype..
	$authobj = db_query_object($qq);
	$authobj->requirements = format_requirements_message($authobj);
	///
	return($authobj);
}


function add_form_for_user($uid,$serviceid,$actype) {
	///
	$qq = "select au.*, ac.* from authspecials au INNER JOIN accounttypes ac on ( au.account_type_id = ac.id ) where ( au.UID = 0 ) AND (ac.type_name = '$actype') AND ( au.serviceid = $serviceid ) AND ( ac.serviceid = $serviceid )"; // Get the prototype..
	$authobj = db_query_object($qq);

	$ID = $authobj->ID;
	// uid
	$serviceid = $authobj->serviceid;
	$account_type_id = $authobj->account_type_id;
	$needs_form = $authobj->needs_form;
	$needs_approval = $authobj->needs_approval;
	$needs_pay = $authobj->needs_pay;
	$form = $authobj->form;
	$approval = $authobj->approval;
	$price = $authobj->price;
	$registered = $authobj->registered;
	$deal_accounts = $authobj->deal_accounts;

	/// Make a special copy for the user...
	$ii = "insert into authspecials (ID, UID, serviceid, account_type_id, needs_form, needs_approval, needs_pay, form, price, registered, deal_accounts) VALUES";
	$ii .= " ($ID, $uid, $serviceid, $account_type_id, $needs_form, $needs_approval, $needs_pay, '$form', '$price', $registered, '$deal_accounts')";
	db_query_exe($ii);
}


function fetch_user_auth_state($uid, $servicename) {
	global $payment_button;
	global $SERVICE;
	global $servicedir;
	global $serviceid;


	$qq = "select id from serivcesource where servicename = '$servicename'";
	$serviceid = db_query_value($qq);

	$qq = "select count(*) from authspecials where ( uid = $uid ) AND ( serviceid = $serviceid ) AND ( registered =  0 )";

	$n = db_query_value($qq);


	$output = "";
	/// ----------------------------------
	if ( $n > 0 ) {
		$qq = "select * from authspecials where ( uid = $uid ) AND ( serviceid = $serviceid ) AND ( registered =  0 )";
		$authobj = db_query_object($qq);

		$qq = "select * from authspecials where ( id = $authobj->ID ) AND ( UID = 0 )";
		$srcobj = db_query_object($qq);

		$strattain = format_attainments_message($authobj,$srcobj);
		$str = format_requirements_message($authobj,$srcobj);

$output .=<<<EODIV
	<div class='requirementsStatment'>
			$strattain
	</div>
	<div class='requirementsStatment'>
			$str
	</div>
	<div id="FORM_STEP_$i"  class="requirementsWorkflowStep" >
EODIV;
	
		if ( $formobj->needs_pay ) {
			$output .= '<form method="POST" action="accounttype/store_accounttype_form.php" onsubmit="fetch_payment_message();"  target="payer">';
			$output .= '<input type="hidden"  NAME="workflowstep" value="pay"  >';
			$output .= '<input type="submit"  NAME="continuer" value="next step: payment"  >';
			$output .= $payment_button;
		} else {
			/// Authorization given...
			$output .= '<form method="POST" action="accounttype/store_accounttype_form.php" onsubmit="fetch_done_message();"  target="registered">';
			$output .= '<input type="hidden"  NAME="workflowstep" value="registered"  >';
			$output .= '<input type="submit"  NAME="continuer" value="next step: registered"  >';
		}

$output .=<<<EODIV
		<input type="hidden"  NAME="SERVICE" value="$SERVICE"  > 
		<input type="hidden"  NAME="servicedir" value="$servicedir"  > 
		<input type="hidden"  NAME="serviceid" value="$serviceid"  > 
		<input type="hidden"  NAME="fiz" value="$uid"  >
		</form></div>
EODIV;

		$output .= "\n\n";
	}

	return($output);
}

function fetch_request_form($uid,$serviceid,$actypes) {
	$qq = "select * from authspecials where (UID = '$uid') AND (serviceid = '$serviceid') AND (account_type_id in ($actypes)) "; // Get the prototype..
	$authobj_l = db_query_object_list($qq);
	return($authobj_l);
}

function map_acc_to_id($acctypes) {
	$typenames = implode("','",$acctypes);
	$qq = "select id from accounttypes where type_name in ('$typenames')";
	$tl = db_query_list($qq);
	$str = implode(",",$tl);
	return($str);
}

function add_to_approval_queue($serviceid,$uid,$accounttype_ids) {
	$now = datetime();

	$values = "";
	$sep = "";
	$accounttype_ids_array = explode(",",$accounttype_ids);

	foreach ( $accounttype_ids_array as $acid ) {
		$values .= $sep . "(0, $uid, $serviceid, $acid, '$now')";
		$sep = ",";
	}

	$ii = "insert into approval_queue (ID, UID, serviceid, account_type_id, whenadded) VALUES " . $values;

	db_query_exe($ii);
}


function send_to_payment_queue($serviceid,$uid,$accounttype_ids) {
	$now = datetime();

	$payQ = "select price,id from authspecials where ( serviceid = $serviceid ) AND ( UID = $uid ) AND account_type_id in ( $accounttype_ids )";
	$prices = db_query_object_list($payQ);

	$values = "";
	$sep = "";
	foreach ( $prices as $priceobj ) {
		$acid = $priceobj->id;
		$price = $priceobj->price;
		$values .= $sep . "(0, $uid, $serviceid, $acid, '$price', '$now')";
		$sep = ",";
	}

	$ii = "insert into payment_queue (ID, UID, serviceid, account_type_id, price, whenadded) VALUES " . $values;
	db_query_exe($ii);
}


function store_useful_post_data($post_array,$serviceid,$uid,$accounttype_ids) {
	///
	unset($post_array['SERVICE']);
	unset($post_array['servicedir']);
	unset($post_array['serviceid']);
	unset($post_array['hasQuestionaire']);
	unset($post_array['fiz']);
	unset($post_array['accounttypes']);
	unset($post_array['workflowstep']);

	$text = "";
	foreach ( $post_array  as $key => $value ) {
		$text .= "&$key=" . urlencode($value);
	}

	$uu = "update authspecials set POSTDATA = '$text' where ( serviceid = $serviceid ) AND ( UID = $uid ) AND account_type_id in ( $accounttype_ids )";
///ID, UID, serviceid, account_type_id, needs_form, needs_approval, needs_pay, form, approval, price, registered, deal_accounts

	db_query_exe($uu);
}




function enocode_as_js($accobject) {
	$ts = (array)($accobject);

	$output = "{";
	$sep = "";
	foreach ( $ts as $key => $value ) {
		$output .= $sep . "$key: '$value'";
		$sep = ",";
	}
	$output = "}";
	return($output);
}


function fetch_account_type_data($serviceid) {
	$QQ = "SELECT ac.*, aut.* FROM accounttypes ac INNER JOIN authspecials aut ON ( ac.serviceid = aut.serviceid ) where ( aut.uid = 0 ) AND ( ac.serviceid = '$serviceid')";
	$aclist = db_query_object_list($QQ);

	$output = "<div class='account_type_report' style='width:95%;max-height:400px;'>\n";
	$output .= "\t<div class='account_type_report_elem' style='width:95%' >";
	///
	$output .= "\t<span id='acc_name_$id' class='account_type_report_elem_id' >type_name</span>";
	$output .= "\t<span id='acc_name_$id' class='account_type_report_elem_req' >needs_for</span>";
	$output .= "\t<span id='acc_name_$id' class='account_type_report_elem_req' >needs_approval</span>";
	$output .= "\t<span id='acc_name_$id' class='account_type_report_elem_req' >needs_pay</span>";
	$output .= "\t<span id='acc_name_$id' class='account_type_report_elem_description' >description</span>";

	foreach ( $aclist as $accobject ) {

		$detaillist = enocode_as_js($accobject);
		$jsdetails = "new account_type_details($detaillist)";

		$output .= "<div class='account_type_report_elem' style='width:95%' onclick=\"edit_acc_type_details($jsdetails)\">";
		///
		$output .= "<span id='acc_name_$id' class='account_type_report_elem_id' >";
		$output .= $aclist->type_name;
		$output .= "</span>";

		$output .= "<span id='acc_name_$id' class='account_type_report_elem_req' >";
		$output .= ( $aclist->needs_form == 1 ) ? "X" : "_";
		$output .= "</span>";
		$output .= "<span id='acc_name_$id' class='account_type_report_elem_req' >";
		$output .= ( $aclist->needs_approval == 1 ) ? "X" : "_";
		$output .= "</span>";
		$output .= "<span id='acc_name_$id' class='account_type_report_elem_req' >";
		$output .= ( $aclist->needs_pay == 1 ) ? "X" : "_";
		$output .= "</span>";

		$output .= "<span id='acc_name_$id' class='account_type_report_elem_description' >";
		$output .= $aclist->description;
		$output .= "</span>";
		///
		$output .= "</div>\n";
	}
	$output .= "</div>\n";
	return($output);
}


function store_account_type_data($serviceid,$js_accountdata) {
	$accountdata = json_decode($js_accountdata);
	$n = count($accountdata);
	for ( $i = 0; $i < $n; $i++ ) {
		$account_object = $accountdata[$i];
		$UU = "UPDATE authspecials set ";
		$sep = "";
		foreach( $account_object as $key => $data ) {
			if ( $key != 'id' ) {
				$UU .= $sep . " $key = '$data'";
				$sep = ",";
			}
		}
		$id = $account_object['id'];
		$UU .= "where id = '$id'";
		db_query_exe($UU);
	}
}
/*
*/

?>
