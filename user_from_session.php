<?php


if ( isset($sessionid) && !isset($sess) ) {
	$sess = $sessionid;
}


include_once('userfeatures.php');

global $sessobj;
global $user;

function has_active_session($uid,$sessuionid) {
	global $db_connection;

	$QU = "select active from authsession where (ID = $sessuionid) AND (UID = $uid) ";
	//
	$rslt = db_query_value($QU);

	if ( $rslt < 1 ) return(false);
	return(true);
}


function get_user_from_session($session) {
	global $user;
	global $sessobj;

	$QQ = "select * from authsession where (id = '$session') and (active = 1)";
	$sessobj = db_query_object($QQ);
	if ( isset($sessobj) ) {
		$addr = $_SERVER['REMOTE_ADDR'];

		if ( strlen($sessobj->ip_address) == 0 ) {
			$QQ = "update authsession set ip_address = '$addr' where ( id = '$session' )";
			db_query_exe($QQ);
		} else {
			if ( strncmp($addr,$sessobj->ip_address,strlen($addr)) != 0 ) {
				echo "PAGE REQUEST FROM UNREGISTERED IP ADDRESS";
				return(array(-1,"spurious"));
			}
		}
		$uid = $sessobj->UID;

		$QQ = "select * from users where id = '$uid'";
		$user = db_query_object($QQ);
		$uname = $user->username;

	} else {
		echo "PAGE REQUEST FROM KNOWN IP ADDRESS";
		return(array(-1,"spurious"));
	}
	return(array($uid,$uname));
}


list($userid,$username) = get_user_from_session($sess);



function roar_get_permissions() {
	static $permissions = NULL;
	if ( $permissions == NULL ) {
		$permissions = apc_fetch("all_permissions");
	}
	if ( $permissions == NULL ) $permissions = array();
	return($permissions);
}


function get_account_type($sess) {
	global $userid;
	global $sessobj;

	$servid = $sessobj->service_entry;
	
	$QQ = "select * from accounttypes act INNER JOIN authspecials aut ON (act.id = aut.account_type_id) where ( aut.uid = $userid ) AND (aut.serviceid = $servid)";
	$actyp_object = db_query_object($QQ);

	$actyp_object = array("name" => $actyp_object->type_name, "id" => $actyp_object->id);
	return($actyp_object);
}

// This being called and the session has already been established...
function user_from_session_id() {
	global $sess;

	return(get_account_type($sess));
}


?>
