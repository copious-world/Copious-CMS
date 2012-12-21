<?php

	if ( isset($_GET['servicedir']) ) {
		$servicedir = $_GET['servicedir'];
		require_once($servicedir . "/" . 'servicename.php');
	} else {
		require_once "../servicename.php";
	}
	require_once('../database.php');
	require_once('params_current.php');

	////
	$nu_symbolname = $_GET['nu_symbolname'];
	//
	$nu_firstname = $_GET['nu_firstname'];
	$nu_lastname = $_GET['nu_lastname'];
	////
echo "$nu_symbolname";
	////
	
	$nq = 2;
	$qrowlist = "[ 1, 1 ]";

	$ans = "";

	for ( $i = 0; $i < $nq; $i++ ) {
		$n = $qrowlist[$i];
		for ( $j = 0; $j < $n; $j++ ) {
			$dname = "q" . ($i+1) . "r" . ($j+1);
			$ans .= $dname;
			$ans .= ":";
			$ans .= $_GET[$dname];
			$ans .= ",";
		}
	}
	
	$table = str_replace(" ","_",("currentQ" . $SERVICE));
	$nowtime = datetime();
	$ans = urlencode($ans);
	
	$QI = "insert into $table ( ID,  entrytime, username, answerdata ) VALUES ( 0, '$nowtime', '$nu_symbolname',  '$ans' )";
	$q_result = @mysql_query($QI) or die (mysql_error());  //

?>

