<?php

include 'servicename.php';
try {
	include '../../database.php';
} catch (Exception $e) {
	echo 'Caught exception: ' .  $e->getMessage();
}
	global $db_connection;

	function fetch_manager($mcommand, $section,$db_connection) {
		//
		$content = true;

		$comkey = fixtext($mcommand);
		$sectkey = fixtext($section);
		$projectkey = fixtext('classifieds');
		////
		$section_q = "select count(*) from managers where (  section = '";
		$section_q .= $sectkey;
		$section_q .= "' ) AND ( project = '$projectkey' ) AND ( docID = '";
		$section_q .= $comkey;
		$section_q .= "' )";
		
		$q_result = @mysqli_query($db_connection,$section_q) or die (mysqli_error($db_connection));  // 
		////
		$row = @mysqli_fetch_row($q_result);
		$counter = $row[0];

		if ( $counter <= 0 ) {
			$content = "The $mcommand manager for section, <b>" . $sectkey . "</b>, $projectkey, is not available.";
		} else {
		//
			$section_q = "select infocontent from managers where (  section = '";
			$section_q .= $sectkey;
			$section_q .= "' ) AND ( project = '$projectkey' ) AND ( docID = '";
			$section_q .= $comkey;
			$section_q .= "' )";
			//
			////
			$q_result = @mysqli_query($db_connection,$section_q) or die (mysqli_error($db_connection));  // 
			////
			$row = @mysqli_fetch_row($q_result);
			$content = urldecode($row[0]);
		}
		
		return $content;
	}


	////////////////////////////////////////////////////////////
	
	$managercommand = $_GET['classicommand'];
	$sectionID = $_GET['section'];
	
	error_reporting(E_ALL);

	$sectionText = fetch_manager($managercommand,$sectionID,$db_connection);
	echo $sectionText;

?>
