<?php

include '../servicename.php';

try {
	include '../database.php';
} catch (Exception $e) {
	echo 'Caught exception: ' .  $e->getMessage();
	exit();
}
/*
*/
global $db_connection;

$QQ = "SELECT count(*) from users where username = 'copious'";
$n = db_query_value($QQ);
if ( $n <= 0 ) {
	$fields = "ID,username,firstname,lastname,postal,city,state,country,";
	$fields .= "zcode,phone_country,phone_area,phone_primary,phone_secondary,";
	$fields .= "phonekey,created,signature,language,trip,wants_notify,registered,email,original_source,source_special,";
	$fields .= "phone_type2,picture";

	$now = datetime();
	$rest = "'01','707','827','3516','70782735167','$now','XXXXXX','english','0','1','2','info@copious-systems.com','copious','Q','skype','none'";

	$II = "INSERT into users ($fields) VALUE (0,'copious','copious','systems','52 Front St.','Camp Meeker','Ca','USA','95419',$rest)"; // Create the COPIOUS user...
	db_query_exe($II);
}
$QQ = "SELECT id from users where username = 'copious'";
$copious_uid = db_query_value($QQ);


///
$QQ = "SELECT count(*) from serivcesource where servicename = 'copious'";
$n = db_query_value($QQ);
if ( $n <= 0 ) {
	$II = "INSERT into serivcesource (ID,hasQuestionaire,sevicename,serviceurl,published_accounts) VALUES (0,0,'copious','www.copious-systems.com','business')";
	db_query_exe($II);
}
$QQ = "SELECT id from serivcesource where servicename = 'copious'";
$copious_sid = db_query_value($QQ);


///
$QQ = "SELECT count(*) from accounttypes where serviceid = '$copious_sid'";
$n = db_query_value($QQ);
if ( $n <= 0 ) {
	/// THERE SHOULD BE AT LEAST TWO for this...
	$II = "INSERT into accounttypes (ID,type_name,roles,serviceid,description) VALUES (0,'BUSINESS','admin,owner','$copious_sid','The basic business signup account type.')";
	db_query_exe($II);
	$II = "INSERT into accounttypes (ID,type_name,roles,serviceid,description) VALUES (0,'SUPER','admin','$copious_sid','Super User for business COPIOUS.')";
	db_query_exe($II);
} else if ( $n < 2 ) { // Find out which one to create.
	$QQ = "SELECT count(*) from accounttypes where ( serviceid = '$copious_sid' ) AND ( type_name = 'BUSINESS') ";
	$n = db_query_value($QQ);
	if ( $n <= 0 ) {
		$II = "INSERT into accounttypes (ID,type_name,roles,serviceid,description) VALUES (0,'BUSINESS','admin,owner','$copious_sid','The basic business signup account type.')";
		db_query_exe($II);
	} else {
		$QQ = "SELECT count(*) from accounttypes where ( serviceid = '$copious_sid' ) AND ( type_name = 'SUPER') ";
		$n = db_query_value($QQ);
		if ( $n <= 0 ) {
			$II = "INSERT into accounttypes (ID,type_name,roles,serviceid,description) VALUES (0,'SUPER','admin','$copious_sid','Super User for business COPIOUS.')";
			db_query_exe($II);
		}
	}
}

// There needs to be a SUPER for each Business ADMIN....
// SO Find business without SUPER account types, determined by serviceid in account types...
$QQ = "SELECT id,servicename from serivcesource where ( servicename <> 'copious' )";
$idlist = db_query_object_list($QQ);

$QQ = "SELECT serviceid from accounttypes where ( type_name = 'SUPER')";
$superlist = db_query_list($QQ);
$II = "INSERT into accounttypes (ID,type_name,roles,serviceid,description) VALUES ";
$sep = "";
$n = 0;
foreach ( $idlist as $service ) {
	$id = $service->id;
	$name = $service->servicename;
	if ( !(in_array($id,$superlist)) ) {
		$II .= $sep . "(0,'SUPER','admin','$id','Super User for business $name.')";
		$sep = ",";
		$n++;
	}
}
if ( $n > 0 ) db_query_exe($II);


// Now make user that all SUPERS and the one BUSINESS account types have basic zero id user authspecials for their signup defaults.
// These are also needed in processing some subsystems.
///
$QQ = "SELECT id,serviceid from accounttypes where ( type_name = 'SUPER' ) OR ( type_name = 'BUSINESS' ) ";
$actlist = db_query_object_list($QQ);
foreach ( $actlist as $acc ) {
	$serviceid = $acc->serviceid;
	$actid = $acc->id;
	$QQ = "SELECT count(*) from authspecials where ( serviceid = '$serviceid' ) AND ( account_type_id = '$actid' )";
	$n = db_query_value($QQ);
	if ( $n <= 0 ) {
		$II = "INSERT into authspecials (ID,uid,serviceid,account_type_id) VALUES (0,0,$serviceid,$actid)";
		db_query_exe($II);
	}
}

/// Make sure that the COPIOUS SYSTEMS business sign up form is in the DB for business to sign up.
/// Always put it there as long as the file can be found...

if ( file_exists("new_copious_business.txt") ) {
	$form = file_get_contents("new_copious_business.txt");
	$form = urlencode($form);
	$QQ = "SELECT id from accounttypes where ( type_name = 'BUSINESS' ) AND  ( serviceid = '$copious_sid' )";
	$actid = db_query_value($QQ);
	$UU = "UPDATE serivcesource set published_accounts = '$form' where ( id = '$copious_sid' )";
	db_query_exe($UU);
	$UU = "UPDATE serivcesource set uses_account_types = '2', solo_account_type = 'BUSINESS' where id = '$copious_sid'";  // 2 is a solo form, only one account type option..
	db_query_exe($UU);
}

?>
KEEP GOING