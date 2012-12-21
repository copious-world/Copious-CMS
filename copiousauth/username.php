<?php

	header('Content-Type: text/html; charset=utf-8' );

	///

	require_once "../admin_header_lite.php";
	global $db_connection;

	///
	$db_charset = mysqli_query($db_connection, "SHOW VARIABLES LIKE 'character_set_database'" );
	$charset_row = mysqli_fetch_assoc( $db_charset );
	mysqli_query($db_connection, "SET NAMES '" . $charset_row['Value'] . "'" );
	unset( $db_charset, $charset_row );
	///

	
	function add_peacename($peacename) {
		global $db_connection;
		//	
		$nowtime = datetime();

		//
		$name_maker = "insert into peacenames ";
		$name_maker .= "(ID,pname,nowtime)";
		$name_maker .= " VALUES (0,'$peacename','$nowtime')";

		$q_result = @mysqli_query($db_connection,$name_maker) or die (mysqli_error($db_connection));  // 
	}
	
	function checkUserName($username) {
		global $db_connection;

		$u_name_q = "select count(*) from users where ( username = '";
		$u_name_q .= trim($username);
		$u_name_q .= "')";
		
		//
		$q_result = @mysqli_query($db_connection,$u_name_q) or die (mysqli_error($db_connection));  // 
		//
		$row = @mysqli_fetch_row($q_result);
		//
		$counter = $row[0];

		return($counter > 0);
	}


	////////////////////////////////////////////////////////////
	
	$username = $_GET['username'];
	$br = $_GET['browser'];
	
	if ( !strcmp($br,"IE") ) {
		$username = urldecode($username);
	}
	
	error_reporting(E_ALL);

	if ( checkUserName($username) ) {
		echo $username;
	} else {
		echo "INV";
	}
?>
