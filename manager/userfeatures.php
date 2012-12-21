<?php

	include '../database.php';

	function get_all_users() {
			$u_name_q = "select ID, username, email from users";
			////
			$q_result = @mysql_query($u_name_q) or die (mysql_error());  // 
			////
			return($q_result);
	}
	


	function find_user_name_id($username) {
		$result = true;
		
		$u_id_q = "select ID from users where ( username = '";
		$u_id_q .= $username;
		$u_id_q .= "')";
		
		//
		$q_result = @mysql_query($u_id_q);  //  or die (mysql_error())
		//
		$row = @mysql_fetch_row($q_result);
		//
		$id = $row[0];
		
		return $id;
	}

	function find_user_email($id) {
		$result = true;
		
		$u_id_q = "select email from users where ( ID  = '$id')";
		//
		$q_result = @mysql_query($u_id_q);  //  or die (mysql_error())
		//
		$row = @mysql_fetch_row($q_result);
		//
		$id = $row[0];
		
		return $id;
	}


	function send_user_private($uname,$pass,$e_mail) {
	    //
	    $mailmsg = "Thank you for using Copious Mail\n";
	    $mailmsg .= "Your account information is as follows:\n";
	    //
	    $mailmsg .= "\tUsername: " . $uname . "\n";
	    $mailmsg .= "\tPassword: " . $pass . "\n";
	    //
		$headers = 'From: mailmanager@copious-systems.com' . "\r\n" . 'Reply-To: mailmanager@copious-systems.com' . "\r\n";
	    //
	    mail($e_mail,$uname . "- Registration information from Copious Mail.", $mailmsg,$headers);
	}


//
	$db_connection = 0;
	$db_select = 0;
	
	
	$features = array('Copious Mail','globe','energy','peacenames','electrichardware','classydex');
	$n = count($features);
	
	$q_u_data = get_all_users();

	while ( $row = @mysql_fetch_row($q_u_data) ) { 
		//
		$uid = $row[0];
		
		if ( $uid > 13 ) continue;
		//
		$uname = $row[1];
		$uemail = $row[2];
		//
echo $uname;
		//
		for ( $i = 0; $i < $n; $i++ ) {
			$ff = $features[$i];
			
			$ff = urlencode($ff);
			$I_feature = "insert into user_features (ID,UID,features,state) VALUES (0,$uid,'$ff',0)";
			$q_result = mysql_query($I_feature) or die (mysql_error());
	
		}
		
	}

	/*
	*/
?>
