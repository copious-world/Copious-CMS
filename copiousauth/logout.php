<?php
	///
	if ( isset($_GET['servicedir']) ) {
		$servicedir = $_GET['servicedir'];
		require_once($servicedir . "/" . 'servicename.php');
	} else {
		require_once "../servicename.php";
	}
	require_once '../database.php';
	global $db_connection;
	
	$uid = $_GET['uid'];
	$sessid = $_GET['sess'];
	$br = $_GET['browser'];

	$endtime = datetime();

	// mark the existing session as closed...
	$QU = "update authsession set active = 0, endtime = '$endtime' where ID = $sessid";
	//
	$q_result = @mysqli_query($db_connection,$QU) or die (mysqli_error($db_connection));  //
	//
?>
