<?php
	global $nu_ID;
	global $nu_firstname;
	global $nu_lastname;
	global $nu_postal;
	global $nu_city;
	global $nu_state;
	global $nu_country;
	global $nu_zcode;
	global $nu_phone_country_code;
	global $nu_phone_area_code;
	global $nu_phone_primary;
	global $nu_phone_secondary;
	global $nu_email;
	global $phonekey;
	global $wants_notify;
	
	global $signerpage;
	//
	global $nu_emailserver;
	global $nu_emailuser;
	global $nu_emailpass;
	
	global $nu_usefeature;
	global $nu_use;
	global $n_uses;
	
	global $username;
	global $SERVICE;

	class toc_line {
		var $tagline = "";
		var $tagset = false;
		var $description = "";
		var $descset = false;
		function complete() {
			$result = ($tagset && $descset);
			return($result);
		}
	}

	$nu_ID = "";
	$nu_firstname = "";
	$nu_lastname = "";
	$nu_postal = "";
	$nu_city = "";
	$nu_state = "";
	$nu_country = "";
	$nu_zcode = "";
	$nu_phone_country_code = "";
	$nu_phone_area_code = "";
	$nu_phone_primary = "";
	$nu_phone_secondary = "";
	$nu_email = "";
	$phonekey = "";
	$wants_notify = "";

	$username = "";

	$signerpage = $SERVICE;

	$nu_emailserver = "";
	$nu_emailuser = "";
	$nu_emailpass = "";

	$nu_usefeature = array();
	$nu_use = array();

	$n_uses = 0;

	function find_user_data($uid) {
		global $nu_ID;
		global $nu_firstname;
		global $nu_lastname;
		global $nu_postal;
		global $nu_city;
		global $nu_state;
		global $nu_country;
		global $nu_zcode;
		global $nu_phone_country_code;
		global $nu_phone_area_code;
		global $nu_phone_primary;
		global $nu_phone_secondary;
		global $nu_email;
		global $phonekey;
		global $wants_notify;
		
		global $signerpage;
		//
		global $nu_emailserver;
		global $nu_emailuser;
		global $nu_emailpass;
		
		global $nu_usefeature;
		global $nu_use;
		global $n_uses;
		
		global $username;
		global $SERVICE;
		global $db_connection;

		$result = true;
		
		$u_name_q = "select * from users where ( ID = '$uid' )";
		//
		$q_result = @mysqli_query($db_connection,$u_name_q) or die (mysqli_error($db_connection));  // 
		$result = false;
		//
		if ( $row = @mysqli_fetch_array($q_result, MYSQL_ASSOC) ) {
			$result = true;
			$nu_ID = $row['ID'];
			$nu_firstname = $row['firstname'];
			$nu_lastname = $row['lastname'];
			$nu_postal = $row['postal'];
			$nu_city = $row['city'];
			$nu_state = $row['state'];
			$nu_country = $row['country'];
			$nu_zcode = $row['zcode'];
			$nu_phone_country_code = $row['phone_country'];
			$nu_phone_area_code = $row['phone_area'];
			$nu_phone_primary = $row['phone_primary'];
			$nu_phone_secondary = $row['phone_secondary'];
			$nu_email = urldecode($row['email']);
			$phonekey = $row['phonekey'];
			$wants_notify = $row['wants_notify'];
			$username = $row['username'];
			//
			$signerpage = "";
			if ( isset($row['original_source']) ) {
				$signerpage = urldecode($row['original_source']);
			}
			if ( strlen($signerpage) == 0 ) $signerpage = $SERVICE;
			
			if ( $wants_notify == 1 ) { $wants_notify = "checked"; } else { $wants_notify = ""; }
			
			$u_name_q = "select * from user_pop3_account where ( UID = '$nu_ID' )";
			$q_result = @mysqli_query($db_connection,$u_name_q) or die (mysqli_error($db_connection));  // 
			//
			if ( $row = @mysqli_fetch_array($q_result, MYSQL_ASSOC) ) {
				$nu_emailserver = $row['emailserver'];
				$nu_emailpass = $row['emailpass'];
				$nu_emailuser = $row['pop3user'];
			}
			//
			$u_name_q = "select * from user_features where ( UID = '$nu_ID' )";
			$q_result = @mysqli_query($db_connection,$u_name_q) or die (mysqli_error($db_connection));  // 
			//
			$nu_usefeature = array();
			$nu_use = array();
			//
			while ( $row = @mysqli_fetch_array($q_result, MYSQL_ASSOC) ) {
				//
				$nu_usefeature[] = urldecode($row['features']);
				$nu_use[] = $row['state'] == 1 ? "checked" : "";
				//
			}
			////
			//
			$n_uses = count($nu_use);
			//
			if ( $n_uses == 0 ) {
				set_user_features($nu_ID);
				//
				$u_name_q = "select * from user_features where ( UID = '$nu_ID' )";
				$q_result = @mysqli_query($db_connection,$u_name_q) or die (mysqli_error($db_connection));  // 
				//
				//
				while ( $row = @mysqli_fetch_array($q_result, MYSQL_ASSOC) ) {
					//
					$nu_usefeature[] = urldecode($row['features']);
					$nu_use[] = $row['state'] == 1 ? "checked" : "";
					//
				}
				////
				//
				$n_uses = count($nu_use);
			}
			//
		}
		//
		
		return $result;
	}

/**/
	//
?>
