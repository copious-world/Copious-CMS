<?php

	function get_all_users() {
		global $db_connection;
		$u_name_q = "select ID, username, email from users";
		////
		$q_result = @mysqli_query($db_connection,$u_name_q) or die (mysqli_error($db_connection));  // 
		////
		return($q_result);
	}

	function find_user_name_id($username) {
		$u_id_q = "select ID from users where ( username = '$username')";
		$id = db_query_value($u_id_q);
		return $id;
	}

	function find_user_name($username) {
		$result = true;
		
		$u_name_q = "select count(*) from users where ( username = '";
		$u_name_q .= trim($username);
		$u_name_q .= "')";
		$counter = db_query_value($u_name_q);
		if ( $counter <= 0 ) $result = false;
		
		return $result;
	}


	function find_users($firstname, $lastname, $email) {
		$result = true;
		$u_name_q = "select count(*) from users where ( firstname = '$firstname') AND ( lastname = '$lastname') AND ( email = '$email')";
		$counter = db_query_value($u_name_q);
		if ( $counter <= 0 ) $result = false;
		return $result;
	}
	
	function samesymbolcount($ssymname) {
		$u_name_q = "select count(*) from users where ( LOCATE(username,'$ssymname') = 1 )";
		$counter = db_query_value($u_name_q);
		return( $counter );
	}


	function find_user_email($id) {
		$u_email_q = "select email from users where ( ID  = '$id')";
		$email = db_query_value($u_email_q);
		if ( !is_string($emai) ) return("");
		return $email;
	}


	function make_initial_group($userid) {
		global $updatereport;
		// Create a new one.
		$create_group_q = "insert into mail_groups ( ID, UID, group1 ) values ( 0, $userid, 'Everyone' )";
		db_query_exe($create_group_q);
		$updatereport = "Created new group members.";
	}



	function send_user_private($uname,$pass,$e_mail) {
	    //
	    $mailmsg = "Thank you for using Peace Names\n";
	    $mailmsg .= "Your account information is as follows:\n";
	    //
	    $mailmsg .= "\tUsername: " . $uname . "\n";
	    $mailmsg .= "\tPassword: " . $pass . "\n";
	    //
	    copious_mail($e_mail,$uname . "Registration information from Peace Names.", $mailmsg);
	}


	function send_new_user_company($uname,$pass,$e_mail) {
		//
		$company_e_mail = "newusermail@copious-systems.com";
	    //
	    $mailmsg = "You have a new user on Peace Names\n";
	    //
	    $mailmsg .= "\tUsername: " . $uname . "\n";
	    $mailmsg .= "\tE-mail: " . $e_mail . "\n";
	    //
	    copious_mail($company_e_mail,"New User for Peace Names.", $mailmsg);
	}




	/// Read These Features from a DB OR FILE....
	$user_features = array('Copious Mail','globe','energy','peacenames','electrichardware','classydex');
	
	function set_user_features($uid) {
		global $user_features;
		//
		$n = count($user_features);
		//
		for ( $i = 0; $i < $n; $i++ ) {
			//
			$ff = $user_features[$i];
			$ff = urlencode($ff);
			//
			$I_feature = "insert into user_features (ID, UID, features, state) VALUES (0,$uid,'$ff',0)";
			db_query_exe($I_feature);
		}
	}

	/*
	*/


	function getusername($userid) {
		$u_group_q = "select username from users where ( ID = '$userid' )";
		$uname = db_query_value($u_group_q);
		return($uname);
	}

	function get_user_name($id) { return(getusername($userid)); }

	function getuserid($membername) {
		$u_group_q = "select ID from users where ( username = '$membername' )";
		$userid = db_query_value($u_group_q);
		return($userid);
	}


	function getusername_list($userid_list) {
		$uname_list = "";
		if ( strlen($userid_list) > 0 ) {
			$u_group_q = "select username from users where ( ID in ($userid_list) )";
			$uname_list = db_query_list($u_group_q);
			$uname_list = implode($uname_list,",");
		}
		return($uname_list);
	}

	function getuserid_list($username_list) {
		$uname_list = "";

		if ( strlen($username_list) > 0 ) {
			$username_list = str_replace(',',"','",$username_list);
			////
			$u_group_q = "select id, username from users where ( username in ('$username_list') )";
			$uname_list = db_query_row_lists($u_group_q);
		}
		return($uname_list);
	}


?>
