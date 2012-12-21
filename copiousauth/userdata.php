<?php
	////	
		//

		//  INCLUDED FILE.
	$pnumber = -1;

	///////////////////////////////////////////////////////////////////////////////
	//
	//		CHECK PASSWORD
	//
	function check_password($pass) {		
		global $pnumber;
		global $db_connection;
		//
		$isok = true;
		////
		$passw_q = "select password from authpass where ( UID = '$pnumber')";
		/////
		//
		//$q_result = @mysqli_query($db_connection,$passw_q);  //  or die (mysqli_error($db_connection))
		$q_result = @mysqli_query($db_connection,$passw_q) or die (mysqli_error($db_connection));  // 
		//
		$row = @mysqli_fetch_row($q_result);
		//
		$tstpass = $row[0];				// $tstpass
		$cpass = crypt(trim($pass), $tstpass);
		//
		if ( strcmp($cpass,$tstpass) != 0 ) $isok = false;
		//
		return($isok);
	}
	//


	function user_ok($username) {
		global $pnumber;
		global $db_connection;
			//
		$isok = true;
		
		$u_name_q = "select count(*) from users where ( username = '";
		$u_name_q .= trim($username);
		$u_name_q .= "')";
		
		//
		//$q_result = @mysqli_query($db_connection,$u_name_q);  //  or die (mysqli_error($db_connection))
		$q_result = @mysqli_query($db_connection,$u_name_q) or die (mysqli_error($db_connection));  // 
		//
		$row = @mysqli_fetch_row($q_result);
		//
		$counter = $row[0];

		if ( $counter <= 0 ) $isok = false;
		else {
			////
			$u_name_q = "select ID from users where ( username = '";
			$u_name_q .= trim($username);
			$u_name_q .= "')";
			////
			$q_result = @mysqli_query($db_connection,$u_name_q) or die (mysqli_error($db_connection));  // 
			////
			$row = @mysqli_fetch_row($q_result);
			$pnumber = $row[0];
		}
		
		return $isok;
	}


	function check_on_user($username,$clearpass) {
		$result = false;
		//
		if ( user_ok($username) ) {
			$result = check_password($clearpass);
		}
		//
		return($result);
	}


	function get_name_and_password($id) {		
		global $db_connection;
		//
		////
		$passw_q = "select a.password, u.username from authpass AS a INNER JOIN users AS u on ( a.UID = '$id') AND ( u.ID = '$id')";
		/////
		//
		//$q_result = @mysqli_query($db_connection,$passw_q);  //  or die (mysqli_error($db_connection))
		$q_result = @mysqli_query($db_connection,$passw_q) or die (mysqli_error($db_connection));  // 
		//
		$up = @mysqli_fetch_object($q_result);
		//
		//
		return($up);
	}
	//


?>

