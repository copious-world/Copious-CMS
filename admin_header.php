<?php

if ( isset($_GET["sess"]) ) {

	if ( isset($_GET["sess"]) ) {
		$sessionid = $_GET["sess"];
		$sess = $sessionid;
	}
	
	if ( isset($_GET['appdir']) ) {
		$appdir = $_GET['appdir'];
	} else $appdir = "";
	///
	
	if ( isset($_GET['busdir']) ) {
		$bus_appdir = $_GET['busdir'];
	} else $bus_appdir = "";

} else {

	if ( isset($_POST["sess"]) ) {
		$sessionid = $_POST["sess"];
		$sess = $sessionid;
	}
	
	if ( isset($_POST['appdir']) ) {
		$appdir = $_POST['appdir'];
	} else $appdir = "";
	///
	
	if ( isset($_POST['busdir']) ) {
		$bus_appdir = $_POST['busdir'];
	} else $bus_appdir = "";
}

global $g_sname_depth;
///
if ( isset($g_sname_depth) ) {
	include "$g_sname_depth/servicename.php";
} else {
	include 'servicename.php';
}

try {
	include 'database.php';
} catch (Exception $e) {
	echo 'Caught exception: ' .  $e->getMessage();
}
global $db_connection;


try {
	require_once('user_from_session.php');
} catch (Exception $e) {
	echo 'Caught exception: ' .  $e->getMessage();
}
require_once('process_account_type.php');
$acc = (object)user_from_session_id();

if ( isset($userlevelsource) ) {
if ( ( $acc->name != "SUPER" ) && !isset($nosuperrequirred) ) {
	$output = file_get_contents("http://$webhost/hosted/accounttype/need_to_be_super.html");
	echo $output;
	exit();
}
}

function majic_quotes($txt) {
	$txt = str_replace('\\"','"',$txt);
	$txt = str_replace("\\'","'",$txt);
	return($txt);
}



require_once('find_service_roles.php');
list($bus_focussed_role_name,$bus_focussed_roles,$bus_appdir) = roles_taxonomy_id_for_service($sess);


global $serviceid;
$serviceid = db_query_value("SELECT id from serivcesource where servicename = '$bus_appdir'");

global $role_bname;

$role_bname = $bus_appdir;


$g_caller_salt = "zx";  // Change when you will.

$g_account_type = $acc->name;

?>





