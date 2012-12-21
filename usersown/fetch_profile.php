<?php

	include "../admin_header.php";

	if ( isset($_GET['userid']) ) {
		$userid = $_GET['userid'];
	}

	$QQ = "SELECT HTML FROM userprofiles WHERE uid = '$userid'";

	$txt = db_query_value($QQ);

	if ( $txt == -1 ) {
		if ( isset($_GET['userid']) ) {
			echo "USER: ($userid) Profile not yet created.";
		} else {
			echo "Your user profile has not yet been created.";
		}
	} else {
		$txt = urldecode($txt);
		$txt = str_replace('\\"','"',$txt);   /// Temporary fix for magic quotes. Final fix is: do this on save.
		echo $txt;
	}

?>
