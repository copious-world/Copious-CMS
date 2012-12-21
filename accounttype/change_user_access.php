<?php



if ( isset($_GET["sess"]) ) {
$sessionid = $_GET["sess"];
$sess = $sessionid;
}


include 'servicename.php';

try {
	include '../database.php';
	require_once('../user_from_session.php');
} catch (Exception $e) {
	echo 'Caught exception: ' .  $e->getMessage();
}
/*
*/
global $db_connection;

require_once('process_account_type.php');
$acc = (object)user_from_session_id();

if ( $acc->name != "SUPER" ) {
	$output = file_get_contents("need_to_be_super.html");
	echo $output;
	exit();
}


require_once('find_service_roles.php');
global $sessobj;


$serviceid = $sessobj->service_entry;


$sess = $_POST['sess'];
$target_uid = $_POST['uid'];


$newacctype = "";
if ( isset($_POST['newtype']) ) {
	$newacctype = $_POST['newtype'];
}


if ( strlen($newacctype) > 0 ) {  /// Set a new account type for the user... (PROMOTION, DEMOTION, etc.)
	$QQ = "SELECT * from accounttypes where type_name = '$newacctype'";
	$accid = db_query_value($QQ);
	if ( $accid > 0 ) {
		$QQ = "UPDATE authspecials where set account_type_id = $accid where (uid = $target_uid) AND ( serviceid = '$serviceid' )";
		db_query_exe($QQ);
	}
} else {
	$QQ = "DELETE From authspecials where (uid = $target_uid) AND ( serviceid = '$serviceid' )";
	db_query_exe($QQ);
}



?>