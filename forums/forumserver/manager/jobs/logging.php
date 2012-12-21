<?php

	
///
	require_once("debug.php"); // this will include a.php again on Windows! (PHP 4 only)

	
////
	function logErr( $emsg ) {
		//echo $emsg;
		logDebug($emsg);
	}
	
	
	function copious_mail($email,$subject,$email_txt,$headers) {
		//
//logDebug( $email . "<br>" . $subject . "<br>" . $email_txt . "<br>" . $headers );
		//
//mail("testpay@copious-systems.com",$subject,$email_txt,$headers);
		//
		mail($email,$subject,$email_txt,$headers);
	}


?>
