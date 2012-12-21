<?php
	////
	//
	header('Content-Type: text/html; charset=utf-8' );
	
	////
	if ( isset($_GET['servicedir']) ) {
		$servicedir = $_GET['servicedir'];
		require_once($servicedir . "/" . 'servicename.php');
	} else {
		require_once "../servicename.php";
	}
	require_once '../database.php';
	require_once './userdata.php';

	global $db_connection;
	//
	////
	//////
	$processible = true;
		//
		//
	$pnumber = -1;
	$report = "";
	
	// Next from the DB...

	$mail_password = $_GET['mail_password'];
	$username =  $_GET['username'];
	$permuter_str = $_GET['permuter_str'];
	$spf_len = $_GET['spf'];
	$spb_len = $_GET['spb'];
	//
	$mail_random = $_GET['arandom'];
	$sessRandom = $_GET['grandom'];
	$sessPrime = $_GET['prime'];


	function remote_address() {
		return($_SERVER['REMOTE_ADDR']);
	}

	function create_user_session($uid,$service) {
		global $db_connection;
	
		$session_id = -1;
	
		$sv = urlencode($service);
	
		$q1 = "select id from serivcesource where servicename = '$sv'";
		$q_result = @mysqli_query($db_connection,$q1) or die (mysqli_error($db_connection));  // 
		//
		if ( $row = @mysqli_fetch_row($q_result) ) {
			//
			$sid = $row[0];
			$nowtime = datetime();

			$addr = remote_address();

			$q1I = "insert into authsession ( ID, UID, service_entry, active, starttime, endtime, ip_address ) VALUES (0,$uid,$sid,1,'$nowtime','$nowtime','$addr')";
			$q_result = @mysqli_query($db_connection,$q1I) or die (mysqli_error($db_connection));  //
			
			$q3 = "select id from authsession where ( active = 1 ) AND ( service_entry = $sid ) AND (UID = $uid) AND (starttime = '$nowtime')";
			$q_result = @mysqli_query($db_connection,$q3) or die (mysqli_error($db_connection));  // 
			if ( $row = @mysqli_fetch_row($q_result) ) {
				$session_id = $row[0];
			}
		}

		return($session_id);
	}

	
	////////
	function remove_stars($txt) {
		$p = strpos($txt,"*");
		if ( $p > 0 ) {
			$cleantxt = substr($txt,0,$p);
		} else $cleantxt = $txt;
		
		return($cleantxt);
	}
	//

	
	function sec_permute($etxt,$permstr,$N) {
		global $report;
		
		$permutation = split(",",$permstr);
		$pArray[0] = ' ';
	
		$ptxt = "";
		$i;
		//
		for ( $i = 0; $i < $N; $i++ ) {
		
			$j = $permutation[$i];
			$pArray[$i] = $etxt[$j];

		}

		for ( $i = 0; $i < $N; $i++ ) {
			$ptxt .= $pArray[$i];
		}
	
		return($ptxt);
	}


	function login_decipher($passNary,$oldR,$globR,$N,$localprime) {
		//
		global $report;
		global $debugArry;
		//
		$ptext = "";
		//
		$hidden = (($oldR& 0x00FFFFFF) + ($globR & 0x00FFFFFF)) & 0x00FFFFFF;	// variable line
		//
		//
		$i = 0;
		$R = $hidden;
		//		
		while ( $i < $N ) {
			//
			$cc = $passNary[$i];
			$mc = ($R & 0xFF);
			//
			$R = ($R >> 8) & 0x00FFFFFF;
			if ( $R == 0 ) {
				$hidden *= $localprime;
				$hidden = ( $hidden & 0x00FFFFFF );
				$R = $hidden;
			}
			//
			//
			//
			$cc_hat = $mc ^ $cc;
			//
			$ptext .= chr($cc_hat);
			//
			$i++;
		}
			
		return($ptext);
	}

	//
	// if ( !user_ok($mail_uname) ) $processible = false;
	// else $processible = true;
	//

	$passnums = split("_",$mail_password);
	$aryN = count($passnums) - 1;
	//
	$deciphered = login_decipher($passnums,$sessRandom,$mail_random,$aryN,$sessPrime);
	$orderedtxt = sec_permute($deciphered,$permuter_str,$aryN);
	$orderedtxt = remove_stars($orderedtxt);
	$slen = strlen($orderedtxt);
	$clearpass = trim( substr($orderedtxt, $spf_len, ( $slen - ($spf_len + $spb_len) ) ));

	//
	////
	//////
	$user_ok = check_on_user($username,$clearpass);
	$user_id = $pnumber;
	
	if ( $user_ok ) {
		$session_id = create_user_session($user_id,$SERVICE);
	}

	
	if ( $user_ok ) {
	
		$good_login_message = "User $username logged on to service: $SERVICE";
		
?>
	set_user_id(<?php echo $user_id; ?>);
	set_session_id(<?php echo $session_id; ?>);
	if ( handleMLO_response != null ) handleMLO_response("<?php echo $good_login_message; ?>");
<?php 
	} else {
?>
		set_user_id(0);
		set_session_id(0);
		alert("invalid user");
<?php 
	}
?>

