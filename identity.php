<?php

	global $db_connection;

	////
	$sv = urlencode($SERVICE);
	$u_name_q = "select ID, serviceurl, hasQuestionaire, questionaire_url,  uses_account_types from serivcesource where ( servicename = '$sv')";
	////
	$q_result = @mysqli_query($db_connection,$u_name_q) or die (mysqli_error($db_connection));  // 
	////
	if ( $row = @mysqli_fetch_row($q_result) ) {
		$serviceid = $row[0];
		$serviceurl = $row[1];
		$hasQuestionaire = $row[2];
		$questionaire_url = $row[3];
		$uses_account_types = $row[4];
	} else {
		echo("This company is not part of the DB.");
	}
/**/
	if ( !isset($questionaire_url) ) {
		$questionaire_url = "makeaccount_userdata.php";
	}
	$user_id_number = -1;

	function active_session($sessid) {
		global $db_connection;
		global $user_id_number;
		$result = false;
		$qq = "select UID from authsession where ( ID = $sessid ) AND ( active = 1 )";
		$q_result = @mysqli_query($db_connection,$qq) or die (mysqli_error($db_connection));  //
		//
		if ( $row = @mysqli_fetch_row($q_result) ) {
			$user_id_number = $row[0];
			$result = true;
		}
		return($result);
	}

	function active_session_uname($sessid) {
		global $db_connection;
		global $user_id_number;
		//
		$nname = "no name";
		if ( $user_id_number == -1 ) {
			if ( !active_session($sessid) ) {
				return($nname);
			}
		}
		
		if ( $user_id_number != -1 ) {
			$u_name_q = "select username from users where ( ID = '$user_id_number' )";
			//
			$q_result = @mysqli_query($db_connection,$u_name_q) or die (mysqli_error($db_connection));  // 
			//
			if ( $row = @mysqli_fetch_row($q_result) ) {
				$nname = $row[0];
			}
		}
		return($nname);
	}

	function getsalt() {
		//
		$passsource = "abcdefghijklmnopqrstuvwxyz";
		$n = strlen($passsource) - 1;
		$rpass = "";
		//
		$rpass .= $passsource[rand(0,$n)];
		$rpass .= $passsource[rand(0,$n)];
		
		return $rpass;
	}
/*
*/


?>
